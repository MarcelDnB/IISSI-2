<?php
	session_start();

	require_once("gestionBD.php");
	require_once("gestionarEvento.php");
	
	else{
	if (isset($_SESSION["evento"])){
		$evento = $_SESSION["evento"];
		unset($_SESSION["evento"]);
	}
}

	$conexion = crearConexionBD();
	$filas = consultarTodosEventos($conexion);
	cerrarConexionBD($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Gestión de biblioteca: Lista de Libros</title>
</head>
<body>
<main>
	<?php
		foreach($filas as $fila) {
	?>
	<article class="libro">
		<form method="post" action="controlador_evento.php">
			<div class="fila_libro">
				<div class="datos_libro">
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
						<div class="titulo"><b>Evento: </b><?php echo $fila['EID'];?><b> Precio: </b><?php echo $fila['PRECIOTOTAL'];?><b> Lugar: </b><?php echo $fila['LUGAR'].''.$fila['LUGAR'];?>
				<?php } ?>
						<b>Fecha de Inicio:</b> <?php echo $fila['FECHAINICIO'];?><b> Fecha Fin: </b><?php echo $fila['FECHAFIN'] ?>
						<b>Estado:</b> <?php echo $fila['ESTADOEVENTO'];?><b> Descripcion del cliente: </b> <?php echo $fila['DESCRIPCIONCLIENTE'];?>


				<?php if (isset($evento) and $fila["eid"] == $evento["eid"]) { ?>
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
					</div>
				</div>
		</form>
	</article>
	<?php } ?>
</main>
</body>
</html>