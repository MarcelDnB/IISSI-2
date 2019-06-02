<?php	
	session_start();
	
	if (isset($_REQUEST["REFERENCIA"])) {
		$otrositems["REFERENCIA"] = $_REQUEST["REFERENCIA"];
		$otrositems["NOMBRE"] = $_REQUEST["NOMBRE"];
        $otrositems["PRECIO"] = $_REQUEST["PRECIO"];
		$otrositems["grabar"] = $_REQUEST["grabar"];
		$_SESSION["otrositems"] = $otrositems;

		if(isset($_REQUEST["editar"])) { //si se ha apretado el boton editar
			Header("Location: ../pagina.php");  //redireccionamos a pagina y ahi sigue el codigo

		}else if(isset($_REQUEST["grabar"])) { // si se ha apretado el boton grabar
			if(isset($_SESSION["otrositems"])) { // comprobamos que en la _session haya un "evento" (habia sesion activa)
				$otrositems = $_SESSION["otrositems"]; // si habia lo guardamos en $evento
				unset($_SESSION["otrositems"]); // y borramos de _session la variable
				
				require_once("../gestionBD.php");
				require_once("gestionarInventario.php");
				
				$conexion = crearConexionBD();		
				$excepcion = modificar_otrositems($conexion,$otrositems["REFERENCIA"],$otrositems["NOMBRE"],$otrositems["PRECIO"]);
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
			$otrositems2['nombreoi']= $_REQUEST['nombreoi'];
			$otrositems2['totalprice'] = $_REQUEST['totalprice'];
			require_once("../gestionBD.php");
			require_once("gestionarInventario.php");
			$conexion = crearConexionBD($conexion);
			$excepcion = agregar_otrositems($conexion,$otrositems2['nombreoi'],$otrositems2['totalprice']);
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
