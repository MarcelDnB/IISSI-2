<?php	
	session_start();
	
	if (isset($_REQUEST["eid"])) {
		$alojamiento["eid"] = $_REQUEST["eid"];
		$alojamiento["direccion"] = $_REQUEST["direccion"];
        $alojamiento["ciudad"] = $_REQUEST["ciudad"];
        $alojamiento["fechainicio"] = $_REQUEST["fechainicio"];
        $alojamiento["fechafin"] = $_REQUEST["fechafin"];
		$evalojamientoento["hotel"] = $_REQUEST["hotel"];
		$alojamiento["numpersonas"] = $_REQUEST["numpersonas"];

		$_SESSION["alojamiento"] = $alojamiento;
			
		if (isset($_REQUEST["editar"])) Header("Location: produccion2.php"); 
		else if (isset($_REQUEST["grabar"])) Header("Location: accion_modificar_evento.php");
		else /* if (isset($_REQUEST["borrar"])) */ Header("Location: accion_borrar_evento.php"); 
	}
	else 
		Header("Location: produccion2.php");
	
?>
