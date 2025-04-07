<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoBasura extends Model
{
    use HasFactory;
    protected $table = 'tipobasura';
    protected $fillable = ['numero', 'nombre'];

    public function contenedores()
    {
        return $this->belongsToMany(Contenedor::class, 'division_contenedor')
                    ->withPivot('cantidad_kg'); // Asumiendo que 'cantidad_kg' es el peso
    }
    public function divisionContenedores()
    {
        return $this->hasMany(DivisionContenedores::class, 'id_tipo_basura');
    }
}
