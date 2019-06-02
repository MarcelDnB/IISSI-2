<?php

function listarTodosEventos($conexion){
	try{
		$consulta = "SELECT * FROM evento ORDER BY eid"; 
    	$stmt = $conexion->query($consulta);
		return $stmt;
	}catch(PDOException $e) {
		return $e->getMessage();
    }
}

?>