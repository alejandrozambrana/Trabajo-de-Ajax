<?php
error_reporting(E_ALL ^ E_NOTICE); //no muestra error de variables indefinida
session_start(); // Inicia la sesión
//incluye la conexion con la base de datos
include '../ConexionBD.php';

//Constante con el número de regitros por página:
$numFilaPorPag = 5;
$paginaactual = 1;

//En caso de que no me llegen parámetros de paginación
//Inicializamos valores de la paginación como página 1
if (empty($_GET["page"]) || ($_GET["page"] == 1)) {
  $pagcomienzo = 0;
} else {
  $pagcomienzo = (($_GET["page"] - 1) * $numFilaPorPag);
  $paginaactual = $_GET["page"];
}

//con esto se realiza una consulta
$listadojugadores = "select * from jugadores ";

//consulta Busqueda avanzada
if (!empty($_GET["busqueda"])) {
  $listadojugadores .= " WHERE nomjug LIKE '%" . $_GET["busqueda"] . "%' ";
}

if (empty($_POST["ordenapor"])) {
  $listadojugadores .= "ORDER BY codjug asc";
} else if ($_POST["ordenapor"] == "nomjug") {
  $listadojugadores .= "ORDER BY nomjug";
} else if ($_POST["ordenapor"] == "codjug") {
  if ($_POST["direccion"] == "desc") {
    $listadojugadores .= "ORDER BY codjug " . $_POST["direccion"];
  } else {
    $listadojugadores .= "ORDER BY codjug asc";
  }
} else if($_POST["ordenapor"] == "equijug"){
  $listadojugadores .= "ORDER BY equijug";
} else if($_POST["ordenapor"] == "dorsaljug"){
  $listadojugadores .= "ORDER BY dorsaljug";
} else if($_POST["ordenapor"] == "edadjug"){
  $listadojugadores .= "ORDER BY edadjug";
} else if($_POST["ordenapor"] == "alturajug"){
  $listadojugadores .= "ORDER BY alturajug";
} else if($_POST["ordenapor"] == "pesojug"){
  $listadojugadores .= "ORDER BY pesojug";
} else if($_POST["ordenapor"] == "codnacjug"){
  $listadojugadores .= "ORDER BY codnac";
} else if($_POST["ordenapor"] == "codpos"){
  $listadojugadores .= "ORDER BY codpos";
} 

//Paginacion
$paginacion = " LIMIT " . $pagcomienzo . "," . $numFilaPorPag;
$consulta = $conexion->query($listadojugadores . $paginacion);
?>
<div id="tabla" class="table-responsive">
  <table class="table table-striped">
    <tr data-tabla="jugadores">
      <td class="ordena" name="codjug"><b>Codigo</b></td>
      <td class="ordena" name="nomjug"><b>Nombre</b></td>
      <td class="ordena" name="equipojug"><b>Equipo</b></td>
      <td class="ordena" name="dorsaljug"><b>Dorsal</b></td>
      <td class="ordena" name="edadjug"><b>Edad</b></td>
      <td class="ordena" name="alturajug"><b>Altura</b></td>
      <td class="ordena" name="pesojug"><b>Peso</b></td>
      <td class="ordena" name="codjug"><b>Nacionalidad</b></td>
      <td class="ordena" name="codpos"><b>Posicion</b></td>
      <td></td>
      <td></td>
    </tr>
    <?php
    //con este while saca todos los datos de la consulta
    while ($jugadores = $consulta->fetchObject()) {
      ?>
      <tr id="botonBorrar_<?= $jugadores->codjug ?>" data-botonborrar="<?= $jugadores->codjug ?>" data-tabla="jugadores" data-campo="codjug">
        <td class="codigo" ><?= $jugadores->codjug ?></td>
        <td class="nombre" data-campo="nomjug" ><?= $jugadores->nomjug ?></td>
        <?php
        //saca los equipos
        $listadoequipos = "SELECT * FROM equipo WHERE codequi=$jugadores->equipojug";
        $consultaequipo = $conexion->query($listadoequipos);
        while ($equipo = $consultaequipo->fetchObject()) {
          ?>
          <td class="equipo" name="<?= $equipo->codequi ?>"><?= $equipo->nomequi ?></td>
          <?php
        }
        ?> 
        <td class="dorsal"><?= $jugadores->dorsaljug ?></td>
        <td class="edad"><?= $jugadores->edadjug ?></td>
        <td class="altura"><?= $jugadores->alturajug ?> Cm </td>
        <td class="peso"><?= $jugadores->pesojug ?> Kg</td>
        <?php
        //saca los equipos
        $listadonacionalidad = "SELECT * FROM nacionalidad WHERE codnac=$jugadores->codnac";
        $consultaNacionalidad = $conexion->query($listadonacionalidad);
        while ($nacionalidad = $consultaNacionalidad->fetchObject()) {
          ?>
          <td class="nacionalidad" name="<?= $nacionalidad->codnac ?>"><?= $nacionalidad->pais ?></td>
          <?php
        }
        //saca los equipos
        $listadoPosiciones = "SELECT * FROM posicion WHERE codpos=$jugadores->codpos";
        $consultaPosiciones = $conexion->query($listadoPosiciones);
        while ($posiciones = $consultaPosiciones->fetchObject()) {
          ?>
          <td class="posicion" name="<?= $posiciones->codpos ?>"><?= $posiciones->posicion ?></td>
          <?php
        }
        ?>
        <td>
          <!--boton eliminar-->
          <button id="borrar" class="btn btn-danger">
            <span class="glyphicon glyphicon-trash"></span> Eliminar
          </button>
        </td>
        <td>
          <!--boton modificar-->
          <button class="btn btn-info" id="modificar">
            <span class="glyphicon glyphicon-pencil"></span> Modificar
          </button>
        </td>
      </tr>
      <?php
    } //cierra while
    ?>
  </table>
</div>
<div class="text-center">
  <ul class="pagination">
    <?php if ($paginaactual != 1) { ?>
      <li><a href="#" data-page="1" data-tabla="jugadores">Primero</a></li>
      <li><a href="#" data-page="<?php echo ($paginaactual - 1) ?>" data-tabla="jugadores"><<</a></li>
      <?php
    }
    //Cuantas páginas
    $consultaSinPaginacion = $conexion->query($listadojugadores);
    $numfilas = $consultaSinPaginacion->rowCount();
    //obtener el valor entero con intval
    $numpaginas = ceil($numfilas / $numFilaPorPag);

    if ($numpaginas <= 3) {
      for ($i = 1; $i <= $numpaginas; $i++) {
        ?>  
        <li><a href="#" data-tabla="jugadores" data-page="<?php echo $i ?>" 
          <?php if ($i == $paginaactual) { ?> 
                 style="background: #337ab7; color: white" <?php }
          ?>> <!--ciera la etiqueta a-->
            <?php echo $i ?></a></li>
        <?php
      }
    } else if ($paginaactual < $numpaginas - 2) {
      if ($paginaactual > $numpaginas - $paginaactual) {
        ?>
        <li><a href="#" data-page="1" data-tabla="jugadores"> 1 </a></li>
        <li><a href="#" data-page="<?php echo $paginaactual ?>" data-tabla="jugadores"> ... </a></li>
        <?php
      }
      for ($i = 1; $i <= $paginaactual + 2; $i++) {
        ?>  
        <li><a href="#" data-tabla="jugadores" data-page="<?php echo $i ?>" 
          <?php if ($i == $paginaactual) { ?> 
                 style="background: #337ab7; color: white" <?php }
          ?>> <!--ciera la etiqueta a-->
            <?php echo $i ?></a></li>
        <?php
      }
    } else if ($paginaactual <= $numpaginas && $paginaactual >= $numpaginas - 2) {
      if ($paginaactual > $numpaginas - $paginaactual) {
        ?>
        <li><a href="#" data-page="1" data-tabla="jugadores"> 1 </a></li>
        <li><a href="#" data-page="<?php echo $paginaactual ?>" data-tabla="jugadores"> ... </a></li>
        <?php
      }
      for ($i = $paginaactual - 1; $i <= $numpaginas; $i++) {
        ?>  
        <li><a href="#" data-tabla="jugadores" data-page="<?php echo $i ?>" 
          <?php if ($i == $paginaactual) { ?> 
                 style="background: #337ab7; color: white" <?php }
          ?>> <!--ciera la etiqueta a-->
            <?php echo $i ?></a></li>
        <?php
      }
    }
    ?>
    <?php
    if ($paginaactual != $numpaginas) {
      if ($paginaactual < $numpaginas - $paginaactual && $numpaginas > 3) {
        ?>
        <li><a href="#" data-page="<?php echo $paginaactual ?>" data-tabla="jugadores"> ... </a></li>
        <li><a href="#" data-page="<?php echo $numpaginas ?>" data-tabla="jugadores"> <?php echo $numpaginas ?> </a></li>
        <?php
      }
      ?>
      <li><a href="#" data-page="<?php echo ($paginaactual + 1) ?>" data-tabla="jugadores"> >> </a></li>
      <li><a href="#" data-page="<?php echo $numpaginas ?>" data-tabla="jugadores"> Ultimo </a></li>
      <?php
    }
    ?>
  </ul>
</div>