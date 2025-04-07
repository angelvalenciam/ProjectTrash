<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaciarContenedor extends Model
{
  use HasFactory;
  protected $table = 'vaciado_contenedor';
  protected $fillable = ['id_division_contenedor', 'id_usuario', 'cantidad_vaciada'];

  public function divisionContenedores()
  {
    return $this->hasMany(DivisionContenedores::class, 'id_contenedor');
  }
  public function usuarios()
  {
    return $this->belongsToMany(User::class, 'usuario_contenedor', 'id_contenedor', 'id_usuario');
  }
}
