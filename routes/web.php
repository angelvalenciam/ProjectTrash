<?php

use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Rules\Role;
use App\Http\Controllers\AwsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Main Page Route

// pages


// Proteger las rutas con un rol específico
Route::middleware([
  'auth:sanctum',
  config('jetstream.auth_session'),
  'verified'
])->group(function () {

  $controller_path = 'App\Http\Controllers';


  // Solo admin puede acceder
  Route::get('/', [$controller_path . '\pages\HomePage', 'index'])->name('pages-home')->middleware('role:escritor');

  // Admin routes

  //dashboard
  Route::get('/dashboard', [$controller_path . '\pages\dashboardAdmin', 'index'])->name('dashboard')->middleware('role:admin');
  //end

  // control users

  Route::get('/usercontrol', [$controller_path . '\pages\userAdmin', 'index'])->name('user-control')->middleware('role:admin');

  //end

  // recompensas
  // Route::get('/recompensasA', [$controller_path . '\pages\adminRecompensas', 'index'])->name('recompensas-admin')->middleware('role:admin');
  // Route::get('/recompensasA-create', [$controller_path . '\pages\adminRecompensas', 'create'])->name('recompensa.create')->middleware('role:admin');
  // Route::post('/recompensasA', [$controller_path . '\pages\adminRecompensas', 'store'])->name('recompensa-admin.store')->middleware('role:admin');
  // web.php
  Route::get('/recompensasA', [$controller_path . '\pages\adminRecompensas', 'index'])->name('recompensas-admin')->middleware('role:admin');
  Route::get('/recompensasA-create', [$controller_path . '\pages\adminRecompensas', 'create'])->name('recompensa.create')->middleware('role:admin');
  Route::post('/recompensasA', [$controller_path . '\pages\adminRecompensas', 'store'])->name('recompensa-admin.store')->middleware('role:admin');
  Route::put('/recompensasA/{id}', [$controller_path . '\pages\adminRecompensas', 'update'])->name('recompensa.update')->middleware('role:admin');
  Route::get('/recompensasA/{id}/edit', [$controller_path . '\pages\adminRecompensas', 'edit'])->name('recompensa.edit')->middleware('role:admin');

  // Route::put('/recompensasA/{id}', [$controller_path . '\pages\adminRecompensas','update'])->name('recompensa.update')->middleware('role:admin');
  Route::delete('/recompensasA/{id}', [$controller_path . '\pages\adminRecompensas', 'destroy'])->name('recompensa.destroy')->middleware('role:admin');

  // end

  // Solo recompensas puede acceder
  Route::get('/page-3', [$controller_path . '\pages\Recompensas', 'index'])->name('pages-page-3')->middleware('role:escritor');


  //end

  // Rencompensas real
  Route::get('/rencompensas', [$controller_path . '\pages\recompensasuser', 'index'])->name('recompensas-user')->middleware('role:escritor');
  //
  //historicos
  Route::get('/historicos', [$controller_path . '\pages\historicos', 'index'])->name('historicos-user')->middleware('role:escritor');
  Route::get('/historicos', [$controller_path . '\pages\historicos','index'])
  ->middleware(['auth:sanctum', 'verified', 'role:escritor'])
  ->name('historicos-user');

  //end

  // Solo user puede acceder
  // Route::get('/contenedor/{id}/niveles', [$controller_path . '\pages\Page2',  'niveles'])->middleware('role:escritor');
  Route::get('/page-2', [$controller_path . '\pages\Page2', 'index'])->name('pages-page-2')->middleware('role:escritor');
  Route::get('/page-3/contenedor/{id}/niveles', [$controller_path . '\pages\Page2', 'showContainerData'])->middleware('role:escritor');
  Route::post('/contenedor/vaciar', [$controller_path . '\pages\Page2', 'vaciarContenedor'])->middleware('role:escritor');
  // Route::get('/page-3/contenedor/{id}/niveles', [$controller_path . '\pages\Page2', 'showContainerData'])->middleware('role:escritor');
  Route::get('/page-3/contenedor/{id}/niveles', [$controller_path . '\pages\Page2', 'showContainerData'])->middleware('role:escritor');

  Route::get('/probar-insert', [$controller_path . '\pages\Page2', 'pruebaInsert']);


  //ahora quiero que al darle al boton vaciar, quiero que se guarde en la siguiente tabla vaciado_contenedor,
  //
  // registrar contenedores

  Route::get('/registercontainer', [$controller_path . '\pages\ContenedorController', 'index'])->name('register-container')->middleware('role:escritor');
  Route::post('/registercontainer', [$controller_path . '\pages\ContenedorController', 'store'])->name('contenedores.store')->middleware('role:escritor');
  Route::delete('/registercontainer/{id}', [$controller_path . '\pages\ContenedorController', 'destroy'])->name('contenedores.destroy')->middleware('role:escritor');

  Route::get('/registercontainer', [$controller_path . '\pages\ContenedorController', 'index'])->name('register-container')->middleware('role:admin');
  Route::post('/registercontainer', [$controller_path . '\pages\ContenedorController', 'store'])->name('contenedores.store')->middleware('role:admin');
  Route::delete('/registercontainer/{id}', [$controller_path . '\pages\ContenedorController', 'destroy'])->name('contenedores.destroy')->middleware('role:admin');

  // end


  // ruta test
});
