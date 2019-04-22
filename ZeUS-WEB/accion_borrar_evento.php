<?php	
	session_start();	
	
	if (isset($_SESSION["evento"])) {
		$evento = $_SESSION["evento"];
		unset($_SESSION["evento"]);
		
		require_once("gestionBD.php");
		require_once("gestionarEvento.php");
	
		$conexion=crearConexionBD();
		$excepcion=quitar_evento($conexion,$evento["EID"]);
		cerrarConexionBD($conexion);
		if($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "produccion1.php";
			Header("Location: excepcion.php");
		}
		else {
			Header("Location: produccion1.php");
		}
	}
	else 
		Header("Location: produccion1.php"); 
?>