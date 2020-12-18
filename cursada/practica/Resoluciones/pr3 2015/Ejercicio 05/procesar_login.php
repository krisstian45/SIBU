<?php
	$usuario = $_POST["usuario"];
	$clave = $_POST["clave"];
 	$datos_validos = false;
	$nombre_archivo = "usuarios.dat";
	if (file_exists($nombre_archivo)){
		$archivo = fopen($nombre_archivo, "r");
		while((!feof($archivo)) && (!$datos_validos)){
			$linea = trim(fgets($archivo)); 
			list($user, $pass) = explode("-", $linea);
			if((strcmp($user, $usuario) == 0) && (strcmp($pass, $clave) == 0))
				$datos_validos = true;
		}	
		fclose($archivo);
		if($datos_validos){
			session_start();
			if (!isset($_COOKIE["ultimaVisita"]))
				setcookie("ultimaVisita", time());
			$_SESSION['usuario'] = $usuario;
			header('Location: bienvenida.php');
		}
		else
			header('Location: error.html');
	}
?>
