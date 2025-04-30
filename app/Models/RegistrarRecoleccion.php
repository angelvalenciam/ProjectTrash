<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\VaciarContenedor;

class RegistrarRecoleccion extends Model
{
  use HasFactory;

  protected $table = 'recolectar_residuos';
  protected $fillable = ['id_user', 'id_vaciado_contenedor'];

  public function usuario()
  {
    return $this->belongsTo(User::class, 'id_user');
  }

  // Relación con vaciado_contenedor
  public function vaciado()
  {
    return $this->belongsTo(VaciarContenedor::class, 'id_vaciado_contenedor');
  }
}
