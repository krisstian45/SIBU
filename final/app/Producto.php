<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Producto extends Model
{
    protected $table = 'productos';
    protected $fillable = ['nombre', 'marca', 'codigo_barra', 'stock', 'stock_minimo', 'fecha_alta', 'proveedor', 'precio_venta_unitario', 'descripcion', 'categoria_id'];

    public function categoria()
    {
    	return ($this->belongsTo('App\Categoria'));
    }

    public function menus()
    {
    	return ($this->hasMany('App\Menu'));
    }

    public function ventas_detalle()
    {
    	return ($this->hasMany('App\Venta_Detalle'));
    }

    public function compras_detalle()
    {
    	return ($this->hasMany('App\Compra_Detalle'));
    }

    public function pedidos_detalle()
    {
    	return ($this->hasMany('App\Pedido_Detalle'));
    }

    public static function obtenerProductos() {
        return (
            DB::table('categorias')
            ->join('productos', 'categorias.id', '=', 'productos.categoria_id')
            ->get()
        );
    }

    public static function obtenerProductosFaltantes() {
        /*return (
            DB::table('categorias')
            ->join('productos', 'categorias.id', '=', 'productos.categoria_id')
            ->where('stock', '<', 'stock_minimo')
            ->get()
        );*/
        return (DB::select("
                    SELECT * FROM categorias INNER JOIN productos ON (categorias.id = productos.categoria_id) WHERE stock < stock_minimo
                "));
    }

    public static function obtenerProductosStockMinimo() {
        /*return (
            DB::table('categorias')
            ->join('productos', 'categorias.id', '=', 'productos.categoria_id')
            ->where('stock', '=', 'stock_minimo')
            ->get()
        );*/
        return (DB::select("
                    SELECT * FROM categorias INNER JOIN productos ON (categorias.id = productos.categoria_id) WHERE stock = stock_minimo
                "));
    }

    public static function obtenerProductosConStock() {
        return (
            DB::table('productos')
            ->where('stock', '>', 0)
            ->get()
        );
    }
}

?>