<?php

class Compra extends CRUD {

	function __construct() {
		parent::__construct();
        self::checkHabilitado(); // Si no está habilitado, lo manda a backend/frontend
    }

    public function listado() {
        return CompraModel::getInstance()->obtenerCompras();
    }

    public function vistaCrear($data = null) {
        $data['listado'] = Producto::getInstance()->listado();
        if(isset($_SESSION['compras'])) {
            $data['compras'] = $_SESSION['compras'];
            $data['total'] = $_SESSION['total'];
        }
        $this->display("crear" . $_GET['action'], $data);
    }

    public function vistaModificar($data = null) {
        if(isset($_GET['idCompra']) && !empty($_GET['idCompra'])) {
            $data['id'] = $_GET['idCompra'];
            $data['compra'] = CompraModel::getInstance()->obtenerCompra($data['id']);
            $this->display('modificarCompra', $data);
        }
        else
            $this->index();
    }

    public function vistaEliminar($data = null) {
        if(isset($_GET['idCompra']) && !empty($_GET['idCompra']) && isset($_GET['fecha']) && !empty($_GET['fecha'])) {
            $data['id'] = $_GET['idCompra'];
            $data['fecha'] = $_GET['fecha'];
            $this->display('eliminarCompra', $data);
        }
        else
            $this->index();
    }

    public function vistaVerDetalle($mensaje = '') {
        if(isset($_GET['id'])) {
            $idCompra = $_GET['id'];
            $compras = CompraModel::getInstance()->obtenerDetallesDeCompra($idCompra);
            $configuracion = ConfiguracionModel::getInstance()->traerConfiguracion();
            if($compras) {
                if($_SERVER['HTTP_HOST'] == "localhost") {
                    $file = "/grupo46/uploads/" . $compras[0]['nombreFactura'];
                }
                else {
                    $file = "/uploads/" . $compras[0]['nombreFactura'];
                }
                $this->display('detalleCompra', array('listado' => $compras, 'factura' => $file, 'configuracion' => $configuracion));
            }
            else {
                // Pasar los mensajes de error
                $this->index();
            }
        }
        else {
            // Pasar los mensajes de error
            $this->index();
        }
    }
        /*try {
            if(isset($_GET['id'])){
                $id = Validar::getInstance()->integer($_GET['id']);
                if(!empty($id['errores']))
                    self::index();
                else{
                    $compra = CompraModel::getInstance()->obtenerCompraFactura($id);
                    //var_dump('http://localhost/grupo46/uploads/' . $compra[0]['nombreFactura']); die();

                    if ($_SERVER['HTTP_HOST'] != "localhost") {
                        $file = "/uploads/" . $compra[0]['nombreFactura'];
                    }
                    else
                        $file = "/grupo46/uploads/" . $compra[0]['nombreFactura'];

                    header('Location: ' . $file);


                    // if ($compra == null)
                    //     throw new Exception();

                    // $file = $compra[0]['nombreFactura'];
                    // $size = filesize("../uploads/" . $file);

                    // header('Content-Length: '.$size);
                    // header("Content-Disposition: attachment; filename= $file");
                    // header("Content-Type: image/png");
                    // $resource = fopen("http://localhost/grupo46/uploads/" . $file, 'r');
                    // if($resource){
                    //     fpassthru($resource);
                    // }
                    // else
                    //     self::index();
                }
            }
        } catch (Exception $e) {
              self::index();
        }*/

   	public function agregarACompra() {
        if(isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['cantidad']) && !empty($_POST['cantidad'])) {
            $id = Validar::getInstance()->integer($_POST['id']);
            $cantidad = Validar::getInstance()->integer($_POST['cantidad']);
            $producto = ProductoModel::getInstance()->obtenerProducto($id);
            if(!empty($producto)) { // Esto es porque en el input hidden del producto a comprar puede poner cualquier verdura
                if(!isset($_SESSION['total']))
                    $_SESSION['total'] = 0;
                if(!isset($_SESSION['compras'][$id])) {
                    $subtotal = (floatval($producto['precio_venta_unitario']) * intval($cantidad));
                    // Colocamos datos en $producto para que se agreguen a la sesion y asi poder mostrarlos en la vista
                    $producto['cantidad'] = $cantidad;
                    $producto['subtotal'] = $subtotal;
                    $_SESSION['compras'][$id] = $producto;
                    $_SESSION['total'] = $_SESSION['total'] + $subtotal;
                }
            }
        }
    }

    public function quitarDeCompra() {
        if(isset($_SESSION['compras'])) {
            if(isset($_POST['id']) && !empty($_POST['id'])) {
                $id = Validar::getInstance()->integer($_POST['id']);
                if(array_key_exists($id, $_SESSION['compras'])) { // Preguntamos si el producto a borrar está en el arreglo de productos
                    $subtotal = $_SESSION['compras'][$id]['subtotal'];
                    $_SESSION['total'] = $_SESSION['total'] - $subtotal;
                    unset($_SESSION['compras'][$id]); // Lo quitamos de la compra
                }
            }
        }
    }

    public function generarCompra() {
        try {
            if(isset($_SESSION['compras']) && isset($_POST['cuit']) && isset($_POST['proveedor']) && isset ($_FILES["factura"])) {
                $proveedor = Validar::getInstance()->string($_POST['proveedor']);
                $cuit = Validar::getInstance()->integer($_POST['cuit']);
                $nombreFactura = $this->subirFactura();
                $data = [
                'compras' => $_SESSION['compras'],
                'proveedor' => $proveedor,
                'proveedor_cuit' => $cuit,
                'nombreFactura' => $nombreFactura
                ];
                CompraModel::getInstance()->generarCompra($data);
                unset($_SESSION['compras']);
                unset($_SESSION['total']);
                $datos['mensaje'] = "Compra generada con exito!";
                $this->vistaCrear($datos);
            }
            else {
                $this->vistaCrear();
            }
        }
        catch(Exception $e) {
            $errores['general'] = $e->getMessage();
            $datos['errores'] = $errores;
            $this->vistaCrear($datos);
        }
    }

    public function subirFactura() {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["factura"]["name"]);
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        // Esto es para chequear la extension
        if(file_exists($target_file))
            throw new Exception("Esta factura ya fue subida");
        if($_FILES["factura"]["size"] > 2000000)
            throw new Exception("El archivo que intenta subir no puede superar los 2MB");
        // Solo permitimos imagenes o pdf
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "pdf")
            throw new Exception("El archivo debe estar en formato imagen o PDF");
        if(!move_uploaded_file($_FILES["factura"]["tmp_name"], $target_file)) //Aca la sube y si hubo un error, tira excepcion
            throw new Exception("Hubo un problema al cargar el archivo. Asegurse que el archivo no supere los 2MB");
        else
            return $_FILES["factura"]["name"];
    }

    public function cancelar() {
        unset($_SESSION['compras']);
        unset($_SESSION['total']);
        $this->index();
    }

    public function modificarCompra() {
        if(isset($_GET['idCompra']) && isset($_POST['proveedor']) && isset($_POST['cuit'])) {
            $data = [
            'id' => Validar::getInstance()->integer($_GET['idCompra']),
            'proveedor' => Validar::getInstance()->string($_POST['proveedor']),
            'proveedor_cuit' => Validar::getInstance()->integer($_POST['cuit'])
            ];
            CompraModel::getInstance()->modificar($data);
            $mensaje = "Compra modificada con exito!";
            $this->index($mensaje);
        }
        else {
            $this->index();
        }
    }

    public function eliminarCompra() {
        if(isset($_GET['idCompra']) && !empty($_GET['idCompra'])) {
            $data['id'] = Validar::getInstance()->integer($_GET['idCompra']);
            CompraModel::getInstance()->eliminar($data['id']);
            $mensaje = "Compra eliminada con exito!";
            $this->index($mensaje);
        }
        else {
            $this->index();
        }
    }

}

?>