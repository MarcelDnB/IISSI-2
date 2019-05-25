<?php
	require_once("gestionBD.php");
	require_once("paginacion_consulta.php");
	if (!isset($_SESSION['login'])) {
		Header("Location: login.php");
	}else {
	if (isset($_SESSION["PERSONALALMACEN"])){
		$personalAlmacen = $_SESSION["PERSONALALMACEN"];
		unset($_SESSION["PERSONALALMACEN"]);
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
	$query = "SELECT * from PERSONAL where DEPARTAMENTO='Almacen'";
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
			<th>PID</th>
			<th>Nombre</th>
			<th>Cargo</th>
			<th>Sueldo</th>
			<th>DNI</th>
			<th>Teléfono</th>
			<th>e-Mail</th>
			<th>Estado</th>
			<th>Evento asignado</th>
			<th>PEID</th>
			</tr>	
	</thead>
	<?php
		foreach($filas as $fila) {
	?>
		<form method="POST" action="almacen/controlador_personalAlmacen.php">
						<input id="PID" name="PID" type="hidden"
						value="<?php echo $fila["PID"];?>"/>
						<input id="NOMBRE" name="NOMBRE" type="hidden"
						value="<?php echo $fila["NOMBRE"];?>"/>
						<input id="CARGO" name="CARGO" type="hidden"
						value="<?php echo $fila["CARGO"];?>"/>
						<input id="SUELDO" name="SUELDO" type="hidden"
						value="<?php echo $fila["PRECIO"];?>"/>
						<input id="DNI" name="DNI" type="hidden"
						value="<?php echo $fila["DNI"];?>"/>
						<input id="TELEFONO" name="TELEFONO" type="hidden"
						value="<?php echo $fila["TELEFONO"];?>"/>
						<input id="EMAIL" name="EMAIL" type="hidden"
						value="<?php echo $fila["EMAIL"];?>"/>
						<input id="ESTADO" name="ESTADO" type="hidden"
						value="<?php echo $fila["ESTADO"];?>"/>
						<input id="EID" name="EID" type="hidden"
						value="<?php echo $fila["EID"];?>"/>
						<input id="PEID" name="PEID" type="hidden"
						value="<?php echo $fila["PEID"];?>"/>

						<tr>
						<td data-title="PID:"><?php echo $fila['PID'];?></td>
						<td data-title="Nombre:"><?php echo $fila['NOMBRE'];?></td>
						<td data-title="Cargo:"><?php echo $fila['CARGO'];?></td>
						<td data-title="Sueldo:"><?php echo $fila['SUELDO'] ?></td>
						<td data-title="DNI:"> <?php echo $fila['DNI'];?></td>
						<td data-title="Teléfono:"><?php echo $fila['TELEFONO'];?></td>
						<td data-title="eMail:"><?php echo $fila['EMAIL'];?></td>
						<td data-title="Estado:"><?php echo $fila['ESTADO'];?></td>
						<td data-title="EID:"><?php echo $fila['EID'];?></td>
						<td data-title="PEID:"><?php echo $fila['PEID'];?></td>

						
			

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
