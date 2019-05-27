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
	if (isset($_SESSION["paginacion"]))
		$paginacion = $_SESSION["paginacion"];
	
	$pagina_seleccionada = isset($_GET["PAG_NUM"]) ? (int)$_GET["PAG_NUM"] : (isset($paginacion) ? (int)$paginacion["PAG_NUM"] : 1);
	$pag_tam = isset($_GET["PAG_TAM"]) ? (int)$_GET["PAG_TAM"] : (isset($paginacion) ? (int)$paginacion["PAG_TAM"] : 5);

	if ($pagina_seleccionada < 1) 		$pagina_seleccionada = 1;
	if ($pag_tam < 1) 		$pag_tam = 5;
	unset($_SESSION["paginacion"]);
	$conexion = crearConexionBD();
	$query = 'SELECT * from ALOJAMIENTO ORDER BY EID';
	$total_registros = total_consulta($conexion, $query);
	$total_paginas = (int)($total_registros / $pag_tam);
	if ($total_registros % $pag_tam > 0)		$total_paginas++;
	if ($pagina_seleccionada > $total_paginas)		$pagina_seleccionada = $total_paginas;
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
<body>
<form method="get" action="pagina.php" class="formpaginacion">

	<input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>

	<a class="mostrando">Mostrando</a>

	<input id="PAG_TAM" name="PAG_TAM" class="PAG_TAM" type="number"

		min="1" max="<?php echo $total_registros; ?>"

		value="<?php echo $pag_tam?>" autofocus="autofocus" />

	entradas de <?php echo $total_registros?>

	<input id="pagin" name="pagin" type="submit" value="Cambiar" class="subpaginacion">


</form>
</nav>
<!--                                                      	PAGINACION                                                            -->
















<!--                                                      	MODAL_FORM                                                            -->
<!-- Trigger/Open The Modal -->
<button id="myBtn" class="mybtn">Añadir Alojamiento </button>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
      <div class="modal-header">
          <span class="close">&times;</span>
          <h2>Añadir Alojamiento</h2>
        </div>
    <div class="modal-body">
      <form method="POST" action="produccion/controlador_alojamiento.php">
				<label>Evento: </label> 
				
				<input list="opcionesEventos" autocomplete="off" id="event" name="event" class="form-modal">
				
				<datalist id="opcionesEventos">
			  	<?php
			  		$eventos = listarEventos($conexion);
			  		foreach($eventos as $evento) {
			  			echo "<option label=Evento-".$evento["EID"]." value='".$evento["EID"]."'>";
					}
				?>
			</datalist>

				<div><label>Direccion: </label> <input autocomplete="off" required type="text" maxlength="50" id="direction" name="direction" class="form-modal"></div>
				<div><label>Ciudad: </label> <input autocomplete="off" required type="text" maxlength="20" id="city" name="city" class="form-modal"></div>
				<div><label>Fecha de Inicio: </label> <input type="date" id="startdate" name="startdate" class="form-modal"></div>
				<div><label>Fecha Fin: </label> <input type="date" id="enddate" name="enddate" class="form-modal"></div>
				<label>Hotel: </label>
				<input required list="opcionesHoteles" autocomplete="off" maxlength="40" id="hotelmodal" name="hotelmodal" class="form-modal">
				<datalist id="opcionesHoteles">
			  	<?php
			  		$hoteles = listarHoteles($conexion);
			  		foreach($hoteles as $hotel) {
			  			echo "<option label=Hotel-".$hotel["HOTEL"]." value='".$hotel["HOTEL"]."'>";
					}
				?>
			</datalist>
				
				<div><label>Numero de Personas: </label> <input type="number" min=1 max=50 id="numpersons" name="numpersonas" class="form-modal"></div>
				<div><button id="agregar" name="agregar" type="submit" value="Añadir" class="btn">Agregar</button></div>
      </form>
    </div>
	</div>
	</div>
	<script src="js/modal.js"></script> 
<!--                                                      	MODAL_FORM                                                            -->










<!--                                                      	TRATAMIENTO DE EXCEPCIONES                                                            -->
<?php if (isset($_SESSION["borrado"])) {
		echo "No se puede borrar";
	}
	if (isset($_SESSION["editando"])) {
		echo "No se puede modificar, tenga cuidado con el formato que se requiere";
	}
	if(isset($_SESSION["errormodal"])) {
		echo "No se ha podido crear el alojamiento, ha introducido algún dato inválido";
}
	if(isset($_SESSION['pagconsult'])) {
		echo "Ha ocurrido un error con la paginación";
	}
	?>
	<!--                                                      	TRATAMIENTO DE EXCEPCIONES                                                            -->






	







<!--                                                       CONSULTA_EVENTO                                                            -->
<div class="seccionEntradas">
<table id="tabla1" style="width:100%">
<thead>		
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
</thead>
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
					if (isset($alojamiento) and ($fila["EID"] == $alojamiento["EID"])) { ?>
						<!-- Editando título -->
						<tr>
						<td data-title="Evento:"><?php echo $fila['EID'];?></td>
						<td data-title="Direccion:"><input maxlength="50" id="DIRECCION" name="DIRECCION" type="text" required value="<?php echo $fila['DIRECCION'];?>"/></td>
						<td data-title="Ciudad:"><input maxlength="20" id="CIUDAD" name="CIUDAD" type="text" required value="<?php echo $fila['CIUDAD'];?>"/></td>
						<td data-title="F.Inicio:"><input id="FECHAINICIO" name="FECHAINICIO" type="date" required required value="<?php echo date_format(date_create_from_format('d/m/y', $fila['FECHAINICIO']), 'Y-m-d'); ?>" /></td>
						<td data-title="F.Fin:"><input id="FECHAFIN" name="FECHAFIN" type="date" required required value="<?php if ($fila["FECHAFIN"] != 0) echo date_format(date_create_from_format('d/m/y', $fila['FECHAFIN']), 'Y-m-d'); ?>" /></td>
						<td data-title="Hotel:"><input maxlength="40" id="HOTEL" name="HOTEL" type="text"  value="<?php echo $fila['HOTEL'];?>"/></td>
						<td data-title="Num.Personas:"><input type="number" min=1 max=50 id="NUMPERSONAS" name="NUMPERSONAS" type="text" value="<?php echo $fila['NUMPERSONAS'];?>"/></td>
						<?php }	else { ?>
						<!-- mostrando título -->	
						<tr>
						<td data-title="Evento:"><?php echo $fila['EID'];?></td>
						<td data-title="Direccion:"><?php echo $fila['DIRECCION'];?></td>
						<td data-title="Ciudad:"><?php echo $fila['CIUDAD']?></td>
						<td data-title="F.Inicio:"><?php if ($fila["FECHAINICIO"] != 0) echo date_format(date_create_from_format('d/m/y', $fila['FECHAINICIO']), 'Y-m-d'); ?></td>
						<td data-title="F.Fin:"><?php if ($fila["FECHAFIN"] != 0) echo date_format(date_create_from_format('d/m/y', $fila['FECHAFIN']), 'Y-m-d'); ?></td>
						<td data-title="Hotel:"> <?php echo $fila['HOTEL'];?></td>
						<td data-title="Num.Personas:"><?php echo $fila['NUMPERSONAS'];?></td>
						

				<?php } ?>
				
				<?php if (isset($alojamiento) and $fila["EID"] == $alojamiento["EID"]) { ?>
				<td data-title="Confirmar:">
					<button id="grabar" name="grabar" type="submit" class="editar_fila">
						<img src="images/bag_menuito.bmp" class="editar_fila" alt="Guardar Cambios">
					</button>
				</td>
				<?php } else {?>
					<td data-title="Editar:">
					<button id="editar" name="editar" type="submit" class="editar_fila">
						<img src="images/pencil_menuito.bmp" class="editar_fila" alt="Editar Libro">
					</button>	
				</td>
				<?php } ?>
				<td data-title="Borrar:">
				<button id="borrar" name="borrar" type="submit" class="editar_fila">
						<img src="images/remove_menuito.bmp" class="editar_fila" alt="Borrar Libro">
					</button>
				</td>

		</form>
	</article>

	
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
<!--                                                       CONSULTA_EVENTO                                                            -->
<?php unset($_SESSION["excepcion"]);
				unset($_SESSION["borrado"]);
				unset($_SESSION["editando"]);
				unset($_SESSION["errormodal"]);
				?>
</body>
</html>