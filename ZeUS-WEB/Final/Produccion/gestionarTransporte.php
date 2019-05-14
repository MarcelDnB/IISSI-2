<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión     			 
     * #	de libros de la capa de acceso a datos 		
     * #==========================================================#
     */
function quitar_transporte($conexion,$TID) { //hay q hacer procedimientos para esto
	try {
		$stmt=$conexion->prepare('CALL QUITAR_TRANSPORTE(:TID)');
		$stmt->bindParam(':TID',$TID);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
		}
}

function modificar_transporte($conexion,$TID,$MEDIOUTILIZADO,$NUMPERSONAS,$EID) {
	try {
		$stmt=$conexion->prepare('CALL MODIFICAR_TRANSPORTE(:TID,:MEDIOUTILIZADO,:NUMPERSONAS,:EID)');
		$stmt->bindParam(':TID',$TID);
		$stmt->bindParam(':MEDIOUTILIZADO',$MEDIOUTILIZADO);
		$stmt->bindParam(':NUMPERSONAS',$NUMPERSONAS);
		$stmt->bindParam(':EID',$EID);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function crear_transporte($conexion,$TID,$MEDIOUTILIZADO,$NUMPERSONAS,$EID) {
	try {
		$stmt=$conexion->prepare("CALL crear_transporte(:TID,:MEDIOUTILIZADO,:NUMPERSONAS,:EID)");
		$stmt->bindParam(':TID',$TID);
		$stmt->bindParam(':MEDIOUTILIZADO',$MEDIOUTILIZADO);
		$stmt->bindParam(':NUMPERSONAS',$NUMPERSONAS);
		$stmt->bindParam(':EID',$EID);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
function listarEventos($conexion){
	try{
		$consulta = "SELECT eid FROM evento WHERE eid NOT IN (SELECT eid FROM transporte) ORDER BY eid"; // SOLO LOS EVENTOS Q NO TIENEN ALOJAMIENTO
    	$stmt = $conexion->query($consulta);
		return $stmt;
	}catch(PDOException $e) {
		return $e->getMessage();
    }
}
	
?>