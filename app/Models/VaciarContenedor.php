<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaciarContenedor extends Model
{
  use HasFactory;

  protected $table = 'vaciado_contenedor';

  protected $fillable = ['id_division_contenedor', 'id_usuario', 'cantidad_vaciada'];

  // Relación con el usuario que vació el contenedor
  public function usuario()
  {
      return $this->belongsTo(User::class, 'id_usuario');
  }

  // Relación con la división del contenedor (si lo necesitas más adelante)
  public function divisionContenedor()
  {
      return $this->belongsTo(DivisionContenedores::class, 'id_division_contenedor');
  }
}
