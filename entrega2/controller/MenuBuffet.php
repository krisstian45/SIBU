<?php

class MenuBuffet extends CRUD {

	function __construct() {
		parent::__construct();
        self::checkLogin();
	}

	public function vistaCrear($data = null)
	{
			self::display('crearMenu');

		// $hoy = (new DateTime())->format('Y-m-d H:i:s');
		// $menu = ModeloBuffet::getInstance()->obtenerMenu($hoy);
		// if(! empty($menu)){
		// 	self::display('crearMenu');
		// }
		// else
		// 	self::index();
	}

	public function listado($value='')
	{
		return false;
	}

}

?>