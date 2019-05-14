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
					$_SESSION["editando"] = 1;
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
	else {
			if(isset($_REQUEST["agregar"])) {
				$alojamiento2['direction']= $_REQUEST['direction'];
				$alojamiento2['event']= $_REQUEST['event'];
				$alojamiento2['city'] = $_REQUEST['city'];
				$alojamiento2['startdate'] = $_REQUEST['startdate'];
				$alojamiento2['enddate'] = $_REQUEST['enddate'];
				$alojamiento2['hotelmodal'] = $_REQUEST['hotelmodal'];
				$alojamiento2['numpersonas'] = $_REQUEST['numpersonas'];
				require_once("../gestionBD.php");
				require_once("gestionarAlojamiento.php");
				$conexion = crearConexionBD($conexion);
				$excepcion = crear_alojamiento($conexion,$alojamiento2['event'],$alojamiento2['city'],$alojamiento2['direction']
				,$alojamiento2['startdate'],$alojamiento2['enddate'],$alojamiento2['hotelmodal'],$alojamiento2['numpersonas']);
				cerrarConexionBD($conexion);
		
				if ($excepcion<>"") {
					$_SESSION["excepcion"] = $excepcion;
					$_SESSION["destino"] = "../pagina.php";
					$_SESSION["errormodal"] = 1;
					Header("Location: ../pagina.php");
				}
				else{
					Header("Location: ../pagina.php");
				}
		}
		}
	
?>
