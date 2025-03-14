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
        Schema::create('posicion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idusu');
            $table->foreign('idusu')->references('id')->on('users')->onDelete('cascade');
            $table->integer('posactual');
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
        Schema::dropIfExists('posicion');
    }
};
