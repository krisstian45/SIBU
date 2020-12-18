<?php 
	if (!isset($_COOKIE["ultimaVisita"]))
		header('Location: error_formulario.html');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Formulario para la reserva</title>
		<link rel="stylesheet" type="text/css" href="formulario.css">
	</head>
	<body>
		<h1>Reserva de Pasajes</h1>
		<form method="post" action="procesar_formulario.php">
			<fieldset>
				<legend>Datos Personales</legend>
				<div class="campo">
					<label>Nombre<span class="asterisco">*</span></label><input type="text" name="nombre" placeholder="Ingrese su nombre" required="required">
				</div>
				<div class="campo">
					<label>Apellido<span class="asterisco">*</span></label><input type="text" name="apellido" placeholder="Ingrese su apellido" required="required">
				</div>
				<div class="campo">
					<label>Mail<span class="asterisco">*</span></label><input type="email" name="mail" placeholder="ejemplo@dominio.com" required="required">
				</div>
				<div class="campo">
					<label>Tel&eacute;fono<span class="asterisco">*</span></label><input type="tel" name="telefono" placeholder="(0221) 447-0000" required="required">
				</div>
				<div class="campo">
					<label>Fecha de Nacimiento<span class="asterisco">*</span></label><input type="date" name="fecha_nac" placeholder="dd/mm/aaaa" required="required">	
				</div>
				<div class="campo">
					<label>N° de Documento<span class="asterisco">*</span></label><input type="number" name="documento" placeholder="Ingrese su n&uacute;mero" required="required">
				</div>
			</fieldset>
			<fieldset>
				<legend>Datos de la Reserva</legend>
				<div class="campo">
					<label>Fecha de Reserva<span class="asterisco">*</span></label><input type="date" name="fecha_reserva" placeholder="dd/mm/aaaa" required="required">
				</div>
				<div class="campo">
					<label>Cantidad<span class="asterisco">*</span></label><input type="number" name="cantidad" value="1" required="required">
				</div>
				<div class="campo">
					<label>Observaciones</label><textarea rows="5" cols="30" name="observaciones"></textarea>
				</div>
			</fieldset>
			<div class="boton">
				<input type="submit" value="Establecer Reserva">
			</div>
			<div class="boton">
				<input type="reset" value="Borrar Todo">
			</div>
		</form>
	</body>
</html>