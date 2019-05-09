<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión     			 
     * #	de libros de la capa de acceso a datos 		
     * #==========================================================#
     */
     
function quitar_personal($conexion,$PID) { //hay q hacer procedimientos para esto
	try {
		$stmt=$conexion->prepare('CALL QUITAR_PERSONAL(:PID)');
		$stmt->bindParam(':PID',$PID);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function modificar_personal($conexion,$PID,$DEPARTAMENTO,$NOMBRE,$CARGO,$SUELDO,$DNI,$TELEFONO,$ESTADO,$EID,$PEID) {
	try {
		$stmt=$conexion->prepare('CALL MODIFICAR_PERSONAL(:PID,:DEPARTAMENTO,:NOMBRE,:CARGO,:SUELDO,:DNI,:TELEFONO,:ESTADO,:EID,:PEID)');
		$stmt->bindParam(':PID',$PID);
		$stmt->bindParam(':DEPARTAMENTO',$DEPARTAMENTO);
		$stmt->bindParam(':NOMBRE',$NOMBRE);
		$stmt->bindParam(':CARGO',$CARGO);
		$stmt->bindParam(':SUELDO',$SUELDO);
		$stmt->bindParam(':DNI',$DNI);
		$stmt->bindParam(':TELEFONO',$TELEFONO);
		$stmt->bindParam(':ESTADO',$ESTADO);
		$stmt->bindParam(':EID',$EID);
		$stmt->bindParam(':PEID',$PEID);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
	
?>