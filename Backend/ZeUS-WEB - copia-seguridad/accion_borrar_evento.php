<?php	
	session_start();	
	
	if (isset($_SESSION["evento"])) {
		$evento = $_SESSION["evento"];
		unset($_SESSION["evento"]);
		
		require_once("gestionBD.php");
		require_once("gestionarEvento.php");
	
		$conexion=crearConexionBD();
		$excepcion=quitar_libro($conexion,$evento["eid"]);
		cerrarConexionBD($conexion);
		if($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "consulta_evento.php";
			Header("Location: excepcion.php");
		}
		else {
			Header("Location: consulta_evento.php");
		}
	}
	else 
		Header("Location: consulta_evento.php"); 
?>