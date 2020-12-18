<?php

class Home extends Base {

	public function __construct() {
		parent::__construct();
	}

	public function frontend() {
		try {
			$configuracion['config'] = ConfiguracionModel::getInstance()->traerConfiguracion();
			$hoy = (new DateTime())->format('Y-m-d');
			$configuracion['menu'] = MenuModel::getInstance()->obtenerMenu($hoy);
		}
		catch (Exception $e) {
			$configuracion['mensaje']= "No se ha podido comunicar con la base de datos";
			$this->display('sitioDeshabilitado', $configuracion);
			return 0;
		}
		if($configuracion['config']['habilitado'])
			$this->display('frontend', $configuracion);
		else
			$this->display('sitioDeshabilitado', $configuracion);
	}

	public function backend() {
		if($this->is_user_logged_in()) {
			$hoy = (new DateTime())->format('Y-m-d');
			$configuracion['menu'] = MenuModel::getInstance()->obtenerMenu($hoy);
			$this->display('backend',$configuracion);
		}
		else
			Sesion::getInstance()->index();
	}

}

?>