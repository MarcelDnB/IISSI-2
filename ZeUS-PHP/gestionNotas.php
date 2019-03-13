<?php
	function getNotasByIdUsuario($idUsuario) {
	try {
	$con = conectarDB();
	$notas=$con->prepare("select * from Notas");
	$notas->execute();
}
catch(PDOException $oops) {
	echo "ERROR: " . $oops->getMesage();
}
return $notas;
}
	function añadirNota($idUsuario,$idNota,$Descripcion) {
	try{
	$con = conectarDB();
	$notas = $con->prepare ("INSERT INTO NOTAS(IDUSUARIO,IDNOTA,DESCRIPCION) VALUES(:idU,idNota,:desc)");
	$notas->bindParam(':idU',$idUsuario);
	$notas->bindParam(':idNota',$idNota);
	$notas->bindParam(':desc',$descripcion);
	$notas->execute();
	}
	catch(PDOException $oops) {
	echo "ERROR: " . $oops->getMesage();
	}
	}
?>