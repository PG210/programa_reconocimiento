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
        Schema::create('insignia', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('descripcion');
            $table->integer('puntos');
            $table->unsignedBigInteger('id_premio');//atributo para referenciar a premios
            $table->foreign('id_premio')->references('id')->on('premios');//llave foranea para referenciar a la tabla categorias
            $table->unsignedBigInteger('id_categoria');//atributo para referenciar a premios
            $table->foreign('id_categoria')->references('id')->on('comportamiento_categ');
            $table->string('rutaimagen');
            $table->string('tipo')->nullable(); //atributo para identificar las insignias de puntos
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
        Schema::dropIfExists('insignia');
    }
};
