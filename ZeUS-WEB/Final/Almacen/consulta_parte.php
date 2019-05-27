<?php
require_once("gestionBD.php");
require_once("gestionarParteAlmacen.php");
require_once("paginacion_consulta.php");
if (!isset($_SESSION['login'])) {
    Header("Location: login.php");
} else {
	if (isset($_SESSION["PARTEEQUIPO"])) {
		$parteequipo = $_SESSION["PARTEEQUIPO"];
		unset($_SESSION["PARTEEQUIPO"]);
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
	$query = "SELECT * from EVENTO"; 
	$total_registros = total_consulta($conexion, $query);
	$paginacion["NUMEROREG"]=$total_registros;
	$query = "SELECT * from PARTEEQUIPO"; 
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
	<!-- The Modal -->

	<div id="myModal2" class="modal">

												<!-- Modal content -->
	<?php 
	$consulta=$_SESSION['Consulta'];

	$inventarioConsulta=$consulta["inventario"];
	$iaConsulta=$consulta["ia"];
	$peid=$_SESSION['peid'];



	?>
	<div class="modal-content">
		<div class="modal-header">
		<span class="close2">&times;</span> 
		<h2>Parte de Equipo</h2>
		</div>
		<div class="modal-body">
			<div><label>Parte de Equipo: <?php echo $peid;?></label></div>					
				<div><label>Inventario: </label></div>
					<div>
					<table >
							<tr>
								<th>Nombre</th>
                				<th>Referencia</th>
                				<th>Cantidad</th>
							</tr>
					<?php foreach((array)$inventarioConsulta as $filaI){?>
						<tr>
							<td><?php echo $filaI["NOMBRE"]; ?></td>
							<td><?php echo $filaI["REFERENCIA"]; ?></td>
							<td><?php echo $filaI["CANTIDAD"]; ?></td>
						</tr>
					<?php }?>
					</table></div>
					
					
					<div><label>Material Alquilado: </label></div>
					<div>
					<table >
							<tr>
								<th>Nombre</th>
                				<th>Tipo</th>
                				<th>Cantidad</th>
							</tr>
					<?php foreach((array)$iaConsulta as $filaIA){?>
						<tr>
							<td><?php echo $filaIA["NOMBRE"]; ?></td>
							<td><?php echo $filaIA["TIPO"]; ?></td>
							<td><?php echo $filaIA["CANTIDAD"]; ?></td>

						</tr>
					<?php }?>
					</table></div>
			</div>
		</div>
	</div>

	<script src="js/modal.js"></script>


<!-- 														MODAL_2																  -->









	<!--                                                      	TRATAMIENTO DE EXCEPCIONES                                                            -->
	<?php if (isset($_SESSION["borrado"])) {
		echo "No se puede borrar";
	}
	if (isset($_SESSION["editando"])) {
		echo "No se puede modificar. Tenga cuidado con el formato que se requiere";
	}
	if(isset($_SESSION["errormodal"])) {
		echo "Error";
		$_SESSION["errormodal"]="FALSE";
}
	if(isset($_SESSION['pagconsult'])) {
		//echo "Ha ocurrido un error con la paginación";
	}
	
	?>
	<!--                                                      	TRATAMIENTO DE EXCEPCIONES                                                            -->

	<!--                                                       CONSULTA_EVENTO                                                            -->
	<div class="seccionEntradas">
		<table id="tabla1" style="width:100%">
			<thead>
			<tr>
				<th>PEID</th>
				<th>Evento</th>
				<th>Consultar</th>
			</tr>
			</thead>
			<?php
			foreach ($filas as $fila) {
				?>
				<form method="POST" action="Almacen/controlador_parteAlmacen.php">
					<input id="EID" name="EID" type="hidden" value="<?php echo $fila["EID"]; ?>" />
					<input id="PEID" name="PEID" type="hidden" value="<?php echo $fila["PEID"]; ?>" />
					<tr>
						<td data-title="PEID:"><?php echo $fila['PEID'];?></td>
						<td data-title="EID:"><?php echo $fila['EID'];?></td>
					<td data-title="Consultar:">
					<button id="consultaBtn" name="consultaBtn" type="submit" class="consultar_fila">
						<img src="images/pencil_menuito.bmp" class="consultar_fila" alt="Consultar PEID">
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
				
				
				?>
				<!--                                                       CONSULTA_PARTEALMACEN                                                           -->

</body>