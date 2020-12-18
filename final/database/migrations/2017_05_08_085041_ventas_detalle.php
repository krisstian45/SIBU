<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VentasDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas_detalle', function (Blueprint $table) {
            // Se definen los campos de la tabla ventas_detalle
            $table->increments('id');
            $table->integer('cantidad');
            $table->float('precio_unitario');
            $table->string('descripcion');
            $table->integer('venta_id')->unsigned();
            $table->integer('producto_id')->unsigned();
            // Se definen las relaciones de las claves foraneas
            $table->foreign('venta_id')->references('id')->on('ventas')->onDelete('RESTRICT')->onUpdate('CASCADE'); // Si se intenta borrar una venta y esta tiene ventas detalle se niega el borrado. Si se actualiza una venta se actualiza el detalle de la venta.
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('RESTRICT')->onUpdate('CASCADE'); // Si se intenta borrar un producto y este tiene ventas se niega el borrado. Si se actualiza un producto se actualiza el detalle de la venta.
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
        Schema::drop('ventas_detalle');
    }
}

?>