<?php

class ValidarBase extends Base
{
    protected $login = array();
    protected $producto = array();
    protected $usuario = array();
    protected $compra = array();
    protected $venta = array();
    protected $configuracion = array();


	function __construct()
	{
        //Esto es para asegurarse que los inputs de (por ejemplo, producto, coincidan con lo que recibo del post y no esten vacios)
       $this->login["usuario"] = array("requerido" => "true", "tipo" => "string", "min" => 2, "max" => 20 );
       $this->login["password"] = array("requerido" => "true", "tipo" => "string", "min" => 6, "max" => 30 ); //Aca el tipo debería ser password, pero lo dejamos para poder entrar mas facil con 123456

       $this->usuario["id"] = array("requerido" => "false", "tipo" => "string", "min" => "0", "max" => "2");
       $this->usuario["usuario"] = array("requerido" => "true", "tipo" => "string", "min" => 5, "max" => 10);
       $this->usuario["clave"] = array("requerido" => "true", "tipo" => "password", "min" => "5","max" => "15");
       $this->usuario["nombre"] = array("requerido" => "true", "tipo" => "string", "min" => 2, "max" => 30);
       $this->usuario["apellido"] = array( "requerido" => "true", "tipo" => "string", "min" => 2, "max" => 20);
       $this->usuario["email"] = array( "requerido" => "true", "tipo" => "email", "min" => 3, "max" => 50);
       $this->usuario["tipoDocumento"] = array( "requerido" => "true", "tipo" => "tipoDoc", "min" => 1, "max" => 6);//ver esto
       $this->usuario["numeroDocumento"] = array( "requerido" => "true", "tipo" => "integer", "min" => 7, "max" => 9);
       $this->usuario["telefono"] = array( "requerido" => "true", "tipo" => "integer", "min" => 6, "max" => 20);
       $this->usuario["rol"] = array("requerido" => "true", "tipo" => "string", "min" => 5, "max" => 15);
       $this->usuario["ubicacion_id"] = array("requerido" => "true", "tipo" => "ubicacion", "min" => 0, "max" => 2);
       $this->usuario["habilitado"] = array("requerido" => "true", "tipo" => "string", "min" => "4", "max" => "15");

       $this->producto["id"] = array("requerido" => "false", "tipo" => "integer", "min" => 0, "max" => 2);
       $this->producto["nombre"] = array("requerido" => "true", "tipo" => "string", "min" => 2, "max" => 20);
       $this->producto["marca"] = array("requerido" => "true", "tipo" => "string", "min" => 2, "max" => 20);
       $this->producto["codigo_barra"] = array("requerido" => "true", "tipo" => "integer", "min" => 10, "max" => 20);
       $this->producto["stock"] = array("requerido" => "true", "tipo" => "integer", "min" => 1, "max" => 1000);
       $this->producto["stock_minimo"] = array("requerido" => "true", "tipo" => "integer", "min" => 1, "max" => 500);
       $this->producto["categoria_id"] = array("requerido" => "true", "tipo" => "categoria", "min" => 0, "max" => 2);
       $this->producto["proveedor"] = array("requerido" => "true", "tipo" => "string", "min" => 2, "max" => 20);
       $this->producto["precio_venta_unitario"] = array("requerido" => "true", "tipo" => "float", "min" => 0, "max" => 1000);
       $this->producto["descripcion"] = array("requerido" => "true", "tipo" => "string", "min" => 2, "max" => 255);
       $this->producto["fecha_alta"] = array("requerido" => "true", "tipo" => "date", "min" => 1, "max" => 20);

       $this->compra["id"] = array("requerido" => "false", "tipo" => "integer", "min" => "5", "max" => "10");
       $this->compra["proveedor"] = array("requerido" => "true", "tipo" => "string", "min" => "5", "max" => "20");
       $this->compra["proveedor_cuit"] = array("requerido" => "true", "tipo" => "string", "min" => "5", "max" => "10");
       $this->compra["fecha_alta"] = array("requerido" => "true", "tipo" => "date", "min" => "5", "max" => "10");

       $this->venta["id"] = array("requerido" => "false", "tipo" => "integer", "min" => "5", "max" => "10");
       $this->venta["productos_id"] = array("requerido" => "true", "tipo" => "integer", "min" => "5", "max" => "10");
       $this->venta["cantidad"] = array("requerido" => "true", "tipo" => "integer", "min" => "5", "max" => "10");
       $this->venta["precio_venta_unitario"] = array("requerido" => "true", "tipo" => "float", "min" => "5", "max" => "10");
       $this->venta["descripcion"] = array("requerido" => "true", "tipo" => "string", "min" => "5", "max" => "10");
       $this->venta["fechaAlta"] = array("requerido" => "true", "tipo" => "date", "min" => "5", "max" => "10");

       $this->configuracion["id"] = array("requerido" => "false", "tipo" => "integer", "min" => "5", "max" => "10");
       $this->configuracion["titulo"] = array("requerido" => "true", "tipo" => "string", "min" => "2", "max" => "50");
       $this->configuracion["descripcion"] = array("requerido" => "true", "tipo" => "string", "min" => "2", "max" => "255");
       $this->configuracion["email"] = array("requerido" => "true", "tipo" => "email", "min" => "2", "max" => "30");
       $this->configuracion["elementos"] = array("requerido" => "true", "tipo" => "integer", "min" => "1", "max" => "9999999");
       $this->configuracion["habilitado"] = array("requerido" => "true", "tipo" => "string", "min" => "0", "max" => "1");
       $this->configuracion["mensaje"] = array("requerido" => "true", "tipo" => "string", "min" => "2", "max" => "255");

	}
}
 ?>