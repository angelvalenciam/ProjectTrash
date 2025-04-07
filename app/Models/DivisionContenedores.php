<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DivisionContenedores extends Model
{
    use HasFactory;
    protected $table = 'division_contenedor';
    protected $fillable = ['id_contenedor', 'id_tipo_basura', 'cantidad_kg'];
  // Relación con contenedor
  public function contenedor()
  {
    return $this->belongsTo(Contenedor::class, 'id_contenedor');
  }

  // Relación con tipo de basura
  public function tipoBasura()
  {
    return $this->belongsTo(TipoBasura::class, 'id_tipo_basura');
  }
}
