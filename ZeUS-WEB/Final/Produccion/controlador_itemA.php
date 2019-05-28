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
		$itema["MID"] = $_REQUEST["MID"];
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
				$excepcion = modificar_itema($conexion,$itema["IA"],$itema["TIPO"],$itema["NOMBRE"],$itema["EMPRESA"],$itema["FECHALLEGADA"],$itema["FECHADEVOLUCION"],$itema["CANTIDAD"],$itema["PRECIO"],$itema["PID"],$itema["PEID"]);
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
		else if(isset($_REQUEST["cancelar"])) {
			if(isset($_SESSION["ITEMA"])) { // comprobamos que en la _session haya un "evento" (habia sesion activa)
				$itema = $_SESSION["ITEMA"]; // si habia lo guardamos en $itema
				unset($_SESSION["ITEMA"]); // y borramos de _session la variable

				Header("Location: ../pagina.php");

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
				// $excepcion = quitar_materialnecesario($conexion,$itema['MID']);
				
				
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
			require_once("../gestionBD.php");
			require_once("gestionarItemA.php");
			$conexion = crearConexionBD($conexion);
			$materiales = listarMaterial($conexion);
			cerrarConexionBD($conexion);
			$bol = false;
			foreach ($materiales as $material) {
				if($material['MID']==$_REQUEST['iagregar']) {
					$bol=true;
					$itema2['iapeid'] = $material['PEID'];
					$itema2['iatipo'] = $material['TIPO'];
					$itema2['ianombre'] = $material['NOMBRE'];
					$itema2['iacantidad'] = $material['CANTIDAD'];
					$itema2['iamid'] = $material['MID'];
					$itema2['iapid'] = $_REQUEST['iapid'];
					require_once("../gestionBD.php");
					require_once("gestionarItemA.php");
					$conexion = crearConexionBD($conexion);
		
					$excepcion = crear_itemalquilado($conexion,$itema2['iapeid'],$itema2['iatipo'],$itema2['ianombre'],$itema2['iacantidad'],$itema2['iamid'],$itema2['iapid']);
					cerrarConexionBD($conexion);
				}
			}
			
			if($bol==false) {
				$_SESSION["errormodal"] ="TRUE";
			}

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
