<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TablaPrecios extends Model
{
    use HasFactory;

    // Definir la tabla explícitamente si el nombre no sigue la convención
    protected $table = 'tablaprecios';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'id_tipo_basura',
        'tokens_por_kg',
    ];

    // Relación con el modelo TipoBasura
    public function tipoBasura()
    {
        return $this->belongsTo(TipoBasura::class, 'id_tipo_basura');
    }
}
