<?php

class ListadoModel extends PDORepository  {

	protected function __construct() {

    }

  	function obtenerProductosFaltantes() {
        $stmt = $this->query("SELECT * FROM producto INNER JOIN categoria ON (producto.categoria_id = categoria.id) WHERE stock < stock_minimo");
        if($stmt->rowCount() > 0) {
            return ($stmt->fetchAll());
        }
        else {
            return (false);
        }
    }

    function obtenerProductosStockMinimo() {
        $stmt = $this->query("SELECT * FROM producto INNER JOIN categoria ON (producto.categoria_id = categoria.id) WHERE stock = stock_minimo");
        if($stmt->rowCount() > 0) {
            return ($stmt->fetchAll());
        }
        else {
            return (false);
        }
    }

    function obtenerGanancias($fechaInicio, $fechaFin) {
        $ingresosVenta = $this->obtenerIngresosVenta($fechaInicio, $fechaFin);
        $ingresosPedidoOnline = $this->obtenerIngresosPedidoOnline($fechaInicio, $fechaFin);
        $egresosCompra = $this->obtenerEgresos($fechaInicio, $fechaFin);
        $ingresos = $this->generarIngresos(strtotime($fechaInicio), strtotime($fechaFin), $ingresosVenta, $ingresosPedidoOnline);
        $egresos = $this->generarEgresos(strtotime($fechaInicio), strtotime($fechaFin), $egresosCompra);
        $ganancias = $this->generarGanancias(strtotime($fechaInicio), strtotime($fechaFin), $ingresos, $egresos);
        return ($ganancias);
    }

    function obtenerIngresosVenta($fechaInicio, $fechaFin) {
        $arrayData = array();
        array_push($arrayData, $fechaInicio, $fechaFin);
        $stmt = $this->query("SELECT date(venta_detalle.fecha) as fecha, FORMAT(SUM(venta_detalle.cantidad * venta_detalle.precio_unitario), 2) as total
            FROM venta INNER JOIN venta_detalle ON (venta.fecha = venta_detalle.fecha)
            WHERE venta_detalle.fecha BETWEEN ? AND ?
            GROUP BY date(venta_detalle.fecha)
            ORDER BY date(venta_detalle.fecha) ASC", $arrayData);
        if($stmt->rowCount() > 0) {
            return ($stmt->fetchAll());
        }
        else {
            return (false);
        }
    }

    function obtenerIngresosPedidoOnline($fechaInicio, $fechaFin) {
        $arrayData = array();
        array_push($arrayData, $fechaInicio, $fechaFin);
        $stmt = $this->query("SELECT date(pedido.fecha) as fecha, FORMAT(SUM(pedido_detalle.cantidad * pedido_detalle.precio_unitario), 2) as total
            FROM pedido INNER JOIN pedido_detalle ON (pedido.id = pedido_detalle.pedido_id)
            WHERE pedido.fecha BETWEEN ? AND ? AND estado = 'Entregado'
            GROUP BY date(pedido.fecha)
            ORDER BY date(pedido.fecha) ASC", $arrayData);
        if($stmt->rowCount() > 0) {
            return ($stmt->fetchAll());
        }
        else {
            return (false);
        }
    }

    function obtenerEgresos($fechaInicio, $fechaFin) {
        $arrayData = array();
        array_push($arrayData, $fechaInicio, $fechaFin);
        $stmt = $this->query("SELECT date(compra.fecha) as fecha, FORMAT(SUM(compra_detalle.cantidad * compra_detalle.precio_unitario), 2) as total
            FROM compra INNER JOIN compra_detalle ON (compra.id = compra_detalle.compra_id)
            WHERE compra.fecha BETWEEN ? AND ?
            GROUP BY date(compra.fecha)
            ORDER BY date(compra.fecha) ASC", $arrayData);
        if($stmt->rowCount() > 0) {
            return ($stmt->fetchAll());
        }
        else {
            return (false);
        }
    }

    function generarIngresos($fechaInicio, $fechaFin, $ingresosVenta, $ingresosPedidoOnline) {
        $indexVenta = 0;
        $indexPedido = 0;
        // Se recorre todo el rango de fechas y se va armando un arreglo con los ingresos teniendo en cuenta las ganancias por ventas y por pedidos online
        for($i = $fechaInicio; $i <= $fechaFin; $i = strtotime('+'. 1 .' day', $i)) {
            $ingresos[$i]['fecha'] = date('d-m-Y', $i);
            // Los isset estan porque puede pasar que cuando aumentemos los indices alguno supere el tamaño del arreglo y cuando se los usa para acceder a alguna posicion quede en fuera de rango
            if(isset($ingresosVenta[$indexVenta]['fecha']) && ($ingresosVenta[$indexVenta]['fecha'] == date('Y-m-d', $i))) {
                if(isset($ingresosPedidoOnline[$indexPedido]['fecha']) && ($ingresosPedidoOnline[$indexPedido]['fecha'] == date('Y-m-d', $i))) {
                    // Caso en el que en una determinada fecha se hayan realizado ventas y pedidos online
                    $ingresos[$i]['monto'] = $ingresosVenta[$indexVenta]['total'] + $ingresosPedidoOnline[$indexPedido];
                    $indexVenta++;
                    $indexPedido++;
                }
                else {
                    // Caso en el que en una determinada fecha se hayan realizado solo ventas
                    $ingresos[$i]['monto'] = $ingresosVenta[$indexVenta]['total'];
                    $indexVenta++;
                }
            }
            else {
                if(isset($ingresosPedidoOnline[$indexPedido]['fecha']) && ($ingresosPedidoOnline[$indexPedido]['fecha'] == date('Y-m-d', $i))) {
                    // Caso en el que en una determinada fecha se hayan realizado solo pedidos online
                    $ingresos[$i]['monto'] = $ingresosPedidoOnline[$indexPedido]['total'];
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

    function generarEgresos($fechaInicio, $fechaFin, $egresosCompra) {
        $indexCompra = 0;
        // Se recorre todo el rango de fechas y se va armando un arreglo con los egresos teniendo en cuenta las perdidas por compras
        for($i = $fechaInicio; $i <= $fechaFin; $i = strtotime('+'. 1 .' day', $i)) {
            $egresos[$i]['fecha'] = date('d-m-Y', $i);
            // El isset esta porque puede pasar que cuando aumentemos el indice supere el tamaño del arreglo y cuando se lo usa para acceder a alguna posicion quede en fuera de rango
            if(isset($egresosCompra[$indexCompra]['fecha']) && ($egresosCompra[$indexCompra]['fecha'] == date('Y-m-d', $i))) {
                    // Caso en el que en una determinada fecha se hayan realizado compras
                    $egresos[$i]['monto'] = $egresosCompra[$indexCompra]['total'];
                    $indexCompra++;
            }
            else {
                // Caso en el que en una determinada fecha no se hayan realizado compras
                $egresos[$i]['monto'] = 0;
            }
        }
        return ($egresos);
    }

    function generarGanancias($fechaInicio, $fechaFin, $ingresos, $egresos) {
        for($i = $fechaInicio; $i <= $fechaFin; $i = strtotime('+'. 1 .' day', $i)) {
            $ganancias[$i]['fecha'] = $ingresos[$i]['fecha'];
            $ganancias[$i]['monto'] = $ingresos[$i]['monto'] - $egresos[$i]['monto'];
        }
        return ($ganancias);
    }

    function obtenerCantidadDeVentasPorProducto($fechaInicio, $fechaFin) {
        $arrayData = array();
        array_push($arrayData, $fechaInicio, $fechaFin);
        $stmt = $this->query("SELECT producto.nombre, producto.marca, producto.codigo_barra, SUM(venta_detalle.cantidad) as cantVentas
            FROM producto INNER JOIN venta_detalle ON (producto.id = venta_detalle.producto_id)
            WHERE venta_detalle.fecha BETWEEN ? AND ?
            GROUP BY producto.id, producto.nombre, producto.marca, producto.codigo_barra", $arrayData);
        if($stmt->rowCount() > 0) {
            return ($stmt->fetchAll());
        }
        else {
            return (false);
        }
    }

}

?>
