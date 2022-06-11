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
        Schema::create('postulado', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_postulado');
            $table->foreign('id_postulado')->references('id')->on('users');
            $table->unsignedBigInteger('id_votocat');
            $table->foreign('id_votocat')->references('id')->on('comportamiento_categ');
            $table->unsignedBigInteger('id_votante');
            $table->foreign('id_votante')->references('id')->on('users');
            $table->string('periodo', 20);
            $table->string('anio', 20);
            $table->dateTime('fecha_voto');
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
        Schema::dropIfExists('postulado');
    }
};
