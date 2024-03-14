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
        Schema::create('usugrupos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idgrupo');
            $table->foreign('idgrupo')->references('id')->on('grupos');
            $table->unsignedBigInteger('idusu');
            $table->foreign('idusu')->references('id')->on('users');
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
        Schema::dropIfExists('usugrupos');
    }
};
