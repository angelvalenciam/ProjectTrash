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
    // Obtener el usuario autenticado
    $user = auth()->user();

    // Validar que esté logueado
    if (!$user) {
        return redirect()->route('login')->with('error', 'Debes iniciar sesión para ver tus recompensas.');
    }

    // Obtener los tokens directamente del campo "tokens" en la tabla users
    $token = $user->tokens;

    // Obtener recompensas paginadas
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
      $user = auth()->user();  // Obtener el usuario autenticado
      $recompensaId = $request->input('recompensa_id');  // Obtener el ID de la recompensa seleccionada

      // Obtener los datos de la recompensa
      $recompensa = RecompensaAdmin::findOrFail($recompensaId);

      // Obtener los tokens disponibles del usuario
      $userTokens = DB::table('users')
          ->where('id', $user->id)
          ->value('tokens');  // Obtenemos directamente los tokens de la tabla users

      // Verificar si el usuario tiene suficientes tokens
      if ($userTokens < $recompensa->precio) {
          // Si no tiene suficientes tokens, mostramos un mensaje claro
          return back()->with('error', 'No tienes suficientes tokens para esta recompensa. Tienes ' . $userTokens . ' tokens, pero necesitas ' . $recompensa->precio . ' tokens.');
      }

      // Descontar los tokens del usuario
      DB::table('users')
          ->where('id', $user->id)
          ->decrement('tokens', $recompensa->precio);  // Decrementamos los tokens directamente

      // Registrar el canje de recompensa en el historial
      HistorialRecompensas::create([
          'id_usuario' => $user->id,
          'id_recompensa' => $recompensa->id,
          'tokens_gastados' => $recompensa->precio,
      ]);

      // Redirigir con mensaje de éxito
      return back()->with('success', 'Has canjeado exitosamente tu recompensa: ' . $recompensa->titulo);
  }


}
