<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VaciarContenedor;
use App\Models\TipoBasura;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCharts;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\ChartType;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Layout;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;

class historicos extends Controller
{
  public function index(Request $request)
  {
      $userId = Auth::id();
      $query = VaciarContenedor::where('id_usuario', $userId)
          ->with('divisionContenedor.tipoBasura', 'divisionContenedor.contenedor');

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

      // Agrupamos para el resumen total
      $resumen = VaciarContenedor::selectRaw('
              contenedores.nombre as nombre_contenedor,
              tipobasura.nombre as nombre_tipo_basura,
              SUM(vaciado_contenedor.cantidad_vaciada) as total_kg
          ')
          ->join('division_contenedor', 'vaciado_contenedor.id_division_contenedor', '=', 'division_contenedor.id')
          ->join('contenedores', 'division_contenedor.id_contenedor', '=', 'contenedores.id')
          ->join('tipobasura', 'division_contenedor.id_tipo_basura', '=', 'tipobasura.id')
          ->where('vaciado_contenedor.id_usuario', $userId)
          ->when($filtro === 'hoy', fn($q) => $q->whereDate('vaciado_contenedor.created_at', now()->toDateString()))
          ->when($filtro === 'semana', fn($q) => $q->whereBetween('vaciado_contenedor.created_at', [now()->startOfWeek(), now()->endOfWeek()]))
          ->when($filtro === 'mes', fn($q) => $q->whereMonth('vaciado_contenedor.created_at', now()->month)->whereYear('vaciado_contenedor.created_at', now()->year))
          ->when($filtro === 'rango' && $request->filled('desde') && $request->filled('hasta'), fn($q) => $q->whereBetween('vaciado_contenedor.created_at', [$request->input('desde'), $request->input('hasta')]))
          ->groupBy('contenedores.nombre', 'tipobasura.nombre')
          ->get();

      return view('content.pages.historicos', compact('registros', 'resumen'));
  }

}
