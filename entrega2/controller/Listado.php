<?php

class Listado extends Base {

	function __construct() {
		parent::__construct();
        self::checkHabilitado(); //Si no está habilitado, lo manda a backend/frontend
	}

	function productosFaltantes() {
		$configuracion = ConfiguracionModel::getInstance()->traerConfiguracion();
		$productosFaltantes = ListadoModel::getInstance()->obtenerProductosFaltantes();
		$this->display("productosFaltantes", array("configuracion" => $configuracion, "listado" => $productosFaltantes));
	}

	function productosStockMinimo() {
		$configuracion = ConfiguracionModel::getInstance()->traerConfiguracion();
		$productosStockMinimo = ListadoModel::getInstance()->obtenerProductosStockMinimo();
		$this->display("productosStockMinimo", array("configuracion" => $configuracion, "listado" => $productosStockMinimo));
	}

}

?>