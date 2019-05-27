<?php	
	session_start();

	if (isset($_REQUEST["EID"])) {
		$parteequipo["PEID"] = $_REQUEST["PEID"];
		$parteequipo["EID"] = $_REQUEST["EID"];
		$_SESSION["PARTEEQUIPO"] = $parteequipo;

		if(isset($_REQUEST["editar"])) { //si se ha apretado el boton editar
			Header("Location: ../pagina.php");  //redireccionamos a pagina y ahi sigue el codigo

		}else if(isset($_REQUEST["grabar"])) { // si se ha apretado el boton grabar
			if(isset($_SESSION["PARTEEQUIPO"])) { // comprobamos que en la _session haya un "parteequipo" (habia sesion activa)
				$parteequipo = $_SESSION["PARTEEQUIPO"]; // si habia lo guardamos en $parteequipo
				unset($_SESSION["PARTEEQUIPO"]); // y borramos de _session la variable
				
				require_once("../gestionBD.php");
				require_once("gestionarParteEquipo.php");
				
				$conexion = crearConexionBD();		
				$excepcion = modificar_parteEquipo($conexion,$parteequipo["EID"],$parteequipo["PEID"]);
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
			if(isset($_SESSION["PARTEEQUIPO"])) {
				$parteequipo = $_SESSION["PARTEEQUIPO"];
				unset($_SESSION["PARTEEQUIPO"]);
				
				require_once("../gestionBD.php");
				require_once("gestionarParteEquipo.php");

				$conexion=crearConexionBD();
				$excepcion=quitar_parteEquipo($conexion,$parteequipo["PEID"]);
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
		}		else  if(isset($_REQUEST["consultar"])) { // lo mismo que antes
			if(isset($_SESSION["PARTEEQUIPO"])) {
				$parteequipo = $_SESSION["PARTEEQUIPO"];
				unset($_SESSION["PARTEEQUIPO"]);
				
				require_once("../gestionBD.php");
				require_once("gestionarParteEquipo.php");
			
				$conexion=crearConexionBD();
				$excepcion=consultar_parteEquipo($conexion,$parteequipo["EID"],$parteequipo["PEID"]);
				cerrarConexionBD($conexion);
				if($excepcion<>"") {
					$_SESSION["excepcion"] = $excepcion;
					$_SESSION["destino"] = "../pagina.php";
					$_SESSION["consultado"] = 1;
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
			$parteequipo2['EID']= $_REQUEST['eid'];
			$aux=$_SESSION["paginacion"];
			if($parteequipo2["EID"]<=$aux["NUMEROREG"]){
				require_once("../gestionBD.php");
				require_once("gestionarParteequipo.php");
				$conexion = crearConexionBD($conexion);
				$excepcion = crear_parteEquipo($conexion,$parteequipo2['EID']);
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

			}else{
				$_SESSION["fallo"]=1;
				Header("Location: ../pagina.php");
			}
	
	}
	}
?>
