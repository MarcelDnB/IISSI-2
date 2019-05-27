<?php
  //Funciones para las devoluciones

function crear_devolucion($conexion, $direcciondev, $empresadev, $devpersonal, $devitem){
	try {
		$stmt=$conexion->prepare("CALL CREAR_DEVOLUCION(:DIRECCIONDEV,:EMPRESADEV,:DEVPERSONAL,:DEVITEM)");
		$stmt->bindParam(':DIRECCIONDEV',$direcciondev);
		$stmt->bindParam(':EMPRESADEV',$empresadev);
		$stmt->bindParam(':DEVPERSONAL',$devpersonal);
		$stmt->bindParam(':DEVITEM',$devitem);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function modificar_devolucion($conexion,$diddev, $direcciondev, $empresadev){
	try {
		$stmt=$conexion->prepare("CALL MODIFICAR_DEVOLUCION(:DIDDEV, :DIRECCIONDEV, :EMPRESADEV)");
		$stmt->bindParam(':DIDDEV', $diddev);
		$stmt->bindParam(':DIRECCIONDEV',$direcciondev);
		$stmt->bindParam(':EMPRESADEV',$empresadev);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function fin_devolucion($conexion,$diddev, $devpersonal){
	try {
		$stmt=$conexion->prepare("CALL FIN_DEVOLUCION(:DIDDEV, :DEVPERSONAL)");
		$stmt->bindParam(':DIDDEV',$diddev);
		$stmt->bindParam(':DEVPERSONAL', $devpersonal);
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

function listarItemsPorDevolver($conexion){
	try{
		$consulta = "SELECT IA FROM ITEMALQUILADO WHERE ESTADO='porDevolver'"; 
  	$stmt = $conexion->query($consulta);
		return $stmt;
	}catch(PDOException $e) {
		return $e->getMessage();
    }
}

?>