<?php	
	session_start();
	
	if (isset($_REQUEST["PEID"])) {
		$parteequipo["PEID"] = $_REQUEST["PEID"];
        $parteequipo["EID"] = $_REQUEST["EID"];

		$_SESSION["PARTEEQUIPO"] = $parteequipo;

	}
?>