<?php	
	session_start();	
	
	if (isset($_SESSION["TRANSPORTE"])) {
		$transporte = $_SESSION["TRANSPORTE"];
		unset($_SESSION["TRANSPORTE"]);
		
		require_once("gestionBD.php");
		require_once("gestionarTransporte.php");
		
		$conexion = crearConexionBD();		
		$excepcion = modificar_transporte($conexion,$transporte["TID"],$transporte["MEDIOUTILIZADO"],$transporte["NUMPERSONAS"],$transporte["EID"]);
		cerrarConexionBD($conexion);
			
		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "produccion3.php";
			Header("Location: excepcion.php");
		}
		else
			Header("Location: produccion3.php");
	}
	else Header("Location: produccion3.php"); // Se ha tratado de acceder directamente a este PHP
?>
