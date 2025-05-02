<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Unidades as RegistrarTransporte;

class RegistrarUnidad extends Controller
{
  public function index()
  {
    return view('content.pages.admin.registrarUnidad');
  }

  public function store(Request $request)
  {

    $request->validate([
      'input_marca' => 'required | string',
      'input_modelo' => 'required ',
      'input_placa' => 'required'
    ]);

    try {

      $numeroSerie = $this->createSerialNumber();

      $unidadNueva = RegistrarTransporte::create([
        'num_unidad' => $numeroSerie,
        'marca' => $request->input_marca,
        'modelo' => $request->input_modelo,
        'placa' => $request->input_placa,
      ]);

      return redirect()->route('registrarunidades-admin')->with('success', 'Unidad registrada correctamente');

    } catch (\Exception $e) {

      return back()->withErrors(['error' => 'Error al intentar registrar unidad ' . $e->getMessage()]);
    };
  }

  // generar numero de unidad
  public function createSerialNumber()
  {
    do {
      $serial = 'NOG-' . strtoupper(Str::random(6));
    } while (RegistrarTransporte::where('num_unidad', $serial)->exists());
    return $serial;


  }


}
