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
        Schema::create('insignia_obtenida', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_insignia');//atributo para referenciar a insignias
            $table->foreign('id_insignia')->references('id')->on('insignia');//llave foranea para referenciar a la tabla categorias
            $table->unsignedBigInteger('id_usuario');//atributo para referenciar a categoria
            $table->foreign('id_usuario')->references('id')->on('users');//llave foranea para referenciar a la tabla categorias
            $table->string('fecha');
            $table->integer('puntos_acumulados');
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
        Schema::dropIfExists('insignia_obtenida');
    }
};
