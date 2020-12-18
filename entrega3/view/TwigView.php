<?php

// Agregué esta linea porque Twig AutoLoader está deprecated

//require_once './libs/vendor/autoload.php';

class TwigView {

    public static function getTwig() {
        $loader = new Twig_Loader_Filesystem(array('./template/', './template/compra', './template/listado', './template/producto', './template/usuario', './template/venta', './template/pedido', './template/menu'));
        $config = array();
        if($_SERVER['HTTP_HOST'] != "localhost") {
            $path = "https://".$_SERVER['HTTP_HOST']."/entrega3"; // Esto es porque en grupo46.proyecto2016.linti.unlp.edu.ar ya apunta a entrega3
            //$config = array('cache' => '/tmp');
        }
        else {
            $config = array('debug' => true);
            $path = "http://".$_SERVER['HTTP_HOST']."/grupo46/entrega3"; // Esto es porque nuestro localhost es localhost/grupo46/
        }
        $twigInstance = new Twig_Environment($loader, $config);
        $twigInstance->addExtension(new Twig_Extension_Debug());
        if(isset($_SESSION['id'])) {
            $twigInstance->addGlobal("session", $_SESSION); // By emi: Agrega los datos de la sesion para que sean accesibles en las vistas del usuario logueado
        }
        $twigInstance->addGlobal('path', $path); // Con este agrego una variable global. Fijense que en los .twig la invoco con {{ path }}
        return ($twigInstance);
    }

    public function show($template, $arrayData) {
        $this->getTwig()->display($template . '.twig', array('data' => $arrayData)); // By emi: Con arrayData pasamos parametros a la vista, siempre se tiene que mandar un array porque cuando accedemos a la vista el array se rompe y cada posicion se convierte en una variable independiente. Por eso el array('data' => $arrayData).
    }

}

?>
