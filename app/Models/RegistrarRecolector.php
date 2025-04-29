<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrarRecolector extends Model
{
  use HasFactory;

  protected $table = 'register_recolector';

  protected $fillable = [
    'num_empleado',
    'nombres',
    'apellidos',
    'email',
    'telefono'
  ];

}
