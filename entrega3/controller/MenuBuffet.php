<?php

class MenuBuffet extends CRUD {

	function __construct() {
		parent::__construct();
        self::checkLogin();
        self::checkHabilitado();
	}

	public function vistaCrear($data = null)
	{
			//self::display('crearMenu');
		if (isset($_GET['fecha']) && $_GET['fecha'] == "hoy")
			$fecha = (new DateTime())->format('Y-m-d');
		else{
			if( $_GET['fecha'] == "mañana" ){
				$hoy = (new DateTime());
				$hoy->add(new DateInterval('P1D'));
				$fecha = date_format($hoy, 'Y-m-d');
			}
			else{
				self::index();
				return 0;
			}
		}
		$menu = MenuModel::getInstance()->obtenerMenu($fecha); //acá hay q sacar $hoy y que quede solo $menu = self::listado();
		$productos=ProductoModel::getInstance()->obtenerProductosConStock();//consulta con left join

		if(!empty($menu)){
			$menuArray = array();
			foreach ($menu as $prodMenu) {
				array_push($menuArray,  $prodMenu['producto_id']);
			}

			foreach ($productos as &$producto) {
				$producto['menu'] = null;
				if(in_array($producto['id'], $menuArray))
					$producto['menu'] = "Esta en el menu de " . $fecha;
			}
		}

		$data['productos'] = $productos;
		$data['fecha']=$fecha;
		self::display('crearMenuBuffet',$data);

	}

	public function listado($value='')
	{
		$hoy = (new DateTime())->format('Y-m-d');
		return MenuModel::getInstance()->obtenerMenu($hoy);
	}

}

?>