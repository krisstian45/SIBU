<?php

class Usuario extends CRUD {

	public function __construct() {
        parent::__construct();
        self::checkLogin();
        self::checkAdmin();
    }

    //Esta función es única para crear o modificar
    public function crear(){self::vista("crear");}
    public function vista($operacion = null, $data = null) {
        $data['listado'] = UsuarioModel::getInstance()->obtenerUbicaciones();
        $data['sesion'] = $_SESSION['rol_id'];
        self::display($operacion . $_GET['action'], $data); // Ejemplo request= crear, action=Producto (infla crearProducto.twig)
    }

    //Le cambie el nombre a esta funcion (cambiar puede ser borrar o modificar dependiendo de lo pedido)
    public function editar() {
        if (isset($_GET['usuario']) && !empty($_GET['usuario']) ){
            if(isset($_GET['operacion']) && ($_GET['operacion'] == "modificar" || $_GET['operacion'] ==  "borrar")){
                $usuario= $_GET['usuario'];
                $array = UsuarioModel::getInstance()->obtenerUsuario($usuario);
                if (!empty($array)){
                    $data['datosUsuario'] = $array[0];
                    self::vista($_GET['operacion'], $data);
                    return 0;
                }
            }
        }
        //Si hay algún error, vuelve al listado.
        self::index();
    }

    //Este es el destino del post de crearUsuario, borrarUsuario o modificarUsuario.
    public function operar() {
        try {
            if (isset($_GET['operacion'])) {
                $operacion = $_GET['operacion'];
                if($operacion == "crear" || $operacion == "borrar" || $operacion == "modificar")
                    self::operacion($operacion);
                else
                    throw new Exception("La operación solicitada no existe");
            }
            else
                throw new Exception("La operación solicitada no existe");
        }
        catch (Exception $e) {
            self::index($e->getMessage());
            return 0;
        }
    }

    public function operacion($operacion)
    {
        if($operacion == "borrar"){
            //Nos aseguramos que se estamos recibiendo el usuario
            if(isset($_POST['usuario']))
                $usuarioValido = Validar::getInstance()->string($_POST['usuario']); //Si no es válido, entra por el catch.
            else
                throw new Exception("Por favor, verificar completar correctamente los campos");

            if (isset($_GET['operacion']) && ($_GET['operacion'] == "borrar")) {
                $usuarioActual = $_SESSION['usuario']; //Enviamos esto para saber si no se esta queriendo eliminar a si mismo.
                UsuarioModel::getInstance()->borrar($usuarioValido, $usuarioActual);
                self::index("Operación realizada con éxito!");
                return 0;
            }
            else
                throw new Exception("Los datos son incorrectos. Por favor, intente de nuevo. ");

        }
        elseif($operacion == "crear" || $operacion == "modificar"){
                //Nos aseguramos que se estamos recibiendo el usuario
                $usuarioValido = Validar::getInstance()->validarInputs($_POST, "usuario");
                try {

                    if(!empty($usuarioValido['errores']) || sizeof($usuarioValido) == 1) //Si no hay errores y los datos validados se encuentran presentes.
                        throw new Exception("Por favor, verificar completar correctamente los campos");

                    if($operacion == "crear")
                        UsuarioModel::getInstance()->crear($usuarioValido);
                    else{
                        $usuarioActual = $_SESSION['usuario'];
                        UsuarioModel::getInstance()->modificar($usuarioValido, $usuarioActual);
                    }

                    self::index("Operación realizada con éxito!");
                    return 0;

                } catch (Exception $e) {
                    $data['general'] = $e->getMessage();
                    $data['datosUsuario'] = $usuarioValido; //tambien tiene los errores que hubo (data.datosUsuario.usuario , etc...)
                    self::vista($operacion, $data);
                    return 0;
                }
        }

    }

    public function listado() {
        return UsuarioModel::getInstance()->obtenerUsuarios();
    }

}

?>
