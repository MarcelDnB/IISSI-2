<?php
	require_once("gestionBD.php");
	require_once("gestionarMantenimiento.php");
	require_once("paginacion_consulta.php");
	if (!isset($_SESSION['login'])) {
		Header("Location: login.php");
	}else {
	if (isset($_SESSION["MANTENIMIENTO"])){
		$mantenimiento = $_SESSION["MANTENIMIENTO"];
		unset($_SESSION["MANTENIMIENTO"]);
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
	$query = 'SELECT * from MANTENIMIENTO';
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
	<input id="PAG_TAM" name="PAG_TAM" type="number"
		min="1" max="<?php echo $total_registros; ?>"
		value="<?php echo $pag_tam?>" autofocus="autofocus" />
	entradas de <?php echo $total_registros?>
	<input id="pagin" name="pagin" type="submit" value="Cambiar" class="subpaginacion">
</form>
</nav>
<!--                                                      	PAGINACION                                                            -->


<!--                                                      	MODAL_FORM                                                            -->
<!-- Trigger/Open The Modal -->
<button id="myBtn" class="mybtn">Asignar mantenimiento </button>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
      <div class="modal-header">
          <span class="close">&times;</span>
          <h2>Asignar mantenimiento</h2>
        </div>
    <div class="modal-body">
      <form method="POST" action="Almacen/controlador_mantenimiento.php">
				<label>Ítems por reparar: </label> 
				<input list="opcionesItems" autocomplete="off" id="event" name="event" class="form-modal">
				<datalist id="opcionesItems">
			  	<?php
			  		$items = listarItemsPorReparar($conexion);
			  		foreach($items as $mantenimiento) {
			  			echo "<option label=Ítem-".$mantenimiento["REFERENCIA"]." value='".$mantenimiento["REFERENCIA"]."'>";
					}
				?>
			</datalist>
				<!--<div><label>Fecha de Inicio: </label> <input type="date" id="startdate" name="startdate" class="form-modal"></div>-->
				<label>Encargado de la reparación: </label> 
				<input list="opcionesPersonal" autocomplete="off" id="event" name="event" class="form-modal">
				<datalist id="opcionesPersonal">
			  	<?php
			  	  $empleadosDisponibles = listarPersonalAlmacenDisponible($conexion);
			  		foreach($empleadosDisponibles as $personal) {
			  			echo "<option label=Empleado-".$personal["PID"]." value='".$personal["PID"]."'>";
					}
				?>
			</datalist>
				<div><button id="agregar" name="agregar" type="submit" value="Añadir" class="btn">Asignar</button></div>
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

<!--                                                      	TRATAMIENTO DE EXCEPCIONES                                                            -->
<?php if (isset($_SESSION["borrado"])) {
		echo "No se puede borrar";
	}
	if (isset($_SESSION["editando"])) {
		echo "Ítem ya agregado";
	}
	if (isset($_SESSION["errormodal"])) {
		echo "No se ha podido asignar la reparación, ha introducido algún dato inválido";
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
			<th>Fecha de inicio</th>
			<th>Empleado encargado</th>
			<th>Referencia</th>
			<th>Finalizar</th>
			</tr>	
	<?php
		foreach($filas as $fila) {
	?>
		<form method="post" action="Almacen/controlador_mantenimiento.php">
						<input id="FECHAINICIO" name="FECHAINICIO" type="hidden"
						value="<?php echo $fila["FECHAINICIO"];?>"/>
						<input id="PID" name="PID" type="hidden"
						value="<?php echo $fila["PID"];?>"/>
						<input id="REFERENCIA" name="REFERENCIA" type="hidden"
						value="<?php echo $fila["REFERENCIA"];?>"/>
					
						<tr>
						<td><?php if ($fila["FECHAINICIO"] != 0) echo date_format(date_create_from_format('d/m/y', $fila['FECHAINICIO']), 'Y-m-d'); ?></td>
						<td><?php echo $fila['PID'];?></td>
						<td><?php echo $fila['REFERENCIA'];?></td>
			
				
				<td>
				<button id="borrar" name="borrar" type="submit" class="editar_fila">
					<img src="images/remove_menuito.bmp" class="editar_fila" alt="Finalizar mantenimiento">
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