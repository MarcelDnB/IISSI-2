<div class="sidebar"><!--Inicio del sidebar-->
	<h2>Menú</h2>
	<?php if($_SESSION['consultarproduccion'] == 1) { /*Este es el menu para produccion*/?> 
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
	}/*Para los demas igual */
?>