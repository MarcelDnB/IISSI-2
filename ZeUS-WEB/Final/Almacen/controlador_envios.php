<?php	
	session_start();
	
	if (isset($_REQUEST["ENID"])) {
		$envios["ENID"] = $_REQUEST["ENID"];
		$envios["DIRECCION"] = $_REQUEST["DIRECCION"];
        $envios["FECHASALIDA"] = $_REQUEST["FECHASALIDA"];
        $envios["FECHAENTRADA"] = $_REQUEST["FECHAENTRADA"];
        $envios["ESTADOENVIO"] = $_REQUEST["ESTADOENVIO"];
		$envios["PID"] = $_REQUEST["PID"];
		$envios["PEID"] = $_REQUEST["PEID"];
		$envios["grabar"] = $_REQUEST["grabar"];
		$_SESSION["envios"] = $envios;

		if(isset($_REQUEST["editar"])) { //si se ha apretado el boton editar
			Header("Location: ../pagina.php");  //redireccionamos a pagina y ahi sigue el codigo

		}else if(isset($_REQUEST["grabar"])) { // si se ha apretado el boton grabar
			if(isset($_SESSION["envios"])) { // comprobamos que en la _session haya un "evento" (habia sesion activa)
				$envios = $_SESSION["envios"]; // si habia lo guardamos en $evento
				unset($_SESSION["envios"]); // y borramos de _session la variable
				
				require_once("../gestionBD.php");
				require_once("gestionarEnvios.php");
				
				$conexion = crearConexionBD();		
				$excepcion = modificar_envio($conexion,$envios["ENID"],$envios["DIRECCION"],$envios["ESTADOENVIO"]);
				cerrarConexionBD($conexion);

				if ($excepcion<>"") { //si hubo excepcion tenemos que controlarla
					$_SESSION["excepcion"] = $excepcion;
					$_SESSION["destino"] = "../pagina.php";
					$_SESSION["editando"] = 1;
					Header("Location: ../pagina.php");
				}
				else{ // si no hubo excepcion, redirigimos a pagina.php
					Header("Location: ../pagina.php");
				}
			}
		} 
		else  if(isset($_REQUEST["borrar"])) { // lo mismo que antes
			if(isset($_SESSION["envios"])) {
				$envios = $_SESSION["envios"];
				unset($_SESSION["envios"]);
				
				require_once("../gestionBD.php");
				require_once("gestionarEnvios.php");
			
				$conexion=crearConexionBD();
				$excepcion=fin_envio($conexion,$envios["PID"],$envios["ENID"]);
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
			else{
				Header("Location: ../pagina.php");
			}
		}
		
	}else { 
		 if(isset($_REQUEST["agregar"])) {
			$envios2['direccionenv']= $_REQUEST['direccionenv'];
			$envios2['fsalidaenv'] = $_REQUEST['fsalidaenv'];
			$envios2['fregresoenv'] = $_REQUEST['fregresoenv'];
			$envios2['envpersonal'] = $_REQUEST['envpersonal'];
			$envios2['envparte'] = $_REQUEST['envparte'];
			require_once("../gestionBD.php");
			require_once("gestionarEnvios.php");
			$conexion = crearConexionBD($conexion);
			$excepcion = crear_envio($conexion,$envios2['direccionenv'],$envios2['fregresoenv'],$envios2['fsalidaenv'],$envios2['envpersonal'],$envios2['envparte']);
			cerrarConexionBD($conexion);
	
			if ($excepcion<>"") {
				$_SESSION["excepcion"] = $excepcion;
				$_SESSION["destino"] = "../pagina.php";
				$_SESSION["errormodal"] ="TRUE";

				Header("Location: ../pagina.php");
				
			}
			else{
				Header("Location: ../pagina.php");
			}
	}
	}
?>
