<?php
	session_start();
    require_once("gestionBD.php");
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
    <title>ZeUS</title>
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

<body id="body22">
	
	<?php
		include_once("sidebar.php");
		include_once("barrafija.php");
	?>
	<div class="contenido">	<!--Caben 11 párrafos Lorem Ipsum sin hacr scroll-->	 <!-- Hay q de alguna manera, incorporar las otras paginas de produccion aqui sin necesidad de tener este codigo en cada una -->
    
    <?php
if($_SESSION['consultarproduccion'] == 1) { //Para produccion

    if (($_SESSION["localidad"] == "evento")){
        include_once("produccion/produccion1.php");
    }
    else if (($_SESSION["localidad"] == "alojamiento")) {
        include_once("produccion/produccion2.php");
    }
    else if ( ($_SESSION["localidad"] == "transporte")) {
        include_once("produccion/produccion3.php");
    }
    else if ( ($_SESSION["localidad"] == "material")) {
        include_once("produccion/produccion4.php");
    }
    else if (($_SESSION["localidad"] == "personal")) {
        include_once("produccion/produccion5.php");
    }else {

    }
}
if($_SESSION['consultartecnico']==1){
    if(($_SESSION['localidad']=="eventoTecnico")){
        include_once("tecnico/tecnico.php");
    }
    else if(($_SESSION['localidad']=="parteEquipo")){
        include_once("tecnico/tecnico2.php");
    }
    else if(($_SESSION['localidad']=="peticion")){
        include_once("tecnico/tecnico3.php");
    }
    else if(($_SESSION['localidad']=="personalTecnico")){
        include_once("tecnico/tecnico4.php");
    }else{
        include_once("tecnico/tecnico.php");
    }
}

if($_SESSION['consultaralmacen'] == 1) {    //Para almacén
    if (($_SESSION["localidad"] == "inventario")){
        include_once("almacen/consulta_inventario.php");
    }
    else if (($_SESSION["localidad"] == "altavoces")) {
        include_once("almacen/consulta_altavoces.php");
    }
    else if (($_SESSION["localidad"] == "focos")) {
        include_once("almacen/consulta_focos.php");
    }
    else if (($_SESSION["localidad"] == "envios")) {
        include_once("almacen/consulta_envios.php");
    }
    else if (($_SESSION["localidad"] == "itemsalquilados")) {
        include_once("almacen/consulta_itemsalquilados.php");
    }
    else if (($_SESSION["localidad"] == "mantenimiento")) {
        include_once("almacen/consulta_mantenimiento.php");
    }
    else if (($_SESSION["localidad"] == "personal")) {
        include_once("almacen/consulta_personalalmacen.php");
    }
    else if (($_SESSION["localidad"] == "parte")){
	include_once("almacen/consulta_parte.php");
    }
    else{
	include_once("almacen/consulta_inventario.php");
    }
}
?>
</div>
	<script src="js/toggleSidebar.js"></script>
</body>

</html>
<?php } ?>
