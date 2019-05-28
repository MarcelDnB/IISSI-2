<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión     			 
     * #	de libros de la capa de acceso a datos 		
     * #==========================================================#
     */
function cambiar_itema($conexion,$IA) { //hay q hacer procedimientos para esto
	try {
		$stmt=$conexion->prepare("UPDATE itemalquilado set estado='porDevolver' where IA=:IA");
		$stmt->bindParam(':IA',$IA);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
function quitar_materialnecesario($conexion,$IA) { //hay q hacer procedimientos para esto
	try {
		$stmt=$conexion->prepare('CALL QUITAR_MATERIALNECESARIO(:IA)');	
		$stmt->bindParam(':IA',$IA);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function modificar_itema($conexion,$IA,$TIPO,$NOMBRE,$EMPRESA,$FECHALLEGADA,$FECHADEVOLUCION,$CANTIDAD,$PRECIO,$PID,$PEID) {
	try {
		$stmt=$conexion->prepare("CALL MODIFICAR_ITEMA(:IA,:TIPO,:NOMBRE,:EMPRESA,TO_DATE(:FECHALLEGADA,'YYYY-MM-DD'),TO_DATE(:FECHADEVOLUCION,'YYYY-MM-DD'),:CANTIDAD,:PRECIO,:PID,:PEID)");
		$stmt->bindParam(':TIPO',$TIPO);
		$stmt->bindParam(':IA',$IA);
		$stmt->bindParam(':NOMBRE',$NOMBRE);
		$stmt->bindParam(':EMPRESA',$EMPRESA);
		$stmt->bindParam(':FECHALLEGADA',$FECHALLEGADA);
		$stmt->bindParam(':FECHADEVOLUCION',$FECHADEVOLUCION);
		$stmt->bindParam(':CANTIDAD',$CANTIDAD);
		$stmt->bindParam(':PRECIO',$PRECIO);
		$stmt->bindParam(':PID',$PID);
		$stmt->bindParam(':PEID',$PEID);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
function crear_itemalquilado($conexion,$PEID,$TIPO,$NOMBRE,$CANTIDAD,$MID,$PID) { //hay q hacer procedimientos para esto
	try {
		$stmt=$conexion->prepare("CALL alquilar_item(:TIPO,:NOMBRE,'','','',:CANTIDAD,'',:PID,:PEID,:MID)");
		$stmt->bindParam(':TIPO',$TIPO);
		$stmt->bindParam(':PEID',$PEID);
		$stmt->bindParam(':NOMBRE',$NOMBRE);
		$stmt->bindParam(':CANTIDAD',$CANTIDAD);
		$stmt->bindParam(':MID',$MID);
		$stmt->bindParam(':PID',$PID);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function listarMaterial($conexion){
	try{
		$consulta = "SELECT * FROM materialnecesario WHERE MID NOT IN (SELECT MID FROM ITEMALQUILADO)"; 
    	$stmt = $conexion->query($consulta);
		return $stmt;
	}catch(PDOException $e) {
		return $e->getMessage();
    }
}
function comprobarUsuario($conexion,$email){
	try{
		$consulta = "SELECT * FROM PERSONAL WHERE EMAIL='$email'"; 
		$stmt = $conexion->query($consulta);
		return $stmt;
	}catch(PDOException $e) {
		return $e->getMessage();
    }
}

?>