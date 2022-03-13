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
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->string('mensaje');
            $table->unsignedBigInteger('id_uscomen');//atributo para referenciar a usuario recibe el comentario
            $table->foreign('id_uscomen')->references('id')->on('users');//llave foranea para referenciar a la tabla usuarios
            $table->unsignedBigInteger('id_envcomen');//atributo para referenciar a usuarios que envian mensaje
            $table->foreign('id_envcomen')->references('id')->on('users');//llave foranea para referenciar a la tabla usuarios
            $table->unsignedBigInteger('id_icon');//enviar reacciones
            $table->foreign('id_icon')->references('id')->on('reacciones');//llave foranea para referenciar a la tabla reacciones
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
        Schema::dropIfExists('comentarios');
    }
};
