<?php

class Listado extends Base {

	function __construct() {
		parent::__construct();
        $this->checkHabilitado(); // Si no está habilitado, lo manda a backend/frontend
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

	function balanceGanancias($mensaje = '') {
		$this->display('balanceGanancias', array('mensaje' => $mensaje));
	}

	function balanceVentas($mensaje = '') {
		$this->display('balanceVentas', array('mensaje' => $mensaje));
	}

	function calcularBalanceGanancias() {
		if(isset($_POST['fechaInicio']) && !empty($_POST['fechaInicio']) && isset($_POST['fechaFin']) && !empty($_POST['fechaFin'])) {
			$f1 = (new DateTime($_POST['fechaInicio']))->format("Y-m-d 00:00:00");
			$f2 = (new DateTime($_POST['fechaFin']))->format("Y-m-d 23:59:59");
			$fechaInicio = Validar::getInstance()->date($f1);
			$fechaFin = Validar::getInstance()->date($f2);
			if(($fechaInicio <= $fechaFin) && (($fechaFin - $fechaInicio) <= 1)) {
				$configuracion = ConfiguracionModel::getInstance()->traerConfiguracion();
				$ganancias = ListadoModel::getInstance()->obtenerGanancias($fechaInicio, $fechaFin);
				$this->display('listadoBalanceGanancias', array('configuracion' => $configuracion, 'listado' => $ganancias, 'fechaInicio' => date('d-m-Y', strtotime($fechaInicio)), 'fechaFin' => date('d-m-Y', strtotime($fechaFin))));
			}
			else {
				$mensaje = "Debe ingresar una fecha correcta, entre un rango de un año, y la primera debe ser menor o igual a la segunda";
				$this->balanceGanancias($mensaje);
			}
		}
		else {
			$this->balanceGanancias();
		}
	}

	function calcularBalanceVentas() {
		if(isset($_POST['fechaInicio']) && !empty($_POST['fechaInicio']) && isset($_POST['fechaFin']) && !empty($_POST['fechaFin'])) {
			$f1 = (new DateTime($_POST['fechaInicio']))->format("Y-m-d 00:00:00");
			$f2 = (new DateTime($_POST['fechaFin']))->format("Y-m-d 23:59:59");
			$fechaInicio = Validar::getInstance()->date($f1);
			$fechaFin = Validar::getInstance()->date($f2);
			if(($fechaInicio <= $fechaFin) && (($fechaFin - $fechaInicio) <= 1)) {
				$configuracion = ConfiguracionModel::getInstance()->traerConfiguracion();
				$ventas = ListadoModel::getInstance()->obtenerCantidadDeVentasPorProducto($fechaInicio, $fechaFin);
				$this->display('listadoBalanceVentas', array('configuracion' => $configuracion, 'listado' => $ventas, 'fechaInicio' => date('d-m-Y', strtotime($fechaInicio)), 'fechaFin' => date('d-m-Y', strtotime($fechaFin))));
			}
			else {
				$mensaje = "Debe ingresar una fecha correcta, entre un rango de un año, y la primera debe ser menor o igual a la segunda";
				$this->balanceVentas($mensaje);
			}
		}
		else {
			$this->balanceVentas();
		}
	}

}

?>
