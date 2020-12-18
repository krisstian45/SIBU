<?php

// Con esto habilitamos el informe de errores en el php.ini en tiempo de ejecución. Se recomienda encarecidamente mantener desactivado display_startup_errors, excepto para la depuración.

// error_reporting — Establece cuáles errores de PHP son notificados -1 notifica TODOS los errores de PHP.

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('requires.php');

if($_SERVER['HTTP_HOST'] != "localhost" && $_SERVER['REQUEST_METHOD'] != "GET" ){
	if (BotTelegram2::getInstance()->verificacion()) {
		$bot = BotTelegram2::getInstance()->init();
		return 0; // Importante el return 0, sino entra en loop y manda mensajes infinitamente.
	}
}

$router = Router::getInstance();
$router->route();

?>