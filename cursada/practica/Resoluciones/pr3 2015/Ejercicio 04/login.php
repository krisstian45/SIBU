<?php
 session_start();
 $token= md5(uniqid());
 $_SESSION['delete_customer_token']= $token;
 session_write_close();
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
			 <input type="hidden" name="token" value="<?php echo $token; ?>" />

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