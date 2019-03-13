<?php
include_once 'gestionDB.php';
include_once 'gestionNotas.php';

$notas = getNotasByIdUsuario(1);

echo "Se han extraido: " . $notas->rowCount() . " notas<br/>";
foreach($notas as $nota) {
	echo $nota['FECHA'] . "--" . $nota['DESCRIPCION'] . "</br>";
	}
/*
echo "Vamos a insertar una nota...";
añadirNota(1, 4, "ejemplo");
*/
 ?>