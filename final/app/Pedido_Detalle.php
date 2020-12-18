<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido_Detalle extends Model
{
    protected $table = 'pedidos_detalle';
    protected $fillable = ['cantidad', 'precio_unitario', 'pedido_id', 'producto_id'];

    public function pedido()
    {
    	return ($this->belongsTo('App\Pedido'));
    }

    public function producto()
    {
    	return ($this->belongsTo('App\Producto'));
    }
}

?>