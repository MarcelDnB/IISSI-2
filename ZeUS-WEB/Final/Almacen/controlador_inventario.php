<?php	
	session_start();
	
	if (isset($_REQUEST["REFERENCIA"])) {
		$inventario["REFERENCIA"] = $_REQUEST["REFERENCIA"];
		$inventario["NOMBRE"] = $_REQUEST["NOMBRE"];
        $inventario["ESTADOITEM"] = $_REQUEST["ESTADOITEM"];
        $inventario["PRECIO"] = $_REQUEST["PRECIO"];
		$inventario["PEID"] = $_REQUEST["PEID"];
		$inventario["editar"] = $_REQUEST["editar"];
		$_SESSION["INVENTARIO"] = $inventario;

		if(isset($_REQUEST["editar"])) { 
			if(isset($_SESSION["INVENTARIO"])) { 
				$inventario = $_SESSION["INVENTARIO"]; 
				unset($_SESSION["INVENTARIO"]); 
				
				require_once("../gestionBD.php");
				require_once("gestionarInventario.php");
				
				$conexion = crearConexionBD();		
				$excepcion = necesita_reparacion($conexion,$inventario["REFERENCIA"]);
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
		} else if(isset($_REQUEST["borrar"])) { 
			if(isset($_SESSION["INVENTARIO"])) {
				$inventario = $_SESSION["INVENTARIO"];
				unset($_SESSION["INVENTARIO"]);
				
				require_once("../gestionBD.php");
				require_once("gestionarInventario.php");
			
				$conexion=crearConexionBD();
				$excepcion=borrar_item($conexion,$inventario["REFERENCIA"]);
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
	}
?>
