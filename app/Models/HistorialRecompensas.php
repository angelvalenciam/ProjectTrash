<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialRecompensas extends Model
{
    use HasFactory;

    protected $table = 'historial_recompensas';
    protected $fillable = ['id_usuario', 'id_recompensa', 'tokens_gastados'];

    // Relación con usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    // Relación con recompensa
    public function recompensa()
    {
        return $this->belongsTo(Recompensa::class, 'id_recompensa');
    }
}
