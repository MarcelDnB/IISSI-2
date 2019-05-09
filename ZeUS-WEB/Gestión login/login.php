<?php
	session_start();
  	
  	include_once("gestionBD.php");
 	include_once("gestionarUsuarios.php");
	
	if (isset($_POST['submit'])){
		$email= $_POST['email'];
		$pass = $_POST['pass'];
		$conexion = crearConexionBD();
		$num_usuarios_almacen = consultarUsuarioAlmacen($conexion,$email,$pass);
		$num_usuarios_prod = consultarUsuarioProduccion($conexion,$email,$pass);
		$num_usuarios_tec = consultarUsuarioTecnico($conexion,$email,$pass);
	
		cerrarConexionBD($conexion);	

		if ($num_usuarios_almacen > 0){
			$_SESSION['login'] = $email;
			Header("Location: homeAlmacen.php");
		}else if($num_usuarios_prod > 0){
			$_SESSION['login'] = $email;
			Header("Location: homeProduccion.php");	//Anteriormente, pagina.php
		}else if($num_usuarios_tec >0){
			$_SESSION['login'] = $email;
			Header("Location: homeTecnico.php");
		}
		else{
			$_SESSION['login'] = "error";
		}
	}
?>

<!DOCTYPE html>
<html lang="es" >
<head>
  <meta charset="UTF-8">
  <title>ZeUSware</title>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:600'>
  <link rel="stylesheet" type="text/css" href="css/estiloLogin.css">
</head>

<body>
<img class="image" src="images/zeus.png">
	<div class="body">
	<form action="login.php" method="post">
	<div class="login">
		<input type="text" placeholder="Email" name="email" id="email" class="text"/>
		<input placeholder="Contraseña" type="password" id="pass" name="pass" class="pass"/>
		<input type="submit" name="submit" class="button" value="Login"/>
		
		<?php if ((isset($_POST['submit'])) && $_SESSION['login'] == "error") {
		echo "<div class=\"error\">";
		echo "Error en la contraseña o no existe el usuario";
		echo "</div>";
	}	
	?>
	</div>
	</form>
	</div>
</div>
</body>
</html>