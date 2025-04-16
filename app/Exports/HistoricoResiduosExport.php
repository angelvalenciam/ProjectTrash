<?php

namespace App\Exports;

use App\Models\VaciarContenedor;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
class HistoricoResiduosExport implements FromCollection, WithHeadings
{
  use Exportable;

  public function export()
  {
    return Excel::download(new HistoricoResiduosExport, 'historico_residuos.xlsx');
  }
  public function collection()
  {
    $registros = VaciarContenedor::with('divisionContenedor.tipoBasura', 'divisionContenedor.contenedor')
      ->where('id_usuario', auth()->id()) // Filtrar por usuario actual
      ->get()
      ->map(function ($registro) {
        return [
          'Dispositivo' => $registro->divisionContenedor->contenedor->nombre ?? 'No disponible',
          'Tipo de basura' => $registro->divisionContenedor->tipoBasura->nombre ?? 'No disponible',
          'Cantidad (kg)' => $registro->cantidad_vaciada,
          'Fecha' => $registro->created_at->format('d/m/Y H:i'),
        ];
      });

    return new Collection($registros);
  }
  public function exportarHistorico()
  {
    // Aquí llamamos a tu método personalizado export()
    return (new HistoricoResiduosExport)->export();
  }
  public function headings(): array
  {
    return [
      'Nombre de Dispositivo',
      'Tipo de Basura',
      'Cantidad Vaciada (kg)',
      'Fecha',
    ];
  }

  public function sheets(): array
  {
    return [
      new HistoricoResiduosDetalleSheet(),
      new HistoricoResumenSheet()
    ];
  }
}
