<?php
	session_start();
	require_once("gestionBD.php");
	require_once("gestionarEvento.php");
	require_once("paginacion_consulta.php");
	if (!isset($_SESSION['login'])) {
		Header("Location: login.php");
	}else {
	if (isset($_SESSION["EVENTO"])){
		$evento = $_SESSION["EVENTO"];
		unset($_SESSION["EVENTO"]);
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
	$query = 'SELECT * from EVENTO';

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
<div id="enlaces">

	<?php

		for( $pagina = 1; $pagina <= $total_paginas; $pagina++ )

			if ( $pagina == $pagina_seleccionada) { 	?>

				<span class="current"><?php echo $pagina; ?></span>

	<?php }	else { ?>

				<a href="pagina.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

	<?php } ?>

</div>



<form method="get" action="pagina.php">

	<input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>

	Mostrando

	<input id="PAG_TAM" name="PAG_TAM" type="number"

		min="1" max="<?php echo $total_registros; ?>"

		value="<?php echo $pag_tam?>" autofocus="autofocus" />

	entradas de <?php echo $total_registros?>

	<input type="submit" value="Cambiar" class="subpaginacion">

</form>

</nav>
<!--                                                      	 PAGINACION                                                           -->

<!--                                                      	MODAL_FORM                                                            -->
<!-- Trigger/Open The Modal -->
<button id="myBtn" class="mybtn">Añadir Evento </button>
<?php if(isset($_SESSION["grabar"]) && isset($_SESSION["excepcion"])) {
				echo "Ha introducido algun dato mal";
}else {
			unset($_SESSION["excpcion"]);
			unset($_SESSION["hayono"]);
} ?>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
      <div class="modal-header">
          <span class="close">&times;</span>
          <h2>Añadir Evento</h2>
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
			<th>Evento</th>
			<th>Precio</th>
			<th>Fecha de Inicio</th>
			<th>Fecha Fin</th>
			<th>Estado</th>
			<th>Descripcion del cliente</th>
			<th>Lugar</th>
			<th>Editar</th>
			<th>Borrar</th>
			</tr>	
	<?php
		foreach($filas as $fila) {
	?>
		<form method="post" action="controlador_evento.php">
					<!-- Controles de los campos que quedan ocultos:
						OID_LIBRO, OID_AUTOR, OID_AUTORIA, NOMBRE, APELLIDOS -->
						<input id="EID" name="EID" type="hidden"
						value="<?php echo $fila["EID"];?>"/>
						<input id="PRECIOTOTAL" name="PRECIOTOTAL" type="hidden"
						value="<?php echo $fila["PRECIOTOTAL"];?>"/>
						<input id="LUGAR" name="LUGAR" type="hidden"
						value="<?php echo $fila["LUGAR"];?>"/>
						<input id="FECHAINICIO" name="FECHAINICIO" type="hidden"
						value="<?php echo $fila["FECHAINICIO"];?>"/>
						<input id="FECHAFIN" name="FECHAFIN" type="hidden"
						value="<?php echo $fila["FECHAFIN"];?>"/>
						<input id="DESCRIPCIONCLIENTE" name="DESCRIPCIONCLIENTE" type="hidden"
						value="<?php echo $fila["DESCRIPCIONCLIENTE"];?>"/>
						<input id="ESTADOEVENTO" name="ESTADOEVENTO" type="hidden"
						value="<?php echo $fila["ESTADOEVENTO"];?>"/>
				<?php
					if (isset($evento) and ($fila["EID"] == $evento["EID"])) { ?>
						<!-- Editando título -->
						<tr>
						<td><input id="EID" name="EID" type="text" value="<?php echo $fila['EID'];?>"/></td>
						<td><input id="PRECIOTOTAL" name="PRECIOTOTAL" type="text" value="<?php echo $fila['PRECIOTOTAL'];?>"/></td>
						<td><input id="FECHAINICIO" name="FECHAINICIO" type="text" value="<?php echo $fila['FECHAINICIO'];?>"/></td>
						<td><input id="FECHAFIN" name="FECHAFIN" type="text" value="<?php echo $fila['FECHAFIN'];?>"/></td>
						<td><input id="ESTADOEVENTO" name="ESTADOEVENTO" type="text" value="<?php echo $fila['ESTADOEVENTO'];?>"/></td>
						<td><input id="DESCRIPCIONCLIENTE" name="DESCRIPCIONCLIENTE" type="text" value="<?php echo $fila['DESCRIPCIONCLIENTE'];?>"/></td>
						<td><input id="LUGAR" name="LUGAR" type="text" value="<?php echo $fila['LUGAR'];?>"/>	</td>
						<?php }	else { ?>
						<!-- mostrando título -->	
						<tr>
						<td><?php echo $fila['EID'];?></td>
						<td><?php echo $fila['PRECIOTOTAL'];?></td>
						<td><?php echo $fila['FECHAINICIO'];?></td>
						<td><?php echo $fila['FECHAFIN'] ?></td>
						<td> <?php echo $fila['ESTADOEVENTO'];?></td>
						<td><p><?php echo $fila['DESCRIPCIONCLIENTE'];?></p></td>
						<td><?php echo $fila['LUGAR']?></td>

				<?php } ?>
				
				<?php if (isset($evento) and $fila["EID"] == $evento["EID"]) { ?>
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
<!--                                                       CONSULTA_EVENTO                                                            -->

</body>