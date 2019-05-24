<?php	
	session_start();
	
	if (isset($_REQUEST["PID"])) {
		$personal["PID"] = $_REQUEST["PID"];
		$personal["DEPARTAMENTO"] = $_REQUEST["DEPARTAMENTO"];
        $personal["NOMBRE"] = $_REQUEST["NOMBRE"];
		$personal["CARGO"] = $_REQUEST["CARGO"];
		$personal["SUELDO"] = $_REQUEST["SUELDO"];
		$personal["DNI"] = $_REQUEST["DNI"];
		$personal["TELEFONO"] = $_REQUEST["TELEFONO"];
		$personal["ESTADO"] = $_REQUEST["ESTADO"];
		$personal["EID"] = $_REQUEST["EID"];
		$personal["PEID"] = $_REQUEST["PEID"];

		$_SESSION["PERSONAL"] = $personal;
			
		if (isset($_REQUEST["editar"])) Header("Location: ../pagina.php"); 
		
		else if (isset($_REQUEST["grabar"])){
			
			if(isset($_SESSION["PERSONAL"])) { // comprobamos que en la _session haya un "evento" (habia sesion activa)
				$personal = $_SESSION["PERSONAL"]; // si habia lo guardamos en $evento
				unset($_SESSION["PERSONAL"]); // y borramos de _session la variable
				
				require_once("../gestionBD.php");
				require_once("gestionarPersonal.php");
				
				$conexion = crearConexionBD();		
				$excepcion = modificar_personal($conexion,$personal["PID"],$personal["DEPARTAMENTO"],$personal["NOMBRE"],$personal["CARGO"],$personal["SUELDO"],$personal["DNI"],$personal["TELEFONO"],$personal["ESTADO"],$personal["EID"],$personal["PEID"]);
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
		else if (isset($_REQUEST["borrar"])) { 
			if(isset($_SESSION["PERSONAL"])) {
				$personal = $_SESSION["PERSONAL"];
				unset($_SESSION["PERSONAL"]);
				
				require_once("../gestionBD.php");
				require_once("gestionarPersonal.php");
			
				$conexion=crearConexionBD();
				$excepcion=quitar_personal($conexion,$personal["PID"]);
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
		 }
	}
	else {
			if (isset($_REQUEST['agregar'])){
				$personal2['persid']= $_REQUEST['persid'];
				$personal2['dept'] = $_REQUEST['dept'];
				$personal2['nmbre'] = $_REQUEST['nmbre'];
				$personal2['carg'] = $_REQUEST['carg'];
				$personal2['sueld'] = $_REQUEST['sueld'];
				$personal2['denei'] = $_REQUEST['denei'];
				$personal2['telf'] = $_REQUEST['telf'];
				$personal2['estd'] = $_REQUEST['estd'];
				$personal2['event'] = $_REQUEST['event'];
				$personal2['parteid'] = $_REQUEST['parteid'];
				$personal2['emeil'] = $_REQUEST['emeil'];
				$personal2['contra'] = $_REQUEST['contra'];
				require_once("../gestionBD.php");
				require_once("gestionarPersonal.php");
				$conexion = crearConexionBD();
				$excepcion = crear_usuario($conexion,$personal2['dept'],$personal2['nmbre'],$personal2['carg'],
				$personal2['sueld'],$personal2['denei'],$personal2['telf'],$personal2['estd'],$personal2['event'],$personal2['parteid'],$personal2['emeil'],
				$personal2['contra']);
				cerrarConexionBD($conexion);
		
				if ($excepcion<>"") {
					$_SESSION["excepcion"] = $excepcion;
					$_SESSION["destino"] = "../pagina.php";
					$_SESSION['errormodal']=1;
					Header("Location: ../pagina.php");

				}
				else
					Header("Location: ../pagina.php");
			}
		}
	
?>
