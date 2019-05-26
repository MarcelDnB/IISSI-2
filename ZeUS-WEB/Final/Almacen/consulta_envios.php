<?php
require_once("gestionBD.php");
require_once("gestionarEnvios.php");
require_once("paginacion_consulta.php");
if (!isset($_SESSION['login'])) {
	Header("Location: login.php");
} else {
	if (isset($_SESSION["envios"])) {
		$envios = $_SESSION["envios"];
		unset($_SESSION["envios"]);
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
	$query = 'SELECT * from ENVIOS';
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
	<!-- Trigger/Open The Modal -->
	<button id="myBtn" class="mybtn">Añadir envío </button>

	<!-- The Modal -->
	
	<div id="myModal" class="modal">

		<!-- Modal content -->
		<div class="modal-content">
			<div class="modal-header">
				<span class="close">&times;</span> <!-- he utilizado bootstrap solo para la X -->
				<h2>Añadir envío</h2>
			</div>
			<div class="modal-body">
				<form method="POST" action="almacen/controlador_envios.php">
					<label>Dirección: </label>
					<div><textarea required type="text" id="direccionenv" name="direccionenv" rows="1" cols="40" maxlength="30"></textarea></div>
					<label>Fecha de Salida: </label> <input required type="date" id="fsalidaenv" name="fsalidaenv" class="form-modal">
					<label>Fecha de Regreso: </label> <input required type="date" id="fentradaenv" name="fentradaenv" class="form-modal">
					<label>Encargado del envío: </label> 
				    <input required list="opcionesPersonalEnvio" autocomplete="off" id="envpersonal" name="envpersonal" class="form-modal">
				    <datalist id="opcionesPersonalEnvio">
					<?php
			  	    	$empleadosDisponibles = listarPersonalAlmacenDisponible($conexion);
			  			foreach($empleadosDisponibles as $personal) {
			  				echo "<option label=Empleado-".$personal["PID"]." value='".$personal["PID"]."'>";
						}
					?>
					</datalist>
					<label>Parte a enviar: </label> 
					<input required list="opcionesParteEnvio" autocomplete="off" id="envparte" name="envparte" class="form-modal">
					<datalist id="opcionesParteEnvio">
			  		<?php
			  			$partes = listarPartesSinEnviar($conexion);
			  			foreach($partes as $parte) {
			  				echo "<option label=Parte-".$parte["PEID"]." value='".$parte["PEID"]."'>";
						}
					?>
					</datalist>
					<button id="agregar" name="agregar" type="submit" value="Añadir" class="btn">Añadir</button>
					<?php if (isset($_SESSION["errormodal"])) { ?>
						<label>HA OCURRIDO UN ERROR</label>
					<?php } ?>


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
		echo "No se puede modificar. Tenga cuidado con el formato que se requiere";
	}
	if(isset($_SESSION["errormodal"])) {
		echo "No se ha podido crear el envío. Ha introducido algún dato inválido";
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
				<th>ID Envío</th>
				<th>Dirección</th>
				<th>Fecha de salida</th>
				<th>Fecha de regreso</th>
				<th>Estado del envío</th>
				<th>Encargado</th>
				<th>PEID</th>
				<th>Editar</th>
				<th>Finalizar</th>
				</tr>
			</thead>
			<?php
			foreach ($filas as $fila) {
				?>
				<form method="POST" action="almacen/controlador_envios.php">
					<!-- Controles de los campos que quedan ocultos:
								OID_LIBRO, OID_AUTOR, OID_AUTORIA, NOMBRE, APELLIDOS -->
					<input id="ENID" name="ENID" type="hidden" value="<?php echo $fila["ENID"]; ?>" />
					<input id="DIRECCION" name="DIRECCION" type="hidden" value="<?php echo $fila["DIRECCION"]; ?>" />
					<input id="FECHASALIDA" name="FECHASALIDA" type="hidden" value="<?php echo $fila["FECHASALIDA"]; ?>" />
					<input id="FECHAENTRADA" name="FECHAENTRADA" type="hidden" value="<?php echo $fila["FECHAENTRADA"]; ?>" />
					<input id="ESTADOENVIO" name="ESTADOENVIO" type="hidden" value="<?php echo $fila["ESTADOENVIO"]; ?>" />
					<input id="PID" name="PID" type="hidden" value="<?php echo $fila["PID"]; ?>" />
					<input id="PEID" name="PEID" type="hidden" value="<?php echo $fila["PEID"]; ?>" />
					<?php
					if (isset($envios) and ($fila["ENID"] == $envios["ENID"])) { ?>
						<!-- Editando título -->
						<tr>
						<td data-title="ID envío:"><?php echo $fila['ENID']; ?></td>
						<td data-title="Dirección:"><input required type="text" id="DIRECCION" name="DIRECCION" maxlength=30 value="<?php echo $fila['DIRECCION'];?>"</input></td>
						<td data-title="F.Salida:"><?php echo date_format(date_create_from_format('d/m/y', $fila['FECHASALIDA']), 'Y-m-d'); ?></td>
						<td data-title="F.Regreso:"><?php echo date_format(date_create_from_format('d/m/y', $fila['FECHAENTRADA']), 'Y-m-d'); ?></td>
						<td data-title="Estado:"><select id="ESTADOENVIO" required name="ESTADOENVIO">
							<?php if ($fila['ESTADOENVIO'] != "porRealizar") echo "<option>porRealizar</option>" ?>
							<?php if ($fila['ESTADOENVIO'] != "enEvento") echo "<option>enEvento</option>" ?>
							<option selected="selected"><?php echo $fila['ESTADOENVIO']; ?></option>
							</select></td>
						<td data-title="PID:"><?php echo $fila['PID']; ?></td>
						<td data-title="PEID:"><?php echo $fila['PEID']; ?></td>

						<?php } else { ?>
							<!-- mostrando título -->
						<tr>
							<td data-title="ID envío:"><?php echo $fila['ENID']; ?></td>
							<td data-title="Dirección:"><?php echo $fila['DIRECCION']; ?></td>
							<td data-title="F.Salida:"><?php echo $fila['FECHASALIDA']; ?></td>
							<td data-title="F.Regreso:"><?php echo $fila['FECHAENTRADA']; ?></td>
							<td data-title="Estado:"><?php echo $fila['ESTADOENVIO']; ?></td>
							<td data-title="PID:"><?php echo $fila['PID']; ?></td>
							<td data-title="PEID:"><?php echo $fila['PEID']; ?></td>

						<?php } ?>

						<?php if (isset($envios) and $fila["ENID"] == $envios["ENID"]) { ?>
							<td data-title="Confirmar:">
								<button id="grabar" name="grabar" type="submit" class="editar_fila">
									<img src="images/bag_menuito.bmp" class="editar_fila" alt="Guardar Cambios">
								</button>
							</td>
						<?php } else { ?>
							<td data-title="Editar:">
								<button id="editar" name="editar" type="submit" class="editar_fila">
									<img src="images/pencil_menuito.bmp" class="editar_fila" alt="Editar envío">
								</button>
							</td>
						<?php } ?>
						<td data-title="Borrar:">
							<button id="borrar" name="borrar" type="submit" class="editar_fila">
								<img src="images/remove_menuito.bmp" class="editar_fila" alt="Borrar envío">
							</button>
						</td>

				</form>

				</article>
				<div>

				<?php } ?>
				<div id="enlaces" class="enlaces">

					<?php

					for ($pagina = 1; $pagina <= $total_paginas; $pagina++)

						if ($pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

					<?php } else { ?>

						<a href="pagina.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

					<?php } ?>

				</div>

				<?php unset($_SESSION["excepcion"]);
				unset($_SESSION["borrado"]);
				unset($_SESSION["editando"]);
				unset($_SESSION["errormodal"]);
				unset($_SESSION["pagconsult"]);
				
				
				?>
				<!--para reestablecer el error que salia antes, para evitar que salga siempre -->
				<!--                                                       CONSULTA_ENVIOS                                                         -->

</body>