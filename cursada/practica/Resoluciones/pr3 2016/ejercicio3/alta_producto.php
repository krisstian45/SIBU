<?php

function validar($arg)
{
	if(isset($arg) && !empty($arg)) {
		return ($arg);
	}
	else {
		return (false);
	}
}

if(isset ($_POST['nombre']) && !empty($_POST['nombre'])){
	$data['nombre'] = validar($_POST['nombre']);
	$data['marca'] = validar($_POST['marca']);
	$data['codigoBarra'] = validar($_POST['codigoBarra']);
	$data['stock'] = validar($_POST['stock']);
	$data['categoria'] = validar($_POST['categoria']);
	$data['proveedor'] = validar($_POST['proveedor']);
	$data['precio'] = validar($_POST['precio']);
}



 ?>
