<?php
  //Borrar ítem desde la ventana "Inventario"
function borrar_item($conexion,$referencia) { 
	try {
		$stmt=$conexion->prepare('CALL BORRAR_ITEM(:REFERENCIA)');
		$stmt->bindParam(':REFERENCIA',$referencia);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

//Enviar a reparar un ítem
function necesita_reparacion($conexion, $referencia){
	try {
		$stmt=$conexion->prepare("CALL NECESITA_REPARACION(:REFERENCIA)");
		$stmt->bindParam(':REFERENCIA',$referencia);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

//Funciones para agregar y modificar cada tipo de ítem
	//Altavoz
function agregar_altavoz($conexion, $nombreal, $precioal, $potenciaal, $pulgadaal){
	try {
		$stmt=$conexion->prepare("CALL AGREGAR_ALTAVOZ(:NOMBREAL, :PRECIOAL, :POTENCIAAL, :PULGADAAL)");
		$stmt->bindParam(':NOMBREAL',$nombreal);
		$stmt->bindParam(':PRECIOAL',$precioal);
		$stmt->bindParam(':POTENCIAAL',$potenciaal);
		$stmt->bindParam(':PULGADAAL',$pulgadaal);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function modificar_altavoz($conexion,$referencia, $precioal, $potenciaal, $pulgadaal){
	try {
		$stmt=$conexion->prepare("CALL MODIFICAR_ALTAVOZ(:REFERENCIA, :PRECIOAL, :POTENCIAAL, :PULGADAAL)");
		$stmt->bindParam(':REFERENCIA', $referencia);
		$stmt->bindParam(':PRECIOAL',$precioal);
		$stmt->bindParam(':POTENCIAAL',$potenciaal);
		$stmt->bindParam(':PULGADAAL',$pulgadaal);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function agregar_otrositems($conexion, $nombreoi, $preciooi){
	try {
		$stmt=$conexion->prepare("CALL AGREGAR_OTROSITEMS(:NOMBREOI, :PRECIOOI)");
		$stmt->bindParam(':NOMBREOI',$nombreoi);
		$stmt->bindParam(':PRECIOOI',$preciooi);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function modificar_otrositems($conexion,$referencia, $nombreoi, $preciooi){
	try {
		$stmt=$conexion->prepare("CALL MODIFICAR_OTROSITEMS(:REFERENCIA, :NOMBREOI, :PRECIOOI)");
		$stmt->bindParam(':REFERENCIA', $referencia);
		$stmt->bindParam(':NOMBREOI',$nombreoi);
		$stmt->bindParam(':PRECIOOI',$preciooi);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
?>