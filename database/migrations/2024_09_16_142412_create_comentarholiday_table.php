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
        Schema::create('comentarholiday', function (Blueprint $table) {
            $table->id();
            $table->text('comentario')->nullable();
            $table->unsignedBigInteger('iduser');
            $table->foreign('iduser')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('useraccion');
            $table->foreign('useraccion')->references('id')->on('users')->onDelete('cascade');
            $table->integer('tipo')->nullable(); //1 cumple y 2 para aniversario
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
        Schema::dropIfExists('comentarholiday');
    }
};
