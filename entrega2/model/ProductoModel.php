 <?php

class ProductoModel extends PDORepository  {

    private $id;
    private $nombre;
    private $marca;
    private $codigo_barra;
    private $stock;
    private $stock_minimo;
    private $fecha_alta;
    private $proveedor;
    private $precio_venta_unitario;
    private $descripcion;
    private $categoria_id;

    protected function __construct() {

    }

    public function crear($data) {
        $arrayData = self::setProducto($data);
        $codigoBarra = array($arrayData[3]);
        $stmt = $this->query("SELECT * FROM producto WHERE codigo_barra = ?", $codigoBarra);
        if ($stmt->fetch()>0) {
            throw new Exception("Error el producto ya existe,intenta verifica tu producto");
        }
        $this->query("INSERT INTO producto (id, nombre, marca, codigo_barra, stock, stock_minimo, fecha_alta, proveedor, precio_venta_unitario, descripcion, categoria_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $arrayData);
        return 0;
    }

    public function borrar($data) {
        $id = (array) $data['id'];
        $this->query("DELETE FROM producto WHERE id=?", $id);
        return 0;
    }

    public function modificar($data) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare("UPDATE producto
            SET
                nombre = :nombre,
                marca = :marca,
                codigo_barra = :codigo_barra,
                stock = :stock,
                stock_minimo = :stock_minimo,
                fecha_alta = :fecha_alta,
                proveedor = :proveedor,
                precio_venta_unitario = :precio_venta_unitario,
                descripcion = :descripcion,
                categoria_id = :categoria_id
            WHERE id = :id");
        $stmt->bindValue(":id", $data['id'], PDO::PARAM_STR);
        $stmt->bindValue(":nombre", $data['nombre'], PDO::PARAM_STR);
        $stmt->bindValue(":marca", $data['marca'], PDO::PARAM_STR);
        $stmt->bindValue(":codigo_barra", $data['codigo_barra'], PDO::PARAM_STR);
        $stmt->bindValue(":stock", $data['stock'], PDO::PARAM_STR);
        $stmt->bindValue(":stock_minimo", $data['stock_minimo'], PDO::PARAM_STR);
        $stmt->bindValue(":fecha_alta", $data['fecha_alta'], PDO::PARAM_STR);
        $stmt->bindValue(":proveedor", $data['proveedor'], PDO::PARAM_STR);
        $stmt->bindValue(":precio_venta_unitario", $data['precio_venta_unitario'], PDO::PARAM_STR);
        $stmt->bindValue(":descripcion", $data['descripcion'], PDO::PARAM_STR);
        $stmt->bindValue(":categoria_id", $data['categoria_id'], PDO::PARAM_STR);
        $stmt->execute();
        $this->closeConnection($conn);
    }

    public function setProducto($data) {
        $this->id = null;
        $this->nombre = $data['nombre'];
        $this->marca = $data['marca'];
        $this->codigo_barra= $data['codigo_barra']; // TODO: hay que verificiar este valor y preguntarlo...
        $this->stock = $data['stock'];
        $this->stock_minimo = $data['stock_minimo'];
        $this->proveedor = $data['proveedor'];
        $this->precio_venta_unitario = $data['precio_venta_unitario'];
        $this->descripcion = $data['descripcion'];
        if(!isset($data['fecha_alta'])) {
            $this->fecha_alta = (new DateTime())->format('Y-m-d H:i:s');
        }
        else {
            $this->fecha_alta = $data['fecha_alta'];
        }
        $this->categoria_id = $data['categoria_id']; // TODO: el tipo se obtiene de la bd
        $arrayData = (array) get_object_vars($this);
        return (array_values($arrayData));
    }

    public function obtenerProductos() {
        $stmt = $this->query("SELECT * FROM producto INNER JOIN categoria on producto.categoria_id = categoria.id");
        return $stmt->fetchAll();
    }

    public function obtenerProducto($producto) {
        $data= (array)$producto;
        $stmt = $this->query("SELECT * FROM producto WHERE id = ?", $data);
        return $stmt->fetch();
    }

    public function obtenerCategorias() {
        $stmt = $this->query("SELECT * FROM categoria");
        return $stmt->fetchAll();
    }

}

?>
