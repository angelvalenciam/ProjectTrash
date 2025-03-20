<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('division_contenedor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_contenedor')->constrained('contenedores')->onDelete('cascade');
            $table->foreignId('id_tipo_basura')->constrained('tipobasura')->onDelete('cascade');
            $table->double('cantidad_kg');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('division_contenedor');
    }
};
