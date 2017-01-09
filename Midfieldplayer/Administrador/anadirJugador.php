<!DOCTYPE html>
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
    
      $tabla = $_POST['tabla'];
      $nombre = $_POST['nombre'];
      $equipo = $_POST['equipo'];
      $dorsal = $_POST['dorsal'];
      $edad = $_POST['edad'];
      $altura = $_POST['altura'];
      $peso = $_POST['peso'];
      $nacionalidad = $_POST['nacionalidad'];
      $posicion = $_POST['posicion'];

      $inserta = "INSERT INTO " .$tabla. " (`nomjug`, `equipojug`, `dorsaljug`, `edadjug`, `alturajug`, `pesojug`, `codnac`, `codpos`) "
              . "VALUES (\"$nombre\", \"$equipo\", \"$dorsal\", \"$edad\", \"$altura\", \"$peso\", \"$nacionalidad\", \"$posicion\")";
      $conexion->exec($inserta);
    ?>
  </body>
</html>
