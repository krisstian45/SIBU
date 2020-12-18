<?php 
	$nombre_archivo = "../Ejercicio 07/libros.csv";
	if (file_exists($nombre_archivo)){
		$archivo = fopen($nombre_archivo, "a+");
		$datos = array($_POST['titulo'], $_POST['autor'], $_POST['publicacion'], $_POST['edicion'], $_POST['isbn'].PHP_EOL);
		fputcsv($archivo, $datos, ';');	
		fclose($archivo);
		header('Location: ../Ejercicio 07/tabla_libros.php');
	}
?>

