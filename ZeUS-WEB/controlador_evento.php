<?php	
	session_start();
	
	if (isset($_REQUEST["eid"])) {
		$evento["eid"] = $_REQUEST["eid"];
		$evento["preciototal"] = $_REQUEST["preciototal"];
        $evento["lugar"] = $_REQUEST["lugar"];
        $evento["fechainicio"] = $_REQUEST["fechainicio"];
        $evento["fechafin"] = $_REQUEST["fechafin"];
		$evento["descripcioncliente"] = $_REQUEST["descripcioncliente"];
		$evento["estadoevento"] = $_REQUEST["estadoevento"];

		$_SESSION["evento"] = $evento;
			
		if (isset($_REQUEST["editar"])) Header("Location: produccion1.php"); 
		else if (isset($_REQUEST["grabar"])) Header("Location: accion_modificar_evento.php");
		else /* if (isset($_REQUEST["borrar"])) */ Header("Location: accion_borrar_evento.php"); 
	}
	else 
		Header("Location: produccion1.php");
	
?>
