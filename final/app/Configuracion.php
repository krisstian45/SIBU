<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Configuracion extends Model
{
    protected $table = 'configuracion';
    protected $fillable = ['titulo', 'descripcion', 'email', 'elementos', 'habilitado', 'mensaje'];
}

?>