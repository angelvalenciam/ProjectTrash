<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioContenedor extends Model
{
    use HasFactory;
    protected $table = 'usuario_contenedor';
    protected $fillable = ['id_usuario', 'id_contenedor'];
}
