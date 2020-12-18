<?php

class PedidoModel extends PDORepository  {

    private $id;
    private $usuario_id;
    private $estado;
    private $fecha;
    private $observacion;

    private $pedido_id;
    private $producto_id;
    private $cantidad;
    private $precio_unitario;

    protected function __construct() {

    }

    public function generarPedido($pedidos, $userId) {
        $nuevoPedido = self::setPedido($pedidos, $userId);
        $this->crearPedido($nuevoPedido);
        $this->id = self::obtenerIdPedidoActual($this->fecha);

        foreach($pedidos as $pedido) {
            $arrayData = $this->setPedidoDetalle($pedido);
            $this->crearPedidoDetalle($arrayData);
        }
        return (true);
    }

    public function crearPedido($data) { //var_dump($data); die();
            $this->query("INSERT INTO pedido (usuario_id, estado, fecha, observacion)
            VALUES (?, ?, ?, ?)", $data);
    }

    public function crearPedidoDetalle($data) { //var_dump($data); die();
        $this->query("INSERT INTO pedido_detalle (pedido_id, producto_id, cantidad, precio_unitario)
            VALUES (?, ?, ?, ?)", $data);
    }


    public function actualizarPedido($pedido)
    {
        $arrayData = array();
        array_push($arrayData, $pedido['estado'], $pedido['observacion'], $pedido['pedido_id']);
        $this->query("UPDATE pedido
            SET
                estado = ?,
                observacion = ?
            WHERE id = ?", $arrayData);
    }

    public function eliminar($pedido)
    {
        $this->query("DELETE FROM pedido_detalle WHERE pedido_id =?", array($pedido['id']));
        $this->query("DELETE FROM pedido WHERE pedido.id = ?", array($pedido['id']));
        return 0;
    }

    public function setPedido($data, $userId) {
        $this->usuario_id = intval($userId);
        $this->estado = "Pendiente";
        $this->fecha = (new DateTime())->format('Y-m-d H:i:s');
        $this->observacion = "";
        $arrayData = (array)get_object_vars($this);
        $pedido = array_values($arrayData);
        return array_slice($pedido, 1, 4); //Con array slice, nos quedamos con cantidad, pedido_id y producto_id
    }

    public function setPedidoDetalle($data) {
        $this->pedido_id = $this->id;
        $this->producto_id = $data['id'];
        $this->cantidad = $data['cantidad'];
        $this->precio_unitario = ProductoModel::getInstance()->obtenerPrecioUnitario($data['id'])['precio_venta_unitario'];
        $arrayData = (array)get_object_vars($this);
        $detalle = array_values($arrayData);
        return array_slice($detalle, 5); //Con array slice, nos quedamos con  pedido_id, producto_id, cantidad, y precio venta unitario
    }

    public function obtenerIdPedidoActual($fecha) {
        $data = array();
        array_push($data, $fecha);
        $stmt = $this->query("SELECT id FROM pedido WHERE fecha = ?", $data);
        return ($stmt->fetchColumn());
    }


    public function obtenerPedidos() {
        $stmt = $this->query("SELECT pedido.id,  pedido.estado, pedido.fecha, FORMAT(SUM( pedido_detalle.precio_unitario * pedido_detalle.cantidad ), 2) as total
                            FROM pedido INNER JOIN pedido_detalle on (pedido.id = pedido_detalle.pedido_id)
                            GROUP BY pedido.id, pedido.estado, pedido.fecha DESC");
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $pedidos;
    }

    public function obtenerPedido($id) {
        $stmt = $this->query("SELECT pedido.*, DATE_FORMAT( pedido.fecha, '%d-%m-%Y %T') as fecha, pedido_detalle.* , FORMAT(SUM( pedido_detalle.precio_unitario * pedido_detalle.cantidad ), 2) as total
                            FROM pedido INNER JOIN pedido_detalle on (pedido.id = pedido_detalle.pedido_id)
                            WHERE pedido.id = ?
                            GROUP BY pedido.id", array($id));
        $pedidos = $stmt->fetch(PDO::FETCH_ASSOC);
        return $pedidos;
    }

    public function obtenerPedidosUsuario($idUsuario) {
        $stmt = $this->query("SELECT pedido.id, DATE_FORMAT( pedido.fecha, '%d-%m-%Y %T') as fecha, pedido.estado, pedido.observacion, FORMAT(SUM( pedido_detalle.precio_unitario * pedido_detalle.cantidad ), 2) as total
                            FROM pedido INNER JOIN pedido_detalle on (pedido.id = pedido_detalle.pedido_id)
                            WHERE usuario_id = ?
                            GROUP BY pedido.fecha DESC", array($idUsuario));
                            //GROUP BY pedido.id", array($idUsuario));
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $pedidos;
    }

    public function obtenerDetalle($id)
    {
        $stmt = $this->query("SELECT *
                            FROM pedido_detalle INNER JOIN pedido on (pedido.id = pedido_detalle.pedido_id) INNER JOIN producto on (pedido_detalle.producto_id = producto.id)
                            WHERE pedido.id = ?
                            ", array($id));
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $pedidos;
    }

    public function aceptarPedido($id)
    {
        $detalles = self::obtenerDetalle($id);

        foreach ($detalles as $detalle) {
            $producto = ProductoModel::getInstance()->obtenerProducto($detalle['producto_id']);
            if($detalle['stock'] >= $detalle['cantidad']){
                $producto['stock'] = $producto['stock'] - $detalle['cantidad'];
                ProductoModel::getInstance()->modificar($producto);
            }
            else
                throw new Exception("No hay stock para el producto " . $producto['id']);
        }
        $pedido = self::obtenerPedido($id);
        $pedido['estado'] = "Entregado";
        $pedido['observacion'] = "Listo";
        $this->actualizarPedido($pedido);
        return true;
    }

    public function rechazarPedido($id, $observacion)
    {
        $pedido = self::obtenerPedido($id);
        $pedido['estado'] = "Cancelado";
        $pedido['observacion'] = $observacion;
        $this->actualizarPedido($pedido);
        return true;
    }

}

?>
