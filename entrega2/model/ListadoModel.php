<?php

class ListadoModel extends PDORepository  {

	protected function __construct() {

    }

  	function obtenerProductosFaltantes() {
        $stmt = $this->query("SELECT * FROM producto WHERE stock < stock_minimo");
        if($stmt->rowCount() > 0) {
            return ($stmt->fetchAll());
        }
        else {
            return (false);
        }
    }

    function obtenerProductosStockMinimo() {
        $stmt = $this->query("SELECT * FROM producto WHERE stock = stock_minimo");
        if($stmt->rowCount() > 0) {
            return ($stmt->fetchAll());
        }
        else {
            return (false);
        }
    }

}
