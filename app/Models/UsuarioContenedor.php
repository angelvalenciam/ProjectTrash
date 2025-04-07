<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioContenedor extends Model
{
    use HasFactory;
    protected $table = 'usuario_contenedor';
    protected $fillable = ['id_usuario', 'id_contenedor'];

  public function usuario()
  {
    return $this->belongsTo(User::class, 'id_usuario');
  }

  public function contenedor()
  {
    return $this->belongsTo(Contenedor::class, 'id_contenedor');
  }
}
