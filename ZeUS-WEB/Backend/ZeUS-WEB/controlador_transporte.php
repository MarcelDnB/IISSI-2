<?php	
	session_start();
	
	if (isset($_REQUEST["TID"])) {
		$transporte["TID"] = $_REQUEST["TID"];
		$transporte["MEDIOUTILIZADO"] = $_REQUEST["MEDIOUTILIZADO"];
        $transporte["NUMPERSONAS"] = $_REQUEST["NUMPERSONAS"];
        $transporte["EID"] = $_REQUEST["EID"];

		$_SESSION["TRANSPORTE"] = $transporte;
			
		if (isset($_REQUEST["editar"])) Header("Location: produccion3.php");
		else if (isset($_REQUEST["grabar"])) Header("Location: accion_modificar_transporte.php");
		else /*if (isset($_REQUEST["borrar"]))*/ Header("Location: accion_borrar_transporte.php"); 
		echo "<h1>se ha intentado</h1>";
	}
	else 
		Header("Location: produccion3.php");
	
?>
