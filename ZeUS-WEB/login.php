<?php
	session_start();
  	
  	include_once("gestionBD.php");
 	include_once("gestionarUsuarios.php");
	
	if (isset($_POST['submit'])){
		$email= $_POST['email'];
		$pass = $_POST['pass'];

		$conexion = crearConexionBD();
		$num_usuarios = consultarUsuario($conexion,$email,$pass);
		cerrarConexionBD($conexion);	
	
		if ($num_usuarios == 2){
			$login = "error";
		}else {
			$_SESSION['login'] = $email;
			Header("Location: index.php");
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
<main>
<?php if (isset($login)) {
		echo "<div class=\"error\">";
		echo "Error en la contraseña o no existe el usuario.";
		echo "</div>";
	}	
	?>

		<div class="login-html">
		<form action="login.php" method="post">
		<label id="aversiva" class="aversiva">Login</label><br><br><br>
		<label for="email" class="label1">Usuario:</label>
		<input id="email" name="email" type="text" class="input"/>
		<br><label for="pass" class="label2">Contraseña:</label>
		<input id="pass" name="pass" type="password" class="input"/>
		<br><input type="submit" name="submit" class="button" value="submit"/>
		</form>
</main>
		<div class="hr"></div>
		<a href="#forgot">He olvidado mi contraseña</a>
		</div>
</div>

</body>

</html>
