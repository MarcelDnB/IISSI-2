<?php
	session_start();
  	
  	include_once("gestionBD.php");
 	include_once("gestionUsuarios.php");
	
	if (isset($_POST['submit'])){
		$email= $_POST['email'];
		$pass = $_POST['pass'];
		$conexion = crearConexionBD();
		$num_usuarios = consultarUsuario($conexion,$email,$pass);
		cerrarConexionBD($conexion);	
	
		if ($num_usuarios == 0){
			$login = "error";
		}else {
			$_SESSION['login'] = $email;
			Header("Location: tecnico.php");
		}
	}
?>

<!DOCTYPE html>
<html lang="es" >
<head>
  <meta charset="UTF-8">
  <title>ZeUSware</title>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:600'>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
<img class="image" src="images/zeus.png">
	<div class="body">
	<form action="login.php" method="post">
	<div class="login">
		<input type="text" placeholder="Email" name="email" id="email" class="text"/>
		<input placeholder="Contraseña" type="password" id="pass" name="pass" class="pass"/>
		<input type="submit" name="submit" class="button" value="Login"/>
		<?php if (isset($login)) {
		echo "<div class=\"error\">";
		echo "Error en la contraseña o no existe el usuario.";
		echo "</div>";
	}	
	?>
	</div>
	</form>
	</div>
</div>
</body>
</html>