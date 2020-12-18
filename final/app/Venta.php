<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $fillable = ['fecha'];

    public function ventas_detalle()
    {
    	return ($this->hasMany('App\Venta_Detalle'));
    }

    public static function obtenerVentas() {
    	return (DB::select("
                    SELECT ventas.id, ventas.fecha, SUM(ventas_detalle.cantidad) as cantidad, FORMAT(SUM(ventas_detalle.precio_unitario * ventas_detalle.cantidad ), 2) as total
                    FROM ventas
                    JOIN ventas_detalle
                    ON ventas.id = ventas_detalle.venta_id
                    GROUP BY ventas.id, ventas.fecha
                "));
    }

    public static function generarVenta($productosVenta) {
        // En este caso es necesario usar self porque el metodo fue llamado estaticamente, sin haber instanciado la clase Venta, por lo tanto no funciona con this
        $idVenta = self::crearVenta();
        foreach($productosVenta as $productoVenta) {
            self::crearVentaDetalle($idVenta, $productoVenta);
            $producto = Producto::find($productoVenta->id);
            $producto->stock = $productoVenta->stock - $productoVenta->cantidad;
            $producto->save();
        }
    }

    public static function crearVenta() {
        $venta = new Self();
        $venta->fecha = (new \DateTime())->format('Y-m-d');
        $venta->save();
        return ($venta->id);
    }

    public static function crearVentaDetalle($idVenta, $productoVenta) {
        $venta_detalle = new Venta_Detalle();
        $venta_detalle->cantidad = $productoVenta->cantidad;
        $venta_detalle->precio_unitario = $productoVenta->precio_venta_unitario;
        $venta_detalle->descripcion = $productoVenta->descripcion;
        $venta_detalle->venta_id = $idVenta;
        $venta_detalle->producto_id = $productoVenta->id;
        $venta_detalle->save();
    }

    public static function obtenerDetallesDeVenta($idVenta) {
        return (
            DB::table('ventas')
            ->join('ventas_detalle', 'ventas.id', '=', 'ventas_detalle.venta_id')
            ->join('productos', 'ventas_detalle.producto_id', '=', 'productos.id')
            ->join('categorias', 'productos.categoria_id', '=', 'categorias.id')
            ->where('ventas.id', '=', $idVenta)
            ->get()
        );
    }

    public static function eliminar($idVenta) {
        $venta_detalle = self::obtenerVentaDetalle($idVenta);
        foreach($venta_detalle as $venta) {
            $producto = Producto::find($venta->producto_id);
            $producto->stock = $venta->stock + $venta->cantidad;
            $producto->save();
        }
        $venta_detalle = Venta_Detalle::where('venta_id', '=', $idVenta)->get();
        foreach($venta_detalle as $producto) {
            $producto->delete();
        }
        $venta = Self::find($idVenta);
        $venta->delete();
    }

    public static function obtenerVentaDetalle($idVenta) {
        return (
            DB::table('ventas_detalle')
            ->join('productos', 'ventas_detalle.producto_id', '=', 'productos.id')
            ->where('ventas_detalle.venta_id', '=', $idVenta)
            ->get()
        );
    }
}

?>