<?php
//si la session esta iniciada la destruye
if(session_start() == true){
  session_destroy();
}
error_reporting(E_ALL ^ E_NOTICE); //no muestra error de variables indefinida
session_start();// Inicia la sesión

if(!isset($_SESSION['usuario']) && !isset($_SESSION['logueado'])) {//comprueba que la variable no esta iniciada.
$_SESSION['usuario'] = " ";
$_SESSION['logueado'] = false;
$_SESSION['tipoUsuario'] = " ";
}

?>
<!DOCTYPE html>
<!--
Login de Acceso
-->
<html>
  <head>
    <meta charset="UTF-8">
    <title>MilField Player</title>
    <link rel="shortcut icon" type="image/png" href="imagen/logo.png"/>
    <!--bootstrap-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.validate.js"></script>
    <script src="js/funciones.js"></script>
    <!-- CSS de Bootstrap -->
    <link href="bootstrap/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <!--css propio-->
    <link href="css/estilos.css" rel="stylesheet"> 
  </head>
  <body>
    <?php
      //comprueba si se establece conexion con mysql
      //incluye la conexion con la base de datos
      include 'ConexionBD.php';
      //con esto se realiza una consulta
      $usuarioBBDD = $conexion -> query("select nomusu, contrausu, tipousu from usuarios ORDER BY 1");
    
      $_SESSION['usuario'] = $_POST['usuario'];
      $contraseñaIntroducida = $_POST['contraseña'];
      
      while (($usuario = $usuarioBBDD->fetchObject())) {
        if($usuario->nomusu == $_SESSION['usuario'] && $usuario->contrausu == $contraseñaIntroducida && $usuario->tipousu == "administrador"){ 
          $_SESSION['logueado'] = true;
          $_SESSION['tipoUsuario'] = $usuario->tipousu;
          header("Refresh: 0; url=menu.php");//esto redirecciona a otra pagina
        } else if ($usuario->nomusu == $_SESSION['usuario'] && $usuario->contrausu != $contraseñaIntroducida){
          echo '<script>alert("Contraseña Incorrecta");</script>';
        } else if ($usuario->nomusu == $_SESSION['usuario'] && $usuario->contrausu == $contraseñaIntroducida && $usuario->tipousu == "cliente"){
          $_SESSION['logueado'] = true;
          $_SESSION['tipoUsuario'] = $usuario->tipousu;
          header("Refresh: 0; url=menu.php");//esto redirecciona a otra pagina
        } 
      } 
    ?>
    <div class="tituloLogin" class="col-xs-12 col-sm-8 col-md-12">
      <img src="imagen/logoNombre.png" name="MidField Player" alt="MidField Player" width="350" >
    </div>

      <div id="login" class="col-xs-12 col-sm-12 col-md-12">
        <h1 style="margin-bottom: 50px;">Login</h1>
        <form id="formularioLogin" action="index.php" method="POST">
          <span class="glyphicon glyphicon-user"></span>
          <label for="usuarioId">Usuario</label><br>
          <input type="text" name="usuario" class="form-control center-block" id="usuarioId" autofocus placeholder="Usuario" value="<?=$_SESSION['usuario']?>" required></br>
          <span class="glyphicon glyphicon-lock"></span>
          <label for="contrasenaId">Contraseña</label><br>
          <input type="password" class="form-control center-block" name="contraseña" id="contrasenaId" placeholder="Contraseña"></br></br>
          <button type="submit" class="btn btn-default" name="action" style="background-color: #e6e6e6;">Acceder
            <span class="glyphicon glyphicon-send" aria-hidden="true"></span>
          </button>
        </form>
        <div class="registrar">
          <a href="registrate.php">¿No eres usuario?</a>
        </div>
    </div>
      <script>
        $("#formularioLogin").validate({
            rules: {
              usuario: {
                required: true
              },
              contraseña: {
                  required: true
              }
            },
            messages: {
              usuario: {
                required: "Usuario requerido"
              },
              contraseña: {
                required: "Contraseña requerida"
              }
            }
        });
      </script>
  </body>
</html>
