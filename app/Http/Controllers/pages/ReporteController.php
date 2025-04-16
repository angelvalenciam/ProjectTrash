<?php

namespace App\Http\Controllers\pages;
use App\Exports\HistoricoResiduosExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
  public function exportarHistorico()
  {
      // Aquí llamamos a tu método personalizado export()
      return (new HistoricoResiduosExport)->export();
  }
}
