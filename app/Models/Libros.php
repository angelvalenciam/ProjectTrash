<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libros extends Model
{
    use HasFactory;
    protected $table = 'libros_re';
    protected $fillable = [
      'titulo',
      'autor',
      'fecha',
    ];
}
