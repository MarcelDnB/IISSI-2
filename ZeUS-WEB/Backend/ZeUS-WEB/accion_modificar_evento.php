<?php	
	session_start();	
	
	if (isset($_SESSION["EVENTO"])) {
		$evento = $_SESSION["EVENTO"];
		unset($_SESSION["EVENTO"]);
		
		require_once("gestionBD.php");
		require_once("gestionarEvento.php");
		
		$conexion = crearConexionBD();		
		$excepcion = modificar_evento($conexion,$evento["EID"],$evento["PRECIOTOTAL"],$evento["LUGAR"],$evento["FECHAINICIO"],$evento["FECHAFIN"],$evento["DESCRIPCIONCLIENTE"],$evento["ESTADOEVENTO"]);
		cerrarConexionBD($conexion);
			
		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "produccion1.php";
			Header("Location: excepcion.php");
		}
		else
			Header("Location: produccion1.php");
	}
	else Header("Location: produccion1.php"); // Se ha tratado de acceder directamente a este PHP
?>
