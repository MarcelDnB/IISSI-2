<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión     			 
     * #	de libros de la capa de acceso a datos 		
     * #==========================================================#
     */
  
function quitar_alojamiento($conexion,$EID,$HOTEL) { //hay q hacer procedimientos para esto
	try {
		$stmt=$conexion->prepare('CALL QUITAR_ALOJAMIENTO(:EID,:HOTEL)');
		$stmt->bindParam(':EID',$EID);
		$stmt->bindParam(':HOTEL',$HOTEL);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}


function modificar_alojamiento($conexion,$EID,$CIUDAD,$DIRECCION,$FECHAINICIO,$FECHAFIN,$HOTEL,$NUMPERSONAS) {
	try {
		$stmt=$conexion->prepare("CALL MODIFICAR_ALOJAMIENTO(:CIUDAD,:DIRECCION,TO_DATE(:FECHAINICIO,'YYYY-MM-DD'),TO_DATE(:FECHAFIN,'YYYY-MM-DD'),:HOTEL,:NUMPERSONAS,:EID)");
		$stmt->bindParam(':EID',$EID);
		$stmt->bindParam(':DIRECCION',$DIRECCION);
		$stmt->bindParam(':FECHAINICIO',$FECHAINICIO);
		$stmt->bindParam(':FECHAFIN',$FECHAFIN);
		$stmt->bindParam(':CIUDAD',$CIUDAD);
		$stmt->bindParam(':NUMPERSONAS',$NUMPERSONAS);
		$stmt->bindParam(':HOTEL',$HOTEL);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}


function crear_alojamiento($conexion,$EID,$CIUDAD,$DIRECCION,$FECHAINICIO,$FECHAFIN,$HOTEL,$NUMPERSONAS) {
	try {
		$stmt=$conexion->prepare("CALL crear_alojamiento(:EID,:CIUDAD,:DIRECCION,TO_DATE(:FECHAINICIO,'YYYY-MM-DD'),TO_DATE(:FECHAFIN,'YYYY-MM-DD'),:HOTEL,:NUMPERSONAS)");
		$stmt->bindParam(':EID',$EID);
		$stmt->bindParam(':DIRECCION',$DIRECCION);
		$stmt->bindParam(':FECHAINICIO',$FECHAINICIO);
		$stmt->bindParam(':FECHAFIN',$FECHAFIN);
		$stmt->bindParam(':CIUDAD',$CIUDAD);
		$stmt->bindParam(':NUMPERSONAS',$NUMPERSONAS);
		$stmt->bindParam(':HOTEL',$HOTEL);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
function listarEventos($conexion){
	try{
		$consulta = "SELECT eid FROM evento WHERE eid NOT IN (SELECT eid FROM alojamiento) ORDER BY eid"; // SOLO LOS EVENTOS Q NO TIENEN ALOJAMIENTO
    	$stmt = $conexion->query($consulta);
		return $stmt;
	}catch(PDOException $e) {
		return $e->getMessage();
    }
}
function listarHoteles($conexion){
	try{
		$consulta = "SELECT hotel FROM hoteles WHERE hotel NOT IN (SELECT hotel FROM alojamiento)"; 
    	$stmt = $conexion->query($consulta);
		return $stmt;
	}catch(PDOException $e) {
		return $e->getMessage();
    }
}
	
?>