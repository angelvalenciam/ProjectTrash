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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique(); // Nombre de usuario
            $table->string('nombres'); // Nombre completo
            $table->string('apellidos');
            $table->string('ciudad');
            $table->string('colonia');
            $table->string('numero_exterior');
            $table->text('descripcion_vivienda')->nullable();
            $table->double('tokens', 8, 2)->default(0)->nullable(); // Tokens con dos decimales, inicia en 0
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
