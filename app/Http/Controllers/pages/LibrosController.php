<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Libros;
use Illuminate\Http\Request;

class LibrosController extends Controller
{
  public function index(){
    $libros = Libros::all();
    return view('content.pages.register', compact('libros'));


  }
  public function store(Request $request){

    $request->validate([
      'titulo' => 'required',
      'autor' => 'required',
      'dated' => 'required',
    ]);

    Libros::create([
        'titulo' => $request->titulo,
      'autor' => $request->autor,
      'fecha' => $request->dated,
    ]);
    return redirect()->route('register')->with('status', 'Libro registrado');
  }
}
