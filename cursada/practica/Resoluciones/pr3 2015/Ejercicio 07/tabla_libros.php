	<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Listado de Libros</title>
		<link rel="stylesheet" type="text/css" href="estilos.css">
	</head>
	<body>
		<h1>Libros</h1>
		<a href="../Ejercicio 08/formulario_alta_libro.html">Nuevo Libro</a>
		<table class="center">
			<thead>
			<tr>
				<th>T&iacute;tulo</th>
					<th>Autor</th>
					<th>Publicaci&oacute;n</th>
					<th>Edici&oacute;n</th>
					<th>ISBN</th>
				</tr>
			</thead>
			<?php 
				$nombre_archivo = "libros.csv";
				if (file_exists($nombre_archivo)){
					$archivo = fopen($nombre_archivo, "r");
					while(!feof($archivo)){
						$datos = fgetcsv($archivo, 1000, ';');
						print("<tbody><tr><td>".$datos[0]."</td>");
						print("<td>".$datos[1]."</td>");
						print("<td>".$datos[2]."</td>");
						print("<td>".$datos[3]."</td>");
						print("<td>".$datos[4]."</td></tr></tbody>");
					}
					fclose($archivo);
				}
			?>
		</table>	
	</body>
</html>