<?php
	require_once("gestionBD.php");
	require_once("gestionarPersonal.php");
	require_once("paginacion_consulta.php");
	if (!isset($_SESSION['login'])) {
		Header("Location: login.php");
	}else {
	if (isset($_SESSION["PERSONAL"])){
		$PERSONAL = $_SESSION["PERSONAL"];
		unset($_SESSION["PERSONAL"]);
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
	$query = "SELECT * FROM PERSONAL ORDER BY PID";
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
<button id="myBtn" class="mybtn">Añadir Personal </button>
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
      <div class="modal-header">
          <span class="close">&times;</span>
          <h2>Añadir Personal</h2>
        </div>
    <div class="modal-body">
      <form method="post" action="produccion/controlador_personal.php">
				<div><label>Departamento: </label> 
				<select class="form-modal" id="dept" required name="dept">
									<option selected="selected">Produccion</option>
									<option>Tecnico</option>
									<option>Almacen</option>
								</select></div>
				<div><label>Nombre: </label> <input autocomplete="off" required type="text" maxlength="20" id="nmbre" name="nmbre" class="form-modal"></div>
				<div><label>Cargo: </label> <input autocomplete="off" required type="text" id="carg" maxlength="20" name="carg" class="form-modal"></div>
				<div><label>Sueldo: </label> <input autocomplete="off"  type="number" max=100000 id="sueld" name="sueld" class="form-modal"></div>
				<div><label>DNI: </label> <input autocomplete="off" required maxlength="9" type="text" id="denei" name="denei" class="form-modal"></div>
				<div><label>Email: </label> <input autocomplete="off" type="text" maxlength="20" id="emeil" name="emeil" class="form-modal"></div>
				<div><label>Contraseña: </label> <input autocomplete="off" type="password" maxlength="20" id="contra" name="contra" class="form-modal"></div>
				<div><label>Telefono: </label> <input autocomplete="off" type="number" max=999999999 id="telf" name="telf" class="form-modal"></div>
				<div><label>Estado: </label> 
				<select class="form-modal" id="estd" required name="estd">
									<option selected="selected">Libre</option>
									<option>Ocupado</option>
								</select></div>
				
				
				
				<label>EID: </label>
				<input list="opcionesEventos" autocomplete="off" id="event" name="event" class="form-modal">
				
				<datalist id="opcionesEventos">
			  	<?php
			  		$eventos = listarEventos($conexion);
			  		foreach($eventos as $evento) {
			  			echo "<option label=Evento-".$evento["EID"]." value='".$evento["EID"]."'>";
					}
				?>
			</datalist>





				<label>PEID: </label> 
				<input list="opcionesParte" autocomplete="off" id="parteid" name="parteid" class="form-modal">
				
				<datalist id="opcionesParte">
			  	<?php
			  		$partes = listarParteequipo($conexion);
			  		foreach($partes as $parte) {
			  			echo "<option label=Parte-".$parte["PEID"]." value='".$parte["PEID"]."'>";
					}
				?>
			</datalist>






				<div><button id="agregar" name="agregar" type="submit" value="Añadir" class="btn">Añadir</button></div>
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
				echo "No se ha podido crear el usuario, ha introducido algún dato inválido";
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
			<th>Personal</th>
			<th>Departamento</th>
			<th>Nombre</th>
			<th>Cargo</th>
			<th>Sueldo</th>
			<th>DNI</th>
			<th>Telefono</th>
			<th>Estado</th>
			<th>EID</th>
			<th>PEID</th>
			<th>Editar</th>
			<th>Borrar</th>
			</tr>	
		</thead>
	<?php
		foreach($filas as $fila) {
	?>
		<form method="POST" action="produccion/controlador_personal.php">
					<!-- Controles de los campos que quedan ocultos:
						OID_LIBRO, OID_AUTOR, OID_AUTORIA, NOMBRE, APELLIDOS -->
						<input id="PID" name="PID" type="hidden"
						value="<?php echo $fila["PID"];?>"/>
						<input id="DEPARTAMENTO" name="DEPARTAMENTO" type="hidden"
						value="<?php echo $fila["DEPARTAMENTO"];?>"/>
						<input id="NOMBRE" name="NOMBRE" type="hidden"
						value="<?php echo $fila["NOMBRE"];?>"/>
						<input id="CARGO" name="CARGO" type="hidden"
						value="<?php echo $fila["CARGO"];?>"/>
						<input id="SUELDO" name="SUELDO" type="hidden"
						value="<?php echo $fila["SUELDO"];?>"/>
						<input id="DNI" name="DNI" type="hidden"
						value="<?php echo $fila["DNI"];?>"/>
						<input id="TELEFONO" name="TELEFONO" type="hidden"
						value="<?php echo $fila["TELEFONO"];?>"/>
						<input id="ESTADO" name="ESTADO" type="hidden"
						value="<?php echo $fila["ESTADO"];?>"/>
						<input id="EID" name="EID" type="hidden"
						value="<?php echo $fila["EID"];?>"/>
						<input id="PEID" name="PEID" type="hidden"
						value="<?php echo $fila["PEID"];?>"/>
				<?php
					if (isset($PERSONAL) and ($fila["PID"] == $PERSONAL["PID"])) { ?>
						<!-- Editando título -->
						<tr>
						<td data-title="Personal:"><input id="PID" name="PID" type="text" value="<?php echo $fila['PID'];?>"/></td>
						
						<td data-title="Departamento:"><select id="DEPARTAMENTO" required name="DEPARTAMENTO">
									<?php if ($fila['DEPARTAMENTO'] != "Produccion") echo "<option>Produccion</option>" ?>
									<?php if ($fila['DEPARTAMENTO'] != "Tecnico") echo "<option>Tecnico</option>" ?>
									<?php if ($fila['DEPARTAMENTO'] != "Almacen") echo "<option>Almacen</option>" ?>
									<option selected="selected"><?php echo $fila['DEPARTAMENTO']; ?></option>
								</select></td>
						<td data-title="Personal:"><input id="NOMBRE" name="NOMBRE" type="text" value="<?php echo $fila['NOMBRE'];?>"/></td>
						<td data-title="Cargo:"><input id="CARGO" name="CARGO" type="text" value="<?php echo $fila['CARGO'];?>"/></td>
						<td data-title="Sueldo:"><input id="SUELDO" name="SUELDO" type="text" value="<?php echo $fila['SUELDO'];?>"/></td>
						<td data-title="DNI:"><input id="DNI" name="DNI" type="text" value="<?php echo $fila['DNI'];?>"/></td>
						<td data-title="Telefono:"><input id="TELEFONO" name="TELEFONO" type="text" value="<?php echo $fila['TELEFONO'];?>"/></td>
						<td data-title="Estado:"><select id="ESTADO" required name="ESTADO">
									<?php if ($fila['ESTADO'] != "Libre") echo "<option>Libre</option>" ?>
									<?php if ($fila['ESTADO'] != "Ocupado") echo "<option>Ocupado</option>" ?>
									<option selected="selected"><?php echo $fila['ESTADO']; ?></option>
								</select></td>
						<td data-title="Evento:"><input list="opcionesEventos" id="EID" name="EID" autocomplete="off">
				
				<datalist id="opcionesEventos">
			  	<?php
			  		$eventos = listarEventos($conexion);
			  		foreach($eventos as $evento) {
			  			echo "<option label=Evento-".$evento["EID"]." value='".$evento["EID"]."'>";
					}
				?>
			</datalist></td>

				<td data-title="PEID:"><input list="opcionesParte" autocomplete="off" id="PEID" name="PEID">
				
				<datalist id="opcionesParte">
			  	<?php
			  		$partes = listarParteequipo($conexion);
			  		foreach($partes as $parte) {
			  			echo "<option label=Parte-".$parte["PEID"]." value='".$parte["PEID"]."'>";
					}
				?>
			</datalist></td>



						<?php }	else { ?>
						<!-- mostrando título -->	
						<tr>
						<td data-title="Personal:"><?php echo $fila['PID'];?></td>
						<td data-title="Departamento:"><?php echo $fila['DEPARTAMENTO'];?></td>
						<td data-title="Nombre:"><?php echo $fila['NOMBRE'];?></td>
						<td data-title="Cargo:"><?php echo $fila['CARGO'] ?></td>
						<td data-title="Sueldo:"><?php echo $fila['SUELDO'];?></td>
						<td data-title="DNI:"><?php echo $fila['DNI'];?></td>
						<td data-title="Telefono:"><?php echo $fila['TELEFONO']?></td>
						<td data-title="Estado:"><?php echo $fila['ESTADO']?></td>
						<td data-title="Evento:"><?php echo $fila['EID']?></td>
						<td data-title="PEID:"><?php echo $fila['PEID']?></td>

				<?php } ?>
				
				<?php if (isset($PERSONAL) and $fila["PID"] == $PERSONAL["PID"]) { ?>
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
				unset($_SESSION["errormodal"]);?> <!--para reestablecer el error que salia antes, para evitar que salga siempre -->
	
	
<!--                                                       CONSULTA_EVENTO                                                            -->

</body>
