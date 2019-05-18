<?php
require_once("gestionBD.php");
require_once("gestionarItemA.php");
require_once("paginacion_consulta.php");
if (!isset($_SESSION['login'])) {
	Header("Location: login.php");
} else {
	if (isset($_SESSION["ITEMA"])) {
		$itema = $_SESSION["ITEMA"];
		unset($_SESSION["ITEMA"]);
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
	$query = 'SELECT * from ITEMALQUILADO';
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
			<input id="PAG_TAM" name="PAG_TAM" type="number" min="1" max="<?php echo $total_registros; ?>" value="<?php echo $pag_tam ?>" autofocus="autofocus" />
			entradas de <?php echo $total_registros ?>
			<input id="pagin" name="pagin" type="submit" value="Cambiar" class="subpaginacion">
		</form>
	</nav>
	<!--                                                      	 PAGINACION                                                           -->

		<?php
		$conexion = crearConexionBD();
		$materiales=listarMaterial($conexion);
		$usuarios = comprobarUsuario($conexion,$_SESSION['login']);
		cerrarConexionBD($conexion);
		?>

		<?php foreach($usuarios as $usuario){$usuariomod= $usuario['PID'];}?>




	<!--                                                      	MODAL_FORM                                                            -->
	<!-- Trigger/Open The Modal -->
	<button id="myBtn" class="mybtn">Añadir Item </button>

	<!-- The Modal -->
	
	<div id="myModal" class="modal">

		<!-- Modal content -->
		<div class="modal-content-material">
			<div class="modal-header">
				<span class="close">&times;</span> <!-- he utilizado bootstrap solo para la X -->
				<h2>Añadir Item</h2>
			</div>
			<div class="modal-body">
				<form method="POST" action="produccion/controlador_itemA.php">
				<table id="tabla3" style="width:100%">
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Tipo</th>
				<th>Cantidad</th>
				<th>PID</th>
				<th>Confirmar</th>
			</tr>
			<?php foreach ($materiales as $material) { ?>
			<tr>
				<td ><input type="text" id="iamid" name="iamid" readonly value="<?php echo $material['MID']; ?>"> </td>
				<td ><input type="text" id="ianombre" name="ianombre" readonly value="<?php echo $material['NOMBRE']; ?>"> </td>
				<td ><input type="text" id="iatipo" name="iatipo" readonly value="<?php echo $material['TIPO']; ?>"></td>
				<td ><input type="text" id="iacantidad" name="iacantidad" readonly value="<?php echo $material['CANTIDAD']; ?>"></td>
				<th><input type="text" id="iapid" name="iapid" readonly value="<?php echo $usuariomod ?>"></th>
				<td>
					<button id="agregar" name="agregar" type="submit" class="editar_fila">Alquilar</button>
				</td>
			</tr>
			<?php } ?>
				</table>
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
		echo "No se puede modificar, tenga cuidado con el formato que se requiere";
		echo $_SESSION["excepcion"];
	}
	if(isset($_SESSION["errormodal"])) {
		echo "No se ha podido crear el usuario, ha introducido algún dato inválido";
		echo $_SESSION["excepcion"];
}
	if(isset($_SESSION['pagconsult'])) {
		echo "Ha ocurrido un error con la paginación";
	}
	?>
	<!--                                                      	TRATAMIENTO DE EXCEPCIONES                                                            -->















	<!--                                                       CONSULTA_EVENTO                                                            -->
	<div class="seccionEntradas">
		<table id="tabla1" style="width:100%">
			<tr>
				<th>ID</th>
				<th>Tipo</th>
				<th>Nombre</th>
				<th>Empresa</th>
				<th>Fecha de llegada</th>
				<th>Fecha de devolución</th>
				<th>Cantidad</th>
				<th>Precio</th>
				<th>PID</th>
				<th>PEID</th>
				<th>Editar</th>
				<th>Borrar</th>
			</tr>
			<?php
			foreach ($filas as $fila) {
				?>
				<form method="POST" action="produccion/controlador_itemA.php">
					<!-- Controles de los campos que quedan ocultos:
								OID_LIBRO, OID_AUTOR, OID_AUTORIA, NOMBRE, APELLIDOS -->
					<input id="IA" name="IA" type="hidden" value="<?php echo $fila["IA"]; ?>" />
					<input id="TIPO" name="TIPO" type="hidden" value="<?php echo $fila["TIPO"]; ?>" />
					<input id="NOMBRE" name="NOMBRE" type="hidden" value="<?php echo $fila["NOMBRE"]; ?>" />
					<input id="EMPRESA" name="EMPRESA" type="hidden" value="<?php echo $fila["EMPRESA"]; ?>" />
					<input id="FECHALLEGADA" name="FECHALLEGADA" type="hidden" value="<?php echo $fila["FECHALLEGADA"]; ?>" />
					<input id="FECHADEVOLUCION" name="FECHADEVOLUCION" type="hidden" value="<?php echo $fila["FECHADEVOLUCION"]; ?>" />
					<input id="CANTIDAD" name="CANTIDAD" type="hidden" value="<?php echo $fila["CANTIDAD"]; ?>" />
					<input id="PRECIO" name="PRECIO" type="hidden" value="<?php echo $fila["PRECIO"]; ?>" />
					<input id="PID" name="PID" type="hidden" value="<?php echo $fila["PID"]; ?>" />
					<input id="PEID" name="PEID" type="hidden" value="<?php echo $fila["PEID"]; ?>" />

					<?php
					if (isset($itema) and ($fila["IA"] == $itema["IA"])) { ?>
						<!-- Editando título -->
						<tr>
							<td><?php echo $fila['IA']; ?></td>
							<td><input id="TIPO" name="TIPO" type="text" value="<?php echo $fila['TIPO']; ?>" /></td>
							<td><input id="NOMBRE" name="NOMBRE" type="text" value="<?php echo $fila['NOMBRE']; ?>" /></td>
							<td><input id="EMPRESA" name="EMPRESA" type="text" value="<?php echo $fila['EMPRESA']; ?>" /></td>
							<td><input id="FECHALLEGADA" name="FECHALLEGADA" type="date" required value="<?php if ($fila["FECHALLEGADA"] != 0) echo date_format(date_create_from_format('d/m/y', $fila['FECHALLEGADA']), 'Y-m-d'); ?>" /></td>
							<td><input id="FECHADEVOLUCION" name="FECHADEVOLUCION" type="date" required value="<?php if ($fila["FECHADEVOLUCION"] != 0) echo date_format(date_create_from_format('d/m/y', $fila['FECHADEVOLUCION']), 'Y-m-d'); ?>" /></td>
							<td><input id="CANTIDAD" name="CANTIDAD" type="text" value="<?php echo $fila['CANTIDAD']; ?>" /></td>
							<td><input id="PRECIO" name="PRECIO" type="text" value="<?php echo $fila['PRECIO']; ?>" /></td>
							<td><input id="PID" name="PID" type="text" value="<?php echo $fila['PID']; ?>" /></td>
							<td><input id="PEID" name="PEID" type="text" value="<?php echo $fila['PEID']; ?>" /></td>
						<?php } else { ?>
							<!-- mostrando título -->
						<tr>
							<td><?php echo $fila['IA']; ?></td>
							<td><?php echo $fila['TIPO']; ?></td>
							<td><?php echo $fila['NOMBRE']; ?></td>
							<td><?php echo $fila['EMPRESA']; ?></td>
							<td><?php if ($fila["FECHALLEGADA"] != 0) echo date_format(date_create_from_format('d/m/y', $fila['FECHALLEGADA']), 'Y-m-d'); ?></td>
							<td><?php if ($fila["FECHADEVOLUCION"] != 0) echo date_format(date_create_from_format('d/m/y', $fila['FECHADEVOLUCION']), 'Y-m-d'); ?></td>
							<td><?php echo $fila['CANTIDAD']; ?></td>
							<td><?php echo $fila['PRECIO']; ?></td>
							<td><?php echo $fila['PID']; ?></td>
							<td> <?php echo $fila['PEID']; ?></td>
						<?php } ?>

						<?php if (isset($itema) and $fila["IA"] == $itema["IA"]) { ?>
							<td>
								<button id="grabar" name="grabar" type="submit" class="editar_fila">
									<img src="images/bag_menuito.bmp" class="editar_fila" alt="Guardar Cambios">
								</button>
							</td>
						<?php } else { ?>
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
				
				
				?>
				<!--para reestablecer el error que salia antes, para evitar que salga siempre -->
				<!--                                                       CONSULTA_EVENTO                                                            -->

</body>