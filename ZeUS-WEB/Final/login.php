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
		$_SESSION['consultaralmacen'] = $num_usuarios_almacen;
		$_SESSION['consultarproduccion'] = $num_usuarios_prod;
		$_SESSION['consultartecnico'] = $num_usuarios_tec;
		cerrarConexionBD($conexion);	

		if ($num_usuarios_almacen > 0){
			$_SESSION['login'] = $email;
			$_SESSION['localidad']="inventario";
			Header("Location: pagina.php");
		}else if($num_usuarios_prod > 0){
			$_SESSION['login'] = $email;
			$_SESSION['localidad']="evento";
			Header("Location: pagina.php");	//Anteriormente, pagina.php
		}else if($num_usuarios_tec >0){
			$_SESSION['login'] = $email;
			Header("Location: pagina.php");
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
</head>

<body>
<img class="image" src="images/zeus.png">
	<div class="body">
	<form action="login.php" method="post">
	<div class="login">
		<input type="text" placeholder="Email" name="email" id="email" class="text"/>
		<input placeholder="Contraseña" type="password" id="pass" name="pass" class="pass"/>
		<input type="submit" name="submit" id="enviar" class="button" value="Login"/>
		
		<?php if (((isset($_POST['submit'])) && $_SESSION['login'] == "error")) {
		echo "<div class=\"error\">";
		echo "Error en la contraseña o no existe el usuario";
		echo "</div>";
	}else if((isset($_SESSION['errorBD']))) {
		echo "<div class=\"error\">";
		echo "Error con la base de datos";
		echo "</div>";
	}
	?>
	</div>
	</form>
	</div>
</div>
<script src="js/jquerry.js"></script>
<button type="button" id="creditos"> Acerca de</button>

<br><p id="texto" hidden>Somos un grupo de sicarios del cuartel del golfo, nuestro objetivo es hacer una página web
	para reclutar jovenes emprendedores con capacidades de decapitar cabezas, piernas, manos, etc. Entre otras muchas
	extremidades del cuerpo.
</p>
</body>
<?php unset($_SESSION['errorBD']); ?>
</html>