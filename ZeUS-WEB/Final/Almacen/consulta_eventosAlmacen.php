<?php
	require_once("gestionBD.php");
	require_once("paginacion_consulta.php");
	if (!isset($_SESSION['login'])) {
		Header("Location: login.php");
	}else {
	if (isset($_SESSION["EVENTOALMACEN"])){
		$eventoalmacen = $_SESSION["EVENTOALMACEN"];
		unset($_SESSION["EVENTOALMACEN"]);
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
	$query = "SELECT * from EVENTO where ESTADOEVENTO<>'Realizado'";
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
		<form method="get" action="pagina.php" class="formpaginacion">
			<input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada ?>" />
			<a class="mostrando">Mostrando</a>
			<input id="PAG_TAM" name="PAG_TAM" class="PAG_TAM" type="number" min="1" max="<?php echo $total_registros; ?>" value="<?php echo $pag_tam ?>" autofocus="autofocus" />
			entradas de <?php echo $total_registros ?>
			<input id="pagin" name="pagin" type="submit" value="Cambiar" class="subpaginacion">
		</form>
	</nav>
<!--                                                      	 PAGINACION                                                           -->

<!--                                                      	MODAL_FORM                                                            -->
<!--                                                      	PAGINACION                                                            -->
<!--                                                       CONSULTA_EVENTO                                                            -->

<div class="seccionEntradas">
<table id="tabla1" style="width:100%">
	<thead>
			<tr>
			<th>Evento</th>
			<th>Lugar</th>
			<th>Fecha inicio</th>
			<th>Fecha fin</th>
			</tr>	
	</thead>
	<?php
		foreach($filas as $fila) {
	?>
		<form method="POST" action="almacen/controlador_eventosAlmacen.php">
						<input id="EID" name="EID" type="hidden"
						value="<?php echo $fila["EID"];?>"/>
						<input id="LUGAR" name="LUGAR" type="hidden"
						value="<?php echo $fila["LUGAR"];?>"/>
						<input id="FECHAINICIO" name="FECHAINICIO" type="hidden"
						value="<?php echo $fila["FECHAINICIO"];?>"/>
						<input id="FECHAFIN" name="FECHAFIN" type="hidden"
						value="<?php echo $fila["FECHAFIN"];?>"/>
						<tr>
						<td data-title="Evento:"><?php echo $fila['EID'];?></td>
						<td data-title="Lugar:"><?php echo $fila['LUGAR'];?></td>
						<td data-title="Fecha de inicio:"><?php echo $fila['FECHAINICIO'];?></td>
						<td data-title="Fecha de fin:"><?php echo $fila['FECHAFIN'];?></td>

		</form>
		
	</article>
	<div>
		
	<?php } ?>
	<div id="enlaces" class="enlaces">
	<?php

	for( $pagina = 1; $pagina <= $total_paginas; $pagina++ )
		if ( $pagina == $pagina_seleccionada) { 	?>
			<span class="current"><?php echo $pagina; ?></span>
	<?php }	else { ?>
			<a href="pagina.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>
	<?php } ?>

</div>

</body>
