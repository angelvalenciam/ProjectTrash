<?php

namespace App\Exports;

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

class HistoricoResumenSheet implements FromArray, WithTitle, WithHeadings, WithCharts
{
    protected $data;

    public function __construct()
    {
        $this->data = DB::table('vaciado_contenedor')
            ->join('division_contenedor', 'vaciado_contenedor.id_division_contenedor', '=', 'division_contenedor.id')
            ->join('contenedores', 'division_contenedor.id_contenedor', '=', 'contenedores.id')
            ->join('tipobasura', 'division_contenedor.id_tipo_basura', '=', 'tipobasura.id')
            ->select(
                'contenedores.nombre as Dispositivo',
                'tipobasura.nombre as Tipo',
                DB::raw('SUM(vaciado_contenedor.cantidad_vaciada) as TotalKG')
            )
            ->where('vaciado_contenedor.id_usuario', auth()->id())
            ->groupBy('contenedores.nombre', 'tipobasura.nombre')
            ->get()
            ->map(fn ($item) => [$item->Dispositivo, $item->Tipo, $item->TotalKG])
            ->toArray();
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return ['Dispositivo', 'Tipo de Basura', 'Total Vaciado (kg)'];
    }

    public function title(): string
    {
        return 'Resumen Totales';
    }

    public function charts(): array
    {
        $labels = new DataSeriesValues('String', "'Resumen Totales'!B2:B" . (count($this->data) + 1), null, count($this->data));
        $values = new DataSeriesValues('Number', "'Resumen Totales'!C2:C" . (count($this->data) + 1), null, count($this->data));

        $series = new DataSeries(
            DataSeries::TYPE_BARCHART,
            null,
            range(0, count($this->data) - 1),
            [],
            [$labels],
            [$values]
        );

        $plotArea = new PlotArea(null, [$series]);
        $legend = new Legend();
        $title = new Title('Totales por Tipo de Basura');

        $chart = new Chart(
            'chart1',
            $title,
            $legend,
            $plotArea
        );

        $chart->setTopLeftPosition('E2');
        $chart->setBottomRightPosition('M20');

        return [$chart];
    }
}
