<?php
	session_start();

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
	$query = 'SELECT * from TRANSPORTE';

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
    <script src="js/prod1.js"></script> 

    <title>Departamento de Produccion</title>
</head>
<body>

    <ul class="breadcrumb">
        <li><a href="#">Transporte</a></li>
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

				<a href="produccion3.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

	<?php } ?>

</div>



<form method="get" action="produccion3.php">

	<input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>

	Mostrando

	<input id="PAG_TAM" name="PAG_TAM" type="number"

		min="1" max="<?php echo $total_registros; ?>"

		value="<?php echo $pag_tam?>" autofocus="autofocus" />

	entradas de <?php echo $total_registros?>

	<input type="submit" value="Cambiar">

</form>

</nav>
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
		<form method="post" action="controlador_transporte.php">

						<input id="TID" name="TID" type="hidden"
						value="<?php echo $fila["TID"];?>"/>
						<input id="MEDIOUTILIZADO" name="MEDIOUTILIZADO" type="hidden"
						value="<?php echo $fila["MEDIOUTILIZADO"];?>"/>
						<input id="NUMPERSONAS" name="NUMPERSONAS" type="hidden"
          	 value="<?php echo $fila["NUMPERSONAS"];?>"/>
            <input id="EID" name="EID" type="hidden"
						value="<?php echo $fila["EID"];?>"/>
				<?php
				
				if (isset($transporte) and ($transporte["TID"] == $fila["TID"])) { ?>
						<!-- Editando título -->
						<label><b>Transporte: </b><?php echo $fila['TID'];?></label>
						<label><b> Medio utilizado: </b></label><input id="MEDIOUTILIZADO" name="MEDIOUTILIZADO" type="text" value="<?php echo $fila['MEDIOUTILIZADO'];?>"/>
						<label><b> Numero de personas: </b><input id="NUMPERSONAS" name="NUMPERSONAS" type="text" value="<?php echo $fila['NUMPERSONAS'];?>"/>

						<label><b>Evento: </b></label><input id="EID" name="EID" type="text" value="<?php echo $fila['EID'];?>"/>
					
						<?php }	else { ?>

						<!-- mostrando título -->	
						<input id="MEDIOUTILIZADO" name="MEDIOUTILIZADO" type="hidden" value="<?php echo $fila['MEDIOUTILIZADO'];?>"/>
						<input id="NUMPERSONAS" name="NUMPERSONAS" type="hidden" value="<?php echo $fila['NUMPERSONAS'];?>"/>
						<input id="EID" name="EID" type="hidden" value="<?php echo $fila['EID'];?>"/>
					  <div class="titulo"><label><b>Transporte: </b><?php echo $fila['TID'];?></label><label><b> Medio utilizado: </b><?php echo $fila['MEDIOUTILIZADO'];?></label>
						<label><b>Numero de personas:</b> <?php echo $fila['NUMPERSONAS'];?></label>
						<label><b>Evento: </b> <?php echo $fila['EID'];?></label>
						
				<?php } ?>
            
            <div>

				<?php if (isset($transporte) and ($transporte["TID"] == $fila["TID"])) { ?>
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