<?php
require_once("gestionBD.php");
require_once("gestionarInventario.php");
require_once("paginacion_consulta.php");
if (!isset($_SESSION['login'])) {
	Header("Location: login.php");
} else {
	if (isset($_SESSION["otrositems"])) {
		$otrositems = $_SESSION["otrositems"];
		unset($_SESSION["otrositems"]);
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
	$query = 'SELECT * from OTROSITEMS ORDER BY REFERENCIA';
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
	<button id="myBtn" class="mybtn">Añadir ítem </button>

	<!-- The Modal -->
	
	<div id="myModal" class="modal">

		<!-- Modal content -->
		<div class="modal-content">
			<div class="modal-header">
				<span class="close">&times;</span> <!-- he utilizado bootstrap solo para la X -->
				<h2>Añadir ítem</h2>
			</div>
			<div class="modal-body">
				<form method="POST" action="almacen/controlador_otrositems.php">
					<label>Nombre: </label>
					<div><textarea required type="text" id="nombreoi" name="nombreoi" rows="1" cols="40" maxlength="30"></textarea></div>
					<label>Precio Total: </label> <input required type="number" autocomplete="off" min="1" max="1000000000" id="totalprice" name="totalprice" class="form-modal">
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
		echo "No se puede modificar, tenga cuidado con el formato que se requiere";
	}
	if(isset($_SESSION["errormodal"])) {
		echo "No se ha podido agregar el ítem, ha introducido algún dato inválido";
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
				<th>Referencia</th>
				<th>Nombre</th>
				<th>Precio</th>
				<th>Editar</th>
				</tr>
			</thead>
			<?php
			foreach ($filas as $fila) {
				?>
				<form method="POST" action="almacen/controlador_otrositems.php">
					<!-- Controles de los campos que quedan ocultos:
								OID_LIBRO, OID_AUTOR, OID_AUTORIA, NOMBRE, APELLIDOS -->
					<input id="REFERENCIA" name="REFERENCIA" type="hidden" value="<?php echo $fila["REFERENCIA"]; ?>" />
					<input id="NOMBRE" name="NOMBRE" type="hidden" value="<?php echo $fila["NOMBRE"]; ?>" />
					<input id="PRECIO" name="PRECIO" type="hidden" value="<?php echo $fila["PRECIO"]; ?>" />
					<?php
					if (isset($otrositems) and ($fila["REFERENCIA"] == $otrositems["REFERENCIA"])) { ?>
						<!-- Editando título -->
						<tr>
							<td data-title="Referencia:"><?php echo $fila['REFERENCIA']; ?></td>
							<td data-title="Nombre:"><input required type="text" id="NOMBRE" name="NOMBRE" maxlength=30 value="<?php echo $fila['NOMBRE'];?>"</input></td>
							<td data-title="Precio:"><input id="PRECIO" name="PRECIO" required type="number" min="1" max="1000000000" value="<?php echo $fila['PRECIO']; ?>" /></td>
						<?php } else { ?>
							<!-- mostrando título -->
						<tr>
							<td data-title="Referencia:"><?php echo $fila['REFERENCIA']; ?></td>
							<td data-title="Nombre:"><?php echo $fila['NOMBRE']; ?></td>
							<td data-title="Precio:"><?php echo $fila['PRECIO']; ?></td>
						<?php } ?>

						<?php if (isset($otrositems) and $fila["REFERENCIA"] == $otrositems["REFERENCIA"]) { ?>
							<td data-title="Confirmar:">
								<button id="grabar" name="grabar" type="submit" class="editar_fila">
									<img src="images/bag_menuito.bmp" class="editar_fila" alt="Guardar Cambios">
								</button>
							</td>
						<?php } else { ?>
							<td data-title="Editar:">
								<button id="editar" name="editar" type="submit" class="editar_fila">
									<img src="images/pencil_menuito.bmp" class="editar_fila" alt="Editar Libro">
								</button>
							</td>
						<?php } ?>

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
				<!--                                                       CONSULTA_OTROSITEMS                                                           -->

</body>