<?php	
	session_start();
	
	if (isset($_REQUEST["TID"])) {
		$transporte["TID"] = $_REQUEST["TID"];
		$transporte["MEDIOUTILIZADO"] = $_REQUEST["MEDIOUTILIZADO"];
        $transporte["NUMPERSONAS"] = $_REQUEST["NUMPERSONAS"];
        $transporte["EID"] = $_REQUEST["EID"];

		$_SESSION["TRANSPORTE"] = $transporte;
			
		if (isset($_REQUEST["editar"])){ 
			Header("Location: ../pagina.php");
		}
		else if (isset($_REQUEST["grabar"])) {
			if (isset($_SESSION["TRANSPORTE"])) {
				$transporte = $_SESSION["TRANSPORTE"];
				unset($_SESSION["TRANSPORTE"]);
				
				require_once("../gestionBD.php");
				require_once("gestionarTransporte.php");
				
				$conexion = crearConexionBD();		
				$excepcion = modificar_transporte($conexion,$transporte["TID"],$transporte["MEDIOUTILIZADO"],$transporte["NUMPERSONAS"],$transporte["EID"]);
				cerrarConexionBD($conexion);
					
				if ($excepcion<>"") {
					$_SESSION["excepcion"] = $excepcion;
					$_SESSION["destino"] = "../pagina.php";
					Header("Location: ../pagina.php");
				}
				else
					Header("Location: ../pagina.php");
			}
		}
		else if (isset($_REQUEST["borrar"])){ 
			if (isset($_SESSION["TRANSPORTE"])) {
				$transporte = $_SESSION["TRANSPORTE"];
				unset($_SESSION["TRANSPORTE"]);
				
				require_once("../gestionBD.php");
				require_once("gestionarTransporte.php");
			
				$conexion=crearConexionBD();
				$excepcion=quitar_transporte($conexion,$transporte["TID"]);
				cerrarConexionBD($conexion);
				if($excepcion<>"") {
					$_SESSION["excepcion"] = $excepcion;
					$_SESSION["destino"] = "../pagina.php";
					Header("Location: ../pagina.php");
				}
				else {
					Header("Location: ../pagina.php");
				}
		}
		echo "<h1>se ha intentado</h1>";
	}
	else 
		Header("Location: ../pagina.php");
}
?>