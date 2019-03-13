<?php
	session_start();
	include_once 'gestionDB.php';
	include_once 'gestionNotas.php';
	include_once 'gestionUsuarios.php';
	$login=$_POST['login'];
	$password=$_POST['passwd'];
	if(comprobarUsuario($login,$password)) {
		include('index.php');
	}
	else {
		include('frm_login_fallo.php');
	}
?>

