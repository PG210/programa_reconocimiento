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
        Schema::create('noti_insignia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_insignoti');//usuario a quien le pertenece la notificacion
            $table->foreign('id_insignoti')->references('id')->on('insignia_obtenida'); 
            $table->String('estado');//estado puede ser 1 o 0 dependiendo si esta leido o no
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
        Schema::dropIfExists('noti_insignia');
    }
};
