<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Suscripciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suscripciones', function (Blueprint $table) {
            // Se definen los campos de la tabla suscripciones
            $table->string('chat_id', 45)->primary();
            $table->string('nombre', 45);
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
        Schema::drop('suscripciones');
    }
}
