<?php

class Router extends Base {

    // By emi: Este constructor llama al constructor de la super clase

    public function __construct() {
        parent::__construct();
    }

    public function route() {
        try {
            if(isset($_GET["action"]) && isset($_GET['request'])) {
                $controller = $_GET['action'];
                $method = $_GET['request'];
                    if(is_callable(array($controller, $method)))
                        $controller::getInstance()->$method(); // method es el string con el metodo a llamar. Ejemplo: login().
                    else
                        throw new Exception("La pagina que usted quiere ingresar no existe");
            }
            else
                throw new Exception("Error. Debe existir un action y un request para poder ingresar a alguna pagina");
        }
        // TODO: By emi: Despues hay que ver si estos mensajes que creados con las excepciones se los mostramos al usuario o solo lo redirigimos sin decirle nada
        catch (Exception $e) {
            // By emi: Esto es porque en el caso que este logueado debe volver al backend, con el codigo anterior cuando algo fallaba estabamos enviando al usuario al frontend y el ayudante dijo que si esta logueado no tiene que volver al frontend
            if($this->is_user_logged_in())
                header('Location: ?action=Home&request=backend');
            else
                header('Location: ?action=Home&request=frontend');
        }
    }

}

?>