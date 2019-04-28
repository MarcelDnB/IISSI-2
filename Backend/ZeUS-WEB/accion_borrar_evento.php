<?php	
	session_start();	
	
	if (isset($_SESSION["EVENTO"])) {
		$evento = $_SESSION["EVENTO"];
		unset($_SESSION["EVENTO"]);
		
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