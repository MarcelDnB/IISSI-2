<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión     			 
     * #	de libros de la capa de acceso a datos 		
     * #==========================================================#
     */
function quitar_solicitud($conexion,$MID) { //hay q hacer procedimientos para esto
	try {
		$stmt=$conexion->prepare('CALL CANCELARSOLICITUD(:MID)');
		$stmt->bindParam(':MID',$MID);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function modificar_peticion($conexion,$MID,$NOMBRE,$TIPO,$CANTIDAD,$PEID) {
	try {
		$stmt=$conexion->prepare("CALL EDITARSOLICITUD(:MID,:NOMBRE,:TIPO,:CANTIDAD,:PEID)");
		$stmt->bindParam(':MID',$MID);
		$stmt->bindParam(':NOMBRE',$NOMBRE);
		$stmt->bindParam(':TIPO',$TIPO);
		$stmt->bindParam(':CANTIDAD',$CANTIDAD);
		$stmt->bindParam(':PEID',$PEID);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
function crear_solicitud($conexion,$NOMBRE,$TIPO,$CANTIDAD,$PEID) { //hay q hacer procedimientos para esto
	try {
		$stmt=$conexion->prepare("CALL SOLICITARMATERIAL(:NOMBRE,:TIPO,:CANTIDAD,:PEID)");
        $stmt->bindParam(':NOMBRE',$NOMBRE);
				$stmt->bindParam(':TIPO',$TIPO);
				$stmt->bindParam(':CANTIDAD',$CANTIDAD);
				$stmt->bindParam(':PEID',$PEID);
				$stmt->execute();
				return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
?>