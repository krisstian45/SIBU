<?php

	class Menu extends Base
	{

		function __construct()
		{
		}

		public function verificarId($id)
		{
			$data=ProductoModel::getInstance()->obtenerProducto($id);
			if ($data==false){//no existe el producto quieren meter otra cosa que no existe
				return false;
			}else {//existe el producto en la bd
				return true;
			}
		}


		public function route()
		{
			// echo $_POST['id'];
			$verificar=Menu::getInstance()->verificarId(json_decode($_POST['id']));//retorna true si esta en la BD ,false caso contrario
			$id=$_POST['id'];
			if ($verificar) {// existe el producto puedo operar con el
				// $hoy = (new DateTime())->format('Y-m-d');
				$hoy=$_POST['fecha'];
				$menu=MenuModel::getInstance()->obtenerMenu($hoy);
				if ($menu)  {// hay menus para ese dia debo verificar que ese producto no este en menu
					# code...
					$result=MenuModel::getInstance()->obtenerProductoMenu($id,$hoy);
					if (! $result ) {//No esta el producto en el menu debo agregarlo
						$agregar=MenuModel::getInstance()->agregarProducto($id,$hoy);
						 echo "agregado";
					}else // el Producto esta en el menu debo eliminarlo
						{
							$eliminar=MenuModel::getInstance()->eliminarProducto($id,$hoy);
							echo "eliminado";
						}
				}else{// no hay  menus para ese dia  debo agregar el producto
					$agregar=MenuModel::getInstance()->agregarProducto($id,$hoy);
					echo "agregado2";
				}
			}else {//no existe el producto no debo hacer nada
				# code...
				 echo "notExist";
			}
		}

	}

?>