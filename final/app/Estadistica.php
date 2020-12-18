<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Estadistica extends Model
{
    public static function obtenerGanancias($fechaInicio, $fechaFin) {
    	// En este caso es necesario usar self porque el metodo fue llamado estaticamente, sin haber instanciado la clase Listado, por lo tanto no funciona con this
        $ingresosVenta = self::obtenerIngresosVenta($fechaInicio, $fechaFin);
        $ingresosPedidoOnline = self::obtenerIngresosPedidoOnline($fechaInicio, $fechaFin);
        $egresosCompra = self::obtenerEgresos($fechaInicio, $fechaFin);
        $ingresos = self::generarIngresos(strtotime($fechaInicio), strtotime($fechaFin), $ingresosVenta, $ingresosPedidoOnline);
        $egresos = self::generarEgresos(strtotime($fechaInicio), strtotime($fechaFin), $egresosCompra);
        $ganancias = self::generarGanancias(strtotime($fechaInicio), strtotime($fechaFin), $ingresos, $egresos);
        return ($ganancias);
    }

    public static function obtenerIngresosVenta($fechaInicio, $fechaFin) {
    	$arrayData = array();
        array_push($arrayData, $fechaInicio, $fechaFin);
    	return (DB::select("
                    SELECT date(ventas.fecha) as fecha, FORMAT(SUM(ventas_detalle.cantidad * ventas_detalle.precio_unitario), 2) as total
                    FROM ventas INNER JOIN ventas_detalle ON (ventas.id = ventas_detalle.venta_id)
		            WHERE ventas.fecha BETWEEN ? AND ?
		            GROUP BY date(ventas.fecha)
		            ORDER BY date(ventas.fecha) ASC
                ", $arrayData));
    }

    public static function obtenerIngresosPedidoOnline($fechaInicio, $fechaFin) {
        $arrayData = array();
        array_push($arrayData, $fechaInicio, $fechaFin);
        return (DB::select("
                    SELECT date(pedidos.fecha) as fecha, FORMAT(SUM(pedidos_detalle.cantidad * pedidos_detalle.precio_unitario), 2) as total
		            FROM pedidos INNER JOIN pedidos_detalle ON (pedidos.id = pedidos_detalle.pedido_id)
		            WHERE pedidos.fecha BETWEEN ? AND ? AND estado = 'Entregado'
		            GROUP BY date(pedidos.fecha)
		            ORDER BY date(pedidos.fecha) ASC
                ", $arrayData));
    }

    public static function obtenerEgresos($fechaInicio, $fechaFin) {
        $arrayData = array();
        array_push($arrayData, $fechaInicio, $fechaFin);
        return (DB::select("
                    SELECT date(compras.fecha) as fecha, FORMAT(SUM(compras_detalle.cantidad * compras_detalle.precio_unitario), 2) as total
		            FROM compras INNER JOIN compras_detalle ON (compras.id = compras_detalle.compra_id)
		            WHERE compras.fecha BETWEEN ? AND ?
		            GROUP BY date(compras.fecha)
		            ORDER BY date(compras.fecha) ASC
                ", $arrayData));
    }

    public static function generarIngresos($fechaInicio, $fechaFin, $ingresosVenta, $ingresosPedidoOnline) {
        $indexVenta = 0;
        $indexPedido = 0;
        // Se recorre todo el rango de fechas y se va armando un arreglo con los ingresos teniendo en cuenta las ganancias por ventas y por pedidos online
        for($i = $fechaInicio; $i <= $fechaFin; $i = strtotime('+'. 1 .' day', $i)) {
            $ingresos[$i]['fecha'] = date('d-m-Y', $i);
            // Los isset estan porque puede pasar que cuando aumentemos los indices alguno supere el tamaño del arreglo y cuando se los usa para acceder a alguna posicion quede en fuera de rango
            if(isset($ingresosVenta[$indexVenta]->fecha) && ($ingresosVenta[$indexVenta]->fecha == date('Y-m-d', $i))) {
                if(isset($ingresosPedidoOnline[$indexPedido]->fecha) && ($ingresosPedidoOnline[$indexPedido]->fecha == date('Y-m-d', $i))) {
                    // Caso en el que en una determinada fecha se hayan realizado ventas y pedidos online
                    $ingresos[$i]['monto'] = $ingresosVenta[$indexVenta]->total + $ingresosPedidoOnline[$indexPedido];
                    $indexVenta++;
                    $indexPedido++;
                }
                else {
                    // Caso en el que en una determinada fecha se hayan realizado solo ventas
                    $ingresos[$i]['monto'] = $ingresosVenta[$indexVenta]->total;
                    $indexVenta++;
                }
            }
            else {
                if(isset($ingresosPedidoOnline[$indexPedido]->fecha) && ($ingresosPedidoOnline[$indexPedido]->fecha == date('Y-m-d', $i))) {
                    // Caso en el que en una determinada fecha se hayan realizado solo pedidos online
                    $ingresos[$i]['monto'] = $ingresosPedidoOnline[$indexPedido]->total;
                    $indexPedido++;
                }
                else {
                    // Caso en el que en una determinada fecha no se hayan realizado ventas ni pedidos online
                    $ingresos[$i]['monto'] = 0;
                }
            }
        }
        return ($ingresos);
    }

    public static function generarEgresos($fechaInicio, $fechaFin, $egresosCompra) {
        $indexCompra = 0;
        // Se recorre todo el rango de fechas y se va armando un arreglo con los egresos teniendo en cuenta las perdidas por compras
        for($i = $fechaInicio; $i <= $fechaFin; $i = strtotime('+'. 1 .' day', $i)) {
            $egresos[$i]['fecha'] = date('d-m-Y', $i);
            // El isset esta porque puede pasar que cuando aumentemos el indice supere el tamaño del arreglo y cuando se lo usa para acceder a alguna posicion quede en fuera de rango
            if(isset($egresosCompra[$indexCompra]->fecha) && ($egresosCompra[$indexCompra]->fecha == date('Y-m-d', $i))) {
                    // Caso en el que en una determinada fecha se hayan realizado compras
                    $egresos[$i]['monto'] = $egresosCompra[$indexCompra]->total;
                    $indexCompra++;
            }
            else {
                // Caso en el que en una determinada fecha no se hayan realizado compras
                $egresos[$i]['monto'] = 0;
            }
        }
        return ($egresos);
    }

    public static function generarGanancias($fechaInicio, $fechaFin, $ingresos, $egresos) {
        for($i = $fechaInicio; $i <= $fechaFin; $i = strtotime('+'. 1 .' day', $i)) {
            $ganancias[$i]['fecha'] = $ingresos[$i]['fecha'];
            $ganancias[$i]['monto'] = $ingresos[$i]['monto'] - $egresos[$i]['monto'];
        }
        return ($ganancias);
    }

    public static function obtenerCantidadDeVentasPorProducto($fechaInicio, $fechaFin) {
        $arrayData = array();
        array_push($arrayData, $fechaInicio, $fechaFin);
        return (DB::select("
                    SELECT productos.nombre_producto, productos.marca, productos.codigo_barra, SUM(ventas_detalle.cantidad) as cantVentas
		            FROM productos
		            INNER JOIN ventas_detalle ON (productos.id = ventas_detalle.producto_id)
		            INNER JOIN ventas ON (ventas_detalle.venta_id = ventas.id)
		            WHERE ventas.fecha BETWEEN ? AND ?
		            GROUP BY productos.id, productos.nombre_producto, productos.marca, productos.codigo_barra
                ", $arrayData));
    }
}

?>