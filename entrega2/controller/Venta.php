<?php

class Venta extends CRUD {

	function __construct() {
		parent::__construct();
        self::checkHabilitado(); // Si no está habilitado, lo manda a backend/frontend
	}

    public function listado() {
        unset ($_SESSION['ventas']);
        return (VentaModel::getInstance()->obtenerVentas());
    }

    public function vistaCrear($data = null) {
        $data['listado'] = Producto::getInstance()->listado();
        if(isset($_SESSION['ventas'])) {
            $data['ventas'] = $_SESSION['ventas'];
            $data['total'] = $_SESSION['total'];
        }
        $this->display("crear" . $_GET['action'], $data);
    }

    public function vistaModificar($data = null) {
        $fecha = Validar::getInstance()->date($_GET["fecha"]);
        if (empty($fecha['errores']) ) {
            $data['fecha'] = $fecha;
            $data['listado'] = Producto::getInstance()->listado();
            $data['ventas'] = VentaModel::getInstance()->obtenerVentaDetalle($fecha);
            //$_SESSION['ventas'] = $data['ventas'];
            //var_dump($data['ventas']); die();
            $this->display('modificarVenta', $data);
        }
        else
            $this->index();
    }

    public function vistaBorrar($data = null) {
        $fecha = Validar::getInstance()->date($_GET["fecha"]);
        if (empty($fecha['errores']) ) {
            $data['fecha'] = $_GET['fecha'];
            $this->display('borrarVenta', $data);
        }
        else
            $this->index();
    }


    public function detalleVenta($data = null) {
        $fecha = Validar::getInstance()->date($_GET["fecha"]);
        if (empty($fecha['errores']) ) {
            $data['ventas'] = VentaModel::getInstance()->obtenerVentaDetalle($fecha);
            $data['fecha'] = $_GET['fecha'];
            $this->display('detalleVenta', $data);

        }
        else
            $this->index();
    }


    // Para realizar las ABM

	public function operar() {
        try {
            $operacion = $_GET['operacion']; // crear, modificar o borrar
            $ventaModel = VentaModel::getInstance();
            if(isset($_GET['operacion'])) {
                if ($_GET['operacion'] == "borrar" && isset($_POST["fecha"]) && !empty($_POST["fecha"])){
                    $fecha = Validar::getInstance()->date($_POST['fecha']);
                    $ventaModel->$operacion($fecha);
                    $this->index("Operación realizada con éxito");
                }
                else
                    throw new Exception("Verifique los datos ingresados.");
            }
            else
                throw new Exception("Los datos son incorrectos. Por favor, intente de nuevo.");
        }
        catch (Exception $e) {
            $this->index($e->getMessage());
        }
	}

    public function agregarAVenta() {
        if(isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['cantidad']) && !empty($_POST['cantidad'])) {
            $id = Validar::getInstance()->integer($_POST['id']);
            $cantidad = Validar::getInstance()->integer($_POST['cantidad']);
            $producto = ProductoModel::getInstance()->obtenerProducto($id);
            if (!empty($producto)) {// Esto es porque en el input hidden del producto a comprar puede poner cualquier verdura
                if(!isset($_SESSION['total']))
                    $_SESSION['total'] = 0;
                if(!isset($_SESSION['ventas'][$id])) {
                    if(intval($cantidad) <= intval($producto['stock'])) { // Si el producto pedido tiene stock
                        $subtotal = (floatval($producto['precio_venta_unitario']) * intval($cantidad));
                        // Colocamos datos en $producto para que se agreguen a la sesion y asi poder mostrarlos en la vista
                        $producto['cantidad'] = $cantidad;
                        $producto['subtotal'] = $subtotal;
                        $_SESSION['ventas'][$id] = $producto;
                        $_SESSION['total'] = $_SESSION['total'] + $subtotal;
                    }
                }
            }
        }
    }

    public function quitarDeVenta() {
        if(isset($_SESSION['ventas'])) {
            if(isset($_POST['id']) && !empty($_POST['id'])) {
                $id = Validar::getInstance()->integer($_POST['id']);
                if(array_key_exists($id, $_SESSION['ventas'])) { // Preguntamos si el producto a borrar está en el arreglo de productos
                    $subtotal = $_SESSION['ventas'][$id]['subtotal'];
                    $_SESSION['total'] = $_SESSION['total'] - $subtotal;
                    unset($_SESSION['ventas'][$id]); // Lo quitamos de la venta
                }
            }
        }
        else{
            $datos['mensaje'] = "Por favor, ingrese items a la venta";
            self::vistaCrear($datos);
        }
    }

    public function generarVenta() {
        if(isset($_SESSION['ventas']) && !empty($_SESSION['ventas'])) {
            VentaModel::getInstance()->generarVenta($_SESSION['ventas']);
            unset($_SESSION['ventas']);
            unset($_SESSION['total']);
            $datos['mensaje'] = "Venta generada con exito!";
            $this->vistaCrear($datos);
        }
        else {
            $this->vistaCrear();
        }
    }

    public function cancelar() {
        unset($_SESSION['ventas']);
        unset($_SESSION['total']);
        $this->index();
    }

}

?>
