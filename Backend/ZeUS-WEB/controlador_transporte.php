<?php	
	session_start();
	
	if (isset($_REQUEST["tid"])) {
		$transporte["tid"] = $_REQUEST["tid"];
		$transporte["medioutilizado"] = $_REQUEST["medioutilizado"];
        $transporte["numpersonas"] = $_REQUEST["numpersonas"];
        $transporte["eid"] = $_REQUEST["eid"];

		$_SESSION["transporte"] = $transporte;
			
		if (isset($_REQUEST["editar"])) Header("Location: produccion3.php"); 
		else if (isset($_REQUEST["grabar"])) Header("Location: accion_modificar_evento.php");
		else /* if (isset($_REQUEST["borrar"])) */ Header("Location: accion_borrar_evento.php"); 
	}
	else 
		Header("Location: produccion3.php");
	
?>
