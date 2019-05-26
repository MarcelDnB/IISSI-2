<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión     			 
     * #	de libros de la capa de acceso a datos 		
     * #==========================================================#
     */
function quitar_parteEquipo($conexion,$PEID) { //hay q hacer procedimientos para esto
	try {
		$stmt=$conexion->prepare('CALL QUITARPARTEEQUIPO(:PEID)');
		$stmt->bindParam(':PEID',$PEID);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function modificar_parteEquipo($conexion,$EID,$PEID) {
	try {
		$stmt=$conexion->prepare("CALL MODIFICAR_PARTEEQUIPO(:EID,:PEID)");
		$stmt->bindParam(':EID',$EID);
		$stmt->bindParam(':PEID',$PEID);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
function crear_parteEquipo($conexion,$EID) { //hay q hacer procedimientos para esto
	try {
		$stmt=$conexion->prepare("CALL crear_parteEquipo(:EID)");
    $stmt->bindParam(':EID',$EID);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
?>