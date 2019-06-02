<?php

function listarTodosEventos($conexion){
	try{
		$consulta = "SELECT * FROM evento ORDER BY eid"; // SOLO LOS EVENTOS Q NO TIENEN ALOJAMIENTO
    	$stmt = $conexion->query($consulta);
		return $stmt;
	}catch(PDOException $e) {
		return $e->getMessage();
    }
}

?>