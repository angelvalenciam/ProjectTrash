<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenedor extends Model
{
    use HasFactory;
    protected  $table = 'contenedores';
    protected $fillable = ['nombre', 'numero_serie'];

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'usuario_contenedor', 'id_contenedor', 'id_usuario');
    }
}
