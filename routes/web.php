<?php

use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Rules\Role;
use App\Http\Controllers\AwsController;
use App\Exports\HistoricoResiduosExport;
use App\Http\Controllers\pages\ContenedorController;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\DivisionContenedores;
use App\Models\Contenedor;
use App\Models\VaciarContenedor;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\ReporteController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Endroid\QrCode\Builder\Builder;

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
  Route::post('/usercontrol/register', [$controller_path . '\pages\userAdmin', 'store'])->name('user-control.store')->middleware('role:admin');


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
  Route::post('/recompensas-user/redeem', [$controller_path . '\pages\recompensasuser', 'redeem'])->name('recompensas-user.redeem');

  //
  //historicos
  Route::get('/historicos', [$controller_path . '\pages\historicos', 'index'])->name('historicos-user')->middleware('role:escritor');
  Route::get('/historicos', [$controller_path . '\pages\historicos', 'index'])
    ->middleware(['auth:sanctum', 'verified', 'role:escritor'])
    ->name('historicos-user');
  // exportar excel historicos
  // Route::get('/exportar-historico', [HistoricoResiduosExport::class, 'export'])->name('exportar-historico');
  Route::get('/exportar-historico', [ReporteController::class, 'exportarHistorico'])->name('exportar-historico');
  //end
  // Solo user puede acceder
  // Route::get('/contenedor/{id}/niveles', [$controller_path . '\pages\Page2',  'niveles'])->middleware('role:escritor');
  Route::post('/page-2/generar-pdf', [$controller_path . '\pages\Page2', 'generarPDF'])->middleware('role:escritor');
  Route::get('/page-2', [$controller_path . '\pages\Page2', 'index'])->name('pages-page-2')->middleware('role:escritor');
  Route::get('/page-3/contenedor/{id}/niveles', [$controller_path . '\pages\Page2', 'showContainerData'])->middleware('role:escritor');
  Route::get('/page-2/testp', [$controller_path . '\pages\Page2', 'tst'])->name('ticket.vaciado');
  Route::post('/contenedor/vaciar', [$controller_path . '\pages\Page2', 'vaciarContenedor'])->middleware('role:escritor');
  // Route::get('/page-3/contenedor/{id}/niveles', [$controller_path . '\pages\Page2', 'showContainerData'])->middleware('role:escritor');
  Route::get('/page-3/contenedor/{id}/niveles', [$controller_path . '\pages\Page2', 'showContainerData'])->middleware('role:escritor');
  //pdf

  // routes/web.php
  Route::post('/contenedor/generar-pdf', [$controller_path . '\pages\Page2', 'generarPDF']);

  //end
  Route::get('/probar-insert', [$controller_path . '\pages\Page2', 'pruebaInsert'])->middleware('role:escritor');;

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


  // Recolector
  // Recolector
  Route::get('/recolectar', [$controller_path . '\pages\recolectar', 'index'])->name('recolectar')->middleware('role:recolector');
  Route::post('/recolectar/registrar', [$controller_path . '\pages\recolectar', 'store'])->name('recolectar.registrar')->middleware('role:recolector');

  // Registrar unidad
  Route::get('/registrarUnidad', [$controller_path . '\pages\RegistrarUnidad', 'index'])->name('registrarunidades-admin')->middleware('role:admin');
  Route::post('/registrar', [$controller_path . '\pages\RegistrarUnidad', 'store'])->name('registrar-store')->middleware('role:admin');
});

