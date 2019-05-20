<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión     			 
     * #	de libros de la capa de acceso a datos 		
     * #==========================================================#
     */
function quitar_parteEquipo($conexion,$PEID) { //hay q hacer procedimientos para esto
	try {
		$stmt=$conexion->prepare('CALL QUITAR_PARTEEQUIPO(:PEID)');
		$stmt->bindParam(':PEID',$PEID);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function modificar_parteEquipo($conexion,$EID,$PEID,$REFERENCIA) {
	try {
		$stmt=$conexion->prepare("CALL MODIFICAR_PARTEEQUIPO(:EID,:PEID,:REFERENCIA)");
		$stmt->bindParam(':EID',$EID);
		$stmt->bindParam(':PEID',$PEID);
		$stmt->bindParam(':REFERENCIA',$REFERENCIA);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
function crear_parteEquipo($conexion,$EID,$REFERENCIA) { //hay q hacer procedimientos para esto
	try {
		$stmt=$conexion->prepare("CALL crear_parteEquipo(:EID,:REFERENCIA)");
        $stmt->bindParam(':EID',$EID);
        $stmt->bindParam(':REFERENCIA',$REFERENCIA);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
?>