<?php
	session_start();

	require_once("gestionBD.php");
	require_once("gestionarEvento.php");
	require_once("paginacion_consulta.php");
	if (!isset($_SESSION['login'])) {
		Header("Location: login.php");
	}else {
	if (isset($_SESSION["evento"])){
		$evento = $_SESSION["evento"];
		unset($_SESSION["evento"]);
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






<!DOCTYPE html>
<html lang="en" class="html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="css/prod1.css">
		<link rel="stylesheet" href="css/modal.css">
		<script src="js/prod1.js"></script> 
    <title>Departamento de Produccion</title>
</head>
<body>

    <ul class="breadcrumb">
        <li><a href="#">Eventos</a></li>
        <li></li>
      </ul> 
	<label id="prod" class="prod">Departamento de Produccion</label><br><br><br><br>


	
	<!--                                                      	 PAGINACION                                                           -->
<nav>
<div id="enlaces">

	<?php

		for( $pagina = 1; $pagina <= $total_paginas; $pagina++ )

			if ( $pagina == $pagina_seleccionada) { 	?>

				<span class="current"><?php echo $pagina; ?></span>

	<?php }	else { ?>

				<a href="produccion1.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

	<?php } ?>

</div>



<form method="get" action="produccion1.php">

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

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
      <div class="modal-header">
          <span class="close">&times;</span>
          <h2>Añadir Evento</h2>
        </div>
    <div class="modal-body">
      <form>
        <div><label>Lugar: </label> <input type="text" id="modal" class="form-modal"></div>
				<div><label>Fecha de Inicio: </label> <input type="date" id="finicio" class="form-modal"></div>
				<div><label>Fecha de Fin: </label> <input type="date" id="ffin" class="form-modal"></div>
				<div><label>Precio Total: </label> <input type="text" id="preciototal" class="form-modal"></div>
        <div><label>Descripcion: </label> <input type="text" id="descripcion" class="form-modal"></div>
        <div><input type="submit" id="form-modal" formaction="www.meme.com" value="Añadir" class="btn"></div>

      </form>
    </div>
	</div>
	</div>
	<script src="js/modal.js"></script> 
<!--                                                      	MODAL_FORM                                                            -->

<!--                                                      	PAGINACION                                                            -->

<!--                                                      	CUADRITO                                                            -->
<div class="cuadrito">
  <button class="acc-button" onclick="window.location='produccion1.php'">Eventos</button>
	<button class="acc-button" onclick="window.location='produccion2.php'">Alojamiento</button>
	<button class="acc-button" onclick="window.location='produccion3.php'">Transporte</button>
	<button class="acc-button" onclick="window.location='produccion4.php'">Material</button>
	<button class="acc-button" onclick="window.location='produccion5.php'">Personal</button>
	</div>
<!--                                                      	CUADRITO                                                            -->

<!--                                                       CONSULTA_EVENTO                                                            -->
	<div class="seccionEntradas">
	<?php
		foreach($filas as $fila) {
	?>
	<article class="evento">
		<form method="post" action="controlador_evento.php">
					<!-- Controles de los campos que quedan ocultos:
						OID_LIBRO, OID_AUTOR, OID_AUTORIA, NOMBRE, APELLIDOS -->
						<input id="EID" name="EID" type="hidden"
						value="<?php echo $fila["EID"];?>"/>
						<input id="PRECIOTOTAL" name="PRECIOTOTAL" type="hidden"
						value="<?php echo $fila["preciototal"];?>"/>
						<input id="LUGAR" name="LUGAR" type="hidden"
						value="<?php echo $fila["LUGAR"];?>"/>
				<?php
					if (isset($evento) and ($fila["EID"] == $evento["EID"])) { ?>
						<!-- Editando título -->
						<input id="PRECIOTOTAL" name="PRECIOTOTAL" type="text" value="<?php echo $fila['PRECIOTOTAL'];?>"/>
						<h4><?php echo $fila["LUGAR"] . " " . $fila["LUGAR"]; ?></h4>
						<?php }	else { ?>
						<!-- mostrando título -->	
						<input id="PRECIOTOTAL" name="PRECIOTOTAL" type="hidden" value="<?php echo $fila['PRECIOTOTAL'];?>"/>
					  <div class="titulo"><label><b>Evento: </b><?php echo $fila['EID'];?></label><label><b> Precio: </b><?php echo $fila['PRECIOTOTAL'];?></label>
				<?php } ?>
						z	<label><b>Fecha de Inicio:</b> <?php echo $fila['FECHAINICIO'];?></label><label><b> Fecha Fin: </b><?php echo $fila['FECHAFIN'] ?></label>
						<label><b>Estado:</b> <?php echo $fila['ESTADOEVENTO'];?></label>
            <div>
            <label><b> Descripcion del cliente: </b> <?php echo $fila['DESCRIPCIONCLIENTE'];?></label>
            </div>  
            <div>
            <label><b> Lugar: </b><?php echo $fila['LUGAR'].''.$fila['LUGAR'];?></label>
            </div>
				<?php if (isset($evento) and $fila["EID"] == $evento["EID"]) { ?>
						<button id="grabar" name="grabar" type="submit" class="editar_fila">
						<img src="images/bag_menuito.bmp" class="editar_fila" alt="Guardar Cambios">
					</button>
				<?php } else {?>
					<button id="editar" name="editar" type="submit" class="editar_fila">
						<img src="images/pencil_menuito.bmp" class="editar_fila" alt="Editar Libro">
					</button>
				<?php } ?>
				<button id="borrar" name="borrar" type="submit" class="editar_fila">
						<img src="images/remove_menuito.bmp" class="editar_fila" alt="Borrar Libro">
					</button>
		</form>
	</article>
	<div>
	<?php } ?>
<!--                                                       CONSULTA_EVENTO                                                            -->






</body>
</html>