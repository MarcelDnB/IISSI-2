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
	// ¿Venimos simplemente de cambiar página o de haber seleccionado un registro ?
	// ¿Hay una sesión activa?
	if (isset($_SESSION["paginacion"]))
		$paginacion = $_SESSION["paginacion"];
	
	$pagina_seleccionada = isset($_GET["PAG_NUM"]) ? (int)$_GET["PAG_NUM"] : (isset($paginacion) ? (int)$paginacion["PAG_NUM"] : 1);
	$pag_tam = isset($_GET["PAG_TAM"]) ? (int)$_GET["PAG_TAM"] : (isset($paginacion) ? (int)$paginacion["PAG_TAM"] : 5);

	if ($pagina_seleccionada < 1) 		$pagina_seleccionada = 1;
	if ($pag_tam < 1) 		$pag_tam = 5;

	// Antes de seguir, borramos las variables de sección para no confundirnos más adelante
	unset($_SESSION["paginacion"]);

	$conexion = crearConexionBD();

	// La consulta que ha de paginarse
	$query = 'SELECT * from PERSONAL';

	// Se comprueba que el tamaño de página, página seleccionada y total de registros son conformes.
	// En caso de que no, se asume el tamaño de página propuesto, pero desde la página 1
	$total_registros = total_consulta($conexion, $query);
	$total_paginas = (int)($total_registros / $pag_tam);

	if ($total_registros % $pag_tam > 0)		$total_paginas++;

	if ($pagina_seleccionada > $total_paginas)		$pagina_seleccionada = $total_paginas;

	// Generamos los valores de sesión para página e intervalo para volver a ella después de una operación
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
<!--                                                      	 PAGINACION                                                           -->
<!-- crear evento -->
<?php if (isset($_POST['agregar'])){
		$evento['place']= $_POST['place'];
		$evento['finicio'] = $_POST['finicio'];
		$evento['ffin'] = $_POST['ffin'];
		$evento['totalprice'] = $_POST['totalprice'];
		$evento['description'] = $_POST['description'];

		$conexion = crearConexionBD();
		$excepcion = crear_evento($conexion,$evento['totalprice'],$evento['place'],$evento['finicio'],$evento['ffin'],$evento['description']);
		cerrarConexionBD($conexion);

		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "pagina.php";
			Header("Location: pagina.php");
		}
		else
			Header("Location: pagina.php");
	}
?>
<!-- crear evento -->

<body>
	<!--                                                      	 PAGINACION                                                           -->
<nav>




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
<!--                                                      	 PAGINACION                                                           -->

<!--                                                      	MODAL_FORM                                                            -->
<!-- Trigger/Open The Modal -->
<button id="myBtn" class="mybtn">Añadir Personal </button>
<!--                                                      	TRATAMIENTO DE EXCEPCIONES                                                            -->
<?php if(isset($_SESSION["borrado"])) {
					echo "No se puede borrar";
				}
			if(isset($_SESSION["editando"])) {
					echo "No se puede modificar, tenga cuidado con el formato que se requiere";
					echo $_SESSION["excepcion"];
			}
			?>
<!--                                                      	TRATAMIENTO DE EXCEPCIONES                                                            -->
<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
      <div class="modal-header">
          <span class="close">&times;</span>
          <h2>Añadir Personal</h2>
        </div>
    <div class="modal-body">
      <form method="post" action="pagina.php">
        <div><label>Lugar: </label> <input type="text" id="place" name="place" class="form-modal"></div>
				<div><label>Fecha de Inicio: </label> <input type="text" id="finicio" name="finicio" class="form-modal"></div>
				<div><label>Fecha de Fin: </label> <input type="text" id="ffin" name="ffin" class="form-modal"></div>
				<div><label>Precio Total: </label> <input type="text" id="totalprice" name="totalprice" class="form-modal"></div>
        <div><label>Descripcion: </label> <input type="text" id="description" name="description" class="form-modal"></div>
				<div><button id="agregar" name="agregar" type="submit" value="Añadir" class="btn"></div>
				<?php if(isset($_POST['agregar']) && isset($_SESSION['excepcion'])){
					echo '<p>Ha introducido algo mal</p>';
				} ?>
      </form>
    </div>
	</div>
	</div>
	<script src="js/modal.js"></script> 
<!--                                                      	MODAL_FORM                                                            -->

<!--                                                      	PAGINACION                                                            -->
<!--                                                       CONSULTA_EVENTO                                                            -->

<div class="seccionEntradas">
<table id="tabla1" style="width:100%">
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
						<td><input id="PID" name="PID" type="text" value="<?php echo $fila['PID'];?>"/></td>
						<td><input id="DEPARTAMENTO" name="DEPARTAMENTO" type="text" value="<?php echo $fila['DEPARTAMENTO'];?>"/></td>
						<td><input id="NOMBRE" name="NOMBRE" type="text" value="<?php echo $fila['NOMBRE'];?>"/></td>
						<td><input id="CARGO" name="CARGO" type="text" value="<?php echo $fila['CARGO'];?>"/></td>
						<td><input id="SUELDO" name="SUELDO" type="text" value="<?php echo $fila['SUELDO'];?>"/></td>
						<td><input id="DNI" name="DNI" type="text" value="<?php echo $fila['DNI'];?>"/></td>
						<td><input id="TELEFONO" name="TELEFONO" type="text" value="<?php echo $fila['TELEFONO'];?>"/></td>
						<td><input id="ESTADO" name="ESTADO" type="text" value="<?php echo $fila['ESTADO'];?>"/></td>
						<td><input id="EID" name="EID" type="text" value="<?php echo $fila['EID'];?>"/></td>
						<td><input id="PEID" name="PEID" type="text" value="<?php echo $fila['PEID'];?>"/></td>
						<?php }	else { ?>
						<!-- mostrando título -->	
						<tr>
						<td><?php echo $fila['PID'];?></td>
						<td><?php echo $fila['DEPARTAMENTO'];?></td>
						<td><?php echo $fila['NOMBRE'];?></td>
						<td><?php echo $fila['CARGO'] ?></td>
						<td><?php echo $fila['SUELDO'];?></td>
						<td><?php echo $fila['DNI'];?></td>
						<td><?php echo $fila['TELEFONO']?></td>
						<td><?php echo $fila['ESTADO']?></td>
						<td><?php echo $fila['EID']?></td>
						<td><?php echo $fila['PEID']?></td>

				<?php } ?>
				
				<?php if (isset($PERSONAL) and $fila["PID"] == $PERSONAL["PID"]) { ?>
				<td>
					<button id="grabar" name="grabar" type="submit" class="editar_fila">
						<img src="images/bag_menuito.bmp" class="editar_fila" alt="Guardar Cambios">
					</button>
				</td>
				<?php } else {?>
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

	for( $pagina = 1; $pagina <= $total_paginas; $pagina++ )

		if ( $pagina == $pagina_seleccionada) { 	?>

			<span class="current"><?php echo $pagina; ?></span>

<?php }	else { ?>

			<a href="pagina.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

<?php } ?>

</div>
	
	<?php unset($_SESSION["excepcion"]);
				unset($_SESSION["borrado"]);
				unset($_SESSION["editando"]); ?> <!--para reestablecer el error que salia antes, para evitar que salga siempre -->
	
	
<!--                                                       CONSULTA_EVENTO                                                            -->

</body>
