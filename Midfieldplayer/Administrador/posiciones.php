<?php
error_reporting(E_ALL ^ E_NOTICE); //no muestra error de variables indefinida
session_start();// Inicia la sesión
if(!isset($_SESSION['paginas'])) {
    $_SESSION['paginas'] = 1;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>MilField Player</title>
    <link rel="shortcut icon" type="image/png" href="../imagen/logo.png"/>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/jquery.validate.js"></script>
    <!-- Todos los plugins JavaScript de Bootstrap (también puedes
    incluir archivos JavaScript individuales de los únicos
    plugins que utilices) -->
    <script src="../bootstrap/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <!--Estos dos enlaces son para el cuadro de dialogo-->
    <script src="../js/jquery-ui.js"></script>
    <script src="../js/funciones.js"></script>
    <link rel="stylesheet" href="../js/jquery-ui.css">
    <!--bootstrap-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS de Bootstrap -->
    <link href="../bootstrap/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <!--css propio-->
    <link href="../css/estilos.css" rel="stylesheet"> 
  </head>
  <body>
    <?php
      //comprueba si se establece conexion con mysql
      //incluye la conexion con la base de datos
      include '../ConexionBD.php';
    ?>
      <div id="logo" class="col-xs-12 col-sm-12 col-md-12">
        <a href="../menu.php"><img src="../imagen/logo.png" name="MidField Player" alt="MidField Player" width="100" ></a>
      </div>
    <?php
      //deja acceder si estas logueado
      if($_SESSION['logueado'] == true && $_SESSION['tipoUsuario'] == "administrador"){
    ?>
         <!--barra de navegacion -->
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="../menu.php"><span class="glyphicon glyphicon-home"></span> MilField Player</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li><a href="jugadores.php"><span class="glyphicon glyphicon-user"></span> Jugadores</a></li>
                <li><a href="equipos.php"><span class="glyphicon glyphicon-copy"></span> Equipos</a></li>
                <li class="active"><a href="posiciones.php"><span class="glyphicon glyphicon-transfer"></span> Posiciones</a></li>
                <li><a href="nacionalidad.php"><span class="glyphicon glyphicon-list"></span> Nacionalidades</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> <?=$_SESSION['usuario']?> <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li style="text-align: center;"><a href="../index.php">Salir <span class="glyphicon glyphicon-remove"></span></a></li>
                  </ul>
                </li>
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
    <?php        
        //con esto se realiza una consulta
      $listadoPosicion = "select * from posicion ";
      $consulta = $conexion->query($listadoPosicion);  
    ?>
      <!--crea una tabla con los datos-->
      <div class="col-xs-12 col-sm-12 col-md-12">
        <h1 id="tituloAdmin">Posiciones</h1>
      </div>
      Busqueda avanzada <input type="text" data-tabla="posicion" id="buscar" value=""></br>
      Ordenar codigo: <select id="ordenar">
        <option value="asc" selected>Ascendente</option>
        <option value="desc">descendente</option>
      </select>
      <div id="listado">
        <?php
        include './listadoposiciones.php';
        ?>
      </div>
      <div id="dialogoborrar" title="¿Desea borrar?">
        <p>¿Estas seguro de que deseas borrarlo?</p>
      </div>
      <!--Cuadro de dialogo modificar-->
      <div id="dialogomodificar" title="Modificar Posicion">
        <form  id="formulario" action="posiciones.php" method="POST">
          <div class="form-group">
            <b><label for="codigoId">Codigo Posicion</label><br>
                <input type="number" class="form-control" name="codpos" id="codigoId" min="1" step="1" autocomplete required readonly="readonly"></b>
          </div>
          <div class="form-group">
            <b><label for="nombreId">Posicion</label><br>
                <input type="text" class="form-control" name="posicion" id="nombreId" required></b>
          </div>
        </form>
      </div>
      <script>
        $("#formulario").validate({
            rules: {
              codpos: {
                required: true
              },
              posicion: {
                required: true
              }
            },
            messages: {
              codpos: {
                required: "Codigo de Posicion requerido"
              },
              posicion: {
                required: "Posicion requerida"
              }
            }
        });
      </script>
      
      <!--boton añadir-->
      <button id="anadir" class="btn btn-info botonAnadir" data-tabla="posicion" data-campo="codnpos"><span class="glyphicon glyphicon-plus"></span></button>

      <!--------termina cuadro de dialogo---------->
     
      <div class="col-xs-12 col-sm-12 col-md-12">
        <button class="btn btn-default">
          <span class="glyphicon glyphicon-repeat"></span>
          <a href="../menu.php" id="botonVolver"> Volver</a>
        </button>
      </div>
    <?php  
      } else {
        echo "logueate";
      }     
    ?>
  </body>
</html>
