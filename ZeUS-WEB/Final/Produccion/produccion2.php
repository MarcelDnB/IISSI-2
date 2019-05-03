<?php
	require_once("gestionBD.php");
	require_once("gestionarAlojamiento.php");
	require_once("paginacion_consulta.php");
	if (!isset($_SESSION['login'])) {
		Header("Location: login.php");
	}else {
	if (isset($_SESSION["ALOJAMIENTO"])){
		$alojamiento = $_SESSION["ALOJAMIENTO"];
		unset($_SESSION["ALOJAMIENTO"]);
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

				<a href="pagina.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

	<?php } ?>

</div>



<form method="get" action="pagina.php">

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
<!--                                                      	MODAL_FORM                                                            -->
<!-- Trigger/Open The Modal -->
<button id="myBtn" class="mybtn">Añadir Alojamiento </button>
<?php if(isset($_SESSION["excepcion"])) {
				echo "Ha introducido algun dato mal" . $_SESSION["excepcion"];
	}?>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
      <div class="modal-header">
          <span class="close">&times;</span>
          <h2>Añadir Evento</h2>
        </div>
    <div class="modal-body">
      <form method="post" action="pagina.php">
        <div><label>Lugar: </label> <input type="text" id="place" name="place" class="form-modal"></div>
				<div><label>Fecha de Inicio: </label> <input type="text" id="finicio" name="finicio" class="form-modal"></div>
				<div><label>Fecha de Fin: </label> <input type="text" id="ffin" name="ffin" class="form-modal"></div>
				<div><label>Precio Total: </label> <input type="text" id="totalprice" name="totalprice" class="form-modal"></div>
        <div><label>Descripcion: </label> <input type="text" id="description" name="description" class="form-modal"></div>
				<div><button id="agregar" name="agregar" type="submit" value="Añadir" class="btn"></div>
				<?php if(isset($_POST['agregar']) && isset($_SESSION['excepcion'])){
					echo '<p>Ha introducido algo mal</p>';
				} ?>
      </form>
    </div>
	</div>
	</div>
	<script src="js/modal.js"></script> 
<!--                                                      	MODAL_FORM                                                            -->

<!--                                                       CONSULTA_EVENTO                                                            -->
<div class="seccionEntradas">
<table id="tabla1" style="width:100%">
			<tr>
			<th>Evento</th>
			<th>Direccion</th>
			<th>Ciudad</th>
			<th>Fecha de Inicio</th>
			<th>Fecha Fin</th>
			<th>Hotel</th>
			<th>Numero personas</th>
			<th>Editar</th>
			<th>Borrar</th>
			</tr>	
	<?php
		foreach($filas as $fila) {
	?>
		<form method="post" action="produccion/controlador_alojamiento.php">
					<!-- Controles de los campos que quedan ocultos:
						OID_LIBRO, OID_AUTOR, OID_AUTORIA, NOMBRE, APELLIDOS -->
						<input id="EID" name="EID" type="hidden"
						value="<?php echo $fila["EID"];?>"/>
						<input id="DIRECCION" name="DIRECCION" type="hidden"
						value="<?php echo $fila["DIRECCION"];?>"/>
						<input id="CIUDAD" name="CIUDAD" type="hidden"
						value="<?php echo $fila["CIUDAD"];?>"/>
						<input id="FECHAINICIO" name="FECHAINICIO" type="hidden"
						value="<?php echo $fila["FECHAINICIO"];?>"/>
						<input id="FECHAFIN" name="FECHAFIN" type="hidden"
						value="<?php echo $fila["FECHAFIN"];?>"/>
						<input id="HOTEL" name="HOTEL" type="hidden"
						value="<?php echo $fila["HOTEL"];?>"/>
						<input id="NUMPERSONAS" name="NUMPERSONAS" type="hidden"
						value="<?php echo $fila["NUMPERSONAS"];?>"/>
				<?php
					if (isset($evento) and ($fila["EID"] == $evento["EID"])) { ?>
						<!-- Editando título -->
						<tr>
						<td><input id="EID" name="EID" type="text" value="<?php echo $fila['EID'];?>"/></td>
						<td><input id="DIRECCION" name="DIRECCION" type="text" value="<?php echo $fila['DIRECCION'];?>"/></td>
						<td><input id="CIUDAD" name="CIUDAD" type="text" value="<?php echo $fila['CIUDAD'];?>"/></td>
						<td><input id="FECHAINICIO" name="FECHAINICIO" type="text" value="<?php echo $fila['FECHAINICIO'];?>"/></td>
						<td><input id="FECHAFIN" name="FECHAFIN" type="text" value="<?php echo $fila['FECHAFIN'];?>"/></td>
						<td><input id="HOTEL" name="HOTEL" type="text" value="<?php echo $fila['HOTEL'];?>"/></td>
						<td><input id="NUMPERSONAS" name="NUMPERSONAS" type="text" value="<?php echo $fila['NUMPERSONAS'];?>"/></td>
						<?php }	else { ?>
						<!-- mostrando título -->	
						<tr>
						<td><?php echo $fila['EID'];?></td>
						<td><?php echo $fila['DIRECCION'];?></td>
						<td><?php echo $fila['CIUDAD']?></td>
						<td><?php echo $fila['FECHAINICIO'];?></td>
						<td><?php echo $fila['FECHAFIN'] ?></td>
						<td> <?php echo $fila['HOTEL'];?></td>
						<td><p><?php echo $fila['NUMPERSONAS'];?></p></td>
						

				<?php } ?>
				
				<?php if (isset($alojamiento) and $fila["EID"] == $alojamiento["EID"]) { ?>
				<td>
					<button id="grabar" name="grabar" type="submit" class="editar_fila">
						<img src="images/bag_menuito.bmp" class="editar_fila" alt="Guardar Cambios">
					</button>
				</td>
				<?php } else {?>
					<td>
					<button id="editar" name="editar" type="submit" class="editar_fila">
						<img src="images/pencil_menuito.bmp" class="editar_fila" alt="Editar Libro">
					</button>	
				</td>
				<?php } ?>
				<td>
				<button id="borrar" name="borrar" type="submit" class="editar_fila">
						<img src="images/remove_menuito.bmp" class="editar_fila" alt="Borrar Libro">
					</button>
				</td>

		</form>
	</article>
	<div>
	<?php } ?>
<!--                                                       CONSULTA_EVENTO                                                            -->
<?php unset($_SESSION["excepcion"]);?>
</body>
</html>