<?php

 class Validar extends ValidarBase {

 	function __construct() {
        parent::__construct();
  	}


    public function validarInputs($post, $nombreArray) {
        $modulo = $this->$nombreArray;  //En modulo vamos a tener el array correspendiente de ValidarBase (ejemplo, login) $modulo va a tener ("login", array(['requerido']--> zarza...))
        //var_dump($modulo); die();
        return (self::validarCampos($post, $modulo)); //Esto nos va a devolver un array con la data validada. Además, agrega un arreglo que se llama errores. En el controlador, si este no está vacío, debería volver a llamar a la vista mostrando cada error . EJemplo: errores['usuario'].
    }

    public function validarCampos($post, $modulo) {
        $dataValidada = array();
        $errores = array();
        foreach ($post as $key => $value) { //Aca loopeamos por cada uno de los inputs del post
                if(array_key_exists($key, $modulo)){ // por ejemplo, si validamos el login, esto se asegura que existan los campos usuario y password en el array módulo de ValidarBase.
                $requerimientos = $modulo[$key];
                if($requerimientos['requerido']){   //Verificamos que el campo especificado en el array asociativo de ValidarBase sea obligatorio
                    if (empty($value))
                        $errores[$key] = "Este campo no debe estar vacío";
                }
                if (strlen($value) < $requerimientos['min'] || strlen($value) > $requerimientos['max'])
                    $errores[$key] = "Este campo no cumple con la cantidad de caractéres pedidos";

                $validarTipoCampo = $requerimientos ['tipo']; //Esto nos va a retornar "string" o "integer", etc dependiendo del tipo de campo tratando en el momento
                try {

                    $dataValidada[$key] = self::$validarTipoCampo($value);
                } catch (Exception $e) {
                    $errores[$key] = $e->getMessage();
                }
            }
            else{
                $errores['general'] = "Usted posee errores en los datos insertados.";
                break; //Cortamos el loop.
            }
        }

        $dataValidada['errores'] = $errores;
        return $dataValidada;
    }

    public function string($value) {
        $stringLimpio = filter_var($value, FILTER_SANITIZE_STRING);
        if($stringLimpio == $value)
            return $stringLimpio;
        else
            throw new Exception("El string no debe tener carácteres especiales.");
    }

    public function integer($value) {
        if (!filter_var($value,FILTER_VALIDATE_INT) === false) { //Aca ES TRIPLE IGUAL

            $integerLimpio= filter_var($value, FILTER_SANITIZE_NUMBER_INT);
            if($integerLimpio == $value){
                if ($value >= 0) {
                    return $integerLimpio;
                }else throw new Exception("El numero no puedo ser negativo");
            }else
                   throw new Exception("El numero es incorrecto");

        }else

            throw new Exception("El numero es incorrecto");

    }

     public function float($value) {
        if (!filter_var($value,FILTER_VALIDATE_FLOAT) === false) {
            $floatLimpio= filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
            if($floatLimpio== $value){
                return $floatLimpio;
                if ($value >= 0) {
                return $floatLimpio;
                }else throw new Exception("El numero no puedo ser negativo");
            }else
                   throw new Exception("El numero es incorrecto.");

        }else
            throw new Exception("El numero es incorrecto.");
    }

    // TODO: ESta funcion podriamos cambiarle el nombre a dateTime y hacer otra parecida pero que valide solo fecha sin la hora con nombre date

    public function date($value) {
        $format = 'Y-m-d H:i:s';
        //$format = 'd-m-Y';
        $d = DateTime::createFromFormat($format, $value);
        if($d && $d->format($format) == $value){
            return $value;
        } throw new Exception("Formato de fecha incorrecto");
    }

    public function email($value)
    {
       if (!filter_var($value,FILTER_VALIDATE_EMAIL) === false) {
            $emailLimpio= filter_var($value, FILTER_SANITIZE_EMAIL);
            if($emailLimpio== $value){
                return $emailLimpio;
            }else
                throw new Exception("El email tiene formato desconocido");

        }else
            throw new Exception("El email no es valido.");

    }

    public function categoria($value) {
        $data = ProductoModel::getInstance()->obtenerCategorias();
        if(null != self::integer($value)){

            foreach ($data as $key => $valu) {
                if( $valu[0] == $value){
                   return $value;
                }
            } throw new Exception("La categoria no existe");
        }
        else throw new Exception("La categoria no existe");
    }

    public function ubicacion($value) {
        $data = UsuarioModel::getInstance()->obtenerUbicacion();
        if(null != self::integer($value)){

            foreach ($data as $key => $valu) {
                if( $valu[0] == $value){
                   return $value;
                }
            } throw new Exception("La ubicacion no existe");
        }
        else throw new Exception("La ubicacion no existe");
    }

    public function tipoDoc($value) {
        $data=self::string($value);
        if($data==$value){
            if ($value == "DNI" || $value == "CI" || $value == "LE" || $value == "LC") {
                return $value;
            }else throw new Exception("El tipo de documento no es correcto.");
        }
        else
        throw new Exception("El tipo de dni es incorrecto");
    }

    public function password($value) {
        if(preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{5,15}$/', $value)) {
            return $value;
        }
        else
            throw new Exception("La contraseña no es válida");
    }

}

?>
