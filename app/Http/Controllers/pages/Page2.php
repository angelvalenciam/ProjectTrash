<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Contenedor;
use App\Models\TipoBasura;
use App\Models\VaciarContenedor;
use App\Models\User;
use App\Models\DivisionContenedores;
use Aws\Api\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Recompensa;
use App\Models\HistorialRecompensas;
use App\Models\HistorialTokens;
use App\Models\TablaPrecios;

class Page2 extends Controller
{
  public function index()
  {
    $userId = auth()->id();
    $contenedores = Contenedor::whereIn('id', function ($query) use ($userId) {
      $query->select('id_contenedor')
        ->from('usuario_contenedor')
        ->where('id_usuario', $userId);
    })->get();

    return view('content.pages.pages-page2', compact('contenedores'));
  }
  public function showContainerData($id)
  {
    try {
      // Obtén las divisiones de los contenedores
      $divisionContenedores = DivisionContenedores::where('id_contenedor', $id)
        ->with('tipobasura')
        ->get();

      // Verifica si no hay datos
      if ($divisionContenedores->isEmpty()) {
        return response()->json(['error' => 'No hay datos para este contenedor'], 404);
      }

      // Formatea la respuesta
      $data = $divisionContenedores->map(function ($division) {
        return [
          'id' => $division->id, // <-- Agregado
          'id_tipo_basura' => $division->tipoBasura->nombre,
          'cantidad_kg' => $division->cantidad_kg,
        ];
      });

      return response()->json($data);
    } catch (\Exception $e) {
      // Captura cualquier excepción y muestra el mensaje
      return response()->json(['error' => 'Error en la consulta: ' . $e->getMessage()], 500);
    }
  }

  public function niveles($id)
  {
    try {
      $divisiones = DivisionContenedores::where('id_contenedor', $id)->get();
      dd($divisiones);
      return response()->json($divisiones->map(function ($d) {
        return [
          'id' => $d->id,
          'id_tipo_basura' => $d->id_tipo_basura,
          'cantidad_kg' => $d->cantidad_kg,
        ];
      }));
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);
    }

  }
  // public function vaciarContenedor(Request $request)
  // {
  //   try {
  //     // Validar que se haya enviado el id de la división
  //     $request->validate([
  //       'id_division_contenedor' => 'required|integer|exists:division_contenedor,id'
  //     ]);

  //     // Buscar la división de contenedor
  //     $division = DivisionContenedores::find($request->id_division_contenedor);

  //     // Verificar si existe
  //     if (!$division) {
  //       return response()->json(['error' => 'División no encontrada'], 404);
  //     }

  //     // Guardamos la cantidad antes de vaciar
  //     $cantidadVaciada = $division->cantidad_kg;

  //     // 1. Registrar en vaciado_contenedor
  //     VaciarContenedor::create([
  //       'id_division_contenedor' => $division->id,
  //       'id_usuario' => auth()->id(), // el usuario autenticado
  //       'cantidad_vaciada' => $cantidadVaciada
  //     ]);

  //     // 2. Vaciar contenedor (actualizar la cantidad a 0)
  //     $division->cantidad_kg = 0;
  //     $division->save();

  //     return response()->json(['success' => true]);

  //   } catch (\Exception $e) {
  //     return response()->json(['error' => 'Error al vaciar: ' . $e->getMessage()], 500);
  //   }
  // }

  public function pruebaInsert()
  {
    DB::table('vaciado_contenedor')->insert([
      'id_division_contenedor' => 22,
      'id_usuario' => 2, // pon el ID que sí existe
      'cantidad_vaciada' => 43,
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    return 'Insert exitoso';
  }
  // prueba
  public function vaciarContenedor(Request $request)
  {
    try {
      $request->validate([
        'id_division_contenedor' => 'required|integer|exists:division_contenedor,id'
      ]);

      $division = DivisionContenedores::with('tipoBasura')->find($request->id_division_contenedor);
      $usuario = auth()->user();

      // Verifica si el usuario está autenticado
      if (!$usuario) {
        return response()->json(['error' => 'Usuario no autenticado'], 401);
      }

      // Verifica si el usuario existe en la base de datos
      $usuario = User::find($usuario->id);
      if (!$usuario) {
        return response()->json(['error' => 'Usuario no encontrado'], 404);
      }

      $cantidad = $division->cantidad_kg;
      $tipoBasura = $division->tipoBasura;

      // 1. Registrar vaciado
      $vaciado = VaciarContenedor::create([
        'id_division_contenedor' => $division->id,
        'id_usuario' => $usuario->id,
        'cantidad_vaciada' => $cantidad,
      ]);

      if (!$vaciado) {
        return response()->json(['error' => 'Error al registrar vaciado'], 500);
      }

      // 2. Vaciar el contenedor
      $division->cantidad_kg = 0;
      $division->save();

      // 3. Calcular tokens ganados
      $recompensa = TablaPrecios::where('id_tipo_basura', $tipoBasura->id)->first();
      $tokensGanados = $recompensa ? $cantidad * $recompensa->tokens_por_kg : 0;

      // 4. Registrar en historial de tokens
      HistorialTokens::create([
        'id_usuario' => $usuario->id,
        'id_vaciado' => $vaciado->id,
        'tokens_asignados' => $tokensGanados,
      ]);

      // 5. Sumar tokens al usuario
      $usuario->tokens += $tokensGanados;
      $usuario->save();

      return response()->json([
        'success' => true,
        'mensaje' => "¡Vaciado exitoso! Has ganado $tokensGanados tokens.",
        'tokens_totales' => $usuario->tokens
      ]);

    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al vaciar: ' . $e->getMessage()], 500);
    }
  }



}

