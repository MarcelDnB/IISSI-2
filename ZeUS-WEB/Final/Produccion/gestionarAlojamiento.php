<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión     			 
     * #	de libros de la capa de acceso a datos 		
     * #==========================================================#
     */
  
function quitar_alojamiento($conexion,$OidLibro) { //hay q hacer procedimientos para esto
	try {
		$stmt=$conexion->prepare('CALL QUITAR_LIBRO(:OidLibro)');
		$stmt->bindParam(':OidLibro',$OidLibro);
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
		$stmt->bindParam(':PRECIOTOTAL',$PRECIOTOTAL);
		$stmt->bindParam(':LUGAR',$LUGAR);
		$stmt->bindParam(':FECHAINICIO',$FECHAINICIO);
		$stmt->bindParam(':FECHAFIN',$FECHAFIN);
		$stmt->bindParam(':DESCRIPCIONCLIENTE',$DESCRIPCIONCLIENTE);
		$stmt->bindParam(':ESTADOEVENTO',$ESTADOEVENTO);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
	
?>