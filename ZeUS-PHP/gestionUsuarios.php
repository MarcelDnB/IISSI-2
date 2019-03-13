<?php
	function comprobarUsuario($l,$p) {
		$result=false;
		if(existeUsuario($l,$p)) {
			$result=true;			
		}
		return $result;
	}
	
	function existeUsuario($l,$p) {
		$result = false;
		try {
			$con=conectarDB();
			$notas = $con->prepare("select * from USUARIOS where LOGIN=:login AND CLAVE=:password");
			$notas->bindParam(':login',$l);
			$notas->bindParam(':password',$p);	
			$notas->execute();
			$n=$notas->fetch();
			if($n['LOGIN']==$l and $n['CLAVE']==$p) {
				$result=true;
			}
		}
		catch(PDOException $oops) {
			echo "Error: ".$oops->getMessage();
			desconectarDB($con);
		}
		return $result;
	}
?>