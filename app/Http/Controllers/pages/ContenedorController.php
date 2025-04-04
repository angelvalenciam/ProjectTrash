<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Contenedor;
use Illuminate\Http\Request;

class ContenedorController extends Controller
{
  public function index()
  {
    $containers = Contenedor::all();
    return view('content.pages.registercontainer', compact('containers'));
  }

  public function store(Request $request)
  {
    // Validación de datos
    $request->validate([
      'nombre' => 'required|string|max:255',
      'numero_serie' => 'required|string|unique:contenedores,numero_serie',

    ]);

    // Iniciar una transacción para garantizar integridad de los datos
    try {
      Contenedor::create([
        'nombre' => $request->nombre,
        'numero_serie' => $request->numero_serie,
      ]);

      return redirect()->route('register-container');
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al registrar el contenedor: ' . $e->getMessage()], 500);
    }
  }
  public function destroy($id)
  {
    $containers = Contenedor::findOrFail($id);
    $containers->delete();
    return redirect()->route('register-container')->with('success', 'registrado correctamente');
  }
}
