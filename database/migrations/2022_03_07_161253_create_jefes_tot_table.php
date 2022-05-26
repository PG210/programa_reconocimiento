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
        Schema::create('jefes_tot', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jefe');//atributo para referenciar a users porque un jefe puede ser un usuario
            //se debe tener en cuenta los roles (admin, visitante, jefe)
            $table->foreign('id_jefe')->references('id')->on('users');//llave foranea para referenciar a la tabla users
            $table->unsignedBigInteger('id_reporta');//atributo para referenciar al resto de jefes
            $table->foreign('id_reporta')->references('id')->on('users');//llave foranea para referenciar a la tabla users            $table->timestamps();
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
        Schema::dropIfExists('jefes_tot');
    }
};
