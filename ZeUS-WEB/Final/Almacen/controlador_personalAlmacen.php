<?php	
	session_start();
	
	if (isset($_REQUEST["PID"])) {
		$personalAlmacen["PID"] = $_REQUEST["PID"];
        $personalAlmacen["NOMBRE"] = $_REQUEST["NOMBRE"];
		$personalAlmacen["CARGO"] = $_REQUEST["CARGO"];
		$personalAlmacen["SUELDO"] = $_REQUEST["SUELDO"];
		$personalAlmacen["DNI"] = $_REQUEST["DNI"];
		$personalAlmacen["TELEFONO"] = $_REQUEST["TELEFONO"];
		$personalAlmacen["EMAIL"] = $_REQUEST["EMAIL"];
		$personalAlmacen["ESTADO"] = $_REQUEST["ESTADO"];
		$personalAlmacen["EID"] = $_REQUEST["EID"];
		$personalAlmacen["PEID"] = $_REQUEST["PEID"];

		$_SESSION["PERSONALALMACEN"] = $personalAlmacen;

	}
?>
