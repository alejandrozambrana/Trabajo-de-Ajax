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
$listadoNacionalidad = "select * from nacionalidad ";

//consulta Busqueda avanzada
if (!empty($_GET["busqueda"])){
$listadoNacionalidad .= " WHERE pais LIKE '%" . $_GET["busqueda"] . "%' ";
}

if (empty($_POST["ordenapor"])) {
  $listadoNacionalidad .= "ORDER BY codnac asc";
} else {
  if ($_POST["ordenapor"] == "pais") {
    $listadoNacionalidad .= "ORDER BY pais";
  } else if ($_POST["ordenapor"] == "codnac") {
    if ($_POST["direccion"] == "desc") {
      $listadoNacionalidad .= "ORDER BY codnac " . $_POST["direccion"];
    } else {
      $listadoNacionalidad .= "ORDER BY codnac asc";
    }
  }
}

//Paginacion
$paginacion = " LIMIT " . $pagcomienzo . "," . $numFilaPorPag;
$consulta = $conexion->query($listadoNacionalidad . $paginacion);

?>
<div id="tabla" class="table-responsive">
  <table class="table table-striped">
    <tr data-tabla="nacionalidad">
      <td class="ordena" name="codnac"><b>Codigo</b></td>
      <td class="ordena" name="pais"><b>Pais</b></td>
      <td></td>
      <td></td>
    </tr>
    <?php
    //con este while saca todos los datos de la consulta
    while ($nacionalidad = $consulta->fetchObject()) {
      ?>
      <tr id="botonBorrar_<?= $nacionalidad->codnac ?>" data-botonborrar="<?= $nacionalidad->codnac ?>" data-tabla="nacionalidad" data-campo="codnac">
        <td class="codigo" ><?= $nacionalidad->codnac ?></td>
        <td class="nombre" data-campo="pais" ><?= $nacionalidad->pais ?></td>
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
      <li><a href="#" data-page="1" data-tabla="nacionalidad">Primero</a></li>
      <li><a href="#" data-page="<?php echo ($paginaactual - 1) ?>" data-tabla="nacionalidad"><<</a></li>
      <?php
    }
    //Cuantas páginas
    $consultaSinPaginacion = $conexion->query($listadoNacionalidad);
    $numfilas = $consultaSinPaginacion->rowCount();
    //obtener el valor entero con intval
    $numpaginas = ceil($numfilas / $numFilaPorPag);
    
    if ($numpaginas <= 3) {
      for ($i = 1; $i <= $numpaginas; $i++) {
        ?>  
        <li><a href="#" data-tabla="nacionalidad" data-page="<?php echo $i ?>" 
          <?php if ($i == $paginaactual) { ?> 
                 style="background: #337ab7; color: white" <?php }
    ?>> <!--ciera la etiqueta a-->
            <?php echo $i ?></a></li>
        <?php
      }
    } else if ($paginaactual < $numpaginas - 2) {
      if ($paginaactual > $numpaginas - $paginaactual) {
        ?>
        <li><a href="#" data-page="1" data-tabla="nacionalidad"> 1 </a></li>
        <li><a href="#" data-page="<?php echo $paginaactual ?>" data-tabla="nacionalidad"> ... </a></li>
        <?php
      }
      for ($i = 1; $i <= $paginaactual + 2; $i++) {
        ?>  
        <li><a href="#" data-tabla="nacionalidad" data-page="<?php echo $i ?>" 
          <?php if ($i == $paginaactual) { ?> 
                 style="background: #337ab7; color: white" <?php }
    ?>> <!--ciera la etiqueta a-->
            <?php echo $i ?></a></li>
        <?php
      }
    } else if ($paginaactual <= $numpaginas && $paginaactual >= $numpaginas - 2) {
      if ($paginaactual > $numpaginas - $paginaactual) {
        ?>
        <li><a href="#" data-page="1" data-tabla="nacionalidad"> 1 </a></li>
        <li><a href="#" data-page="<?php echo $paginaactual ?>" data-tabla="nacionalidad"> ... </a></li>
        <?php
      }
      for ($i = $paginaactual - 1; $i <= $numpaginas; $i++) {
        ?>  
        <li><a href="#" data-tabla="nacionalidad" data-page="<?php echo $i ?>" 
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
        <li><a href="#" data-page="<?php echo $paginaactual ?>" data-tabla="nacionalidad"> ... </a></li>
        <li><a href="#" data-page="<?php echo $numpaginas ?>" data-tabla="nacionalidad"> <?php echo $numpaginas ?> </a></li>
        <?php
      }
      ?>
      <li><a href="#" data-page="<?php echo ($paginaactual + 1) ?>" data-tabla="nacionalidad"> >> </a></li>
      <li><a href="#" data-page="<?php echo $numpaginas ?>" data-tabla="nacionalidad"> Ultimo </a></li>
      <?php
    }
    ?>
  </ul>
</div>