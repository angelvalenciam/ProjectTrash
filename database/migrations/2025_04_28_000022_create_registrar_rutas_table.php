<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('registrar_rutas', function (Blueprint $table) {
      $table->id();
      $table->string('num_ruta');
      $table->string('colonia')->nullable();
      $table->string('descripcion_vivienda')->nullable();
      $table->integer('cantidad_casas');
      $table->integer('cantidad_clientes');
      $table->double('avance');
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
    Schema::dropIfExists('registrar_rutas');
  }
};
