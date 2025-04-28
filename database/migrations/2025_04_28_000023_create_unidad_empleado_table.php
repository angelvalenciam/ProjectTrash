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
    Schema::create('unidad_empleado', function (Blueprint $table) {
      $table->id();
      $table->foreignId('id_empleado')->constrained('register_recolector')->onDelete('cascade');
      $table->foreignId('id_unidad')->constrained('registrar_unidad')->onDelete('cascade');
      $table->foreignId('id_ruta')->constrained('registrar_rutas')->onDelete('cascade');
      $table->timestamps();
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
    Schema::dropIfExists('unidad_empleado');
  }
};
