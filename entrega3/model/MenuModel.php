<?php

class MenuModel extends PDORepository  {

	protected function __construct() {

    }

  	function obtenerMenu($fecha) {
        $arrayData[0] = $fecha;
        $stmt = $this->query("SELECT * FROM menus INNER JOIN productos on (productos.id = menus.producto_id) WHERE fecha = ?", $arrayData);
        if($stmt->rowCount() > 0) {
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        else {
            return (false);
        }
    }

    public function obtenerProductoMenu($id,$dia)
    {
        # code...
        $arrayData [0]= $id;
        $arrayData [1]= $dia;
        $stmt = $this->query("SELECT * FROM menu WHERE producto_id = ? and fecha = ?", $arrayData);
        if($stmt->rowCount() > 0) {
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        else {
            return (false);
        }
    }

    public function agregarProducto($id,$dia)
    {
        $arrayData [0]= $dia;
        $arrayData [1]= $id;
        $this->query("INSERT INTO menu ( fecha, producto_id)
            VALUES (?, ?)", $arrayData);
        return 0;
    }

    public function eliminarProducto($id,$dia)
    {
        $arrayData [0]= $dia;
        $arrayData [1]= $id;
        $this->query("DELETE FROM menu
            WHERE  fecha=? and producto_id =? ", $arrayData);
        return 0;
    }

}
