<?php

require_once ('./libs/vendor/autoload.php');


require_once('./controller/Singleton.php');
require_once('./controller/Base.php');
require_once('./view/TwigView.php');
require_once('./controller/Router.php');
require_once('./controller/CRUD.php');
require_once('./controller/ValidarBase.php');
require_once('./controller/Validar.php');
require_once('./controller/Sesion.php');
require_once('./controller/Home.php');
require_once('./controller/Usuario.php');
require_once('./controller/Producto.php');
require_once('./controller/Compra.php');
require_once('./controller/Venta.php');
require_once('./controller/MenuBuffet.php');
require_once('./controller/Menu.php');
require_once('./controller/Pedido.php');
require_once('./controller/ProcesaPedido.php');
require_once('./controller/Listado.php');
require_once('./controller/Configuracion.php');
require_once('./controller/BotTelegram2.php');

require_once('./model/PDORepository.php');
require_once('./model/UsuarioModel.php');
require_once('./model/CompraModel.php');
require_once('./model/VentaModel.php');
require_once('./model/ProductoModel.php');
require_once('./model/MenuModel.php');
require_once('./model/SuscripcionModel.php');
require_once('./model/ListadoModel.php');
require_once('./model/PedidoModel.php');
require_once('./model/ConfiguracionModel.php');

if ($_SERVER['HTTP_HOST'] != "localhost")
	ini_set("upload_tmp_dir", "/home/grupo46.proyecto2016.linti.unlp.edu.ar/uploads");
else
	ini_set("upload_tmp_dir", "/var/www/html/grupo46/uploads");

date_default_timezone_set('America/Argentina/Buenos_Aires');

if(!isset($_SESSION)) {
	session_start();
	header('Cache-Control: no cache'); // Para que no cachee el sitio y no tire ERR_CACHE_MISS Confirm Form Resubmission
}

?>