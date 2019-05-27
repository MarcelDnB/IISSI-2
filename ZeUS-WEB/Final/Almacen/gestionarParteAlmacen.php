<?php

function consultar_parteEquipoAlmacen($conexion,$PEID){
	try{
		$consultaI="SELECT * FROM INVENTARIO WHERE PEID=$PEID";
		$stmt=$conexion->query($consultaI);
		$resultadoEI=$stmt->fetch();
		$consulta["inventario"]=$resultadoEI;
		
		$consultaIA="SELECT * FROM ITEMALQUILADO WHERE PEID=$PEID";
		$stmt=$conexion->query($consultaIA);
		$resultadoIA=$stmt->fetch();
		$consulta["ia"]=$resultadoIA;
				
		$_SESSION['Consulta']=$consulta;
		$_SESSION['peid']=$PEID;
		return "";
	}catch(PDOException $e){
		return $e->getMessage();
	}
}


?>