<?php
	foreach (PDO::getAvailableDrivers() as $driver) {
		echo $driver . "<br/>";	
	}
	$host="oci:dbname=localhost/XE;charset=UTF8";
	$user="IISSI";
	$password="ilovednbmusic3012";
	try {
		$con = new PDO($host,$user,$password);
		$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		echo "Conectados a la BD <br/>";
		//hacer algo con la BD
		$con=null;
		echo "Desconectados de la BD <br/>";
	}
	catch(PDOException $oops) {
		echo "Error PDO: " .$oops->getMessage();
	}
	?>