<?php
function consultarUsuario($conexion,$email,$pass) {
	$consulta = "SELECT COUNT(*) AS TOTAL FROM USUARIOS WHERE EMAIL=:email AND PASS=:pass";
   $stmt = $conexion->prepare($consulta);
   $stmt->bindParam(':email',$email);
   $stmt->bindParam(':pass',$pass);
   $stmt->execute();
   return $stmt->fetchColumn();
}
?>