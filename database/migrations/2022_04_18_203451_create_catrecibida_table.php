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
            $table->unsignedBigInteger('id_categoria');//apunta al comportamiento
            $table->foreign('id_categoria')->references('id')->on('comportamiento_categ');//llave foranea para referenciar a la tabla categorias
            $table->unsignedBigInteger('id_comportamiento');//apunta al comportamiento
            $table->foreign('id_comportamiento')->references('id')->on('categoria_reconoc');
            $table->integer('puntos');
            $table->integer('cat1')->default(0);
            $table->integer('cat2')->default(0);
            $table->integer('cat3')->default(0);
            $table->integer('cat4')->default(0);
            $table->integer('cat5')->default(0);
            $table->DateTime('fecha');
            $table->string('detalle');
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
