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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('apellido');
            $table->string('direccion')->nullable();
            $table->string('telefono');
            $table->unsignedBigInteger('id_rol'); //aqui sirve para conocer si el usuario es admin, jefe o visitante
            $table->foreign('id_rol')->references('id')->on('roles');//llave foranea para referenciar a la tabla users           <
            $table->unsignedBigInteger('id_cargo'); //aqui se registra el cargo al cual pertenece ventas, atencion al cliente
            $table->foreign('id_cargo')->references('id')->on('cargo');//llave foranea para referenciar a la tabla cargo            
            $table->string('imagen')->nullable(); //aqui se guarda la ruta de la imagen
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('id_estado'); //aqui se registra el cargo al cual pertenece ventas, atencion al cliente
            $table->foreign('id_estado')->references('id')->on('estado');//llave foranea para referenciar a la tabla cargo            
            $table->date('fecna')->nullable();
            $table->date('fecingreso')->nullable();
            $table->integer('superadmin')->default(0);
            $table->integer('postulado')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
