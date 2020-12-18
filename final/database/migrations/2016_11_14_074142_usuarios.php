<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// NOTA IMPORTANTE: A LA HORA DE REALIZAR LAS MIGRACIONES PARA LA CREACION DE LA BD SE MAPEA DE LA PRIMERA LA LA ULTIMA, POR LO TANTO LAS TABLAS QUE VAN A SER RELACIONADAS DEBEN ESTAR DEFINIDAS ANTES QUE LAS QUE LLEVAN LA CLAVE FORANEA. POR EJEMPLO: LA MIGRACION USERSTABLE DEBE ESTAR DEFINIDA ANTES QUE LA MIGRACION ARTICLESTABLES SINO CUANDO SE CREA LA TABLA ARTICLES SE INTETARA REALACIONAR CON LA TABLA USERS Y DEVOLVERA UN ERROR YA QUE LA TABLA USERS NO EXISTE EN ESE MOMENTO.

class Usuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            // Se definen los campos de la tabla usuarios
            $table->increments('id');
            $table->string('usuario', 45);
            $table->string('password', 60);
            $table->string('nombre', 50);
            $table->string('apellido', 50);
            $table->string('tipoDocumento', 20);
            $table->string('numeroDocumento', 20);
            $table->string('email')->unique();
            $table->string('telefono', 45);
            $table->integer('rol_id')->unsigned();
            $table->integer('ubicacion_id')->unsigned();
            $table->boolean('habilitado');
            // Se definen las relaciones de las claves foraneas
            $table->foreign('rol_id')->references('id')->on('roles')->onDelete('RESTRICT')->onUpdate('CASCADE'); // Si se intenta borrar un rol y este pertenece a un usuario se niega el borrado. Si se actualiza un rol se actualiza el usuario.
            $table->foreign('ubicacion_id')->references('id')->on('ubicaciones')->onDelete('RESTRICT')->onUpdate('CASCADE'); // Si se intenta borrar una ubicacion y esta pertenece a un usuario se niega el borrado. Si se actualiza una ubicacion se actualiza el usuario.
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
        Schema::drop('usuarios');
    }
}

?>