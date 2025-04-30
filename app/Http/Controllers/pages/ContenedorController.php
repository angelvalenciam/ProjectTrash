<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contenedor;
use App\Models\DivisionContenedores as DivisionContenedor;
use App\Models\TipoBasura;
use Illuminate\Support\Str;

use App\Models\UsuarioContenedor;

class ContenedorController extends Controller
{
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
    ]);

    try {
      // Generar un número de serie único
      $numeroSerie = $this->generateUniqueSerialNumber();

      // Guardar el contenedor
      $contenedor = Contenedor::create([
        'nombre' => $request->nombre,
        'numero_serie' => $numeroSerie,
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

// crear  numero de serie
  private function generateUniqueSerialNumber()
  {
    do {
      $serial = 'CTN-' . strtoupper(Str::random(6)); // Ej: CTN-4H7Z3X
    } while (Contenedor::where('numero_serie', $serial)->exists());

    return $serial;
  }

// end
  public function destroy($id)
  {
    $containers = Contenedor::findOrFail($id);
    $containers->delete();
    return redirect()->route('register-container')->with('success', 'registrado correctamente');
  }

  public function showDisponerResiduos(Request $request)
  {

    $userId = auth()->id();

    // Obtener los contenedores del usuario
    $contenedores = Contenedor::whereHas('usuarios', function ($q) use ($userId) {
      $q->where('id_usuario', $userId);
    })->get();

    // Si ya hay un contenedor seleccionado
    $selectedId = $request->get('contenedor_id', $contenedores->first()?->id);

    // Obtener divisiones del contenedor seleccionado
    $divisiones = DivisionContenedor::where('id_contenedor', $selectedId)
      ->with('tipoBasura') // Asumiendo relación con TipoBasura
      ->get();

    return view('pages.tu_vista_disponer', [
      'contenedores' => $contenedores,
      'selectedId' => $selectedId,
      'divisiones' => $divisiones,
    ]);
  }
}
