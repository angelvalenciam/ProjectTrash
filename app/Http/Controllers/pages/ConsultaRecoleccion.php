<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultaRecoleccion extends Controller
{
  public function index()
  {
    $recolecciones = DB::table('recolectar_residuos as rr')
      ->join('vaciado_contenedor as vc', 'rr.id_vaciado_contenedor', '=', 'vc.id')
      ->join('users as u', 'rr.id_recolector', '=', 'u.id')
      ->select(
        DB::raw("CONCAT(u.nombres, ' ', u.apellidos) as nombre_completo"),
        'vc.cantidad_vaciada'
      )
      ->paginate(10);

    return view('content.pages.recolector.consultar', compact('recolecciones'));
  }
}


