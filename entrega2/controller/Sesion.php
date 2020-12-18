<?php

class Sesion extends Base {

	public function __construct() {
        parent::__construct();
        //Agrego esta linea por si por url quiere ir a http://localhost/grupo46/entrega2/index.php/?action=Sesion&request=login
        if($this->is_user_logged_in())
            header('Location: ?action=Home&request=backend');
    }

    public function login() {

        try {
            if(isset($_POST["usuario"]) && isset($_POST["password"])) {
                $dataValidada = Validar::getInstance()->validarInputs($_POST, "login");
                if(!empty($dataValidada['errores'])){
                    $data['errores'] = $dataValidada['errores'];
                    self::display("login", $data);
                    return 0;
                }
                $userInstance = UsuarioModel::getInstance();
                $user = $userInstance->do_login($dataValidada["usuario"], $dataValidada["password"]);
                unset($_POST);
                $_SESSION['id'] = $user['id'];
                $_SESSION['usuario'] = $user['usuario'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['rol_id'] = $user['rol_id'];
                // TODO: By emi: IMPORTANTE !!! cada vez que queramos cargar una vista que pertenezca a otra clase hay que redireccionar porque sino como estaba antes con esta linea Backend::getInstance()->index(); mostraba el backend pero en la url seguia diciendo action=Usuario&request=login entonces cuando actualizabas la pagina fallaba. Hay que ver como manejamos eso, yo le agregue un header para que ande por ahora.
                header('Location: ?action=Home&request=backend');
            }
            else
                throw new Exception("Por favor, introduzca sus credenciales");
        }
        catch (Exception $e) {
            $data['errores']['general'] = $e->getMessage();
            self::display("login", $data);
        }
    }

    public function logout() {
        session_destroy();
        unset($_SESSION);
        header('Location: ?action=Home&request=frontend');
    }

    public function registrarse()
    {
            try {
                if (isset($_POST) && ! empty($_POST)) {
                    // TODO: By emi: Validar login usuario contra XSS attack
                    $data = $_POST;
                    $data['habilitado']="false";
                    $data['rol'] = 'normal';
                    $dataValidada = Validar::getInstance()->validarInputs($data, "usuario");
                    if(!empty($dataValidada['errores'])){
                        // $data['errores'] = $dataValidada['errores'];
                        // //$data['operacion']=$_GET['operacion'];
                        // $data['actual']=$_POST;
                        $data['listado'] = UsuarioModel::getInstance()->obtenerUbicaciones();
                        $data['general'] = "Por favor, verificar los siguientes errores";
                        $data['datosUsuario'] = $dataValidada; //tambien tiene los errores que hubo (data.datosUsuario.usuario , etc...)
                        self::display("registrarse", $data);
                        return 0;
                    }
                    $data=$dataValidada;


                    UsuarioModel::getInstance()->crear($data);
                    unset($_POST);
                    $data['mensaje'] = "Registrado con éxito. En la brevedad sera dado de alta";
                    self::display("login", $data);
                    return 0;
                }
                else
                    throw new Exception();
            }
            catch (Exception $e) {
                $data['mensaje'] = $e->getMessage();
                $data['listado'] = UsuarioModel::getInstance()->obtenerUbicaciones();
                self::display("registrarse", $data);
            }
    }

}

?>
