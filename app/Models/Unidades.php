<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidades extends Model
{
  use HasFactory;

  protected $table = 'registrar_unidad';

  protected $fillable = [
    'num_unidad',
    'marca',
    'modelo',
    'placa'
  ];
}
