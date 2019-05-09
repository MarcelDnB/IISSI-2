<?php
//Se ha hecho una función por departamento de la empresa que cuenta el total de empleados que pertenecen a cada departamento según el email y password introducidos
function consultarUsuarioAlmacen($conexion,$email,$pass) {
   $consulta = "SELECT COUNT(*) AS TOTAL FROM PERSONAL WHERE EMAIL=:email AND PASS=:pass AND DEPARTAMENTO='Almacen'";
   $stmt = $conexion->prepare($consulta);
   $stmt->bindParam(':email',$email);
   $stmt->bindParam(':pass',$pass);
   $stmt->execute();
   return $stmt->fetchColumn();
}

function consultarUsuarioProduccion($conexion,$email,$pass) {
   $consulta = "SELECT COUNT(*) AS TOTAL FROM PERSONAL WHERE EMAIL=:email AND PASS=:pass AND DEPARTAMENTO='Produccion'";
   $stmt = $conexion->prepare($consulta);
   $stmt->bindParam(':email',$email);
   $stmt->bindParam(':pass',$pass);
   $stmt->execute();
   return $stmt->fetchColumn();
}

function consultarUsuarioTecnico($conexion,$email,$pass) {
   $consulta = "SELECT COUNT(*) AS TOTAL FROM PERSONAL WHERE EMAIL=:email AND PASS=:pass AND DEPARTAMENTO='Tecnico'";
   $stmt = $conexion->prepare($consulta);
   $stmt->bindParam(':email',$email);
   $stmt->bindParam(':pass',$pass);
   $stmt->execute();
   return $stmt->fetchColumn();
}

?>