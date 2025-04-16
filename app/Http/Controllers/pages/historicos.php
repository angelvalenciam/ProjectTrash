<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VaciarContenedor;
use App\Models\TipoBasura;
use App\Models\Usuario;

class historicos extends Controller
{
  public function index(Request $request)
  {
      $userId = Auth::id();
      $query = VaciarContenedor::where('id_usuario', $userId)
          ->with('divisionContenedor.tipoBasura', 'divisionContenedor.contenedor');

      // Filtrado por fecha
      $filtro = $request->input('filtro');

      switch ($filtro) {
          case 'hoy':
              $query->whereDate('created_at', now()->toDateString());
              break;
          case 'semana':
              $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
              break;
          case 'mes':
              $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
              break;
          case 'rango':
              if ($request->filled('desde') && $request->filled('hasta')) {
                  $query->whereBetween('created_at', [$request->input('desde'), $request->input('hasta')]);
              }
              break;
      }

      $registros = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

      return view('content.pages.historicos', compact('registros'));
  }

}
