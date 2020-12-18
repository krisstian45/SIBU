<?php

class Configuracion extends Base {

	public function __construct() {
        parent::__construct();
        self::checkLogin();
        self::checkAdmin();
	}

	public function vistaConfiguracion($param = '') {
        try {
        	$configuracion = ConfiguracionModel::getInstance()->traerConfiguracion();
        	$this->display("configuracion", array('configuracion' => $configuracion, 'mensaje' => $param));
        }
        catch (Exception $e) {
            $data['mensaje'] = $e->getMessage();
            $this->display("backend", $data);
        }
	}

    public function actualizarConfiguracion() {
        try {
            $error = array();
            if (isset($_POST) && !empty($_POST)) {
                $datos = [
                "titulo" => $_POST["titulo"],
                "descripcion" => $_POST["descripcion"],
                "email" => $_POST["email"],
                "elementos" => $_POST["elementos"],
                "habilitado" => $_POST["habilitado"],
                "mensaje" => $_POST["mensaje"]
                ];
                $configuracionValidada = Validar::getInstance()->validarInputs($_POST, "configuracion");
            }
            else
                $this->vistaConfiguracion(array('error' => $error));
            // By emi: el metodo validar() devuelve un arreglo con los errores encontrados, si no hay errores lo devueve vacio
            if(empty($this->validar($datos, $error))) {
                $configuracion = ConfiguracionModel::getInstance()->actualizarDatos($datos);
                $this->vistaConfiguracion(array('exito' => "Configuracion actualizada con éxito!"));
            }
            else {
                $this->vistaConfiguracion(array('error' => $error));
            }
        }
        catch (Exception $e) {
            $data['mensaje'] = $e->getMessage();
            $this->vistaConfiguracion($data);
        }
    }

    // TODO: By emi: Agrego las validaciones de la configuracion aca, despues vemos si hacemos validaciones generales. El tema es que si por ejemplo queremos hacer una validacion general para inputs de texto no seria posible porque puede ser que un input acepte una longitud de 30 caracteres y otro una de 255. Asi que habria que verlo.

    public function validar($datos, $error) {
        $error = $this->esValidoTitulo($datos['titulo'], $error);
        $error = $this->esValidoDescripcion($datos['descripcion'], $error);
        $error = $this->esValidoEmail($datos['email'], $error);
        $error = $this->esValidoElementos($datos['elementos'], $error);
        $error = $this->esValidoHabilitado($datos['habilitado'], $error);
        $error = $this->esValidoMensaje($datos['mensaje'], $error);
        return ($error);
    }

    public function esValidoTitulo($titulo, $error) {
        if(!preg_match('/^[a-z\d-_.,\s]{2,50}$/i', $titulo))
            $error['titulo'] = "Este campo no cumple el formato solicitado";
        return ($error);
    }

    public function esValidoDescripcion($descripcion, $error) {
        if(!preg_match('/^[a-z\d-_.,\s]{2,255}$/i', $descripcion))
            $error['descripcion'] = "Este campo no cumple con el tamaño esperado (Min: 2 Max: 255)";
        return ($error);
    }

    public function esValidoEmail($email, $error) {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            $error['email'] = "Este campo no cumple el formato solicitado";
        return ($error);
    }

    public function esValidoElementos($elementos, $error) {
        if(!preg_match('/^\d*$/', $elementos))
            $error['elementos'] = "Este campo no cumple el formato solicitado";
        return ($error);
    }

    public function esValidoHabilitado($habilitado, $error) {
        if(!preg_match('/[0,1]/', $habilitado))
            $error['habilitado'] = "Este campo no cumple el formato solicitado";
        return ($error);
    }

    public function esValidoMensaje($mensaje, $error) {
        if(!preg_match('/^[a-z\d-_.,\s]{2,255}$/i', $mensaje))
            $error['mensaje'] = "Este campo no cumple con el tamaño esperado (Min: 2 Max: 255)";
        return ($error);
    }

}

?>