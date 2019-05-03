<?php	
	session_start();	
	
	if (isset($_SESSION["ALOJAMIENTO"])) {
		$alojamiento = $_SESSION["ALOJAMIENTO"];
		unset($_SESSION["ALOJAMIENTO"]);
		
		require_once("../gestionBD.php");
		require_once("gestionarAlojamiento.php");
		
		$conexion = crearConexionBD();		
		$excepcion = modificar_alojamiento($conexion,$alojamiento["EID"],$alojamiento["CIUDAD"],$alojamiento["DIRECCION"],$alojamiento["FECHAINICIO"],$alojamiento["FECHAFIN"],$alojamiento["HOTEL"],$alojamiento["NUMPERSONAS"]);
		cerrarConexionBD($conexion);
		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "../pagina.php";
			Header("Location: ../pagina.php");
		}
		else
			Header("Location: ../pagina.php");
	}
	else Header("Location: ../pagina.php"); // Se ha tratado de acceder directamente a este PHP
?>
