<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoBasura extends Model
{
    use HasFactory;
    protected $table = 'tipobasura';
    protected $fillable = ['numero', 'nombre'];
}
