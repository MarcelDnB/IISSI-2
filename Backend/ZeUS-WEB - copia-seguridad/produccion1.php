<?php
	session_start();

	require_once("gestionBD.php");
	require_once("gestionarEvento.php");
	
	if (isset($_SESSION["evento"])){
		$evento = $_SESSION["evento"];
		unset($_SESSION["evento"]);
	}

	$conexion = crearConexionBD();
	$filas = consultarTodosEventos($conexion);
	cerrarConexionBD($conexion);
?>







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
        <li><a href="#">Eventos</a></li>
        <li>Lista</li>
      </ul> 
  <label id="prod" class="prod">Departamento de Produccion</label>










<!--                                                       CONSULTA_EVENTO                                                            -->
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
						<label><b>Fecha de Inicio:</b> <?php echo $fila['FECHAINICIO'];?></label><label><b> Fecha Fin: </b><?php echo $fila['FECHAFIN'] ?></label>
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
	<?php } ?>
<!--                                                       CONSULTA_EVENTO                                                            -->
























  <button onclick="myFunction2('Demo1')" class="acc-button pp1">Eventos</button>
  <div id="Demo1" class="acc-hide acc-show">
    <a class="acc-button" href="#">Lista</a>
    <a class="acc-button" href="#">Agregar</a>
    <a class="acc-button" href="#">Alojamiento</a>
    <a class="acc-button" href="#">Transporte</a>
  </div>
  <button onclick="myFunction('Demo2')" class="acc-button "> Alquiler</button>
  <div id="Demo2" class="acc-hide">
    <a class="acc-button" href="#">Material</a>
    <a class="acc-button" href="#">Personal</a>
  </div>
  <button onclick="myFunction('Demo3')" class="acc-button"> Personal</button>
  <div id="Demo3" class="acc-hide">
    <a class="acc-button" href="#">Lista</a>
    <a class="acc-button" href="#">Contactar</a>
  </div>

</body>
</html>