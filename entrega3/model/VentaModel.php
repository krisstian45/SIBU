 <?php

class VentaModel extends PDORepository  {

    private $fecha;
    private $producto_id;
    private $cantidad;
    private $precio_unitario;
    private $descripcion;

    protected function __construct() {

    }

    public function generarVenta($ventas) {

        $this->fecha = (new DateTime())->format('Y-m-d H:i:s');
        $nuevaVenta = array($this->fecha);
        $this->crearVenta($nuevaVenta);

        foreach($ventas as $venta) {
            $venta['stock'] = $venta['stock'] - $venta['cantidad'];
            $venta['fecha'] = $this->fecha;
            ProductoModel::getInstance()->setProducto($venta);
            ProductoModel::getInstance()->modificar($venta);
            $arrayData = $this->setVenta($venta);
            $this->crearVentaDetalle($arrayData);
        }
        return (true);
    }

    public function crearVentaDetalle($data) {
        $this->query("INSERT INTO venta_detalle (fecha, producto_id, cantidad, precio_unitario, descripcion)
            VALUES (?, ?, ?, ?, ?)", $data);
    }

    public function crearVenta($data) {
            $this->query("INSERT INTO venta (fecha)
            VALUES (?)", $data);
    }

    public function borrar($data) {
        $ventas = self::obtenerVentaDetalle($data);
        foreach ($ventas as $venta) {
            $venta['stock'] = $venta['stock'] + $venta['cantidad'];
            ProductoModel::getInstance()->setProducto($venta);
            ProductoModel::getInstance()->modificar($venta);
        }
        $this->query("DELETE FROM venta_detalle WHERE fecha=?", (array)$data);
        $this->query("DELETE FROM venta WHERE fecha=?", (array)$data);
        return 0;
    }

    // public function modificar($data) {
    //     $arrayData = self::setProducto($data);
    //     array_push($arrayData, $data['id']);
    //     $conn = self::getConnection();
    //     $stmt = $conn->prepare("UPDATE venta SET id= :id, nombre= :nombre, marca= :marca, codigo_barra= :codigo_barra, stock=:stock, stock_minimo=:stock_minimo, fecha_alta=:fecha_alta, proveedor=:proveedor, precio_venta_unitario=:precio_venta_unitario, descripcion= :descripcion, categoria_id= :categoria_id
    //         WHERE id= :id
    //         ", $arrayData);
    //     $stmt->bindValue(":id", $data['id'], PDO::PARAM_STR);
    //     $stmt->bindValue(":nombre", $data['nombre'], PDO::PARAM_STR);
    //     $stmt->bindValue(":marca", $data['marca'], PDO::PARAM_STR);
    //     $stmt->bindValue(":codigo_barra", $data['codigo_barra'], PDO::PARAM_STR);
    //     $stmt->bindValue(":stock", $data['stock'], PDO::PARAM_STR);
    //     $stmt->bindValue(":stock_minimo", $data['stock_minimo'], PDO::PARAM_STR);
    //     $stmt->bindValue(":fecha_alta", $arrayData[6], PDO::PARAM_STR); // Aca lo tomo a la fuerza sino nunca puedo  mandarle.. solo cristian lo entiende.
    //     $stmt->bindValue(":proveedor", $data['proveedor'], PDO::PARAM_STR);
    //     $stmt->bindValue(":precio_venta_unitario", $data['precio_venta_unitario'], PDO::PARAM_STR);
    //     $stmt->bindValue(":descripcion", $data['descripcion'], PDO::PARAM_STR);
    //     $stmt->bindValue(":categoria_id", $data['categoria_id'], PDO::PARAM_STR);
    //     $stmt->execute();
    //     self::closeConnection($conn);
    // }

    public function setVenta($data) {
        $this->fecha = $data['fecha'];
        $this->producto_id = $data['id'];
        $this->cantidad = $data['cantidad'];
        $this->precio_unitario = $data['precio_venta_unitario'];
        $this->descripcion = $data['descripcion'];
        $arrayData = (array)get_object_vars($this);
        return (array_values($arrayData));
    }

    public function obtenerVentas() {
        $stmt = $this->query("SELECT venta_detalle.fecha, SUM(venta_detalle.cantidad) as cantidad, FORMAT(SUM(venta_detalle.precio_unitario * venta_detalle.cantidad ), 2) as total
                            FROM venta INNER JOIN venta_detalle on (venta.fecha = venta_detalle.fecha)
                            GROUP BY venta.fecha");
        $ventas = $stmt->fetchAll();
        return $ventas;
    }

    public function obtenerVentaDetalle($fecha) {
        $stmt = $this->query("SELECT DISTINCT producto.*, venta_detalle.cantidad FROM venta_detalle INNER JOIN producto on venta_detalle.producto_id = producto.id WHERE fecha = ?", (array) $fecha);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerVentaProducto($venta) {
        $data= (array)$venta;
        $stmt = $this->query("SELECT * FROM venta_detalle WHERE producto_id = ?", $data);
        return $stmt->fetchAll();
    }

}

?>