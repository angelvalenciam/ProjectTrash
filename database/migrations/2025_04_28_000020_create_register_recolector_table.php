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
    Schema::create('register_recolector', function (Blueprint $table) {
      $table->id();
      $table->string('num_empleado')->unique();
      $table->string('nombres');
      $table->string('apellidos');
      $table->string('email')->unique();
      $table->string('telefono')->unique();
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
    Schema::dropIfExists('register_recolector');
  }
};
