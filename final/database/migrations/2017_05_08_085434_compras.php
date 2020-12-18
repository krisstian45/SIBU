<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Compras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            // Se definen los campos de la tabla compras
            $table->increments('id');
            $table->string('proveedor', 100);
            $table->string('proveedor_cuit', 15);
            $table->datetime('fecha');
            $table->string('nombreFactura', 50);
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
        Schema::drop('compras');
    }
}
