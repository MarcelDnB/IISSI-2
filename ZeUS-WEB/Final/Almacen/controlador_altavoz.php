<?php	
	session_start();
	
	if (isset($_REQUEST["REFERENCIA"])) {
		$altavoz["REFERENCIA"] = $_REQUEST["REFERENCIA"];
		$altavoz["NOMBRE"] = $_REQUEST["NOMBRE"];
        $altavoz["PRECIO"] = $_REQUEST["PRECIO"];
        $altavoz["POTENCIA"] = $_REQUEST["POTENCIA"];
        $altavoz["PULGADAS"] = $_REQUEST["PULGADAS"];
		$altavoz["grabar"] = $_REQUEST["grabar"];
		$_SESSION["altavoz"] = $altavoz;

		if(isset($_REQUEST["editar"])) { //si se ha apretado el boton editar
			Header("Location: ../pagina.php");  //redireccionamos a pagina y ahi sigue el codigo

		}else if(isset($_REQUEST["grabar"])) { // si se ha apretado el boton grabar
			if(isset($_SESSION["altavoz"])) { // comprobamos que en la _session haya un "evento" (habia sesion activa)
				$altavoz = $_SESSION["altavoz"]; // si habia lo guardamos en $evento
				unset($_SESSION["altavoz"]); // y borramos de _session la variable
				
				require_once("../gestionBD.php");
				require_once("gestionarInventario.php");
				
				$conexion = crearConexionBD();		
				$excepcion = modificar_altavoz($conexion,$altavoz["REFERENCIA"],$altavoz["PRECIO"],$altavoz["POTENCIA"],$altavoz["PULGADAS"]);
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
			$altavoz2['nombreal']= $_REQUEST['nombreal'];
			$altavoz2['totalprice'] = $_REQUEST['totalprice'];
			$altavoz2['potenciaal'] = $_REQUEST['potenciaal'];
			$altavoz2['pulgadaal'] = $_REQUEST['pulgadaal'];
			require_once("../gestionBD.php");
			require_once("gestionarInventario.php");
			$conexion = crearConexionBD($conexion);
			$excepcion = agregar_altavoz($conexion,$altavoz2['nombreal'],$altavoz2['totalprice'],$altavoz2['potenciaal'],$altavoz2['pulgadaal']);
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
