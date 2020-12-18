<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ComprasDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras_detalle', function (Blueprint $table) {
            // Se definen los campos de la tabla compras_detalle
            $table->increments('id');
            $table->integer('cantidad');
            $table->float('precio_unitario');
            $table->integer('compra_id')->unsigned();
            $table->integer('producto_id')->unsigned();
            // Se definen las relaciones de las claves foraneas
            $table->foreign('compra_id')->references('id')->on('compras')->onDelete('RESTRICT')->onUpdate('CASCADE'); // Si se intenta borrar una compra y esta tiene compras detalle se niega el borrado. Si se actualiza una compra se actualiza el detalle de la compra.
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('RESTRICT')->onUpdate('CASCADE'); // Si se intenta borrar un producto y este tiene compras se niega el borrado. Si se actualiza una producto se actualiza el detalle de la compra.
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
        Schema::drop('compras_detalle');
    }
}
