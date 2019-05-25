<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión     			 
     * #	de libros de la capa de acceso a datos 		
     * #==========================================================#
     */
function quitar_solicitud($conexion,$IA) { //hay q hacer procedimientos para esto
	try {
		$stmt=$conexion->prepare('CALL CANCELARSOLICITUD(:IA)');
		$stmt->bindParam(':IA',$IA);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function modificar_peticion($conexion,$IA,$NOMBRE,$TIPO,$CANTIDAD,$PEID) {
	try {
		$stmt=$conexion->prepare("CALL EDITARSOLICITUD(:IA,:NOMBRE,:TIPO,:CANTIDAD,:PEID)");
		$stmt->bindParam(':IA',$IA);
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