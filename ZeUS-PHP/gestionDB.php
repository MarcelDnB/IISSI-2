<?php
function conectarDB() {
	$host="oci:dbname=localhost/XE;charset=UTF8";
	$user="IISSI";
	$password="cacamacacacamaca";
	try {
		$con = new PDO($host,$user,$password);
		$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		//echo "Conectados a la BD <br/>";
		//hacer algo con la BD
	}
	catch(PDOException $oops) {
		echo "Error PDO: " .$oops->getMessage();
	}
	return $con;
}

function desconectarDB($con) {
		$con=null;
		echo "Desconectados de la BD <br/>";
	}
	?>