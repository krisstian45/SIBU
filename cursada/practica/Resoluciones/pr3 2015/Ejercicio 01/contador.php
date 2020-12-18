<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Contador de Visitas</title>
	</head>
	<body>
		<?php 
			$nombre_archivo = "contador.txt";
			if (file_exists($nombre_archivo)){
				$archivo = fopen($nombre_archivo, "r+");
				$linea = fread($archivo, filesize($nombre_archivo));
				fclose($archivo);
			}
			$archivo = fopen($nombre_archivo,"w");
			$contador = (int)$linea + 1;
			$linea = fwrite($archivo,$contador);
			echo "<h3>Usted es el visitante n&uacute;mero $contador</h3>";
			fclose($archivo);
		?>		
	</body>
</html>
