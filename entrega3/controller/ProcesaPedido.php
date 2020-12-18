<?php

class ProcesaPedido extends CRUD
{

	function __construct()
	{
		parent::__construct();
		self::checkHabilitado();
	}

	public function index($mensaje = null)
	{
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
                self::display("listadoProcesaPedido", $data);
                return 0;
            }
            parent::index();
	}

	public function vistaModificar()
    {
		try {
		    	if (isset($_GET['pedido']) && ! empty($_GET['pedido'] )) {
		    		$id = Validar::getInstance()->integer($_GET['pedido']);
		    		$pedido  = PedidoModel::getInstance()->obtenerPedido($id);
		    		if(!empty($pedido) || $pedido['estado'] == "Pendiente"){
		    			$data["pedido"] = $pedido;
		    			self::display("modificarProcesaPedido", $data);
		    		}
		    		else
		    			throw new Exception("el pedido ya fué procesado");
		    	}
		} catch (Exception $e) {
			self::index("Error en el pedido: " . $e->getMessage());
		}
    }

    public function operar()
    {
		try {
		    	if (isset($_GET['pedido']) && ! empty($_GET['pedido']) && isset($_GET['operacion']) && ! empty($_GET['operacion']) ) {
		    		$op = $_GET['operacion'];
		    		$id = Validar::getInstance()->integer($_GET['pedido']);
		    		$pedido  = PedidoModel::getInstance()->obtenerPedido($id);
		    		if(empty($pedido) || ! $pedido['estado'] == "Pendiente")
			    		throw new Exception("");

		    		if($op == "aceptarPedido")
		    			PedidoModel::getInstance()->aceptarPedido($id);
		    		elseif ($op == "rechazarPedido") {
		    			if (isset($_POST['observacion']) && !empty( $_POST['observacion']) ){
		    				$observacion = Validar::getInstance()->string($_POST['observacion']);
			    			PedidoModel::getInstance()->rechazarPedido($id, $observacion);
			    		}
		    		}
		    		self::index("Operación exitosa!");
		       	}
		    	else
		    		throw new Exception("especificar pedido y operación.");
		} catch (Exception $e) {
			self::index("Error en el pedido. " . $e->getMessage());
		}
    }

    public function detallePedido()
    {
    	return Pedido::getInstance()->detallePedido();
    }

    public function listado()
    {
    	return  PedidoModel::getInstance()->obtenerPedidos();
    }
}
 ?>