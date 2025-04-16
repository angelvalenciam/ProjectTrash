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
         // Primero eliminamos la clave foránea existente
         Schema::table('historial_tokens', function (Blueprint $table) {
            $table->dropForeign(['id_usuario']);  // Eliminar la clave foránea antigua
        });

        // Ahora agregamos la nueva clave foránea apuntando a la tabla 'users'
        Schema::table('historial_tokens', function (Blueprint $table) {
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
        // Si queremos revertir los cambios, restauramos la clave foránea anterior
        Schema::table('historial_tokens', function (Blueprint $table) {
            $table->dropForeign(['id_usuario']);  // Eliminar la clave foránea actual

            // Restauramos la clave foránea hacia 'usuarios'
            $table->foreign('id_usuario')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }
};
