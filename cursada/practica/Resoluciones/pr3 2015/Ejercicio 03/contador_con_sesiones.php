<?php 
			session_start();
			$nombre_archivo = "contador.txt";
			if (file_exists($nombre_archivo)){
				$archivo = fopen($nombre_archivo, "r+");
				$linea = fread($archivo, filesize($nombre_archivo));
				fclose($archivo);
			}
			if (!isset($_COOKIE["ultimaVisita"])){
				$archivo = fopen($nombre_archivo,"w");
				$contador = (int)$linea + 1;
				$linea = fwrite($archivo,$contador);
				fclose($archivo);
				$valor = $contador;
				setCookie("ultimaVisita", $valor);
			}
			else
				$valor = $_COOKIE["ultimaVisita"];			
?>	
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Contador de Visitas</title>
	</head>
	<body>
		<?php 
			echo "<h3>Usted es el visitante n&uacute;mero $valor</h3>";
		?>	
	</body>
</html>
