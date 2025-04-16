<?php

namespace App\Exports;

use App\Models\VaciarContenedor;
use Maatwebsite\Excel\Concerns\FromCollection;

class HistoricoResiduosExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return VaciarContenedor::all();
    }
}
