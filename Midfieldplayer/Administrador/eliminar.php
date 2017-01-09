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
      $tabla = $_GET['tabla'];
      $campoTabla = $_GET['campo'];

      $borra = "DELETE FROM $tabla WHERE $campoTabla=$codigo";
      $conexion->exec($borra);
    ?>
  </body>
</html>
