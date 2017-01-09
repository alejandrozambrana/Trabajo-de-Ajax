<?php
error_reporting(E_ALL ^ E_NOTICE); //no muestra error de variables indefinida
session_start(); // Inicia la sesión
if (!isset($_SESSION['paginas'])) {
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
    <script src="../js/funciones.js"></script>
    <!--Estos dos enlaces son para el cuadro de dialogo-->
    <link rel="stylesheet" href="../js/jquery-ui.css">
    <script src="../js/jquery-ui.js"></script>
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
    if ($_SESSION['logueado'] == true && $_SESSION['tipoUsuario'] == "administrador") {
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
              <li class="active"><a href="jugadores.php"><span class="glyphicon glyphicon-user"></span> Jugadores</a></li>
              <li><a href="equipos.php"><span class="glyphicon glyphicon-copy"></span> Equipos</a></li>
              <li><a href="posiciones.php"><span class="glyphicon glyphicon-transfer"></span> Posiciones</a></li>
              <li><a href="nacionalidad.php"><span class="glyphicon glyphicon-list"></span> Nacionalidades</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> <?= $_SESSION['usuario'] ?> <span class="caret"></span></a>
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
      $listadoJugadores = "select * from jugadores ";
      $consulta = $conexion->query($listadoJugadores);
      ?>
      <!--crea una tabla con los datos-->
      <div class="col-xs-12 col-sm-12 col-md-12">
        <h1 id="tituloAdmin">Jugadores</h1>
      </div>
      Busqueda avanzada <input type="text" data-tabla="jugadores" id="buscar" value=""></br>
      Ordenar codigo: <select id="ordenar">
        <option value="asc" selected>Ascendente</option>
        <option value="desc">descendente</option>
      </select>
      <div id="listado">
        <?php
        include './listadojugadores.php';
        ?>
      </div>
      <div id="dialogoborrar" title="¿Desea borrar?">
        <p>¿Estas seguro de que deseas borrarlo?</p>
      </div>

      <!--Cuadro de dialogo modificar-->
      <div id="dialogomodificar" title="Modificar Jugador">
        <table>
          <form  id="formularioJugadores" action="jugadores.php" method="POST">
            <div class="form-group">
              <tr><td><b><label for="codigoId">Codigo</label><br>
                    <input type="number" class="form-control" name="codjug" id="codigoId" min="1" step="1" autocomplete required readonly="readonly"></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for="nombreId">Nombre</label><br>
                    <input type="text" class="form-control" name="nomjug" id="nombreId" required></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for=equipoId">Equipo</label><br>
                    <select name="equipojug" class="form-control" id="equipoId" required>
                      <?php
                      //saca la nacionalidad
                      $listadoEquipos = "SELECT * FROM equipo";
                      $consulta = $conexion->query($listadoEquipos);
                      while ($equipos = $consulta->fetchObject()) {
                        ?>
                      <option value="<?= $equipos->codequi ?>"><?= $equipos->nomequi ?></option>
                        <?php
                      }
                      ?>
                    </select></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for="dorsalId">Dorsal</label><br>
                    <input type="text" class="form-control" name="dorsaljug" id="dorsalId" required></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for="edadId">Edad</label><br>
                    <input type="text" class="form-control" name="edadjug" id="datepicker" required></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for="alturaId">Altura</label><br>
                    <input type="text" class="form-control" name="alturajug" id="alturaId" required></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for="pesoId">Peso</label><br>
                    <input type="text" class="form-control" name="pesojug" id="pesoId" required></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for="nacionalidadId">Nacionalidad</label><br>
                    <select name="codnac" class="form-control" id="nacionalidadId" required>
                      <?php
                      //saca la nacionalidad
                      $listadoNacionalidad = "SELECT * FROM nacionalidad";
                      $consulta = $conexion->query($listadoNacionalidad);
                      while ($nacionalidad = $consulta->fetchObject()) {
                        ?>
                        <option value="<?= $nacionalidad->codnac ?>"><?= $nacionalidad->pais ?></option>
                        <?php
                      }
                      ?>
                    </select></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for="posicionId">Posicion</label><br>
                    <select name="codpos" class="form-control" id="posicionId" required>
                      <?php
                      //saca las posiciones
                      $listadoPosiciones = "SELECT * FROM posicion";
                      $consulta = $conexion->query($listadoPosiciones);
                      while ($posicion = $consulta->fetchObject()) {
                        ?>
                        <option value="<?= $posicion->codpos ?>"><?= $posicion->posicion ?></option>
                        <?php
                      }
                      ?>
                    </select></b></td></tr>      
            </div>
          </form>
        </table>
      </div>

      <!--boton añadir-->
      <button id="anadir" class="btn btn-info botonAnadir" data-tabla="jugadores" data-campo="codjug"><span class="glyphicon glyphicon-plus"></span></button>

      <!--Cuadro de dialogo añadir-->
      <div id="cuadroAñadir" title="Añadir Jugador" hidden>
        <table>
          <form action="jugadores.php" method="POST">
            <div class="form-group">
              <tr><td><b><label for="nombreId">Nombre jugador</label><br>
                    <input type="text" class="form-control" name="nomjug" id="nombreId" autocomplete required></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for="equipoId">Equipo</label><br>
                    <select name="equipojug" class="form-control" id="equipoId" required>
                      <?php
                      //saca los equipos
                      $listadoequipos = "SELECT * FROM equipo";
                      $consulta = $conexion->query($listadoequipos);
                      while ($equipo = $consulta->fetchObject()) {
                        ?>
                        <option value="<?= $equipo->codequi ?>"><?= $equipo->nomequi ?></option>
                        <?php
                      }
                      ?>
                    </select></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for="dorsalId">Dorsal</label><br>
                    <input type="number" class="form-control" name="dorsaljug" maxlength="2" min="1" step="1" id="dorsalId"></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for="edadId">Edad</label><br>
                    <input type="number" class="form-control" name="edadjug" maxlength="2" min="10" step="1" id="edadId"></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for="alturaId">Altura</label><br>
                    <input type="number" class="form-control" name="alturajug" maxlength="3" min="140" step="1" id="alturaId"></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for="pesoId">Peso</label><br>
                    <input type="number" class="form-control" name="pesojug" maxlength="2" min="50" step="1" id="pesoId"></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for="nacionalidadId">Nacionalidad</label><br>
                    <select name="codnac" class="form-control" id="nacionalidadId" required>
                      <?php
                      //saca la nacionalidad
                      $listadoNacionalidad = "SELECT * FROM nacionalidad";
                      $consulta = $conexion->query($listadoNacionalidad);
                      while ($nacionalidad = $consulta->fetchObject()) {
                        ?>
                        <option value="<?= $nacionalidad->codnac ?>"><?= $nacionalidad->pais ?></option>
                        <?php
                      }
                      ?>
                    </select></b></td></tr>
            </div>
            <div class="form-group">
              <tr><td><b><label for="posicionId">Posicion</label><br>
                    <select name="codpos" class="form-control" id="posicionId" required>
                      <?php
                      //saca las posiciones
                      $listadoPosiciones = "SELECT * FROM posicion";
                      $consulta = $conexion->query($listadoPosiciones);
                      while ($posicion = $consulta->fetchObject()) {
                        ?>
                        <option value="<?= $posicion->codpos ?>"><?= $posicion->posicion ?></option>
                        <?php
                      }
                      ?>
                    </select></b></td></tr>
            </div>
            <tr><td><button class="btn btn-info botonCuadroAnadir" type="submit" name="accion" value="anadirJugador">Añadir
                  <span class="glyphicon glyphicon-send"></span>
                </button></td></tr>
          </form>
        </table>
      </div>
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
