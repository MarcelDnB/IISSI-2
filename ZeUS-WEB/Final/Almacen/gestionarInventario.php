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
?>