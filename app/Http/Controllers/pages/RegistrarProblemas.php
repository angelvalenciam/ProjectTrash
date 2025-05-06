<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Prioridades;
use App\Models\Prioridades as Prioridad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Unidades as RegistrarTransporte;
use App\Models\User as Recolectores;
use App\Models\RegistrarProblemas as Tickets;
use App\Models\Rutas as Rutas;

class RegistrarProblemas extends Controller
{
  public function index()
  {
    $unidades = RegistrarTransporte::all();
    $prioridades = Prioridad::all();
    return view('content.pages.recolector.tickets', compact('unidades', 'prioridades'));
  }

  public function store(Request $request)
  {
    $userId = auth()->id();

    $request->validate([
      'search_unidad' => 'required',
      'area_detalle' => 'required',
      'prioridad' => 'required', // Cambia el nombre en tu formulario a 'prioridad'
      'status' => 'required',
    ]);

    // Obtener ID de la unidad
    $unidad = DB::table('registrar_unidad')
      ->where('num_unidad', $request->search_unidad)
      ->first();

    if (!$unidad) {
      return back()->with('error', 'Unidad no encontrada');
    }

    // Obtener ID de la prioridad
    $prioridad = DB::table('prioridades')
      ->where('nombre', $request->prioridad) // depende de cómo esté nombrada en tu DB
      ->first();

    if (!$prioridad) {
      return back()->with('error', 'Prioridad no válida');
    }

    // Si tienes rutas en el formulario, aquí un ejemplo:
    $ruta = DB::table('rutas')
      ->where('nombre', $request->ruta) // solo si tienes ruta en el formulario
      ->first();

    if (!$ruta) {
      return back()->with('error', 'Ruta no válida');
    }

    // Crear el ticket
    $createTicket = Tickets::create([
      'id_usuario' => $userId,
      'id_unidad' => $unidad->id,
      'id_ruta' => $ruta->id,
      'id_prioridad' => $prioridad->id,
      'descripcion' => $request->area_detalle,
      'status' => $request->status,
    ]);
    dd(request()->all());
    return redirect()->route('tickets-recolector')->with('success', 'Ticket registrado correctamente');
  }
}
