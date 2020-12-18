<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra_Detalle extends Model
{
    protected $table = 'compras_detalle';
    protected $fillable = ['cantidad', 'precio_unitario', 'compra_id', 'producto_id'];

    public function compra()
    {
    	return ($this->belongsTo('App\Compra'));
    }

    public function producto()
    {
    	return ($this->belongsTo('App\Producto'));
    }
}

?>