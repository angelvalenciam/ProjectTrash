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
//  public function index()
//  {
//    $containers = Contenedor::all();
//    return view('content.pages.registercontainer', compact('containers'));
//  }
  public function index()
  {
    $userId = auth()->id();

    // Trae solo los contenedores que están relacionados con el usuario actual
    $containers = Contenedor::whereIn('id', function ($query) use ($userId) {
      $query->select('id_contenedor')
        ->from('usuario_contenedor')
        ->where('id_usuario', $userId);
    })->get();

    return view('content.pages.registercontainer', compact('containers'));
  }


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
        try {
          DivisionContenedor::create([
            'id_contenedor' => $contenedor->id,
            'id_tipo_basura' => $tipo->id,
            'cantidad_kg' => 0,
          ]);
        } catch (Exception $e) {
          dd($e->getMessage()); // Muestra el error si ocurre
        }
      }
      return redirect()->route('register-container')->with('success', 'Contenedor registrado correctamente.');
    } catch (Exception $e) {
      return back()->withErrors(['error' => 'Error al registrar el contenedor: ' . $e->getMessage()]);
    }
  }

  public function destroy($id)
  {
    $containers = Contenedor::findOrFail($id);
    $containers->delete();
    return redirect()->route('register-container')->with('success', 'registrado correctamente');
  }
}
// divisioncontenedor es ok
// usuariocontenedor
