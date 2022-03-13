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
        Schema::create('categoria_reconoc', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('descripcion');
            $table->unsignedBigInteger('id_comportamiento');//atributo para referenciar a tabla comportamiento_categ
            $table->foreign('id_comportamiento')->references('id')->on('comportamiento_categ');//llave foranea para referenciar a la tabla comportamiento_categ
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
        Schema::dropIfExists('categoria_reconoc');
    }
};
