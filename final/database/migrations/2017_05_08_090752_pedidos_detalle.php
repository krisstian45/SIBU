<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PedidosDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos_detalle', function (Blueprint $table) {
            // Se definen los campos de la tabla pedidos_detalle
            $table->increments('id');
            $table->integer('cantidad');
            $table->float('precio_unitario');
            $table->integer('pedido_id')->unsigned();
            $table->integer('producto_id')->unsigned();
            // Se definen las relaciones de las claves foraneas
            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('RESTRICT')->onUpdate('CASCADE'); // Si se intenta borrar un pedido y este tiene pedidos detalle se niega el borrado. Si se actualiza un pedido se actualiza el detalle del pedido.
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('RESTRICT')->onUpdate('CASCADE'); // Si se intenta borrar un producto y este fue pedido se niega el borrado. Si se actualiza una producto se actualiza el detalle del pedido.
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
        Schema::drop('pedidos_detalle');
    }
}
