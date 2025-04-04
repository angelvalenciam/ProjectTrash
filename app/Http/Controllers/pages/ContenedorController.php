<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contenedor;
use App\Models\DivisionContenedores as DivisionContenedor;
use App\Models\TipoBasura;
use App\Models\UsuarioContenedor;

class ContenedorController extends Controller
{
  public function index()
  {
    $containers = Contenedor::all();
    return view('content.pages.registercontainer', compact('containers'));
  }

//  public function store(Request $request)
//  {
//    // Validación de datos
//    $request->validate([
//      'nombre' => 'required|string|max:255',
//      'numero_serie' => 'required|string|unique:contenedores,numero_serie',
//
//    ]);
//
//    // Iniciar una transacción para garantizar integridad de los datos
//    try {
//      Contenedor::create([
//        'nombre' => $request->nombre,
//        'numero_serie' => $request->numero_serie,
//      ]);
//
//      return redirect()->route('register-container');
//    } catch (\Exception $e) {
//      return response()->json(['error' => 'Error al registrar el contenedor: ' . $e->getMessage()], 500);
//    }
 // }
// trabajar comodamente

  public function store(Request $request)
  {
    $request->validate([
      'nombre' => 'required|string|max:255',
      'numero_serie' => 'required|string',
    ]);

    try {
      // Guardar el contenedor
      $contenedor = Contenedor::create([
        'nombre' => $request->nombre,
        'numero_serie' => $request->numero_serie,
      ]);

      // Asociarlo al usuario logueado
      UsuarioContenedor::create([
        'id_usuario' => auth()->id(),
        'id_contenedor' => $contenedor->id,
      ]);

      // Crear divisiones por tipo de basura automáticamente
      $tipos = TipoBasura::all();
      foreach ($tipos as $tipo) {
        DivisionContenedor::create([
          'id_contenedor' => $contenedor->id,
          'id_tipo_basura' => $tipo->id,
          'cantidad_kg' => 0,
        ]);
      }

      return redirect()->route('register-container')->with('success', 'Contenedor registrado correctamente.');
    } catch (\Exception $e) {
      return back()->withErrors(['error' => 'Error al registrar el contenedor: ' . $e->getMessage()]);
    }
  }
  // end register
  public function destroy($id)
  {
    $containers = Contenedor::findOrFail($id);
    $containers->delete();
    return redirect()->route('register-container')->with('success', 'registrado correctamente');
  }
}
// divisioncontenedor es ok
// usuariocontenedor
