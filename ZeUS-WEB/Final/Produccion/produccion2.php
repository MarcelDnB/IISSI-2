<?php
	session_start();

	require_once("gestionBD.php");
	require_once("gestionarAlojamiento.php");
	require_once("paginacion_consulta.php");
	if (!isset($_SESSION['login'])) {
		Header("Location: login.php");
	}else {
	if (isset($_SESSION["alojamiento"])){
		$alojamiento = $_SESSION["alojamiento"];
		unset($_SESSION["alojamiento"]);
	}
	
	//                                                      	 PAGINACION                                                           //
	// ¿Venimos simplemente de cambiar página o de haber seleccionado un registro ?
	// ¿Hay una sesión activa?
	if (isset($_SESSION["paginacion"]))
		$paginacion = $_SESSION["paginacion"];
	
	$pagina_seleccionada = isset($_GET["PAG_NUM"]) ? (int)$_GET["PAG_NUM"] : (isset($paginacion) ? (int)$paginacion["PAG_NUM"] : 1);
	$pag_tam = isset($_GET["PAG_TAM"]) ? (int)$_GET["PAG_TAM"] : (isset($paginacion) ? (int)$paginacion["PAG_TAM"] : 5);

	if ($pagina_seleccionada < 1) 		$pagina_seleccionada = 1;
	if ($pag_tam < 1) 		$pag_tam = 5;

	// Antes de seguir, borramos las variables de sección para no confundirnos más adelante
	unset($_SESSION["paginacion"]);

	$conexion = crearConexionBD();

	// La consulta que ha de paginarse
	$query = 'SELECT * from ALOJAMIENTO';

	// Se comprueba que el tamaño de página, página seleccionada y total de registros son conformes.
	// En caso de que no, se asume el tamaño de página propuesto, pero desde la página 1
	$total_registros = total_consulta($conexion, $query);
	$total_paginas = (int)($total_registros / $pag_tam);

	if ($total_registros % $pag_tam > 0)		$total_paginas++;

	if ($pagina_seleccionada > $total_paginas)		$pagina_seleccionada = $total_paginas;

	// Generamos los valores de sesión para página e intervalo para volver a ella después de una operación
	$paginacion["PAG_NUM"] = $pagina_seleccionada;
	$paginacion["PAG_TAM"] = $pag_tam;
	$_SESSION["paginacion"] = $paginacion;

	$filas = consulta_paginada($conexion, $query, $pagina_seleccionada, $pag_tam);

	cerrarConexionBD($conexion);
}
	$conexion = crearConexionBD();
	$filas = consulta_paginada($conexion, $query, $pagina_seleccionada, $pag_tam);
	cerrarConexionBD($conexion);
?>
<!--                                                      	 PAGINACION                                                           -->
<body>
	<!--                                                      	 PAGINACION                                                           -->
<nav>
<div id="enlaces">

	<?php

		for( $pagina = 1; $pagina <= $total_paginas; $pagina++ )

			if ( $pagina == $pagina_seleccionada) { 	?>

				<span class="current"><?php echo $pagina; ?></span>

	<?php }	else { ?>

				<a href="produccion2.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

	<?php } ?>

</div>



<form method="get" action="produccion2.php">

	<input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>

	Mostrando

	<input id="PAG_TAM" name="PAG_TAM" type="number"

		min="1" max="<?php echo $total_registros; ?>"

		value="<?php echo $pag_tam?>" autofocus="autofocus" />

	entradas de <?php echo $total_registros?>

	<input type="submit" value="Cambiar">

</form>

</nav>
<!--                                                      	PAGINACION                                                            -->

<!--                                                      	CUADRITO                                                            -->
<div class="cuadrito">
  <button class="acc-button" onclick="window.location='produccion1.php'">Eventos</button>
	<button class="acc-button" onclick="window.location='produccion2.php'">Alojamiento</button>
	<button class="acc-button" onclick="window.location='produccion3.php'">Transporte</button>
	<button class="acc-button" onclick="window.location='produccion4.php'">Material</button>
	<button class="acc-button" onclick="window.location='produccion5.php'">Personal</button>
	</div>
<!--                                                      	CUADRITO                                                            -->

<!--                                                       CONSULTA_EVENTO                                                            -->
	<div class="seccionEntradas">
	<?php
		foreach($filas as $fila) {
	?>
	<article class="evento">
		<form method="post" action="controlador_alojamiento.php">
					<!-- Controles de los campos que quedan ocultos:
						OID_LIBRO, OID_AUTOR, OID_AUTORIA, NOMBRE, APELLIDOS -->
						<input id="EID" name="EID" type="hidden"
						value="<?php echo $fila["EID"];?>"/>
						<input id="HOTEL" name="HOTEL" type="hidden"
						value="<?php echo $fila["HOTEL"];?>"/>
						<input id="NUMPERSONAS" name="NUMPERSONAS" type="hidden"
						value="<?php echo $fila["NUMPERSONAS"];?>"/>
				<?php
					if (isset($alojamiento) and ($fila["EID"] == $alojamiento["EID"])) { ?>
						<!-- Editando título -->
						<input id="PRECIOTOTAL" name="PRECIOTOTAL" type="text" value="<?php echo $fila['PRECIOTOTAL'];?>"/>
						<h4><?php echo $fila["LUGAR"] . " " . $fila["LUGAR"]; ?></h4>
						<?php }	else { ?>
						<!-- mostrando título -->	
						<input id="PRECIOTOTAL" name="PRECIOTOTAL" type="hidden" value="<?php echo $fila['PRECIOTOTAL'];?>"/>
						
						<div class="titulo"><label><b>Evento: </b><?php echo $fila['EID'];?></label><label><b> Hotel: </b><?php echo $fila['HOTEL'];?></label>
						<label><b>Ciudad:</b> <?php echo $fila['CIUDAD'];?></label><label><b>Direccion:</b> <?php echo $fila['DIRECCION'];?></label>
				<?php } ?>
						<label><b>Fecha de Inicio:</b> <?php echo $fila['FECHAINICIO'];?></label><label><b> Fecha Fin: </b><?php echo $fila['FECHAFIN'] ?></label>

						<label><b>Numero de personas:</b> <?php echo $fila['NUMPERSONAS'];?></label>
            <div>
				<?php if (isset($alojamiento) and $fila["EID"] == $alojamiento["EID"]) { ?>
						<button id="grabar" name="grabar" type="submit" class="editar_fila">
						<img src="images/bag_menuito.bmp" class="editar_fila" alt="Guardar Cambios">
					</button>
				<?php } else {?>
					<button id="editar" name="editar" type="submit" class="editar_fila">
						<img src="images/pencil_menuito.bmp" class="editar_fila" alt="Editar Libro">
					</button>
				<?php } ?>
				<button id="borrar" name="borrar" type="submit" class="editar_fila">
						<img src="images/remove_menuito.bmp" class="editar_fila" alt="Borrar Libro">
					</button>
		</form>
	</article>
	<div>
	<?php } ?>
<!--                                                       CONSULTA_EVENTO                                                            -->






</body>
</html>