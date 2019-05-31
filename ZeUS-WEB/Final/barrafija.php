<header id="main-header"><!--Cabecera fija-->
	<img src="images/menu-icono.png" alt="" class="menu-bar">
	<a id="logo-header" href="#">
	<?php
		$conexion = crearConexionBD();
		include_once("Produccion/gestionarItemA.php");
		$usuarios = comprobarUsuario($conexion,$_SESSION['login']);
		cerrarConexionBD($conexion);

		?>
		<span class="site-name">ZeUS</span>

		
	<?php 
	if($_SESSION['consultarproduccion'] == 1) {
		echo '<span class="site-desc">Departamento de Producción</span>';
	}
	if($_SESSION['consultartecnico'] == 1) {
		echo '<span class="site-desc">Departamento Técnico</span>';
	}
	if($_SESSION['consultaralmacen'] == 1) {
		echo '<span class="site-desc">Departamento de Almacén</span>';
	}
	?>
	
	</a>
	<nav id="nav-cerrar">
		<ul>
			<li><a href="logout.php">Cerrar sesión</a></li>
		</ul>
	</nav><!--/nav-->
	<div class="bienvenida">Bienvenido: <?php echo $usuarios["NOMBRE"] ?></div>
		
	 <!--/#logo-header-->
	
</header><!--/#main-header-->