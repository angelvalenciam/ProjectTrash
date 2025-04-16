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

class Page2 extends Controller
{
  // public function index()
  // {
  //   // Consulta los contenedores desde la base de datos
  //   $contenedores = Contenedor::all();

  //   // Pasar los datos a la vista
  //   return view('content.pages.pages-page2', compact('contenedores'));
  // }
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
  // vaciar
  // public function vaciarContenedor(Request $request)
  // {
  //   try {
  //     // Validar solo que se envíe el id
  //     $validated = $request->validate([
  //       'id_division_contenedor' => 'required|integer|exists:division_contenedores,id'
  //     ]);

  //     // Buscar la división
  //     $divisionContenedor = DivisionContenedores::find($validated['id_division_contenedor']);

  //     if (!$divisionContenedor) {
  //       return response()->json(['error' => 'Contenedor no encontrado'], 404);
  //     }

  //     // Guardamos la cantidad antes de vaciar
  //     $cantidadVaciada = $divisionContenedor->cantidad_kg;

  //     // Vaciar el contenedor
  //     $divisionContenedor->cantidad_kg = 0;
  //     $divisionContenedor->cantidad_restante = 0;
  //     $divisionContenedor->save();

  //     // Registrar vaciado
  //     VaciarContenedor::create([
  //       'id_division_contenedor' => $divisionContenedor->id,
  //       'id_usuario' => auth()->id(),
  //       'cantidad_vaciada' => $cantidadVaciada
  //     ]);

  //     return response()->json(['success' => true]);

  //   } catch (\Exception $e) {
  //     return response()->json(['error' => 'Error al procesar la solicitud'], 500);

  //   }
  // }
  // public function vaciarContenedor(Request $request)
  // {
  //   try {
  //     // Validamos que se mande un ID
  //     $id = $request->input('id_division_contenedor');
  //     // dd($request->all()); <-- QUÍTALO

  //     // Lo buscamos
  //     $division = DivisionContenedores::find($id);

  //     if (!$division) {
  //       return response()->json(['error' => 'No encontrado'], 404);
  //     }

  //     // SOLO ACTUALIZAMOS cantidad_kg
  //     $division->cantidad_kg = 0;
  //     $division->save();

  //     return response()->json(['success' => true]);
  //   } catch (\Exception $e) {
  //     return response()->json(['error' => $e->getMessage()], 500);
  //   }
  // }
  public function vaciarContenedor(Request $request)
  {
    try {
      // Validar que se haya enviado el id de la división
      $request->validate([
        'id_division_contenedor' => 'required|integer|exists:division_contenedor,id'
      ]);

      // Buscar la división de contenedor
      $division = DivisionContenedores::find($request->id_division_contenedor);

      // Verificar si existe
      if (!$division) {
        return response()->json(['error' => 'División no encontrada'], 404);
      }

      // Guardamos la cantidad antes de vaciar
      $cantidadVaciada = $division->cantidad_kg;

      // 1. Registrar en vaciado_contenedor
      VaciarContenedor::create([
        'id_division_contenedor' => $division->id,
        'id_usuario' => auth()->id(), // el usuario autenticado
        'cantidad_vaciada' => $cantidadVaciada
      ]);

      // 2. Vaciar contenedor (actualizar la cantidad a 0)
      $division->cantidad_kg = 0;
      $division->save();

      return response()->json(['success' => true]);

    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al vaciar: ' . $e->getMessage()], 500);
    }
  }
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
}

