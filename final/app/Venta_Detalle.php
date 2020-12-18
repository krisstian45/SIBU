<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta_Detalle extends Model
{
    protected $table = 'ventas_detalle';
    protected $fillable = ['cantidad', 'precio_unitario', 'descripcion', 'venta_id', 'producto_id'];

    public function venta()
    {
    	return ($this->belongsTo('App\Venta'));
    }

    public function producto()
    {
    	return ($this->belongsTo('App\Producto'));
    }
}

?>