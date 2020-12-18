<?php 
	if (isset($_COOKIE["ultimaVisita"]))
		header('Location: bienvenida.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Inicio de sesi&oacute;n</title>
		<link rel="stylesheet" type="text/css" href="estilos.css">
	</head>
	<body>
		<form method="post" action="procesar_login.php">
			<div class="campo">
				<label>Usuario</label><input type="text" name="usuario" required="required">
			</div>
			<div class="campo">
				<label>Clave</label><input type="password" name="clave" required="required">
			</div>
			<div id="boton">
		    	<input class="submit" type="submit" value="Ingresar">
		    </div>
		</form>
	</body>
</html>