<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pedido extends Model
{
    protected $table = 'pedidos';
    protected $fillable = ['estado', 'fecha', 'observacion', 'usuario_id'];

    public function usuario()
    {
    	return ($this->belongsTo('App\Usuario'));
    }

    public function pedidos_detalle()
    {
    	return ($this->hasMany('App\Pedido_Detalle'));
    }

    public static function obtenerPedidos() {
        return (DB::select("
                    SELECT pedidos.id,  pedidos.estado, pedidos.created_at, FORMAT(SUM(pedidos_detalle.precio_unitario * pedidos_detalle.cantidad ), 2) as total
                    FROM pedidos INNER JOIN pedidos_detalle on (pedidos.id = pedidos_detalle.pedido_id)
                    GROUP BY pedidos.id, pedidos.estado, pedidos.created_at DESC
                "));
    }

    public static function obtenerPedidosUsuario($idUsuario) {
        return (DB::select("
                    SELECT pedidos.id, pedidos.estado, pedidos.created_at, pedidos.observacion, FORMAT(SUM(pedidos_detalle.precio_unitario * pedidos_detalle.cantidad ), 2) as total
                    FROM pedidos INNER JOIN pedidos_detalle on (pedidos.id = pedidos_detalle.pedido_id)
                    WHERE pedidos.usuario_id = ?
                    GROUP BY pedidos.created_at, pedidos.id, pedidos.estado, pedidos.observacion DESC
                ", array($idUsuario)));
    }

    public static function generarPedido($productosPedido) {
        // En este caso es necesario usar self porque el metodo fue llamado estaticamente, sin haber instanciado la clase Pedido, por lo tanto no funciona con this
        $idPedido = self::crearPedido();
        foreach($productosPedido as $productosPedido) {
            self::crearPedidoDetalle($idPedido, $productosPedido);
        }
    }

    public static function crearPedido() {
        $pedido = new Self();
        $pedido->estado = 'Pendiente';
        $pedido->fecha = (new \DateTime())->format('Y-m-d');
        $pedido->observacion = '';
        $pedido->usuario_id = \Auth::user()->id;
        $pedido->save();
        return ($pedido->id);
    }

    public static function crearPedidoDetalle($idPedido, $productoPedido) {
        $pedido_detalle = new Pedido_Detalle();
        $pedido_detalle->cantidad = $productoPedido->cantidad;
        $pedido_detalle->precio_unitario = $productoPedido->precio_venta_unitario;
        $pedido_detalle->pedido_id = $idPedido;
        $pedido_detalle->producto_id = $productoPedido->id;
        $pedido_detalle->save();
    }

    public static function obtenerDetallesDePedido($idPedido) {
        return (
            DB::table('pedidos')
            ->join('pedidos_detalle', 'pedidos.id', '=', 'pedidos_detalle.pedido_id')
            ->join('productos', 'pedidos_detalle.producto_id', '=', 'productos.id')
            ->join('categorias', 'productos.categoria_id', '=', 'categorias.id')
            ->where('pedidos.id', '=', $idPedido)
            ->get()
        );
    }

    public static function eliminar($idPedido) {
        $pedido_detalle = self::obtenerPedidoDetalle($idPedido);
        foreach($pedido_detalle as $pedido) {
            $producto = Producto::find($pedido->producto_id);
            $producto->stock = $pedido->stock + $pedido->cantidad;
            $producto->save();
        }
        $pedido_detalle = Pedido_Detalle::where('pedido_id', '=', $idPedido)->get();
        foreach($pedido_detalle as $producto) {
            $producto->delete();
        }
        $pedido = Self::find($idPedido);
        $pedido->delete();
    }

    public static function obtenerPedidoDetalle($idPedido) {
        return (
            DB::table('pedidos_detalle')
            ->join('productos', 'pedidos_detalle.producto_id', '=', 'productos.id')
            ->where('pedidos_detalle.pedido_id', '=', $idPedido)
            ->get()
        );
    }

    public static function aceptarPedido($idPedido) {
        $pedido_detalle = self::obtenerDetallesDePedido($idPedido);
        foreach($pedido_detalle as $detalle) {
            $producto = Producto::find($detalle->producto_id);
            $producto->stock = $detalle->stock - $detalle->cantidad;
            $producto->save();
        }
        $pedido = Self::find($idPedido);
        $pedido->estado = 'Entregado';
        $pedido->observacion = 'Listo';
        $pedido->save();
    }

    public static function rechazarPedido($idPedido, $observacion) {
        $pedido = Pedido::find($idPedido);
        $pedido->estado = 'Cancelado';
        $pedido->observacion = $observacion;
        $pedido->save();
    }
}

?>