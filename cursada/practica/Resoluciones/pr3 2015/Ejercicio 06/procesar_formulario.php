<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Visualizando Informaci&oacute;n</title>
		<link rel="stylesheet" type="text/css" href="formulario.css">
	</head>
	<body>
		<?php 
			require('validar.php');
			if (validar_datos()) {
				print("<h1>Datos Ingresados</h1>");
				mostrar_informarcion(); 
			?>
				<input type="submit" value="Confirmar">
			<?php 
			}
			else
				print("<p>Se ingresaron datos err&oacute;neos</p>");
		?>
		<a href="formulario_reserva.php">
			<div class="boton">
					<input type="submit" value="Volver">
			</div>
		</a>	
	</body>
</html>