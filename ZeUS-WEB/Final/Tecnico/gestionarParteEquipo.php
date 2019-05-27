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
		$stmt=$conexion->prepare("CALL CREAR_PARTEEQUIPO(:EID)");
    $stmt->bindParam(':EID',$EID);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
		}
		
}
function consultar_parteEquipo($conexion,$EID,$PEID){
	try{
		$consultaE="SELECT * FROM EVENTO WHERE eid=($EID)";
		$stmt=$conexion->query($consultaE);
		$resultadoEE=$stmt->fetch();
		$consulta['evento']=$resultadoEE;

		$consultaA="SELECT * FROM ALOJAMIENTO WHERE EID=($EID)";
		$stmt=$conexion->query($consultaA);
		$resultadoA=$stmt->fetch();
		$consulta['alojamiento']=$resultadoA;
		
		$consultaT="SELECT * FROM TRANSPORTE WHERE EID=($EID)";
		$stmt=$conexion->query($consultaT);
		$resultadoT=$stmt->fetch();
		$consulta['transporte']=$resultadoT;

	 $_SESSION['Consulta']= $consulta;
	 $_SESSION['peid']=$PEID;
	
		return "";
	}catch(PDOException $e){
		return $e->getMessage();
	}
}
function listarIA($conexion,$PEID){
	try{
		$consulta = "SELECT * FROM ITEMALQUILADO WHERE IA IN (SELECT PEID FROM PARTEEQUIPO WHERE PEID=($PEID))"; 
    	$stmt = $conexion->query($consulta);
		return $stmt;
	}catch(PDOException $e) {
		return $e->getMessage();
    }
}
function listarP($conexion,$PEID){
	try{
		$consulta = "SELECT * FROM PERSONAL WHERE PEID IN (SELECT PEID FROM PARTEEQUIPO WHERE PEID=($PEID))"; 
    	$stmt = $conexion->query($consulta);
		return $stmt;
	}catch(PDOException $e) {
		return $e->getMessage();
    }
}
function listarI($conexion,$PEID){
	try{
		$consulta = "SELECT * FROM INVENTARIO WHERE PEID IN (SELECT PEID FROM PARTEEQUIPO WHERE PEID=($PEID))"; 
    	$stmt = $conexion->query($consulta);
		return $stmt;
	}catch(PDOException $e) {
		return $e->getMessage();
    }
}
?>