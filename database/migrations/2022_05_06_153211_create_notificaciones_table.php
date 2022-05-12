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
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->String('notinom');//nombre de la notificacion insignia o reconocimiento
            $table->String('notides');//descripcion ejem nueva notificacion
            $table->DateTime('fecha');//fecha de la notificacion
            $table->String('estado');//estado puede ser 1 o 0 dependiendo si esta leido o no
            $table->String('idnotifi');//ingrea el id del reconocimiento o insignia
            $table->unsignedBigInteger('id_user');//usuario a quien le pertenece la notificacion
            $table->foreign('id_user')->references('id')->on('users');
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
        Schema::dropIfExists('notificaciones');
    }
};
