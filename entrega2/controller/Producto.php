<?php
class Producto extends CRUD {

	function __construct() {
		parent::__construct();
        self::checkHabilitado(); //Si no está habilitado, lo manda a backend/frontend
	}

	public function vistaCrear($data = null)
	{
		$data = ProductoModel::getInstance()->obtenerCategorias();
		parent::vistaCrear($data);
	}

	public function operarProducto() {
		try
		{
			$operacion = $_GET['operacion'];//TODO:: no logro mandadr bien los datos desde la vista del borrar producto. el post llega vacio.
			if ($operacion != "borrar") {
				$dataValidada = Validar::getInstance()->validarInputs($_POST, "producto");
                if(!empty($dataValidada['errores']) || sizeof($dataValidada) == 1){
                    $data['errores'] = $dataValidada['errores'];
                    $data['operacion']=$_GET['operacion'];
                    $data['actual']=$_POST;
                    $data['categorias']=ProductoModel::getInstance()->obtenerCategorias();
                    self::display("errorProducto", $data);
                    // return 0;
                }
                $data=$dataValidada;
			}else {
				try {
						if (isset($_POST['id'])) {
							$idValidado = Validar::getInstance()->integer($_POST['id']);
							$producto= $_POST['id'];
							$data=ProductoModel::getInstance()->obtenerProducto($producto);
							if ($data==false)
								throw new Exception("Error producto no existe");
						}else
							throw new Exception("Error producto no existe");

					} catch (Exception $e) {
						$data['invalido']="invalido";
						self::display("borrarProducto", $data);
						return 0;

					}


					$data=ProductoModel::getInstance()->obtenerProducto($idValidado);

					}


			$productoModel = ProductoModel::getInstance();
            if (self::checkOperation($data))
				{
					$productoModel->$operacion($data);
	                self::index("Operación realizada con éxito!");
	            }
	            else
	                throw new Exception("Los datos son incorrectos. Por favor, intente de nuevo. ");
        }
        catch(Exception $e)
        {
        	$error=$e->getMessage();
        	$datos['mensaje'] = $error;
        	parent::vistaCrear($datos);
        }

	}

	public function listado() {
		return ProductoModel::getInstance()->obtenerProductos();
	}

	public function vistaBorrar($data= null) { //TODO: esto es temporal hasta refactorizar. dehhh
		if (isset($_GET['producto'])){
			$data['nombre']=$_GET['producto'];
			$data1=ProductoModel::getInstance()->obtenerProducto($data['nombre']);
			if ($data1 != false) {
				//me fijo q no este en una venta
				$data2=VentaModel::getInstance()->obtenerVentaProducto($data['nombre']);

				if (empty($data2) ) {
					self::display("borrar" . $_GET['action'], $data);
				}else{
					$data['existenVentas']="valido";
					self::display("borrarProducto", $data);
					return 0;
				}


			}else {
						$data['invalido']="invalido";
						self::display("borrarProducto", $data);
						return 0;
			}
		}
		else
			self::display("listado" . $_GET['action']); //Ejemplo request= crear, action=Producto (infla crearProducto.twig)
	}

	public function vistaModificar() { //TODO: esto es temporal hasta refactorizar. dehhh
		if (isset($_GET['producto'])){
			$producto= $_GET['producto'];
			$data['actual']=ProductoModel::getInstance()->obtenerProducto($producto);
			$data['categorias']=ProductoModel::getInstance()->obtenerCategorias();
			if ($data != null) {
				self::display("modificar" . $_GET['action'], $data);
			}else throw new Exception("Error, el producto que intenta modificar no existe");
		}
		else
			self::display("listado" . $_GET['action']); //Ejemplo request= crear, action=Producto (infla crearProducto.twig)
	}


}