<?php
  //Funciones para los envíos

function crear_envio($conexion, $direccionenv, $fentradaenv, $fsalidaenv, $envpersonal, $envparte){
	try {
		$stmt=$conexion->prepare("CALL CREAR_ENVIO(:DIRECCIONENV,TO_DATE(:FENTRADAENV,'YYYY-MM-DD'),TO_DATE(:FSALIDAENV,'YYYY-MM-DD'),:PIDENV, :PEIDENV)");
		$stmt->bindParam(':DIRECCIONENV',$direccionenv);
		$stmt->bindParam(':FENTRADAENV',$fentradaenv);
		$stmt->bindParam(':FSALIDAENV',$fsalidaenv);
		$stmt->bindParam(':PIDENV',$envpersonal);
		$stmt->bindParam(':PEIDENV',$envparte);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function modificar_envio($conexion,$enidenv, $direccionenv, $estadoenv){
	try {
		$stmt=$conexion->prepare("CALL MODIFICAR_ENVIO(:ENIDENV, :DIRECCIONENV, :ESTADOENV)");
		$stmt->bindParam(':ENIDENV', $enidenv);
		$stmt->bindParam(':DIRECCIONENV',$direccionenv);
		$stmt->bindParam(':ESTADOENV',$estadoenv);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function fin_envio($conexion,$envpersonal, $enidenv){
	try {
		$stmt=$conexion->prepare("CALL FIN_ENVIO(:ENVPERSONAL, :ENIDENV)");
		$stmt->bindParam(':ENVPERSONAL', $envpersonal);
		$stmt->bindParam(':ENIDENV',$enidenv);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

//Para el form modal
function listarPersonalAlmacenDisponible($conexion){
	try{
		$consulta = "SELECT PID FROM PERSONAL WHERE DEPARTAMENTO='Almacen' AND ESTADO='Libre' ORDER BY PID"; 
  	$stmt = $conexion->query($consulta);
		return $stmt;
	}catch(PDOException $e) {
		return $e->getMessage();
    }
}

function listarPartesSinEnviar($conexion){
	try{
		$consulta = "SELECT PARTE.PEID FROM PARTEEQUIPO PARTE, EVENTO E WHERE E.ESTADOEVENTO='porRealizar'"; 
  	$stmt = $conexion->query($consulta);
		return $stmt;
	}catch(PDOException $e) {
		return $e->getMessage();
    }
}

?>