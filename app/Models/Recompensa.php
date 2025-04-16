<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recompensa extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = 'historial_tokens'; // Nombre de la tabla
    protected $fillable = ['id_usuario', 'id_vaciado', 'tokens_asignados']; // Asegúrate de tener estos campos en la tabla

    // Relación con el usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    // Relación con vaciado
    public function vaciado()
    {
        return $this->belongsTo(VaciarContenedor::class, 'id_vaciado');
    }
    // Relación con división del contenedor

}

