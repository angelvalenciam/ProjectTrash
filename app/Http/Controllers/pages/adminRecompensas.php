<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecompensaAdmin as ModelsRecompensaAdmin;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Aws\Credentials\Credentials;
class adminRecompensas extends Controller
{
    public function index()
    {
        $recompensas = ModelsRecompensaAdmin::paginate(10);
        return view('content.pages.admin.recompensasAdmin', compact('recompensas'));
    }
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            "nameServicio" => "required",
            "descripcion" => "required",
            "precio" => "required",
            "imagen" => "nullable|image|mimes:jpg,jpeg,png,gif|max:2048" // Validación de la imagen
        ]);

        // Subir la imagen si se proporciona
        // Guardar la imagen en el almacenamiento público
        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            // Guardar la imagen en storage/app/public/recompensas
            $imagenPath = $request->file('imagen')->store('public/recompensas');
        }

        // Crear nueva recompensa en la base de datos
        ModelsRecompensaAdmin::create([
            'titulo' => $request->nameServicio,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'imagen' => $imagenPath, // Guardar la ruta de la imagen
        ]);

        return redirect()->route('recompensas-admin')->with('success', 'Se registró correctamente');
    }
    public function edit($id)
    {
        $recompensa = ModelsRecompensaAdmin::findOrFail($id);
        return view('content.pages.admin.editRecompensa', compact('recompensa'));
    }

    public function update(Request $request, $id)
    {
        $recompensa = ModelsRecompensaAdmin::findOrFail($id);
        $recompensa->titulo = $request->titulo;
        $recompensa->descripcion = $request->descripcion;
        $recompensa->precio = $request->precio;

        // Verifica si hay una nueva imagen y actualízala
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('recompensas');
            $recompensa->imagen = $imagePath;
        }

        $recompensa->save();

        return redirect()->route('recompensa-admin');
    }


    public function destroy($id)
    {
        $recompensa = ModelsRecompensaAdmin::findOrFail($id);
        $recompensa->delete();
        return redirect()->route('recompensas-admin')->with('success', 'Recompensa eliminada correctamente');
    }
}
