<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Bienvenida</title>
		<link rel="stylesheet" type="text/css" href="estilos.css">
	</head>
	<body>
		<?php session_start(); 
		print("<h1>Bienvenido ".$_SESSION['usuario']."</h1>"); 
		?>
		<a href="login.html">
			<div id="boton">
			  	<input type="submit" value="Volver">
			</div>
		</a>
	</body>
</html>