<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecompensaAdmin;

class recompensasuser extends Controller
{
    public function index()
    {
        $recompensas = RecompensaAdmin::paginate(8); // Muestra 8 recompensas por página
        return view('content.pages.rencompensas', compact('recompensas'));
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
}
