<?php	
	session_start();
	
	if (isset($_REQUEST["EID"])) {
		$peticion["LISTAMATERIALES"] = $_REQUEST["LISTAMATERIALES"];
		$peticion["EID"] = $_REQUEST["EID"];
		$_SESSION["PETICION"] = $peticion;

		if(isset($_REQUEST["editar"])) { //si se ha apretado el boton editar
			Header("Location: ../pagina.php");  //redireccionamos a pagina y ahi sigue el codigo

		}else if(isset($_REQUEST["grabar"])) { // si se ha apretado el boton grabar
			if(isset($_SESSION["PETICION"])) { // comprobamos que en la _session haya un "parteequipo" (habia sesion activa)
				$peticion = $_SESSION["PETICION"]; // si habia lo guardamos en $parteequipo
				unset($_SESSION["PETICION"]); // y borramos de _session la variable
				
				require_once("../gestionBD.php");
				require_once("gestionarParteEquipo.php");
				
				$conexion = crearConexionBD();		
				$excepcion = modificar_peticion($conexion,$peticion["EID"],$peticion["LISTAMATERIALES"]);
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
			if(isset($_SESSION["PETICION"])) {
				$peticion = $_SESSION["PETICION"];
				unset($_SESSION["PETICION"]);
				
				require_once("../gestionBD.php");
				require_once("gestionarParteEquipo.php");
			
				$conexion=crearConexionBD();
				$excepcion=quitar_solicitud($conexion,$peticion["EID"]);
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
            $peticion2['EID']= $_REQUEST['eid'];
            $peticion2['LISTAMATERIALES']=$_REQUEST['listamateriales'];
			$aux=$_SESSION["paginacion"];
			if($peticion2["EID"]<=$aux["NUMEROREG"]){
				require_once("../gestionBD.php");
				require_once("gestionarParteequipo.php");
				$conexion = crearConexionBD($conexion);
				$excepcion = crear_solicitud($conexion,$peticion2['EID'],$peticion2['LISTAMATERIALES']);
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
