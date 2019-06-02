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

//Micrófono
function agregar_microfono($conexion, $nombremic, $preciomic, $alimentacionmic, $tiposujeccionmic){
	try {
		$stmt=$conexion->prepare("CALL AGREGAR_MICROFONO(:NOMBREMIC, :PRECIOMIC, :ALIMIC, :SUJEMIC)");
		$stmt->bindParam(':NOMBREMIC',$nombremic);
		$stmt->bindParam(':PRECIOMIC',$preciomic);
		$stmt->bindParam(':ALIMIC',$alimentacionmic);
		$stmt->bindParam(':SUJEMIC',$tiposujeccionmic);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function modificar_microfono($conexion,$referencia, $preciomic, $alimic, $sujemic){
	try {
		$stmt=$conexion->prepare("CALL MODIFICAR_MICROFONO(:REFERENCIA, :PRECIOMIC, :ALIMIC, :SUJEMIC)");
		$stmt->bindParam(':REFERENCIA', $referencia);
		$stmt->bindParam(':PRECIOMIC',$preciomic);
		$stmt->bindParam(':ALIMIC',$alimic);
		$stmt->bindParam(':SUJEMIC',$sujemic);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

//Ítems no clasificados
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