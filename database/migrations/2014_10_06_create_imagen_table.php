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
        Schema::create('imagen', function (Blueprint $table) {
            $table->id();
            $table->string('ruta');
            $table->string('nombre');
            $table->unsignedBigInteger('id_tipoimagen');//atributo para referenciar a area
            $table->foreign('id_tipoimagen')->references('id')->on('tipo_imagen');//llave foranea para referenciar a la tabla area
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
        Schema::dropIfExists('imagen');
    }
};
