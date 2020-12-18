<?php

abstract class Base extends Singleton {

    private static $controllers = array();

    public function __construct() {
        array_push(self::$controllers, "Home", "Backend", "Producto", "Usuario", "Compra", "Venta", "Pedido", "ProcesaPedido", "MenuBuffet", "Configuracion", "Sesion", "Listado", "BotTelegram", "BotTelegram2", "Menu");

    }

	// Esta función renderiza la vista pedida
	public function display($template, $data = NULL) { // El = NULL es porque no siempre vamos a enviar parametros a la plantilla que estamos llamando
        $view = new TwigView();
        $view->show($template, $data); // Renderiza la vista
    }

    private function rolId()
    {
        if (isset($_SESSION['rol_id']))
            return $_SESSION['rol_id'];
        else
            return 0;
    }

    public function index() {
        $data['action'] = $_GET['action']; // Esto es para que twig tome el parametro Producto en ABM.twig
        if(self::is_user_logged_in())
            self::display($_GET['action'], $data);
        else
            self::display('frontend');
    }

    public function is_user_logged_in() {
        return (isset($_SESSION['id']));
    }

    public function checkLogin() {
        if(!$this->is_user_logged_in())
            header('Location: ?action=Sesion&request=login');
    }

    public function checkAdmin() {
        if(($this->rolId() != '1'))
            header('Location: ?action=Backend&request=index');
    }

    public function checkHabilitado() {
        self::checkLogin();
        if (($this->rolId() == '1') || ($this->rolId() == '2')){
            return true;
        }
        else
            header('Location: ?action=Backend&request=index');
    }

}

?>
