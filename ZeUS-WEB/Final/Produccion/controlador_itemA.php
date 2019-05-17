<?php	
	session_start();
	
	if (isset($_REQUEST["IA"])) {
		$itema["IA"] = $_REQUEST["IA"];
		$itema["TIPO"] = $_REQUEST["TIPO"];
        $itema["NOMBRE"] = $_REQUEST["NOMBRE"];
        $itema["EMPRESA"] = $_REQUEST["EMPRESA"];
        $itema["FECHALLEGADA"] = $_REQUEST["FECHALLEGADA"];
		$itema["FECHADEVOLUCION"] = $_REQUEST["FECHADEVOLUCION"];
		$itema["CANTIDAD"] = $_REQUEST["CANTIDAD"];
		$itema["PRECIO"] = $_REQUEST["PRECIO"];
		$itema["PID"] = $_REQUEST["PID"];
		$itema["PEID"] = $_REQUEST["PEID"];
		$itema["grabar"] = $_REQUEST["grabar"];
		$_SESSION["ITEMA"] = $itema;

		if(isset($_REQUEST["editar"])) { //si se ha apretado el boton editar
			Header("Location: ../pagina.php");  //redireccionamos a pagina y ahi sigue el codigo

		}else if(isset($_REQUEST["grabar"])) { // si se ha apretado el boton grabar
			if(isset($_SESSION["ITEMA"])) { // comprobamos que en la _session haya un "evento" (habia sesion activa)
				$itema = $_SESSION["ITEMA"]; // si habia lo guardamos en $itema
				unset($_SESSION["ITEMA"]); // y borramos de _session la variable
				
				require_once("../gestionBD.php");
				require_once("gestionarItemA.php");
				
				$conexion = crearConexionBD();		
				$excepcion = modificar_itema($conexion,$itema["TIPO"],$itema["NOMBRE"],$itema["EMPRESA"],$itema["FECHALLEGADA"],$itema["FECHADEVOLUCION"],$itema["CANTIDAD"],$itema["PRECIO"],$itema["PID"],$itema["PEID"]);
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
			if(isset($_SESSION["ITEMA"])) {
				$itema = $_SESSION["ITEMA"];
				unset($_SESSION["ITEMA"]);
				
				require_once("../gestionBD.php");
				require_once("gestionarItemA.php");
				
			
				$conexion=crearConexionBD();
				$excepcion=quitar_itema($conexion,$itema["IA"]);
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
			$itema2['iatipo']= $_REQUEST['iatipo'];
			$itema2['ianombre'] = $_REQUEST['ianombre'];
			$itema2['iacantidad'] = $_REQUEST['iacantidad'];
			$itema2['iamid'] = $_REQUEST['iamid'];
			require_once("../gestionBD.php");
			require_once("gestionarItemA.php");
			$conexion = crearConexionBD($conexion);
			$excepcion = crear_itemalquilado($conexion,$itema2['iatipo'],$itema2['ianombre'],$itema2['iacantidad'],$itema2['iamid'],(int)comprobarUsuario($conexion));
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
