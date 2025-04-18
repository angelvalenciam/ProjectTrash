<?php

namespace App\Http\Controllers\pages;
use App\Models\HistorialTokens;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecompensaAdmin;
use App\Models\HistorialRecompensas;
use Illuminate\Support\Facades\DB;

class recompensasuser extends Controller
{
  public function index()
  {
    $user = auth()->user(); // obtener usuario logueado

    // Sumar todos los tokens del usuario autenticado
    $token = DB::table('historial_tokens')
      ->where('id_usuario', $user->id)
      ->sum('tokens_asignados');

    // Paginación de recompensas
    $recompensas = RecompensaAdmin::paginate(8);

    return view('content.pages.rencompensas', compact('token', 'recompensas'));
  }


  public function store(Request $request)
  {
    $request->validate([
      'titulo' => 'required|string|max:255',
      'descripcion' => 'required|string',
      'precio' => 'required|numeric',
      'imagen' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validación de la imagen
    ]);

    // Subir la imagen
    if ($request->hasFile('imagen')) {
      $imagenPath = $request->file('imagen')->store('public/recompensas'); // Guarda la imagen en el almacenamiento
    } else {
      $imagenPath = null;
    }

    // Crear nueva recompensa
    RecompensaAdmin::create([
      'titulo' => $request->titulo,
      'descripcion' => $request->descripcion,
      'precio' => $request->precio,
      'imagen' => $imagenPath,  // Guarda el nombre de la imagen
    ]);

    return redirect()->route('recompensas-user');
  }
  public function redeem(Request $request)
  {
    $user = auth()->user();
    $recompensaId = $request->input('recompensa_id');

    $recompensa = RecompensaAdmin::findOrFail($recompensaId);
    $userTokens = DB::table('historial_tokens')
      ->where('id_usuario', $user->id)
      ->sum('tokens_asignados');

    if ($userTokens < $recompensa->precio) {
      return back()->with('error', 'No tienes suficientes tokens para esta recompensa.');
    }

    // Descontar tokens → creamos un nuevo registro negativo
    HistorialRecompensas::create([
      'id_usuario' => $user->id,
      'id_recompensa' => $recompensa->id,
      'tokens_gastados' => $recompensa->precio,
    ]);


    return back()->with('success', 'Has canjeado exitosamente tu recompensa: ' . $recompensa->titulo);
  }

}
