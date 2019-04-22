<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Departamento de Produccion</title>
    <link rel="stylesheet" href="css/prod1.css">
    <script src="js/prod1.js"></script>
</head>
<body>
<ul class="breadcrumb">
        <li><a href="#">Eventos</a></li>
        <li>Agregar</li>
      </ul> 
  <label id="prod" class="prod">Departamento de Produccion</label>

<form class="form">
    <div><label>Lugar: </label><input type="text" id="lugar" name="lugar"></div>
    <div><label>Fecha Incio: </label><input type="date" id="fechainicio" name="fechainicio"></div>
    <div><label>Fecha Fin: </label><input type="date" id="fechafin" name="fechafin"></div>
    <div><label>Descripcion: </label><input type="text" id="descripcion" name="descripcion"></div>
    <div><label>Precio: </label><input type="text" id="precio" name="precio"></div>
    <div><input type="button" type="submit" id="submit" name="submit" value="Agregar">
    <input type="button" id="cancelar" name="cancelar" value="Cancelar"></div>
    
</form>















  <button onclick="myFunction2('Demo1')" class="acc-button pp2">Eventos</button>
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