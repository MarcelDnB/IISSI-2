<div class="sidebar"><!--Inicio del sidebar-->
	<!--<h2>Menú</h2>-->
	<?php if($_SESSION['consultarproduccion'] == 1) { /*Este es el menu para produccion*/?> 
	<h2>Producción</h2>
	<form method="get" action="pagina.php">
	<ul>
		<li><button id="eventos" name="eventos" type="submit">Eventos</button></li>
		<li><button id="alojamiento" name="alojamiento" type="submit">Alojamiento</a></li>
		<li><button id="transporte" name="transporte" type="submit">Transporte</a></li>		
		<li><button id="material" name="material" type="submit">Material</a></li>
		<li><button id="personal" name="personal" type="submit">Personal</a></li>
	</ul>
</form>
</div><!--/sidebar-->

<?php 
	if(isset($_GET["eventos"])) {
		$_SESSION["localidad"] = "evento";
	}
	if(isset($_GET["alojamiento"])) {
		$_SESSION["localidad"] = "alojamiento";
	}
	if(isset($_GET["transporte"])) {
		$_SESSION["localidad"] = "transporte";
	}
	if(isset($_GET["material"])) {
		$_SESSION["localidad"] = "material";
	}
	if(isset($_GET["personal"])) {
		$_SESSION["localidad"] = "personal";
	}
} else if($_SESSION['consultaralmacen']==1){	/*Menú de almacén*/?>
	<h2>Almacén</h2>
	<form method="get" action="homeAlmacen.php">
	<ul>
		<li><button class="inventario" name="inventario" type="submit">Inventario</button></li>
		<div class="dropdown-container">
			<li><button class="altavoces" name="altavoces" type="submit">Altavoces</button></li>
		</div>
		<li><button id="envios" name="envios" type="submit">Envíos</button></li>
		<li><button id="itemsalquilados" name="itemsalquilados" type="submit">Ítems alquilados</button></li>		
		<li><button id="mantenimiento" name="mantenimiento" type="submit">Mantenimiento</button></li>
		<li><button id="parte" name="parte" type="submit">Partes de equipo</button></li>
		<li><button id="personal" name="personal" type="submit">Personal de almacén</button></li>
	</ul>
</form>
</div><!--/sidebar-->

<?php 
	if(isset($_GET["inventario"])) {
		$_SESSION["localidad"] = "inventario";
	}
	if(isset($_GET["altavoces"])){
		$_SESSION["localidad"] = "altavoces";
	}
	if(isset($_GET["envios"])) {
		$_SESSION["localidad"] = "envios";
	}
	if(isset($_GET["itemsalquilados"])) {
		$_SESSION["localidad"] = "itemsalquilados";
	}
	if(isset($_GET["mantenimiento"])) {
		$_SESSION["localidad"] = "mantenimiento";
	}
	if(isset($_GET["parte"])){
		$_SESSION["localidad"] = "parte";
	}
	if(isset($_GET["personal"])) {
		$_SESSION["localidad"] = "personal";
	}
}
 else if($_SESSION['consultartecnico']==1){ ?>
	<h2>Técnico</h2>
	<form method="get" action="pagina.php">
	<ul>
		<li><button id="eventoTecnico" name="eventoTecnico" type="submit">Eventos</button></li>
		<div class="dropdown-container">
			<li><button class="parteEquipo" name="parteEquipo" type="submit">Partes de Equipo</button></li>
			<li><button class="peticion" name="peticion" type="submit">Peticiones</button></li>
		<li><button id="personaltecnico" name="personaltecnico" type="submit">Personal</button></li>
	</ul>
</form>
</div>

<?php 
	if(isset($_GET["eventoTecnico"])){
		$_SESSION["localidad"]="eventoTecnico";
	}
	if(isset($_GET["parteEquipo"])){
		$_SESSION["localidad"]="parteEquipo";
	}
	if(isset($_GET["peticion"])){
		$_SESSION["localidad"]="peticion";
	}
	if(isset($_GET["personaltecnico"])){
		$_SESSION["localidad"]="personaltecnico";
	}
 
}
?>
