<?php	
	session_start();
	
	if (isset($_REQUEST["DID"])) {
		$devoluciones["DID"] = $_REQUEST["DID"];
		$devoluciones["DIRECCION"] = $_REQUEST["DIRECCION"];
        $devoluciones["EMPRESA"] = $_REQUEST["EMPRESA"];
        $devoluciones["IA"] = $_REQUEST["IA"];
		$devoluciones["PID"] = $_REQUEST["PID"];
		$devoluciones["ESTADODEVOLUCION"] = $_REQUEST["ESTADODEVOLUCION"];
		$devoluciones["grabar"] = $_REQUEST["grabar"];
		$_SESSION["devoluciones"] = $devoluciones;

		if(isset($_REQUEST["editar"])) { //si se ha apretado el boton editar
			Header("Location: ../pagina.php");  //redireccionamos a pagina y ahi sigue el codigo

		}else if(isset($_REQUEST["grabar"])) { // si se ha apretado el boton grabar
			if(isset($_SESSION["devoluciones"])) { // comprobamos que en la _session haya un "evento" (habia sesion activa)
				$devoluciones = $_SESSION["devoluciones"]; // si habia lo guardamos en $evento
				unset($_SESSION["devoluciones"]); // y borramos de _session la variable
				
				require_once("../gestionBD.php");
				require_once("gestionarDevoluciones.php");
				
				$conexion = crearConexionBD();		
				$excepcion = modificar_devolucion($conexion,$devoluciones["DID"],$devoluciones["DIRECCION"],$devoluciones["EMPRESA"]);
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
			if(isset($_SESSION["devoluciones"])) {
				$devoluciones = $_SESSION["devoluciones"];
				unset($_SESSION["devoluciones"]);
				
				require_once("../gestionBD.php");
				require_once("gestionarDevoluciones.php");
			
				$conexion=crearConexionBD();
				$excepcion=fin_devolucion($conexion,$devoluciones["DID"],$devoluciones["PID"]);
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
			$devoluciones2['direcciondev']= $_REQUEST['direcciondev'];
			$devoluciones2['empresadev'] = $_REQUEST['empresadev'];
			$devoluciones2['devpersonal'] = $_REQUEST['devpersonal'];
			$devoluciones2['devitem'] = $_REQUEST['devitem'];
			require_once("../gestionBD.php");
			require_once("gestionarDevoluciones.php");
			$conexion = crearConexionBD($conexion);
			$excepcion = crear_devolucion($conexion,$devoluciones2['direcciondev'],$devoluciones2['empresadev'],$devoluciones2['devpersonal'],$devoluciones2['devitem']);
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
