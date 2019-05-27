<?php	
	session_start();
	
	if (isset($_REQUEST["PEID"])) {
		$parteequipo["PEID"] = $_REQUEST["PEID"];
		$parteequipo["EID"] = $_REQUEST["EID"];
		$_SESSION["PARTEEQUIPO"] = $parteequipo;

		
		if(isset($_REQUEST["consultar"])) { 
			if(isset($_SESSION["PARTEEQUIPO"])) {
				$parteequipo = $_SESSION["PARTEEQUIPO"];
				unset($_SESSION["PARTEEQUIPO"]);
				
				require_once("../gestionBD.php");
				require_once("gestionarParteAlmacen.php");
			
				$conexion=crearConexionBD();
				$excepcion=consultar_parteEquipoAlmacen($conexion,$parteequipo["PEID"]);
				cerrarConexionBD($conexion);
				if($excepcion<>"") {
					$_SESSION["excepcion"] = $excepcion;
					$_SESSION["destino"] = "../pagina.php";
					$_SESSION["consultado"] = 1;
					Header("Location: ../pagina.php");
				}
				else {
					Header("Location: ../pagina.php");
				}
			}
			else{
				Header("Location: ../pagina.php");
			}
		}
		
	}
?>
