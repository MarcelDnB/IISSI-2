<?php	
	session_start();
	
	if (isset($_REQUEST["EID"])) {
		$evento["EID"] = $_REQUEST["EID"];
		$evento["PRECIOTOTAL"] = $_REQUEST["PRECIOTOTAL"];
        $evento["LUGAR"] = $_REQUEST["LUGAR"];
        $evento["FECHAINICIO"] = $_REQUEST["FECHAINICIO"];
        $evento["FECHAFIN"] = $_REQUEST["FECHAFIN"];
		$evento["DESCRIPCIONCLIENTE"] = $_REQUEST["DESCRIPCIONCLIENTE"];
		$evento["ESTADOEVENTO"] = $_REQUEST["ESTADOEVENTO"];
		$evento["grabar"] = $_REQUEST["grabar"];
		$_SESSION["EVENTO"] = $evento;

		if(isset($_REQUEST["editar"])) { //si se ha apretado el boton editar
			Header("Location: ../pagina.php");  //redireccionamos a pagina y ahi sigue el codigo

		}else if(isset($_REQUEST["grabar"])) { // si se ha apretado el boton grabar
			if(isset($_SESSION["EVENTO"])) { // comprobamos que en la _session haya un "evento" (habia sesion activa)
				$evento = $_SESSION["EVENTO"]; // si habia lo guardamos en $evento
				unset($_SESSION["EVENTO"]); // y borramos de _session la variable
				
				require_once("../gestionBD.php");
				require_once("gestionarEvento.php");
				
				$conexion = crearConexionBD();		
				$excepcion = modificar_evento($conexion,$evento["EID"],$evento["PRECIOTOTAL"],$evento["LUGAR"],$evento["FECHAINICIO"],$evento["FECHAFIN"],$evento["DESCRIPCIONCLIENTE"],$evento["ESTADOEVENTO"]);
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
		}else if(isset($_REQUEST["cancelar"])) {
			if(isset($_SESSION["EVENTO"])) { // comprobamos que en la _session haya un "evento" (habia sesion activa)
				$evento = $_SESSION["EVENTO"]; // si habia lo guardamos en $evento
				unset($_SESSION["EVENTO"]); // y borramos de _session la variable

				Header("Location: ../pagina.php");

			}
		}
		else  if(isset($_REQUEST["borrar"])) { // lo mismo que antes
			if(isset($_SESSION["EVENTO"])) {
				$evento = $_SESSION["EVENTO"];
				unset($_SESSION["EVENTO"]);
				
				require_once("../gestionBD.php");
				require_once("gestionarEvento.php");
			
				$conexion=crearConexionBD();
				$excepcion=quitar_evento($conexion,$evento["EID"]);
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
		
	}else { // he puesto el modal en este else pq el el if veo si tengo eid proveniente del post, por lo q no es el caso
		 if(isset($_REQUEST["agregar"])) {
			$evento2['place']= $_REQUEST['place'];
			$evento2['finicio'] = $_REQUEST['finicio'];
			$evento2['ffin'] = $_REQUEST['ffin'];
			$evento2['totalprice'] = $_REQUEST['totalprice'];
			$evento2['description'] = $_REQUEST['description'];
			require_once("../gestionBD.php");
			require_once("gestionarEvento.php");
			$conexion = crearConexionBD($conexion);
			$excepcion = crear_evento($conexion,$evento2['totalprice'],$evento2['place'],$evento2['finicio'],$evento2['ffin'],$evento2['description']);
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
