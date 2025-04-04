<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoBasura extends Model
{
    use HasFactory;
    protected $table = 'division_contenedor';
    protected $fillable = ['numero', 'nombre'];
}
