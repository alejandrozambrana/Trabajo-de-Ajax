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
    
      $codigo = $_POST['codigo'];
      $tabla = $_POST['tabla'];
      $campoTabla = $_POST['campo'];
      $nombre = $_POST['nombre'];

      $buscaCodigo = 'SELECT * FROM ' .$tabla. ' WHERE '.$campoTabla.' = '.$codigo;
      $consulta = $conexion -> query($buscaCodigo); 

      if ($consulta ->rowCount() == 1) {
        echo '<script type="text/javascript">alert("Lo siento, ya existe una nacionalidad con ese código en la base de datos");</script>';
      } else {
       $inserta = "INSERT INTO " .$tabla. " VALUES (\"$codigo\", \"$nombre\")";
       $conexion->exec($inserta);
      }
    ?>
  </body>
</html>
