<?php
	session_start();
	require_once("gestionBD.php");
	require_once("produccion/gestionarEvento.php");
	require_once("paginacion_consulta.php");
	if (!isset($_SESSION['login'])) {
		Header("Location: login.php");
	}else {
	

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ZeUS - Almacén</title>
    <!--Hoja de estilo-->
    <link rel="stylesheet" type="text/css" media="screen" href="css/estilos.css">
    <!--jQuery-->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <!--Fuente-->
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <!--Iconos-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" crossorigin="anonymous"/>
    
    <link rel="stylesheet" href="css/prod1.css">
		<link rel="stylesheet" href="css/modal.css">
		<script src="js/prod1.js"></script> 
</head>

<body>
	
	<?php
		include_once("sidebar.php");
		include_once("barrafija.php");
	?>
	<div class="contenido abrir">	<!--Caben 11 párrafos Lorem Ipsum sin hacr scroll-->	 <!-- Hay q de alguna manera, incorporar las otras paginas de produccion aqui sin necesidad de tener este codigo en cada una -->
    
    <?php 

    if (isset($_GET["eventos"]) || ($_SESSION["localidad"] == "evento")){
        include_once("produccion/produccion1.php");
    }
    if (isset($_GET["alojamiento"]) || ($_SESSION["localidad"] == "alojamiento")) {
        include_once("produccion/produccion2.php");
    }
    if (isset($_GET["transporte"]) || ($_SESSION["localidad"] == "transporte")) {
        include_once("produccion/produccion3.php");
    }
    if (isset($_GET["material"]) || ($_SESSION["localidad"] == "material")) {
        include_once("produccion/produccion4.php");
    }
    if (isset($_GET["personal"]) || ($_SESSION["localidad"] == "personal")) {
        include_once("produccion/produccion5.php");
    }


    ?>
</div>
	<script src="js/main.js"></script>
</body>
</html>
<?php } ?>