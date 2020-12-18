<!DOCTYPE html>
<html>
<head>
	<title>Confirmar operacion</title>
</head>
<body>

<?php
// define variables and set to empty values
$nombre = $apellido = $mail = $telefono = $nacimiento = $documento = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//nombre
	if (empty($_POST["nombre"])) 
		$errorName = "Nombre no debe estar vacio.";
	else{
		if (!preg_match("/^[a-zA-Z ]*$/",$nombre))		
			echo "Solo letras y espacios son permitidos.";
	   	else 
	   		$nombre = form_input($_POST["nombre"]);
   	}
   	//apellido
	if (empty($_POST["apellido"])) 
		echo "Apellido no debe estar vacio.";
	else{
		if (!preg_match("/^[a-zA-Z ]*$/",$apellido))		
			echo "Solo letras y espacios son permitidos.";
	   	else 
	   		$apellido = form_input($_POST["apellido"]);
   	}
   	//mail
	if (empty($_POST["mail"])) 
		echo "Mail no debe estar vacio.";
	else{
		if (!filter_var(test_input($_POST["email"]);, FILTER_VALIDATE_EMAIL)) 
			$emailErr = "Invalid email format"; 
	   	else 
	   		$mail = form_input($_POST["mail"]);
   	}


   $telefono = form_input($_POST["telefono"]);
   $nacimiento = form_input($_POST["nacimiento"]);
   $documento = form_input($_POST["documento"]);
}

	
function form_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

echo "<h2>Vos escribiste :</h2>";
echo $nombre;
echo "<br>";
echo $apellido;
echo "<br>";
echo $mail;
echo "<br>";
echo $telefono;
echo "<br>";
echo $nacimiento;
echo "<br>";
echo $documento;

?>

<button type="submit"  onclick="alert('Reserva realizada con exito!')" value="Submit">Confirmar</button>

<a href="form.html"><button type="submit" value="Submit">Volver al formulario</button></a>

</body>
</html>
