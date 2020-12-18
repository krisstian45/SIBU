<?php

class Pedido extends CRUD {

	function __construct() {
		parent::__construct();
        self::checkLogin();

    }

    public function index($mensaje = null)
    {
        if ($_SESSION['rol_id'] == '1' || $_SESSION['rol_id'] == '2') //Si es admin o gestion, delega a procesa pedidos.
            header('Location: ?action=ProcesaPedido&request=index');
        else{
            if(isset($_POST['fechaFiltro']) && ! empty($_POST['fechaFiltro']) ){
                $post = Validar::getInstance()->date((new DateTime($_POST['fechaFiltro']))->format("Y-m-d 00:00:00"));
                $fechaFiltro = (new DateTime($post))->format("d-m-Y");
                $pedidos = self::listado();
                $filtrado = array();
                foreach ($pedidos as $pedido) {
                    $fechaPedido = (new DateTime($pedido['fecha']))->format("d-m-Y");
                    if($fechaPedido == $fechaFiltro)
                        array_push($filtrado, $pedido);
                }
                $data['listado'] = $filtrado;
                $data['filtro'] = $fechaFiltro;
                self::display("listadoPedido", $data);
                return 0;
            }
            parent::index();        }
    }

	public function vistaCrear($data = null)
	{
		$hoy = (new DateTime())->format('Y-m-d');
        $data['menu'] = MenuModel::getInstance()->obtenerMenu($hoy);
		$data['productos'] = ProductoModel::getInstance()->obtenerProductosConStock();
        if(isset($_SESSION['pedidos'])) {
            $data['pedidos'] = $_SESSION['pedidos'];
            $data['total'] = $_SESSION['total'];
        }
		self::display('crearPedido', $data);

	}

	public function listado($value='')
	{
        $pedidos = PedidoModel::getInstance()->obtenerPedidosUsuario($_SESSION['id']);
        $fechaHoy = (new DateTime())->format('d-m-Y H:i:s');

        foreach ($pedidos as &$pedido) {    //Se agrega un & para entrar por referencia al valor del array y poder modificarlo

            if($pedido['fecha'] == $fechaHoy && ( round(abs( strtotime($fechaHoy) - strtotime($pedido['fecha'])) / 60,2) <= 30) && $pedido['estado'] == "Pendiente")
                $pedido['cancelable'] = "Si";
            else
                $pedido['cancelable'] = "No";
        }
		return $pedidos;
	}

    public function detallePedido()
    {
        try {
            if (isset($_GET['numeroPedido'])) { 
                $id = Validar::getInstance()->integer($_GET['numeroPedido']);
                $pedido = PedidoModel::getInstance()->obtenerDetalle($id);
                if (!empty($pedido)){
                    if($pedido[0]['usuario_id'] == $_SESSION['id'] || $_SESSION['rol_id'] == '1' || $_SESSION['rol_id'] == '2'  ){ //Validamos que el id del pedido sea del usuario
                        $data['pedido'] = $pedido;
                        $data['fecha'] = (new DateTime($pedido[0]['fecha']))->format("d-m-Y H:i:s");
                        self::display("detallePedido", $data);
                        return 0;
                    }
                }
            }
            throw new Exception(); //Si no pasó algún if, es porque ingresó algo mal.

        } catch (Exception $e) {
            self::index("Debe ingresar un pedido válido");
        }
    }

    public function agregarAPedido() {
        if(isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['cantidad']) && !empty($_POST['cantidad'])) {
            $id = Validar::getInstance()->integer($_POST['id']);
            $cantidad = Validar::getInstance()->integer($_POST['cantidad']);
            $producto = ProductoModel::getInstance()->obtenerProducto($id);
            if (!empty($producto)) {// Esto es porque en el input hidden del producto a comprar puede poner cualquier verdura
                if(!isset($_SESSION['total']))
                    $_SESSION['total'] = 0;
                if(!isset($_SESSION['pedidos'][$id])) {
                    if(intval($cantidad) <= intval($producto['stock'])) { // Si el producto pedido tiene stock
                        $subtotal = (floatval($producto['precio_venta_unitario']) * intval($cantidad));
                        // Colocamos datos en $producto para que se agreguen a la sesion y asi poder mostrarlos en la vista
                        $producto['cantidad'] = $cantidad;
                        $producto['subtotal'] = $subtotal;
                        $_SESSION['pedidos'][$id] = $producto;
                        $_SESSION['total'] = $_SESSION['total'] + $subtotal;
                    }
                }
            }
        }
    }

    public function quitarDePedido() {
        if(isset($_SESSION['pedidos'])) {
            if(isset($_POST['id']) && !empty($_POST['id'])) {
                $id = Validar::getInstance()->integer($_POST['id']);
                if(array_key_exists($id, $_SESSION['pedidos'])) { // Preguntamos si el producto a borrar está en el arreglo de productos
                    $subtotal = $_SESSION['pedidos'][$id]['subtotal'];
                    $_SESSION['total'] = $_SESSION['total'] - $subtotal;
                    unset($_SESSION['pedidos'][$id]); // Lo quitamos de la pedido
                }
            }
        }
    }

    public function generarPedido() {
        if(isset($_SESSION['pedidos']) && !empty($_SESSION['pedidos'])) {
            PedidoModel::getInstance()->generarPedido($_SESSION['pedidos'], $_SESSION['id']);
            unset($_SESSION['pedidos']);
            unset($_SESSION['total']);
            $this->index("Pedido generado con exito!");
        }
        else {
            $this->vistaCrear();
        }
    }

    public function cancelar() {
        if(isset($_GET['pedido']) && !empty($_GET['pedido'])) {
            $id = Validar::getInstance()->integer($_GET['pedido']);
            $pedido = PedidoModel::getInstance()->obtenerPedido($id);

            $fechaHoy = (new DateTime())->format('d-m-Y H:i:s');
            $fechaPedido= date("d-m-Y H:i:s", strtotime($pedido['fecha']));

            $data = "";
            if($fechaPedido = $fechaHoy && ( round(abs( strtotime($fechaHoy) - strtotime($fechaPedido)) / 60,2) <= 30) && $pedido['estado'] == "Pendiente"){
                PedidoModel::getInstance()->eliminar($pedido);
                $data= "Pedido eliminado con exito!";
            }
            $this->index($data);
        }
        else {
            $this->index();
        }
    }


}

?>