<?php	
	session_start();
	
	if (isset($_REQUEST["EID"])) {
		$alojamiento["EID"] = $_REQUEST["EID"];
		$alojamiento["DIRECCION"] = $_REQUEST["DIRECCION"];
        $alojamiento["CIUDAD"] = $_REQUEST["CIUDAD"];
        $alojamiento["FECHAINICIO"] = $_REQUEST["FECHAINICIO"];
        $alojamiento["FECHAFIN"] = $_REQUEST["FECHAFIN"];
		$alojamiento["HOTEL"] = $_REQUEST["HOTEL"];
		$alojamiento["NUMPERSONAS"] = $_REQUEST["NUMPERSONAS"];

		$_SESSION["ALOJAMIENTO"] = $alojamiento;
			
		if (isset($_REQUEST["editar"])) Header("Location: ../pagina.php"); 
		
		else if (isset($_REQUEST["grabar"])){ 
			
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
		}
		else  if (isset($_REQUEST["borrar"])) { 
			if(isset($_SESSION["ALOJAMIENTO"])) {
				$ALOJAMIENTO = $_SESSION["ALOJAMIENTO"];
				unset($_SESSION["ALOJAMIENTO"]);
				
				require_once("../gestionBD.php");
				require_once("gestionarAlojamiento.php");
			
				$conexion=crearConexionBD();
				$excepcion=quitar_alojamiento($conexion,$ALOJAMIENTO["EID"],$ALOJAMIENTO["HOTEL"]);
				cerrarConexionBD($conexion);
				if($excepcion<>"") {
					$_SESSION["excepcion"] = $excepcion;
					$_SESSION["destino"] = "../pagina.php";
					$_SESSION["borrado"] = 1;
					Header("Location: ../pagina.php");
				}
				else {
					Header("Location: ../pagina.php");
				}
			}
		}
	}
	else 
		Header("Location: ../pagina.php");
	
?>
