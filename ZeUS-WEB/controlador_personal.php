<?php	
	session_start();
	
	if (isset($_REQUEST["pid"])) {
		$personal["pid"] = $_REQUEST["pid"];
		$personal["departamento"] = $_REQUEST["departamento"];
        $personal["nombre"] = $_REQUEST["nombre"];
		$personal["cargo"] = $_REQUEST["cargo"];
		$personal["sueldo"] = $_REQUEST["sueldo"];
		$personal["dni"] = $_REQUEST["dni"];
		$personal["telefono"] = $_REQUEST["telefono"];
		$personal["estado"] = $_REQUEST["estado"];
		$personal["eid"] = $_REQUEST["eid"];
		$personal["peid"] = $_REQUEST["peid"];

		$_SESSION["personal"] = $personal;
			
		if (isset($_REQUEST["editar"])) Header("Location: produccion5.php"); 
		else if (isset($_REQUEST["grabar"])) Header("Location: accion_modificar_evento.php");
		else /* if (isset($_REQUEST["borrar"])) */ Header("Location: accion_borrar_evento.php"); 
	}
	else 
		Header("Location: produccion5.php");
	
?>
