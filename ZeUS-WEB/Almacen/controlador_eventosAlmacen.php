<?php	
	session_start();
	
	if (isset($_REQUEST["EID"])) {
        $eventoalmacen["EID"] = $_REQUEST["EID"];
		$eventoalmacen["LUGAR"] = $_REQUEST["LUGAR"];
		$eventoalmacen["FECHAINICIO"] = $_REQUEST["FECHAINICIO"];
		$eventoalmacen["FECHAFIN"] = $_REQUEST["FECHAFIN"];
		$_SESSION["EVENTOALMACEN"] = $eventoalmacen;

	}
?>