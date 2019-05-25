<?php
require_once("gestionBD.php");
require_once("gestionarPeticiones.php");
require_once("paginacion_consulta.php");
if (!isset($_SESSION['login'])) {
    Header("Location: login.php");
} else {
	if (isset($_SESSION["PETICION"])) {
		$PETICION = $_SESSION["PETICION"];
		unset($_SESSION["PETICION"]);
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
	$query = "SELECT * from PARTEEQUIPO"; 
	$total_registros = total_consulta($conexion, $query);
    $paginacion["NUMEROREG"]=$total_registros;
    $query = "SELECT * from MATERIALNECESARIO"; 
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
	<button id="myBtn" class="mybtn">Crear Peticion </button>

	<!-- The Modal -->
	
	<div id="myModal" class="modal">

		<!-- Modal content -->
		<div class="modal-content">
			<div class="modal-header">
				<span class="close">&times;</span> <!-- he utilizado bootstrap solo para la X -->
				<h2>Crear Nueva Peticion</h2>
			</div>
			<div class="modal-body">
				<form method="POST" action="Tecnico/controlador_peticiones.php">
				<div><label>Nombre: </label> <select class="form-modal" id="NOMBRE" required name="NOMBRE">
					<option>Altavoces</option>
					<option>Cable</option>
					<option>Foco</option>
                    <option>Mesa Mezclas</option>
                    <option>Microfono</option>
                    <option>Ordenador</option>
                    <option>Pantalla</option>
                    <option>Proyector</option>
				</select></div>
                <label>Cantidad: </label><input type="" id="CANTIDAD" name="CANTIDAD" class="form_modal" />
                <label>PEID: </label><input type="" id="PEID" name="PEID" class="form_modal" />
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














	<!--                                                      	TRATAMIENTO DE EXCEPCIONES                                                            -->
	<?php if (isset($_SESSION["borrado"])) {
		echo "No se puede borrar";
	}
	if (isset($_SESSION["editando"])) {
		echo "No se puede modificar, tenga cuidado con el formato que se requiere";
	}
	if(isset($_SESSION["errormodal"])) {
		echo "No se ha podido solicitar la peticion, ha introducido algún dato inválido";
		$_SESSION["errormodal"]="FALSE";
	}
	if(isset($_SESSION['pagconsult'])) {
		echo "Ha ocurrido un error con la paginación";
	}
	if(isset($_SESSION["fallo"])){
		echo "No se puede introducir un Parte de Equipo que no existe";
		unset($_SESSION["fallo"]);
	}
	?>
	<!--                                                      	TRATAMIENTO DE EXCEPCIONES                                                            -->















	<!--                                                       CONSULTA_EVENTO                                                            -->
	<div class="seccionEntradas">
		<table id="tabla1" style="width:100%">
			<tr>
				<th>IA</th>
				<th>Nombre</th>
                <th>Tipo</th>
                <th>Cantidad</th>
                <th>PEID</th>
                <th>Editar</th>
                <th>Borrar</th>
			</tr>
			<?php
			foreach ($filas as $fila) {
				?>
				<form method="POST" action="Tecnico/controlador_peticiones.php">
					<!-- Controles de los campos que quedan ocultos:
								OID_LIBRO, OID_AUTOR, OID_AUTORIA, NOMBRE, APELLIDOS -->
					<input id="IA" name="IA" type="hidden" value="<?php echo $fila["IA"]; ?>" />
                    <input id="NOMBRE" name="NOMBRE" type="hidden" value="<?php echo $fila["NOMBRE"]; ?>" />
                    <input id="TIPO" name="TIPO" type="hidden" value="<?php echo $fila["TIPO"]; ?>" />
                    <input id="CANTIDAD" name="CANTIDAD" type="hidden" value="<?php echo $fila["CANTIDAD"]; ?>" />
					<input id="PEID" name="PEID" type="hidden" value="<?php echo $fila["PEID"]; ?>" />

					<?php
                    if (isset($PETICION) and ($fila["IA"] == $PETICION["IA"])) { ?>
						<!-- Editando título -->
						<tr>
							<td><input id="IA" name="IA" type="text" value="<?php echo $fila['IA']; ?>" ></td>
                            <td><input id="NOMBRE" name="NOMBRE" type="text" value="<?php echo $fila['NOMBRE']; ?>" ></td>
                            <td><input id="TIPO" name="TIPO" type="text" value="<?php echo $fila['TIPO']; ?>" ></td>
                            <td><input id="CANTIDAD" name="CANTIDAD" type="text" value="<?php echo $fila['CANTIDAD']; ?>" ></td>
                            <td><input id="PEID" name="PEID" type="text" value="<?php echo $fila['PEID'];?>" >   
						<?php } else { ?>
							<!-- mostrando título -->
						<tr>
							<td><?php echo $fila['IA']; ?></td>
                            <td><?php echo $fila['NOMBRE']; ?></td>
                            <td><?php echo $fila['TIPO']; ?></td>
                            <td><?php echo $fila['CANTIDAD']; ?></td>
							<td><?php echo $fila['PEID']; ?></td>


						<?php } ?>

						<?php if (isset($PETICION) and $fila["IA"] == $PETICION["IA"]) { ?>
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