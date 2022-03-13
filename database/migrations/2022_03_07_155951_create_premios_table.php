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
        Schema::create('premios', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('descripcion');
            $table->integer('puntos');
            $table->unsignedBigInteger('id_imagen');//atributo para referenciar a tabla imagen
            $table->foreign('id_imagen')->references('id')->on('imagen');//llave foranea para referenciar a la tabla imagen
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
        Schema::dropIfExists('premios');
    }
};
