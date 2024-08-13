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
        Schema::create('comunicacion', function (Blueprint $table) {
            $table->id();
            $table->string('imagen');
            $table->text('descrip')->nullable(); // Crea un campo 'content' de tipo text
            $table->integer('posicion'); // posicion de la imagen
            $table->string('colorletra')->nullable();
            $table->string('colorfondo')->nullable();
            $table->integer('estado');
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
        Schema::dropIfExists('comunicacion');
    }
};
