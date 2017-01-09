<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
  <head>
    <meta charset="UTF-8">
    <title>MilField Player</title>
    <link rel="shortcut icon" type="image/png" href="imagen/logo.png"/>
  </head>
  <body>
    <?php
     //comprueba si se establece conexion con mysql
      //incluye la conexion con la base de datos
      include '../ConexionBD.php';
    
      $codigo = $_GET['codigo'];
      $nombre = $_GET['nombre'];
      $equipo = $_GET['equipo'];
      $dorsal = $_GET['dorsal'];
      $edad = $_GET['edad'];
      $altura = $_GET['altura'];
      $peso = $_GET['peso'];
      $nacionalidad = $_GET['nacionalidad'];
      $posicion = $_GET['posicion'];
      

      $modificacion = "UPDATE jugadores SET nomjug='$nombre', equipojug='$equipo', dorsaljug='$dorsal', edadjug='$edad', alturajug='$altura', pesojug='$peso',"
              . "codnac='$nacionalidad', codpos='$posicion' WHERE codjug=" .$codigo;
      $conexion->exec($modificacion);
    ?>
  </body>
</html>
