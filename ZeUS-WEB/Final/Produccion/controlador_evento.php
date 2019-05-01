<?php	
	session_start();
	
	if (isset($_REQUEST["EID"])) {
		$evento["EID"] = $_REQUEST["EID"];
		$evento["PRECIOTOTAL"] = $_REQUEST["PRECIOTOTAL"];
        $evento["LUGAR"] = $_REQUEST["LUGAR"];
        $evento["FECHAINICIO"] = $_REQUEST["FECHAINICIO"];
        $evento["FECHAFIN"] = $_REQUEST["FECHAFIN"];
		$evento["DESCRIPCIONCLIENTE"] = $_REQUEST["DESCRIPCIONCLIENTE"];
		$evento["ESTADOEVENTO"] = $_REQUEST["ESTADOEVENTO"];
		$evento["grabar"] = $_REQUEST["grabar"];

		$_SESSION["EVENTO"] = $evento;
		if (isset($_REQUEST["editar"])) Header("Location: pagina.php"); 
		else if (isset($_REQUEST["grabar"])) Header("Location: accion_modificar_evento.php"); 
		else /* if (isset($_REQUEST["borrar"])) */ Header("Location: accion_borrar_evento.php"); 
	}
	else 
		Header("Location: pagina.php");
	
?>
