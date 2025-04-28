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
        Schema::create('tablaprecios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tipo_basura')->constrained('tipobasura')->onDelete('cascade');
            $table->double('tokens_por_kg', 8, 2);
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
        Schema::dropIfExists('tablaprecios');
    }
};
