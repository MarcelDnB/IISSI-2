<?php
require_once("gestionBD.php");
require_once("gestionarDevoluciones.php");
require_once("paginacion_consulta.php");
if (!isset($_SESSION['login'])) {
	Header("Location: login.php");
} else {
	if (isset($_SESSION["devoluciones"])) {
		$devoluciones = $_SESSION["devoluciones"];
		unset($_SESSION["devoluciones"]);
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
	$query = 'SELECT * from DEVOLUCIONES';
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
	<button id="myBtn" class="mybtn">Añadir devolución </button>

	<!-- The Modal -->
	
	<div id="myModal" class="modal">

		<!-- Modal content -->
		<div class="modal-content">
			<div class="modal-header">
				<span class="close">&times;</span>
				<h2>Añadir devolución</h2>
			</div>
			<div class="modal-body">
				<form method="POST" action="almacen/controlador_devoluciones.php">
					<label>Dirección: </label>
					<div><textarea required type="text" id="direcciondev" name="direcciondev" rows="1" cols="40" maxlength="30"></textarea></div>
					<label>Empresa: </label>
					<div><textarea required type="text" id="empresadev" name="empresadev" rows="1" cols="40" maxlength="30"></textarea></div>
					<label>Encargado del envío: </label> 
				    <input required list="opcionesPersonalDevolucion" autocomplete="off" type="number" id="devpersonal" name="devpersonal" class="form-modal">
				    <datalist id="opcionesPersonalDevolucion">
					<?php
			  	    	$empleadosDisponibles = listarPersonalAlmacenDisponible($conexion);
			  			foreach($empleadosDisponibles as $personal) {
			  				echo "<option label=Empleado-".$personal["PID"]." value='".$personal["PID"]."'>";
						}
					?>
					</datalist>
					<label>Ítem a devolver: </label> 
					<input required list="opcionesDevolucion" autocomplete="off" type="number" id="devitem" name="devitem" class="form-modal">
					<datalist id="opcionesDevolucion">
			  		<?php
			  			$ialq = listarItemsPorDevolver($conexion);
			  			foreach($ialq as $ia) {
			  				echo "<option label=Ítem-".$ia["IA"]." value='".$ia["IA"]."'>";
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
		echo "Ítem ya devuelto";
	}
	if (isset($_SESSION["editando"])) {
		echo "No se puede modificar. Tenga cuidado con el formato que se requiere";
	}
	if(isset($_SESSION["errormodal"])) {
		echo "No se ha podido crear la devolución. Ha introducido algún dato inválido";
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
				<th>ID Devolución</th>
				<th>Dirección</th>
				<th>Empresa</th>
				<th>ID Ítem</th>
				<th>Encargado</th>
				<th>Estado de la devolución</th>
				<th>Editar</th>
				<th>Finalizar</th>
				</tr>
			</thead>
			<?php
			foreach ($filas as $fila) {
				?>
				<form method="POST" action="almacen/controlador_devoluciones.php">
					<input id="DID" name="DID" type="hidden" value="<?php echo $fila["DID"]; ?>" />
					<input id="DIRECCION" name="DIRECCION" type="hidden" value="<?php echo $fila["DIRECCION"]; ?>" />
					<input id="EMPRESA" name="EMPRESA" type="hidden" value="<?php echo $fila["EMPRESA"]; ?>" />
					<input id="IA" name="IA" type="hidden" value="<?php echo $fila["IA"]; ?>" />
					<input id="PID" name="PID" type="hidden" value="<?php echo $fila["PID"]; ?>" />
					<input id="ESTADODEVOLUCION" name="ESTADODEVOLUCION" type="hidden" value="<?php echo $fila["ESTADODEVOLUCION"]; ?>" />
					<?php
					if (isset($devoluciones) and ($fila["DID"] == $devoluciones["DID"])) { ?>
						<!--Editando-->
						<tr>
						<td data-title="ID devolución:"><?php echo $fila['DID']; ?></td>
						<td data-title="Dirección:"><input required type="text" id="DIRECCION" name="DIRECCION" maxlength=30 value="<?php echo $fila['DIRECCION'];?>"</input></td>
						<td data-title="Empresa:"><input required type="text" id="EMPRESA" name="EMPRESA" maxlength=30 value="<?php echo $fila['EMPRESA'];?>"</input></td>
						<td data-title="ID ítem:"><?php echo $fila['IA']; ?></td>
						<td data-title="PID:"><?php echo $fila['PID']; ?></td>
						<td data-title="Estado:"><?php echo $fila['ESTADODEVOLUCION']; ?></td>
						<?php } else { ?>
							<!--Mostrando-->
						<tr>
							<td data-title="ID devolución:"><?php echo $fila['DID']; ?></td>
							<td data-title="Dirección:"><?php echo $fila['DIRECCION']; ?></td>
							<td data-title="Empresa:"><?php echo $fila['EMPRESA']; ?></td>
							<td data-title="ID ítem:"><?php echo $fila['IA']; ?></td>
							<td data-title="PID:"><?php echo $fila['PID']; ?></td>
							<td data-title="Estado:"><?php echo $fila['ESTADODEVOLUCION']; ?></td>
						<?php } ?>

						<?php if (isset($devoluciones) and $fila["DID"] == $devoluciones["DID"]) { ?>
							<td data-title="Confirmar:">
								<button id="grabar" name="grabar" type="submit" class="editar_fila">
									<img src="images/bag_menuito.bmp" class="editar_fila" alt="Guardar Cambios">
								</button>
							</td>
						<?php } else { ?>
							<td data-title="Editar:">
								<button id="editar" name="editar" type="submit" class="editar_fila">
									<img src="images/pencil_menuito.bmp" class="editar_fila" alt="Editar devolución">
								</button>
							</td>
						<?php } ?>
						<td data-title="Borrar:">
							<button id="borrar" name="borrar" type="submit" class="editar_fila">
								<img src="images/remove_menuito.bmp" class="editar_fila" alt="Borrar devolución">
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
				<!--                                                       CONSULTA_DEVOLUCIONES                                                        -->

</body>