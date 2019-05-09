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
		$stmt=$conexion->prepare('CALL MODIFICAR_ALOJAMIENTO(:CIUDAD,:DIRECCION,:FECHAINICIO,:FECHAFIN,:HOTEL,:NUMPERSONAS,:EID)');
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
	
?>