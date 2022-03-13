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
        Schema::create('votacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_postulado');//atributo para referenciar a usuarios postulados para votar pueden ser 3 los que pasen
            $table->foreign('id_postulado')->references('id')->on('postulado');//llave foranea para referenciar a la tabla usuarios
            $table->integer('numero_votos');
            $table->unsignedBigInteger('id_votante');//atributo para referenciar a usuarios
            $table->foreign('id_votante')->references('id')->on('users');//llave foranea para referenciar a la tabla usuarios
            $table->dateTime('fecha_voto'); //fecha en que realiza el voto           
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
        Schema::dropIfExists('votacion');
    }
};
