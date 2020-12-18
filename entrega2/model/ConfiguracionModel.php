<?php

class ConfiguracionModel extends PDORepository {

    private  $titulo;
    private  $descripcion;
    private  $email;
    private  $elementos;
    private  $habilitado;
    private  $mensaje;

    function __construct() {

    }

    public function getTitulo() {
        return ($this->titulo);
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function getDescripcion() {
        return ($this->descripcion);
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getEmail() {
        return ($this->email);
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getElementos() {
        return ($this->elementos);
    }

    public function setElementos($elementos) {
        $this->elementos = $elementos;
    }

    public function getHabilitado() {
        return ($this->habilitado);
    }

    public function setHabilitado($habilitado) {
        $this->habilitado = $habilitado;
    }

    public function getMensaje() {
        return ($this->mensaje);
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function traerConfiguracion() {
        $stmt = $this->query("SELECT * FROM configuracion");
        /* By emi: Debe existir una configuracion para el sistema obligatoriamente, en caso de que no exista muestra error pero es necesario que exista una por defecto sino es como si hubiera un error en el sistema */
        if($stmt->rowCount() > 0) {
            return ($stmt->fetch());
        }
        else {
            throw new Exception("Error del sistema. No existe ninguna configuracion.");
        }
    }

    public function actualizarDatos($datos) {
        $this->query("UPDATE configuracion SET
            titulo = ?, descripcion = ?, email = ?, elementos = ?,
            habilitado = ?, mensaje = ?", array_values($datos));
    }

    /* public function cargarInfoCooperadora() {
        $conn = $this->pdo->getConnection();
        $stmt = $conn->prepare("UPDATE configuracion
            set
                titulo = :titulo,
                descripcion = :descripcion,
                mail = :mail,
                elementos = :elementos,
                habilitado = :habilitado,
                mensaje = :mensaje");
        $stmt->bindValue(":titulo", $this->getTitulo(), PDO::PARAM_STR);
        $stmt->bindValue(":descripcion", $this->getDescripcion(), PDO::PARAM_STR);
        $stmt->bindValue(":mail", $this->getMail(), PDO::PARAM_STR);
        $stmt->bindValue(":elementos", $this->getElementos(), PDO::PARAM_STR);
        $stmt->bindValue(":habilitado", $this->getHabilitado(), PDO::PARAM_STR);
        $stmt->bindValue(":mensaje", $this->getMensaje(), PDO::PARAM_STR);
        $stmt->execute();
        $this->pdo->closeConnection($conn); // Cerramos la conexion
    } */

}

?>