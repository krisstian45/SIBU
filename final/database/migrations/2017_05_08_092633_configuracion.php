<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Configuracion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracion', function (Blueprint $table) {
            // Se definen los campos de la tabla configuracion
            $table->increments('id');
            $table->string('titulo');
            $table->string('descripcion');
            $table->string('email');
            $table->integer('elementos');
            $table->boolean('habilitado');
            $table->string('mensaje');
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
        Schema::drop('configuracion');
    }
}
