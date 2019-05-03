<?php	
	session_start();
	
	if (isset($_REQUEST["EID"])) {
		$alojamiento["EID"] = $_REQUEST["EID"];
		$alojamiento["DIRECCION"] = $_REQUEST["DIRECCION"];
        $alojamiento["CIUDAD"] = $_REQUEST["CIUDAD"];
        $alojamiento["FECHAINICIO"] = $_REQUEST["FECHAINICIO"];
        $alojamiento["FECHAFIN"] = $_REQUEST["FECHAFIN"];
		$alojamiento["HOTEL"] = $_REQUEST["HOTEL"];
		$alojamiento["NUMPERSONAS"] = $_REQUEST["NUMPERSONAS"];

		$_SESSION["ALOJAMIENTO"] = $alojamiento;
			
		if (isset($_REQUEST["editar"])) Header("Location: ../pagina.php"); 
		else if (isset($_REQUEST["grabar"])) Header("Location: accion_modificar_alojamiento.php");
		else /* if (isset($_REQUEST["borrar"])) */ Header("Location: accion_borrar_alojamiento.php"); 
	}
	else 
		Header("Location: ../pagina.php");
	
?>
