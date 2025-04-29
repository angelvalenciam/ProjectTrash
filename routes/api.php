<?php

use App\Models\RegistrarRecolector as Recolector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\RegistrarRecolector;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::post('/test', function (Request $request) {
  $request->validate([
    'num_empleados' => 'required',
    'input_name' => 'required|string',
    'input_apellidos' => 'required|string',
    'input_email' => 'required|email',
    'input_telefono' => 'required'
  ]);

  RegistrarRecolector::create([
    'num_empleado' => $request->num_empleados,
    'nombre' => $request->input_name,
    'apellidos' => $request->input_apellidos,
    'email' => $request->input_email,
    'telefono' => $request->input_telefono
  ]);

  return response()->json('Se registró correctamente', 200);
});
