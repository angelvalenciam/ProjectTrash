<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialTokens extends Model
{
  use HasFactory;

  protected $fillable = ['id_usuario', 'id_vaciado', 'tokens_asignados', 'fecha_asignacion'];

  public function usuario()
  {
    return $this->belongsTo(Usuario::class, 'id_usuario');
  }

  public function vaciado()
  {
    return $this->belongsTo(VaciadoContenedor::class, 'id_vaciado');
  }
}
