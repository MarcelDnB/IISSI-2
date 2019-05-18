<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión     			 
     * #	de libros de la capa de acceso a datos 		
     * #==========================================================#
     */
  
function finalizar_reparacion($conexion,$PID,$REFERENCIA) {
	try {
		$stmt=$conexion->prepare('CALL FIN_REPARACION(:PID,:REFERENCIA)');
		$stmt->bindParam(':PID',$PID);
		$stmt->bindParam(':REFERENCIA',$REFERENCIA);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}


function asignar_reparacion($conexion,$PID,$REFEFENCIA) {
	try {
		$stmt=$conexion->prepare("CALL ASIGNAR_REPARACION(:PID,:REFERENCIA)");
		$stmt->bindParam(':PID',$PID);
		$stmt->bindParam(':REFERENCIA',$REFEFENCIA);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function listarItemsPorReparar($conexion){
	try{
		$consulta = "SELECT REFERENCIA FROM INVENTARIO WHERE ESTADOITEM='porReparar' ORDER BY REFERENCIA";
    	$stmt = $conexion->query($consulta);
		return $stmt;
	}catch(PDOException $e) {
		return $e->getMessage();
    }
}

function listarPersonalAlmacenDisponible($conexion){
	try{
		$consulta = "SELECT PID FROM PERSONAL WHERE DEPARTAMENTO='Almacen' AND ESTADO='Libre' ORDER BY PID"; 
    	$stmt = $conexion->query($consulta);
		return $stmt;
	}catch(PDOException $e) {
		return $e->getMessage();
    }
}
	
?>