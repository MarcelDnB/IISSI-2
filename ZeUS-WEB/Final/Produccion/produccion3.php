<?php
	require_once("gestionBD.php");
	require_once("gestionarTransporte.php");
	require_once("paginacion_consulta.php");
	if (!isset($_SESSION['login'])) {
		Header("Location: login.php");
	}else {
	if (isset($_SESSION["TRANSPORTE"])){
		$transporte = $_SESSION["TRANSPORTE"];
		unset($_SESSION["TRANSPORTE"]);
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
	$query = 'SELECT * from TRANSPORTE ORDER BY TID';
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

	<input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>

	<a class="mostrando">Mostrando</a>

	<input id="PAG_TAM" name="PAG_TAM" type="number" class="PAG_TAM"

		min="1" max="<?php echo $total_registros; ?>"

		value="<?php echo $pag_tam?>" autofocus="autofocus" />

	entradas de <?php echo $total_registros?>

	<input id="pagin" name="pagin" type="submit" value="Cambiar" class="subpaginacion">


</form>

</nav>
<!--                                                      	 PAGINACION                                                           -->

























<!--                                                      	MODAL_FORM                                                            -->
<!-- The Modal -->
<button id="myBtn" class="mybtn">Añadir Transporte</button>
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
      <div class="modal-header">
          <span class="close">&times;</span>
          <h2>Añadir Transporte</h2>
        </div>
    <div class="modal-body">
      <form method="post" action="produccion/controlador_transporte.php">
				<label>Evento: </label>
				<input required	 list="opcionesEventos" autocomplete="off" id="event" name="event" class="form-modal">
				
				<datalist id="opcionesEventos">
			  	<?php
			  		$eventos = listarEventos($conexion);
			  		foreach($eventos as $evento) {
			  			echo "<option label=Evento-".$evento["EID"]." value='".$evento["EID"]."'>";
					}
				?>
			</datalist>






				<div><label>Medio Utilizado: </label> <input autocomplete="off" type="text" maxlength="20" id="medioutil" name="medioutil" class="form-modal"></div>
				<div><label>Numero de personas: </label> <input autocomplete="off" type="number" id="numpers" min=1 max=50 name="numpers" class="form-modal"></div>
				<div><button id="agregar" name="agregar" type="submit" value="Añadir" class="btn">Agregar</button></div>
      </form>
    </div>
	</div>
	</div>
	<script src="js/modal.js"></script> 
<!--                                                      	MODAL_FORM                                                            -->









<!--                                                      	TRATAMIENTO DE EXCEPCIONES                                                            -->
<?php if(isset($_SESSION["borrado"])) {
					echo "No se puede borrar";
				}
			if(isset($_SESSION["editando"])) {
					echo "No se puede modificar, tenga cuidado con el formato que se requiere";
			}
			if(isset($_SESSION["errormodal"])) {
				echo "No se ha podido crear el transporte, ha introducido algún dato inválido";
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
			<th>Transporte</th>
			<th>Evento</th>
			<th>Medio Utilizado</th>
			<th>Numero de personas</th>
			<th>Editar</th>
			<th>Borrar</th>
			</tr>	
		</thead>	
	<?php
		foreach($filas as $fila) {
	?>
		<form method="POST" action="produccion/controlador_transporte.php">
					<!-- Controles de los campos que quedan ocultos:
						OID_LIBRO, OID_AUTOR, OID_AUTORIA, NOMBRE, APELLIDOS -->
						<input id="TID" name="TID" type="hidden"
						value="<?php echo $fila["TID"];?>"/>
						<input id="EID" name="EID" type="hidden"
						value="<?php echo $fila["EID"];?>"/>
						<input id="MEDIOUTILIZADO" name="MEDIOUTILIZADO" type="hidden"
						value="<?php echo $fila["MEDIOUTILIZADO"];?>"/>
						<input id="NUMPERSONAS" name="NUMPERSONAS" type="hidden"
						value="<?php echo $fila["NUMPERSONAS"];?>"/>
						
				<?php
					if (isset($transporte) and ($fila["TID"] == $transporte["TID"])) { ?>
						<!-- Editando título -->
						<tr>
						<td data-title="Transporte:"><input id="TID" name="TID" type="text" value="<?php echo $fila['TID'];?>"/></td>

						
						


						<td data-title="Evento:"><input id="EID" name="EID" type="text" value="<?php echo $fila['EID'];?>"/></td>
						


						
						
						
						<td data-title="Medio utilizado:"> <input maxlength="20" id="MEDIOUTILIZADO" name="MEDIOUTILIZADO" type="text" value="<?php echo $fila['MEDIOUTILIZADO'];?>"/></td>
						<td data-title="Num.Personas:"><input id="NUMPERSONAS" name="NUMPERSONAS" type="number" min=1 max=50 value="<?php echo $fila['NUMPERSONAS'];?>"/></td>
						<?php }	else { ?>
						<!-- mostrando título -->	
						<tr>
						<td data-title="Transporte:"><?php echo $fila['TID'];?></td>
						<td data-title="Evento:"><?php echo $fila['EID'];?></td>
						<td data-title="Medio utilizado:"><?php echo $fila['MEDIOUTILIZADO'];?></td>
						<td data-title="Num.Personas:"><?php echo $fila['NUMPERSONAS'] ?></td>
				<?php } ?>
				
				<?php if (isset($transporte) and $fila["TID"] == $transporte["TID"]) { ?>
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
				unset($_SESSION["borrado"]);
				unset($_SESSION["editando"]);
				unset($_SESSION["errormodal"]); ?> <!--para reestablecer el error que salia antes, para evitar que salga siempre -->
	
	
<!--                                                       CONSULTA_EVENTO                                                            -->

</body>
