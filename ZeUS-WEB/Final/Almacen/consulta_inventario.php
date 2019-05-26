<?php
	require_once("gestionBD.php");
	require_once("almacen/gestionarInventario.php");
	require_once("paginacion_consulta.php");
	if (!isset($_SESSION['login'])) {
		Header("Location: login.php");
	}else {
	if (isset($_SESSION["inventario"])){
		$inventario = $_SESSION["inventario"];
		unset($_SESSION["inventario"]);
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
	$query = 'SELECT * from INVENTARIO';

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

<!--                                                      	EXCEPCIONES                                                            -->
<?php if (isset($_SESSION["borrado"])) {
		echo "No se puede borrar";
	}
	if (isset($_SESSION["editando"])) {
		echo "Ítem ya agregado";
	}
	if(isset($_SESSION['pagconsult'])) {
		echo "Ha ocurrido un error con la paginación";
	}
	?>
<!--                                                      	PAGINACION                                                            -->
<!--                                                       CONSULTA_EVENTO                                                            -->

<div class="seccionEntradas">
<table id="tabla1" style="width:100%">
		<thead>
			<tr>
			<th>Referencia</th>
			<th>Nombre</th>
			<th>Estado</th>
			<th>Precio</th>
			<th>ID Parte de equipo</th>
			<th>Necesita reparación</th>
			<th>Borrar</th>
			</tr>	
		</thead>
	<?php
		foreach($filas as $fila) {
	?>
		<form method="POST" action="almacen/controlador_inventario.php">
						<input id="REFERENCIA" name="REFERENCIA" type="hidden" value="<?php echo $fila["REFERENCIA"];?>"/>
						<input id="NOMBRE" name="NOMBRE" type="hidden" value="<?php echo $fila["NOMBRE"];?>"/>
						<input id="ESTADOITEM" name="ESTADOITEM" type="hidden" value="<?php echo $fila["ESTADOITEM"];?>"/>
						<input id="PRECIO" name="PRECIO" type="hidden" value="<?php echo $fila["PRECIO"];?>"/>
						<input id="PEID" name="PEID" type="hidden" value="<?php echo $fila["PEID"];?>"/>

						<?php if (isset($inventario) and ($fila["REFERENCIA"] == $inventario["REFERENCIA"])) { ?>
							<!--Edición-->
							<tr>
							<td data-title="Referencia:"><?php echo $fila['REFERENCIA'];?></td>
							<td data-title="Nombre:"><?php echo $fila['NOMBRE'];?></td>
							<td data-title="Estado:"><select id="ESTADOITEM" required name="ESTADOITEM">
								<?php if ($fila['ESTADOITEM'] != "Disponible") echo "<option>Disponible</option>" ?>
								<?php if ($fila['ESTADOITEM'] != "porReparar") echo "<option>enMantenimiento</option>" ?>
								<option selected="selected"><?php echo $fila['ESTADOITEM']; ?></option>
							</select></td>
							<td data-title="Precio:"><?php echo $fila['PRECIO'] ?></td>
							<td data-title="PEID:"> <?php echo $fila['PEID'];?></td>	
						
						<?php }else{ ?>
						<!--Mostrando-->
						<tr>
						<td data-title="Referencia:"><?php echo $fila['REFERENCIA'];?></td>
						<td data-title="Nombre:"><?php echo $fila['NOMBRE'];?></td>
						<td data-title="Estado:"><?php echo $fila['ESTADOITEM'];?></td>
						<td data-title="Precio:"><?php echo $fila['PRECIO'] ?></td>
						<td data-title="PEID:"> <?php echo $fila['PEID'];?></td>	
						<?php } ?>
						
						
						<td data-title="A reparar:">
							<button id="editar" name="editar" type="submit" class="editar_fila">
								<img src="images/pencil_menuito.bmp" class="editar_fila" alt="Editar ítem">
							</button>
						</td>
						<td data-title="Borrar:">
							<button id="borrar" name="borrar" type="submit" class="editar_fila">
								<img src="images/remove_menuito.bmp" class="editar_fila" alt="Borrar ítem">
							</button>
						</td>

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
	
	<?php unset($_SESSION["excepcion"]);
		  unset($_SESSION["borrado"]); ?>

</body>
