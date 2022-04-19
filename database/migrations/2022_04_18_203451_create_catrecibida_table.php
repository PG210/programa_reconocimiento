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
        Schema::create('catrecibida', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user_recibe');//atributo para referenciar a categoria
            $table->foreign('id_user_recibe')->references('id')->on('users');//llave foranea para referenciar a la tabla categorias
            $table->unsignedBigInteger('id_user_envia');//atributo para referenciar a categoria
            $table->foreign('id_user_envia')->references('id')->on('users');//llave foranea para referenciar a la tabla categorias
            $table->unsignedBigInteger('id_categoria_rec');
            $table->foreign('id_categoria_rec')->references('id')->on('categoria_reconoc');//llave foranea para referenciar a la tabla categorias
            $table->integer('puntos');
            $table->string('fecha');
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
        Schema::dropIfExists('catrecibida');
    }
};
