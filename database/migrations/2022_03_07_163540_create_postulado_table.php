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
            $table->string('descripcion');
            $table->unsignedBigInteger('id_postulado');//atributo para referenciar a usuarios
            $table->foreign('id_postulado')->references('id')->on('users');//llave foranea para referenciar a la tabla usuarios
            $table->integer('votos_post'); //numero de votos con lo que se postula
            $table->unsignedBigInteger('id_votante');//atributo para referenciar a usuarios
            //se guara el id del usuario que vota
            $table->foreign('id_votante')->references('id')->on('users');//llave foranea para referenciar a la tabla usuarios
            $table->dateTime('fecha_voto');

            $table->unsignedBigInteger('id_estado');//atributo para referenciar a estado
            $table->foreign('id_estado')->references('id')->on('estado');//llave foranea para referenciar a la tabla estado
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
