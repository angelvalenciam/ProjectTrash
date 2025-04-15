


<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Contenedor;
use App\Models\TipoBasura;
use App\Models\VaciarContenedor;
use App\Models\User;
use App\Models\DivisionContenedores;
use Illuminate\Http\Request;

class Page2 extends Controller
{
  public function index()
  {
    // Consulta los contenedores desde la base de datos
    $contenedores = Contenedor::all();

    // Pasar los datos a la vista
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
  public function vaciarContenedor(Request $request)
  {
    dd($request); 
    try {
      // Validar los datos de la solicitud
      $validated = $request->validate([
        'id_division_contenedor' => ' ',
        'cantidad_vaciada' => '  '
      ]);

      // Obtener el contenedor
      $divisionContenedor = DivisionContenedores::find($validated['id']);

      if (!$divisionContenedor) {
        return response()->json(['error' => 'Contenedor no encontrado'], 404);
      }

      // Verificar la cantidad de residuos disponible
      if ($divisionContenedor->cantidad_kg < $validated['cantidad_vaciada']) {
        return response()->json(['error' => 'No hay suficiente cantidad de residuos para vaciar'], 400);
      }

      $divisionContenedor->cantidad_kg -= $validated['cantidad_vaciada'];
      // Actualizar la cantidad restante en el contenedor
      $divisionContenedor->cantidad_restante -= $validated['cantidad_vaciada'];
      $divisionContenedor->save();

      // Registrar el vaciado en la base de datos
      VaciarContenedor::create([
        'id_division_contenedor' => $validated['id_division_contenedor'],
        'id_usuario' => auth()->id(),
        'cantidad_vaciada' => $validated['cantidad_vaciada']
      ]);

      return response()->json(['success' => true]);

    } catch (\Exception $e) {

      return response()->json(['error' => 'Error al procesar la solicitud'], 500);
    }
  }

}

