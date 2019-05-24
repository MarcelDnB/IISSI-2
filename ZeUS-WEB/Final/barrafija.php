<header id="main-header"><!--Cabecera fija-->
	<img src="images/menu-icono.png" alt="" class="menu-bar">
	<a id="logo-header" href="#">
		
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
		
	</a> <!--/#logo-header-->
	<nav id="nav-cerrar">
		<ul>
			<li><a href="logout.php">Cerrar sesión</a></li>
		</ul>
	</nav><!--/nav-->
</header><!--/#main-header-->