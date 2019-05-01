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
	<div class="contenido abrir">	<!--Caben 11 párrafos Lorem Ipsum sin hacr scroll-->	
	<div class="produccion">
    <?php include_once("produccion1.php");?>
    </div>
    
</div>
	<script src="js/main.js"></script>
</body>
</html>