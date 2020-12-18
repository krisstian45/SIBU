<?php

class PDORepository extends Singleton {

    const USERNAME = "grupo46";
    const PASSWORD = "Pafi6seiho";
	const HOST ="localhost";
	const DB = "grupo46";


    protected function getConnection() {
        $user = self::USERNAME;
        $pass = self::PASSWORD;
        $db = self::DB;
        $host = self::HOST;
        $connection = new PDO("mysql:dbname=$db;host=$host", $user, $pass);
        return ($connection);
    }

    protected function closeConnection($connection) {
        $connection = NULL;
    }

    // By emi: Esqueleto para realizar cualquier consulta
    // NOTA: el $args = array() es porque puede haber consultas que no necesiten parametros, como la de traerConfiguracion de la clase ConfiguracionModel. Por eso lo inicializamos en un array vacio. (Tiene que ser array si o si porque si lo inicializamos en NULL o '' explota la consulta a la BD)

    protected function query($sql, $args = array()) {
        $connection = $this->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute($args);
        $this->closeConnection($connection); // By emi: Cerramos la conexion
        return $stmt;
    }

}

?>
