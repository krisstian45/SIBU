<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Pedidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            // Se definen los campos de la tabla pedidos
            $table->increments('id');
            $table->string('estado', 45);
            $table->datetime('fecha');
            $table->string('observacion');
            $table->integer('usuario_id')->unsigned();
            // Se definen las relaciones de las claves foraneas
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('RESTRICT')->onUpdate('CASCADE'); // Si se intenta borrar un usuario y este tiene pedidos se niega el borrado. Si se actualiza un usuario se actualiza el pedido.
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
        Schema::drop('pedidos');
    }
}
