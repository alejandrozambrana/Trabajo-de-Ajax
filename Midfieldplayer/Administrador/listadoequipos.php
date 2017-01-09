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
$listadoEquipos = "select * from equipo ";

//consulta Busqueda avanzada
if (!empty($_GET["busqueda"])){
$listadoEquipos .= " WHERE nomequi LIKE '%" . $_GET["busqueda"] . "%' ";
}

if (empty($_POST["ordenapor"])) {
  $listadoEquipos .= "ORDER BY codequi asc";
} else {
  if ($_POST["ordenapor"] == "nomequi") {
    $listadoEquipos .= "ORDER BY nomequi";
  } else if ($_POST["ordenapor"] == "codequi") {
    if ($_POST["direccion"] == "desc") {
      $listadoEquipos .= "ORDER BY codequi " . $_POST["direccion"];
    } else {
      $listadoEquipos .= "ORDER BY codequi asc";
    }
  }
}

//Paginacion
$paginacion = " LIMIT " . $pagcomienzo . "," . $numFilaPorPag;
$consulta = $conexion->query($listadoEquipos . $paginacion);

?>
<div id="tabla" class="table-responsive">
  <table class="table table-striped">
    <tr data-tabla="equipo">
      <td class="ordena" name="codequi"><b>Codigo</b></td>
      <td class="ordena" name="nomequi"><b>Equipo</b></td>
      <td></td>
      <td></td>
    </tr>
    <?php
    //con este while saca todos los datos de la consulta
    while ($equipo = $consulta->fetchObject()) {
      ?>
      <tr id="botonBorrar_<?= $equipo->codequi ?>" data-botonborrar="<?= $equipo->codequi ?>" data-tabla="equipo" data-campo="codequi">
        <td class="codigo" ><?= $equipo->codequi ?></td>
        <td class="nombre" data-campo="nomequi" ><?= $equipo->nomequi ?></td>
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
      <li><a href="#" data-page="1" data-tabla="equipo">Primero</a></li>
      <li><a href="#" data-page="<?php echo ($paginaactual - 1) ?>" data-tabla="equipo"><<</a></li>
      <?php
    }
    //Cuantas páginas
    $consultaSinPaginacion = $conexion->query($listadoEquipos);
    $numfilas = $consultaSinPaginacion->rowCount();
    //obtener el valor entero con intval
    $numpaginas = ceil($numfilas / $numFilaPorPag);
    
    if ($numpaginas <= 3) {
      for ($i = 1; $i <= $numpaginas; $i++) {
        ?>  
        <li><a href="#" data-tabla="equipo" data-page="<?php echo $i ?>" 
          <?php if ($i == $paginaactual) { ?> 
                 style="background: #337ab7; color: white" <?php }
    ?>> <!--ciera la etiqueta a-->
            <?php echo $i ?></a></li>
        <?php
      }
    } else if ($paginaactual < $numpaginas - 2) {
      if ($paginaactual > $numpaginas - $paginaactual) {
        ?>
        <li><a href="#" data-page="1" data-tabla="equipo"> 1 </a></li>
        <li><a href="#" data-page="<?php echo $paginaactual ?>" data-tabla="equipo"> ... </a></li>
        <?php
      }
      for ($i = 1; $i <= $paginaactual + 2; $i++) {
        ?>  
        <li><a href="#" data-tabla="equipo" data-page="<?php echo $i ?>" 
          <?php if ($i == $paginaactual) { ?> 
                 style="background: #337ab7; color: white" <?php }
    ?>> <!--ciera la etiqueta a-->
            <?php echo $i ?></a></li>
        <?php
      }
    } else if ($paginaactual <= $numpaginas && $paginaactual >= $numpaginas - 2) {
      if ($paginaactual > $numpaginas - $paginaactual) {
        ?>
        <li><a href="#" data-page="1" data-tabla="equipo"> 1 </a></li>
        <li><a href="#" data-page="<?php echo $paginaactual ?>" data-tabla="equipo"> ... </a></li>
        <?php
      }
      for ($i = $paginaactual - 1; $i <= $numpaginas; $i++) {
        ?>  
        <li><a href="#" data-tabla="equipo" data-page="<?php echo $i ?>" 
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
        <li><a href="#" data-page="<?php echo $paginaactual ?>" data-tabla="equipo"> ... </a></li>
        <li><a href="#" data-page="<?php echo $numpaginas ?>" data-tabla="equipo"> <?php echo $numpaginas ?> </a></li>
        <?php
      }
      ?>
      <li><a href="#" data-page="<?php echo ($paginaactual + 1) ?>" data-tabla="equipo"> >> </a></li>
      <li><a href="#" data-page="<?php echo $numpaginas ?>" data-tabla="equipo"> Ultimo </a></li>
      <?php
    }
    ?>
  </ul>
</div>
