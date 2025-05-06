<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\VaciarContenedor;

class HomePage extends Controller
{
  public function index()
  {
    $idUser = auth()->id();
    $ganancias = User::all();
    $vaciado = VaciarContenedor::all();

    $buscarToken = DB::table('users')->select('tokens')
      ->where('id', $idUser)
      ->first();
    $totalesVaciados = DB::table('vaciado_contenedor')
      ->where('id_usuario', $idUser)
      ->sum('cantidad_vaciada');

    return view('content.pages.pages-home', compact('buscarToken', 'totalesVaciados'));
  }
}
