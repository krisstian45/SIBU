<?php

class SuscripcionModel extends PDORepository  {
    protected function __construct() {

    }

    public function crearSuscripcion($value)
    {
        $suscripcion[0]= $value["message"]["chat"]["id"];
        $suscripcion[1]= $value['message']['from']['first_name'];
        $usuario=array_values($suscripcion);

        $query = $this->query("INSERT INTO suscripciones (chat_id, nombre)
            VALUES (?, ?)", $usuario);

        return $query->rowCount();
    }

    public function eliminarSuscripcion($value)
    {
        $chat_id[0] = $value["message"]["chat"]["id"];
        $query = $this->query("DELETE FROM suscripciones WHERE chat_id=?", $chat_id);
        return $query->rowCount();
    }
    public function obtenerSuscriptos()
    {
        $stmt = $this->query("SELECT * FROM suscripciones ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>