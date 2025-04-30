<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\RegistrarRecoleccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\RegistrarRecolector;
class recolectar extends Controller
{
  public function index(Request $request)
  {
    $vaciadoId = $request->get('ticket_id'); // aquí realmente es el ID del vaciado

    $vaciado = null;
    $usuario = null;
    $qrCode = null;

    if ($vaciadoId) {
      // Buscar vaciado con joins para obtener tipo de basura y contenedor
      $vaciado = DB::table('vaciado_contenedor as vc')
        ->join('division_contenedor as dc', 'vc.id_division_contenedor', '=', 'dc.id')
        ->join('tipobasura as tb', 'dc.id_tipo_basura', '=', 'tb.id')
        ->join('contenedores as c', 'dc.id_contenedor', '=', 'c.id')
        ->where('vc.id', $vaciadoId)
        ->select(
          'vc.id',
          'vc.created_at',
          'vc.cantidad_vaciada',
          'vc.id_usuario',
          'tb.nombre as tipo_basura',
          'c.nombre as contenedor_nombre'
        )
        ->first();

      // Buscar datos del usuario si existe un vaciado
      if ($vaciado) {
        $usuario = User::select('nombres', 'apellidos', 'colonia', 'ciudad', 'numero_exterior')
          ->where('id', $vaciado->id_usuario)
          ->first();

        // QR opcional
      }
    }

    return view('content.pages.recolector.recolectar', compact('usuario', 'vaciado', 'qrCode'));
  }

  public function store(Request $request){

    $request->validate([
      'id_user' => 'required',
      'id_vaciado' => 'required',
    ]);

    RegistrarRecoleccion::create([
      'id_user' => $request->id_user,
      'id_vaciado_contenedor' => $request->id_vaciado,
    ]);

    return  redirect()->route('recolectar')->with('success', 'se registro correctamente');
  }
}
