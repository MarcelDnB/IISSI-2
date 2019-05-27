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
		
		$consultaI="SELECT * FROM INVENTARIO WHERE PEID=($PEID)";
		$stmt=$conexion->query($consultaI);
		$resultadoEI=$stmt->fetch();
		$consulta['inventario']=$resultadoEI;
		
		$consultaIA="SELECT * FROM ITEMALQUILADO WHERE PEID=($PEID)";
		$stmt=$conexion->query($consultaIA);
		$resultadoIA['filas']=$stmt->fetch();

		$total_consulta = "SELECT COUNT(*) AS TOTAL FROM ($consultaIA)";
		$stmt = $conexion->query($total_consulta);
		$resultadoIA['n'] = $stmt->fetch();

		$consulta['ia']=$resultadoIA;
		
		$consultaA="SELECT * FROM ALOJAMIENTO WHERE EID=($EID)";
		$stmt=$conexion->query($consultaA);
		$resultadoA=$stmt->fetch();
		$consulta['alojamiento']=$resultadoA;
		
		$consultaT="SELECT * FROM TRANSPORTE WHERE EID=($EID)";
		$stmt=$conexion->query($consultaT);
		$resultadoT=$stmt->fetch();
		$consulta['transporte']=$resultadoT;
		
		$consultaP="SELECT * FROM PERSONAL WHERE PEID=($PEID)";
		$stmt=$conexion->query($consultaP);
		$resultadoP=$stmt->fetch();
		$consulta['personal']=$resultadoP;

	


	 $_SESSION['Consulta']= $consulta;
	 $_SESSION['peid']=$PEID;
	
		return $consulta;
	}catch(PDOException $e){
		return $e->getMessage();
	}
}


?>