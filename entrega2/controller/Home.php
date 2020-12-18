<?php

class Home extends Base {

	public function __construct() {
		parent::__construct();
	}

	public function frontend() {
		try {
			$configuracion = ConfiguracionModel::getInstance()->traerConfiguracion();
		}
		catch (Exception $e) {
			$configuracion['mensaje']= "No se ha podido comunicar con la base de datos";
			$this->display('sitioDeshabilitado', $configuracion);
			return 0;
		}
		if($configuracion['habilitado'])
			$this->display('frontend', $configuracion);
		else
			$this->display('sitioDeshabilitado', $configuracion);
	}

	public function backend() {
		if($this->is_user_logged_in())
			$this->display('backend');
		else
			Sesion::getInstance()->index();
	}

}

?>
