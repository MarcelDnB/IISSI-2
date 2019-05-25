<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión     			 
     * #	de libros de la capa de acceso a datos 		
     * #==========================================================#
     */
function quitar_solicitud($conexion,$EID) { //hay q hacer procedimientos para esto
	try {
		$stmt=$conexion->prepare('CALL CANCELARSOLICITUD(:EID)');
		$stmt->bindParam(':EID',$EID);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function modificar_peticion($conexion,$EID,$lista) {
	try {
		$stmt=$conexion->prepare("CALL EDITARSOLICITUD(:EID,:LISTAMATERIALES)");
		$stmt->bindParam(':EID',$EID);
		$stmt->bindParam(':LISTAMATERIALES',$lista);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
function crear_solicitud($conexion,$EID,$lista) { //hay q hacer procedimientos para esto
	try {
		$stmt=$conexion->prepare("CALL SOLICITARMATERIAL(:EID,:LISTAMATERIALES)");
        $stmt->bindParam(':EID',$EID);
        $stmt->bindParam(':LISTAMATERIALES',$lista);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
?>