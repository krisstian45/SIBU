<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Menus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            // Se definen los campos de la tabla menus
            $table->increments('id');
            $table->datetime('fecha');
            $table->integer('producto_id')->unsigned();
            // Se definen las relaciones de las claves foraneas
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('RESTRICT')->onUpdate('CASCADE'); // Si se intenta borrar un producto y este esta en un menu se niega el borrado. Si se actualiza un producto se actualiza el menu.
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
        Schema::drop('menus');
    }
}

?>