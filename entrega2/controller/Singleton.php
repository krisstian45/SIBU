<?php

abstract class Singleton {

    private static $instances = array(); // Como son multiples clases que vamos a inicializar con Singleton, las guardamos en un array

    protected function __construct() {}

    public static function getInstance() {
        $class = get_called_class(); // Con get_called_class() obtenemos la clase a la cual se va a instanciar
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new $class; // A partir de PHP 5.3. se puede hacer new static (instancia la clase que llama a getInstance)
        }
        return (self::$instances[$class]); // Devolvemos la instancia de la clase
    }

}

?>