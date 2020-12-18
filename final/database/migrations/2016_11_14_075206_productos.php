<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Productos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            // Se definen los campos de la tabla productos
            $table->increments('id');
            $table->string('nombre_producto', 100);
            $table->string('marca', 45);
            // BUSCAR COMO DECLARAR UN BIG INT
            $table->integer('codigo_barra');
            $table->integer('stock');
            $table->integer('stock_minimo');
            $table->datetime('fecha_alta');
            $table->string('proveedor', 45);
            $table->float('precio_venta_unitario');
            $table->string('descripcion');
            $table->integer('categoria_id')->unsigned();
            // Se definen las relaciones de las claves foraneas
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('RESTRICT')->onUpdate('CASCADE'); // Si se intenta borrar una categoria y esta tiene productos se niega el borrado. Si se actualiza una categoria se actualizan los productos.
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
        Schema::drop('productos');
    }
}

?>
