<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecompensasTable extends Migration
{
    public function up()
    {
        Schema::create('recompensas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo'); // Corresponde al campo 'titulo'
            $table->text('descripcion'); // Corresponde al campo 'descripcion'
            $table->decimal('precio', 8, 2); // Corresponde al campo 'precio'
            $table->string('imagen')->nullable(); // Corresponde al campo 'imagen'
            $table->timestamps(); // Para las columnas created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('recompensas');
    }
}
