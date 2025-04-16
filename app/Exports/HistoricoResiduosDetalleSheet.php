<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use App\Models\VaciarContenedor;

class HistoricoResiduosDetalleSheet implements FromCollection, WithHeadings
{
    public function collection()
    {
        $registros = VaciarContenedor::with('divisionContenedor.tipoBasura', 'divisionContenedor.contenedor')
            ->where('id_usuario', auth()->id())
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

    public function headings(): array
    {
        return [
            'Nombre de Dispositivo',
            'Tipo de Basura',
            'Cantidad Vaciada (kg)',
            'Fecha',
        ];
    }
}
