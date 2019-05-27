<?php
require_once("gestionBD.php");
require_once("gestionarParteEquipo.php");
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
			<input id="PAG_TAM" name="PAG_TAM" type="number" min="1" max="<?php echo $total_registros; ?>" value="<?php echo $pag_tam ?>" autofocus="autofocus" />
			entradas de <?php echo $total_registros ?>
			<input id="pagin" name="pagin" type="submit" value="Cambiar" class="subpaginacion">
		</form>
	</nav>
	<!--                                                      	 PAGINACION                                                           -->










	<!--                                                      	MODAL_FORM                                                            -->
	<!-- Trigger/Open The Modal -->
	<button id="myBtn" class="mybtn">Crear Parte de Equipo </button>
	<button id="consultaBtn" class="mybtn">Consultar Parte de Equipo</button>

	<!-- The Modal -->

	<div id="myModal" class="modal">
		<!-- Modal content -->
		<div class="modal-content">
			<div class="modal-header">
				<span class="close">&times;</span> <!-- he utilizado bootstrap solo para la X -->
				<h2>Crear Parte de Equipo</h2>
			</div>
			<div class="modal-body">
				<form method="POST" action="Tecnico/controlador_parteEquipo.php">
					<label>Evento:</label><input type="" id="eid" name="eid" class="form-modal" >
					<button id="agregar" name="agregar" type="submit" value="Añadir" class="btn">Crear</button>
					<?php if (isset($_SESSION["errormodal"])) { ?>
						<label>HA OCURRIDO UN ERROR</label>
					<?php } ?>


				</form>
			</div>
		</div>
	</div>
	<script src="js/modal.js"></script>
	<script>
		window.onload = function(event){
 		 if($_SESSION["errormodal"]=="TRUE") {
    		modal.style.display = "block";
  }
}
</script>
	<!--                                                      	MODAL_FORM                                                            -->

<!-- 														MODAL_2																  -->
	<div id="myModal2" class="modal">

												<!-- Modal content -->
	<?php 
	$consulta=$_SESSION['Consulta'];

	$eventoConsulta=$consulta['evento'];
	$alojamientoConsulta=$consulta['alojamiento'];
	$inventarioConsulta=$consulta['inventario'];
	$iaConsulta=$consulta['ia'];
	$transporteConsulta=$consulta['transporte'];
	$personalConsulta=$consulta['personal'];

	$peid=$_SESSION['peid'];


	

	?>
	<div class="modal-content">
		<div class="modal-header2">
		<span class="close2">&times;</span> <!-- he utilizado bootstrap solo para la X -->
		<h2>Parte de Equipo</h2>
		</div>
		<div class="modal-body">
			<div><label><?php echo var_dump($consulta['ia']);?></label></div>
			<div><label>Parte de Equipo: <?php echo $peid;?></label></div>
				
				<div><label>Evento: <?php echo $eventoConsulta['EID']; ?></label>
					<div><label>Lugar:  <?php echo $eventoConsulta['LUGAR'];?></label>
					<label>Precio:  <?php echo $eventoConsulta['PRECIOTOTAL'];?></label>
					<label>Estado:  <?php echo $eventoConsulta['ESTADOEVENTO'];?><label>
					</div>
					<div><label>Fecha:  Del <?php echo $eventoConsulta['FECHAINICIO'];?> al <?php echo $eventoConsulta['FECHAFIN'];?></label></div>
					<div><label>Alojamiento:</label></div>
					<div><label>Hotel: <?php echo $alojamientoConsulta['HOTEL']?></label>
						 <label>Direccion: <?php echo $alojamientoConsulta['DIRECCION'];?></label></div>
					<div><label>Ciudad: <?php echo $alojamientoConsulta['CIUDAD']; ?></label>
						 <label>Numero de Personas: <?php echo $alojamientoConsulta['NUMPERSONAS'];?></label></div>
					<div><label>Transporte:</label></div>
						 <label>Medio: <?php echo $transporteConsulta['MEDIOUTILIZADO'];?></label></div>
					<div><label>Personal: </label></div>
					<div>
					<table >
							<tr>
								<th>Nombre</th>
                				<th>DNI</th>
                				<th>Departamento</th>
								<th>Cargo</th>
							</tr>
					<?php foreach((array)$personalConsulta as $filaP){?>
						<tr>
							<td><?php echo $filaP['NOMBRE']; ?></td>
							<td><?php echo $filaP['DNI']; ?></td>
							<td><?php echo $filaP['DEPARTAMENTO']; ?></td>
							<td><?php echo $filaP['CARGO']; ?></td>
						</tr>
					<?php }?>
					</table>
				</div>
									
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
							<td><?php echo $filaI['NOMBRE']; ?></td>
							<td><?php echo $filaI['REFERENCIA']; ?></td>
							<td><?php echo $filaI['CANTIDAD']; ?></td>
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
					<?php foreach($iaConsulta['n']['TOTAL'] as $filaIA){?>
						<tr>
							<td><?php echo $filaIA['NOMBRE']; ?></td>
							<td><?php echo $filaIA['TIPO']; ?></td>
							<td><?php echo $filaIA['CANTIDAD']; ?></td>

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
		echo "No se puede modificar, tenga cuidado con el formato que se requiere";
	}
	if(isset($_SESSION["errormodal"])) {
		echo "No se ha podido crear el Parte de Equipo, ha introducido algún dato inválido";
		$_SESSION["errormodal"]="FALSE";
}
	if(isset($_SESSION['pagconsult'])) {
		//echo "Ha ocurrido un error con la paginación";
	}
	if(isset($_SESSION["fallo"])){
		echo "No se puede introducir un evento que no existe";
		unset($_SESSION["fallo"]);
	}
	?>
	<!--                                                      	TRATAMIENTO DE EXCEPCIONES                                                            -->















	<!--                                                       CONSULTA_EVENTO                                                            -->
	<div class="seccionEntradas">
		<table id="tabla1" style="width:100%">
			<tr>
				<th>PEID</th>
                <th>Editar</th>
                <th>Borrar</th>
				<th>Consultar</th>
			</tr>
			<?php
			foreach ($filas as $fila) {
				?>


				<form method="POST" action="Tecnico/controlador_parteEquipo.php">
					<!-- Controles de los campos que quedan ocultos:
								OID_LIBRO, OID_AUTOR, OID_AUTORIA, NOMBRE, APELLIDOS -->
					<input id="EID" name="EID" type="hidden" value="<?php echo $fila["EID"]; ?>" />
					<input id="PEID" name="PEID" type="hidden" value="<?php echo $fila["PEID"]; ?>" />

					<?php
					if (isset($parteequipo) and ($fila["PEID"] == $parteequipo["PEID"])) { ?>
						<!-- Editando título -->
						<tr>

                            <td><input id="PEID" name="PEID" type="text" value="<?php echo $fila['PEID'];?>" >   
						<?php } else { ?>
							<!-- mostrando título -->

							<tr>
							<td><?php echo $fila['PEID']; ?></td>

						<?php } ?>

						<?php if (isset($parteequipo) and $fila["PEID"] == $parteequipo["PEID"]) { ?>
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
						<td>
							<button id="consultar" name="consultar" type="submit" class="consultar_fila">
								<img src="images/ojo.png" class="consultar_fila" alt="Consultar PEID">
							</button>

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
				<!--para reestablecer el error que salia antes, para evitar que salga siempre -->
				<!--                                                       CONSULTA_EVENTO                                                            -->

</body>