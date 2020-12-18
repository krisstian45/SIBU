<?php

abstract class CRUD extends Base {

	function __construct() {
        self::checkLogin();
	}

	public function index($mensaje = null) {
		$clase = $_GET['action'];
		$listado = $this->listado();
		$data['exito'] = $mensaje;
		$configuracion = ConfiguracionModel::getInstance()->traerConfiguracion();
		self::display('listado' . $clase, array("configuracion" => $configuracion, "listado" => $listado, "mensaje" => $data));
	}

    public function vistaCrear($data = null) {
        self::display("crear" . $_GET['action'], $data); // Ejemplo request=crear, action=Producto (infla crearProducto.twig)
    }

    public function checkOperation($dataValidada)
    {
    	return (!is_null($dataValidada) && isset($_GET['operacion']) && ($_GET['operacion'] == "crear" || $_GET['operacion'] == "modificar" || $_GET['operacion'] == "borrar" ));
    }

}

?>
