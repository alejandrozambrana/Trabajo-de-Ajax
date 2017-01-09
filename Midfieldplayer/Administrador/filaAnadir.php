<?php
include '../ConexionBD.php';

if ($_POST['tabla'] == "nacionalidad") {
  ?>
  <label id="filaAnadir" data-tabla="nacionalidad" data-campo="codnac">
    <form id="formulario" action="#" method="POST">
      <input type="number" placeholder="Codigo" style="width: 150px; margin: 0 auto;" class="form-control" name="codnac" id="codigoId" min="1" step="1" autocomplete required="required">
      <input type="text" placeholder="Pais" style="width: 250px; margin: 0 auto;" size="1" class="form-control" name="pais" id="nombreId" required="required">
      <button id="anadirNuevo" class="btn btn-info"><span class="glyphicon glyphicon-floppy-saved"></span> Añadir</button>
      <button id="cancelarNuevo" class="btn btn-danger"><span class="glyphicon glyphicon-floppy-remove"></span> Cancelar</button>
    </form>
  </label>
  <script>
      $("#formulario").validate({
          rules: {
            codnac: {
              required: true
            },
            pais: {
              required: true
            }
          },
          messages: {
            codnac: {
              required: "Codigo de pais requerido"
            },
            pais: {
              required: "Pais requerido"
            }
          }
      });
  </script>
  <?php
}

if ($_POST['tabla'] == "posicion") {
  ?>
  <label id="filaAnadir" data-tabla="posicion" data-campo="codpos">
    <form id="formulario" action="#" method="POST">
      <input type="number" placeholder="Codigo" style="width: 150px; margin: 0 auto;" class="form-control" name="codpos" id="codigoId" min="1" step="1" autocomplete required="required">
      <input type="text" placeholder="Posicion" style="width: 250px; margin: 0 auto;" size="1" class="form-control" name="posicion" id="nombreId" required="required">
      <button id="anadirNuevo" class="btn btn-info"><span class="glyphicon glyphicon-floppy-saved"></span> Añadir</button>
      <button id="cancelarNuevo" class="btn btn-danger"><span class="glyphicon glyphicon-floppy-remove"></span> Cancelar</button>
    </form>
  </label>
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
              required: "Codigo de posicion requerida"
            },
            posicion: {
              required: "Posicion requerida"
            }
          }
      });
  </script>
  <?php
}

if ($_POST['tabla'] == "equipo") {
  ?>
  <label id="filaAnadir" data-tabla="equipo" data-campo="codequi">
    <form id="formulario" action="#" method="POST">
      <input type="number" placeholder="Codigo" style="width: 150px; margin: 0 auto;" class="form-control" name="codequi" id="codigoId" min="1" step="1" autocomplete required>
      <input type="text" placeholder="Equipo" style="width: 250px; margin: 0 auto;" size="1" class="form-control" name="nomequi" id="nombreId" required>
      <button id="anadirNuevo" class="btn btn-info"><span class="glyphicon glyphicon-floppy-saved"></span> Añadir</button>
      <button id="cancelarNuevo" class="btn btn-danger"><span class="glyphicon glyphicon-floppy-remove"></span> Cancelar</button>
    </form>
  </label>
  <script>
      $("#formulario").validate({
          rules: {
            codequi: {
              required: true
            },
            nomequi: {
              required: true
            }
          },
          messages: {
            codequi: {
              required: "Codigo del equipo requerido"
            },
            nomequi: {
              required: "Equipo requerido"
            }
          }
      });
  </script>
  <?php
}

if ($_POST['tabla'] == "jugadores") {
  ?>
  <label id="filaAnadir" data-tabla="jugadores" data-campo="codjug" style="width: 100%">
    <form id="formularioJug" action="#" method="POST">
      <input type="text" placeholder="Nombre" style="width: 150px; margin: 0 auto;" class="form-control" name="nomjug" id="nombreId" required>
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
      </select>
      <input type="number" placeholder="Dorsal" style="width: 80px; margin: 0 auto;" class="form-control" name="dorsaljug" id="dorsalId" min="1" step="1" autocomplete required>
      <input type="text" placeholder="Fecha Nacimiento" style="width: 150px; margin: 0 auto;" class="form-control" name="edadjug" id="datepicker" autocomplete required>
      <input type="number" placeholder="Altura" style="width: 80px; margin: 0 auto;" class="form-control" name="alturajug" id="alturaId" min="1" step="1" autocomplete required>
      <input type="number" placeholder="Peso" style="width: 80px; margin: 0 auto;" class="form-control" name="pesojug" id="pesoId" min="1" step="1" autocomplete required>
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
      </select>
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
      </select>
      <button id="anadirNuevo" class="btn btn-info"><span class="glyphicon glyphicon-floppy-saved"></span> Añadir</button>
      <button id="cancelarNuevo" class="btn btn-danger"><span class="glyphicon glyphicon-floppy-remove"></span> Cancelar</button>
    </form>
  </label>
  <script>
      $("#formularioJug").validate({
          rules: {
            nomjug: {
              required: true
            },
            dorsaljug: {
              required: true
            },
            edadjug: {
              required: true
            },
            alturajug: {
              required: true
            },
            pesojug: {
              required: true
            }
          },
          messages: {
            nomjug: {
              required: "Introduzca el nombre del jugador"
            },
            dorsaljug: {
              required: "Dorsal requerido"
            },
            edadjug: {
              required: "Edad requerida"
            },
            alturajug: {
              required: "Altura requerida"
            },
            pesojug: {
              required: "Peso requerido"
            }
          }
      });
  </script>

  <?php
}
?>

