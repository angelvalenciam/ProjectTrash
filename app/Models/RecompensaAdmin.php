<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecompensaAdmin extends Model
{
    use HasFactory;

    protected $table = "recompensas";
    protected $fillable = ["titulo", "descripcion", "precio", "imagen"]; // Añadido el campo "imagen"
}
