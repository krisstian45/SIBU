<?php

class Pedido extends CRUD {

	function __construct() {
		parent::__construct();
        self::checkLogin();
	}

	public function index($mensaje = null) {
		$data['seccion'] = $_GET['action'];
		self::display('notYet', $data);
	}

}

?>