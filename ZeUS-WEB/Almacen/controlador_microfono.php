<?php	
	session_start();
	
	if (isset($_REQUEST["REFERENCIA"])) {
		$microfono["REFERENCIA"] = $_REQUEST["REFERENCIA"];
		$microfono["NOMBRE"] = $_REQUEST["NOMBRE"];
        $microfono["PRECIO"] = $_REQUEST["PRECIO"];
        $microfono["ALIMENTACION"] = $_REQUEST["ALIMENTACION"];
        $microfono["TIPOSUJECCION"] = $_REQUEST["TIPOSUJECCION"];
		$microfono["grabar"] = $_REQUEST["grabar"];
		$_SESSION["microfono"] = $microfono;

		if(isset($_REQUEST["editar"])) { //si se ha apretado el boton editar
			Header("Location: ../pagina.php");  //redireccionamos a pagina y ahi sigue el codigo

		}else if(isset($_REQUEST["grabar"])) { // si se ha apretado el boton grabar
			if(isset($_SESSION["microfono"])) { // comprobamos que en la _session haya un "evento" (habia sesion activa)
				$microfono = $_SESSION["microfono"]; // si habia lo guardamos en $evento
				unset($_SESSION["microfono"]); // y borramos de _session la variable
				
				require_once("../gestionBD.php");
				require_once("gestionarInventario.php");
				
				$conexion = crearConexionBD();		
				$excepcion = modificar_microfono($conexion,$microfono["REFERENCIA"],$microfono["PRECIO"],$microfono["ALIMENTACION"],$altavoz["TIPOSUJECCION"]);
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
		
	}else { //MODAL FORM
		 if(isset($_REQUEST["agregar"])) {
			$microfono2['nombremic']= $_REQUEST['nombremic'];
			$microfono2['totalprice'] = $_REQUEST['totalprice'];
			$microfono2['alimic'] = $_REQUEST['alimic'];
			$microfono2['sujemic'] = $_REQUEST['sujemic'];
			require_once("../gestionBD.php");
			require_once("gestionarInventario.php");
			$conexion = crearConexionBD($conexion);
			$excepcion = agregar_microfono($conexion,$microfono2['nombremic'],$microfono2['totalprice'],$microfono2['alimic'],$microfono2['sujemic']);
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
