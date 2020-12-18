 <?php

class CompraModel extends PDORepository  {

    private $id;
    private $proveedor;
    private $proveedor_cuit;
    private $fecha;
    private $nombreFactura;

    private $compra_id;
    private $producto_id;
    private $cantidad;
    private $precio_unitario;

    protected function __construct() {

    }

    public function generarCompra($data) {
        $data['fecha'] = (new DateTime())->format('Y-m-d H:i:s');
        $this->crearCompra($data);
        $idCompra = $this->obtenerIdCompraActual($data['fecha']);
        foreach($data['compras'] as $compra) {
            $this->crearCompraDetalle($idCompra, $compra);
            $compra['stock'] = $compra['stock'] + $compra['cantidad'];
            //$producto = ProductoModel::getInstance()->setProducto($compra); // TODO: Esto al final termina estando demas, porque no estamos usando las variables de instancia las seteamos sin sentido. Ademas el modificar de la clase Producto no utiliza un array indexado, utiliza un asociativo, entonces no servia llamar a este metodo porque retornaba un array indexado
            ProductoModel::getInstance()->modificar($compra);
        }
    }

    public function crearCompra($data) {
        $arrayData = array();
        array_push($arrayData, $data['proveedor'], $data['proveedor_cuit'], $data['fecha'], $data['nombreFactura']);
        $stmt = $this->query("INSERT INTO compra (proveedor, proveedor_cuit, fecha, nombreFactura)
            VALUES (?, ?, ?, ?)", $arrayData);
    }

    public function crearCompraDetalle($idCompra, $compra) {
        $arrayData = array();
        array_push($arrayData, $idCompra, $compra['id'], $compra['cantidad'], $compra['precio_venta_unitario']);
        $this->query("INSERT INTO compra_detalle (compra_id, producto_id, cantidad, precio_unitario)
            VALUES (?, ?, ?, ?)", $arrayData);
    }

    public function modificar($data) {
        $arrayData = array();
        //$nombreFactura = $this->obtenerNombreFactura($data['id']);
        array_push($arrayData, $data['proveedor'], $data['proveedor_cuit'], $data['id']);
        $this->query("UPDATE compra
            SET
                proveedor = ?,
                proveedor_cuit = ?
            WHERE id = ?", $arrayData);
    }

    public function eliminar($idCompra) {
        $compras = $this->obtenerCompraDetalle($idCompra);
        foreach($compras as $compra) {
            $compra['stock'] = $compra['stock'] - $compra['cantidad'];
            ProductoModel::getInstance()->modificar($compra);
        }
        $this->query("DELETE FROM compra_detalle WHERE compra_id = ?", (array) $idCompra);
        $this->query("DELETE FROM compra WHERE id = ?", (array) $idCompra);
    }

    public function obtenerCompras() {
        $stmt = $this->query("SELECT * FROM compra");
        return ($stmt->fetchAll());
    }

    public function obtenerCompra($idCompra) {
        $data = array();
        array_push($data, $idCompra);
        $stmt = $this->query("SELECT * FROM compra WHERE id = ?", $data);
        return ($stmt->fetch());
    }

    public function obtenerIdCompraActual($fecha) {
        $data = array();
        array_push($data, $fecha);
        $stmt = $this->query("SELECT * FROM compra WHERE fecha = ?", $data);
        return ($stmt->fetchColumn());
    }

    /*public function obtenerNombreFactura($idCompra) {
        $stmt = $this->query("SELECT nombreFactura FROM compra WHERE id = ?", (array) $idCompra);
        return ($stmt->fetchColumn());
    }*/

    public function obtenerCompraDetalle($idCompra) {
        $stmt = $this->query("SELECT producto.*, compra_detalle.cantidad
            FROM compra_detalle INNER JOIN producto on compra_detalle.producto_id = producto.id
            WHERE compra_detalle.compra_id = ?", (array) $idCompra);
        return ($stmt->fetchAll());
    }

    public function obtenerDetallesDeCompra($idCompra) {
        $stmt = $this->query("SELECT *
            FROM compra INNER JOIN compra_detalle ON (compra.id = compra_detalle.compra_id) INNER JOIN producto ON (compra_detalle.producto_id = producto.id)
            WHERE compra.id = ?", (array) $idCompra);
        if($stmt->rowCount() > 0) {
            return ($stmt->fetchAll());
        }
        else {
            return (false);
        }
    }

}

?>