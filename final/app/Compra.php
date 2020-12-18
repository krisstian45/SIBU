<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Compra extends Model
{
    protected $table = 'compras';
    protected $fillable = ['proveedor', 'proveedor_cuit', 'fecha', 'nombre_factura'];

    public function compras_detalle()
    {
    	return ($this->hasMany('App\Compra_Detalle'));
    }

    public static function generarCompra($datos) {
    	// En este caso es necesario usar self porque el metodo fue llamado estaticamente, sin haber instanciado la clase Compra, por lo tanto no funciona con this
    	$idCompra = self::crearCompra($datos);
    	foreach($datos['productosCompra'] as $productoCompra) {
    		self::crearCompraDetalle($idCompra, $productoCompra);
    		$producto = Producto::find($productoCompra->id);
    		$producto->stock = $productoCompra->stock + $productoCompra->cantidad;
    		$producto->save();
    	}
    }

    public static function crearCompra($datos) {
    	$compra = new Self();
    	$compra->proveedor = $datos['proveedor'];
    	$compra->proveedor_cuit = $datos['proveedor_cuit'];
    	$compra->fecha = (new DateTime())->format('Y-m-d');
    	$compra->nombreFactura = $datos['nombreFactura'];
    	$compra->save();
    	return ($compra->id);
    }

    public static function crearCompraDetalle($idCompra, $productoCompra) {
    	$compra_detalle = new Compra_Detalle();
    	$compra_detalle->cantidad = $productoCompra->cantidad;
    	$compra_detalle->precio_unitario = $productoCompra->precio_venta_unitario;
    	$compra_detalle->compra_id = $idCompra;
    	$compra_detalle->producto_id = $productoCompra->id;
    	$compra_detalle->save();
    }

    public static function obtenerDetallesDeCompra($idCompra) {
        return (
            DB::table('compras')
            ->join('compras_detalle', 'compras.id', '=', 'compras_detalle.compra_id')
            ->join('productos', 'compras_detalle.producto_id', '=', 'productos.id')
            ->join('categorias', 'productos.categoria_id', '=', 'categorias.id')
            ->where('compras.id', '=', $idCompra)
            ->get()
        );
    }

    public static function eliminar($idCompra) {
        $compra_detalle = self::obtenerCompraDetalle($idCompra);
        foreach($compra_detalle as $compra) {
            $producto = Producto::find($compra->producto_id);
            $producto->stock = $compra->stock - $compra->cantidad;
            $producto->save();
        }
        $compra_detalle = Compra_Detalle::where('compra_id', '=', $idCompra)->get();
        foreach($compra_detalle as $producto) {
            $producto->delete();
        }
        $compra = Self::find($idCompra);
        $compra->delete();
    }

    public static function obtenerCompraDetalle($idCompra) {
        return (
            DB::table('compras_detalle')
            ->join('productos', 'compras_detalle.producto_id', '=', 'productos.id')
            ->where('compras_detalle.compra_id', '=', $idCompra)
            ->get()
        );
    }
}

?>