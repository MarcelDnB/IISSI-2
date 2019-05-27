<?php	
	session_start();
	
	if (isset($_REQUEST["MID"])) {
		$peticion["NOMBRE"] = $_REQUEST["NOMBRE"];
		$peticion["TIPO"] = $_REQUEST["TIPO"];
		$peticion["CANTIDAD"] = $_REQUEST["CANTIDAD"];
		$peticion["PEID"] = $_REQUEST["PEID"];
		$peticion["MID"] = $_REQUEST["MID"];
		$_SESSION["PETICION"] = $peticion;
		if(isset($_REQUEST["editar"])) { //si se ha apretado el boton editar
			Header("Location: ../pagina.php");  //redireccionamos a pagina y ahi sigue el codigo
		}else if(isset($_REQUEST["grabar"])) { // si se ha apretado el boton grabar
			if(isset($_SESSION["PETICION"])) { // comprobamos que en la _session haya un "parteequipo" (habia sesion activa)
				$peticion = $_SESSION["PETICION"]; // si habia lo guardamos en $parteequipo
				unset($_SESSION["PETICION"]); // y borramos de _session la variable
				
				require_once("../gestionBD.php");
				require_once("gestionarPeticiones.php");
				
				$conexion = crearConexionBD();		
				$excepcion = modificar_peticion($conexion,$peticion["MID"],$peticion["NOMBRE"],$peticion["TIPO"],$peticion["CANTIDAD"],$peticion["PEID"]);
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
				require_once("gestionarPeticiones.php");
			
				$conexion=crearConexionBD();
				$excepcion=quitar_solicitud($conexion,$peticion["MID"]);
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
			$peticion2['NOMBRE']=$_REQUEST['NOMBRE'];
			if($peticion2["NOMBRE"]=="Altavoces" || $peticion2["NOMBRE"]=="Microfono" ||$peticion2["NOMBRE"]=="Mesa Mezcla" ){
				$peticion2["TIPO"]="Audio";
			}else if($peticion2["NOMBRE"]=="Foco"){
				$peticion2["TIPO"]="Ilum";				
			}else if($peticion2["NOMBRE"]=="Cable" || $peticion2["NOMBRE"]=="Ordenador"){
				$peticion2["TIPO"]="Electr";
			}else{
				$peticion2["TIPO"]="AudVis";
			}
			$peticion2['CANTIDAD']= $_REQUEST['CANTIDAD'];
			$peticion2['PEID']= $_REQUEST['PEID'];
			$aux=$_SESSION["paginacion"];
			if($peticion2["PEID"]<=$aux["NUMEROREG"]){
				require_once("../gestionBD.php");
				require_once("gestionarPeticiones.php");
				$conexion = crearConexionBD($conexion);
				$excepcion = crear_solicitud($conexion,$peticion2['NOMBRE'],$peticion2["TIPO"],$peticion2["CANTIDAD"],$peticion2["PEID"]);
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
