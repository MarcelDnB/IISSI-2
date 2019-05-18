<?php	
	session_start();
	
	if (isset($_REQUEST["REFERENCIA"])) {
		$mantenimiento["PID"] = $_REQUEST["PID"];
		$mantenimiento["REFERENCIA"] = $_REQUEST["REFERENCIA"];
		$_SESSION["MANTENIMIENTO"] = $mantenimiento;
			
		if (isset($_REQUEST["borrar"])) { 
			if(isset($_SESSION["MANTENIMIENTO"])) {
				$mantenimiento = $_SESSION["MANTENIMIENTO"];
				unset($_SESSION["MANTENIMIENTO"]);
				
				require_once("../gestionBD.php");
				require_once("gestionarMantenimiento.php");
			
				$conexion=crearConexionBD();
				$excepcion=finalizar_reparacion($conexion,$mantenimiento["PID"],$mantenimiento["REFERENCIA"]);
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
	else if(isset($_REQUEST["agregar"])) {
				$mantenimiento2['maitems'] = $_REQUEST['maitems'];
				$mantenimiento2['mapersonal'] = $_REQUEST['mapersonal'];

				require_once("../gestionBD.php");
				require_once("gestionarMantenimiento.php");
				$conexion = crearConexionBD($conexion);
				$excepcion = asignar_reparacion($conexion,$mantenimiento2['mapersonal'],$mantenimiento2['maitems']);
				cerrarConexionBD($conexion);
		
				if ($excepcion<>"") {
					$_SESSION["excepcion"] = $excepcion;
					$_SESSION["destino"] = "../pagina.php";
					$_SESSION["errormodal"] = "TRUE";
					Header("Location: ../pagina.php");
				}
				else{
					Header("Location: ../pagina.php");
				}
			}
			else{
				Header("Location: ../pagina.php");
			}
	
?>
