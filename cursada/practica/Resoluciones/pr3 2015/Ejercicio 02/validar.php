<?php 
	function validar_texto($campo_text){
		return preg_match("/[A-Za-z]{1,30}/", $campo_text);
	}

	function validar_numero($campo_number){
		return preg_match("/[0-9]/", $campo_number);
	}

	function validar_email($campo_email){
		return preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/", $campo_email);
	}

	function validar_telefono($campo_tel){
		return preg_match("#^\(?\d{4}\)?[\s\.-]?\d{3}[\s\.-]?\d{4}$#", $campo_tel);
	}

	function validar_fecha_firefox($campo_fecha){
		return preg_match("#^(0[1-9]|[12][0-9]|3[01])[\/](0[1-9]|1[012])[\/](19|20)[0-9]{2}$#", $campo_fecha);
	}

	function validar_fecha_chrome($campo_fecha){
		return preg_match("#^(19|20)[0-9]{2}[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])$#",$campo_fecha);	
	}

	function validar_fecha($campo_fecha){
		return validar_fecha_firefox($campo_fecha) || validar_fecha_chrome($campo_fecha);
	}

	function validar_datos(){
		return validar_texto($_POST["nombre"]) && 
				   validar_texto($_POST["apellido"]) &&
				   validar_email($_POST["mail"]) &&
				   validar_telefono($_POST["telefono"]) &&
				   validar_fecha($_POST["fecha_nac"]) &&
				   validar_numero($_POST["documento"]) &&
				   validar_fecha($_POST["fecha_reserva"]) &&
				   validar_numero($_POST["cantidad"]);
	} 

	function mostrar_informarcion(){
		print("<p> Nombre: " . $_POST["nombre"] ."</p>");
		print("<p> Apellido: ". $_POST["apellido"] ."</p>");
		print("<p> Mail: ". $_POST["mail"] ."</p>");
		print("<p> Tel&eacute;fono: " . $_POST["telefono"] ."</p>");
		print("<p> Fecha de Nacimiento: " . $_POST["fecha_nac"] ."</p>");
		print("<p> N° de Documento: " . $_POST["documento"] ."</p>");
		print("<p> Fecha de Reserva: " . $_POST["fecha_reserva"] ."</p>");
		print("<p> Cantidad: " . $_POST["cantidad"] ."</p>");
		print("<p> Observaciones: " . $_POST["observaciones"] ."</p>");
	}
?>