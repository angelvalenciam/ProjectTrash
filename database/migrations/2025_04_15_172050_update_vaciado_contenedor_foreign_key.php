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
        Schema::table('vaciado_contenedor', function (Blueprint $table) {
            // Eliminar la clave foránea actual
            $table->dropForeign(['id_usuario']);

            // Agregar la clave foránea correcta
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vaciado_contenedor', function (Blueprint $table) {
            // Revertir el cambio de clave foránea
            $table->dropForeign(['id_usuario']);
            $table->foreign('id_usuario')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }
};
