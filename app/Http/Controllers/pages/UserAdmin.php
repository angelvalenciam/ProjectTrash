<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

// << TE FALTABA ESTO
use App\Models\RegistrarRecolector;

class UserAdmin extends Controller
{
  public function index()
  {
    return view('content.pages.admin.users');
  }

  public function create()
  {
    //
  }

  public function store(Request $request)
  {


    $errors = [];

    if (DB::table('register_recolector')->where('email', $request->input('input_email'))->exists()) {
      $errors[] = 'Email';
    }
    if (DB::table('register_recolector')->where('telefono', $request->input('input_telefono'))->exists()) {
      $errors[] = 'Número de Teléfono';
    }

    do {
      $num_emp = random_int(10000, 99999);
    } while (DB::table('register_recolector')->where('num_empleado', $num_emp)->exists());

    if (!empty($errors)) {
      return back()->with('modal_error', 'Lo sentimos, el campo(s): ' . implode(', ', $errors) . ' que intenta registrar ya existe(n).')->withInput();
    } else {
      $request->validate([
        'input_name' => 'required|string',
        'input_apellidos' => 'required|string',
        'input_email' => 'required|email',
        'input_telefono' => 'required'
      ]);

      RegistrarRecolector::create([
        'num_empleado' => $num_emp,
        'nombres' => $request->input('input_name'),
        'apellidos' => $request->input('input_apellidos'),
        'email' => $request->input('input_email'),
        'telefono' => $request->input('input_telefono')
      ]);

      return redirect()->route('user-control')->with('success', 'El registro se guardó correctamente');

    }
  }
}
