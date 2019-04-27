<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión     			 
     * #	de libros de la capa de acceso a datos 		
     * #==========================================================#
     */
     
function consultarTodosTransporte($conexion) {
	$consulta = "SELECT * FROM TRANSPORTE";
    return $conexion->query($consulta);
}
  
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

function modificar_titulo($conexion,$OidLibro,$TituloLibro) {
	try {
		$stmt=$conexion->prepare('CALL MODIFICAR_TITULO(:OidLibro,:TituloLibro)');
		$stmt->bindParam(':OidLibro',$OidLibro);
		$stmt->bindParam(':TituloLibro',$TituloLibro);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
	
?>