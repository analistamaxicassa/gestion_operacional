<?php
require_once('../conexionesDB/conexion.php');
ini_set("session.gc_maxlifetime","2700");
$link_maxlibreta = Conectarse_maxlibreta();
  // if (!(empty($_GET['mensaje']))) {
  //   $mensaje = $_GET['mensaje'];
  // }
  $mostrar_mensaje = false;
  if (isset($_GET['mensaje'])) {
    $mostrar_mensaje = true;
    $tipo_mensaje = $_GET['mensaje'];
    if ($tipo_mensaje == '1') {
        $alertType = 'alert-danger';
      $mensaje = "<strong> El número de identificación ingresado no se encuentra activo</strong> en el sistema de recursos humanos, verifique lo e intente nuevamente.";
    }elseif ($tipo_mensaje == '2') {
        $alertType = 'alert-warning';
        $mensaje = '<strong> El usuario no cuenta con los permisos necesarios para ingresar.</strong>';
    }elseif ($tipo_mensaje == '3') {
        $alertType = 'alert-warning';
        $mensaje = '<strong> El usuario no cuenta con el perfil adecuado para ingresar .</strong>';
    }elseif ($tipo_mensaje == '4') {
        $alertType = 'alert-warning';
        $mensaje = '<strong>La contraseña ingresada esta errada,</strong> recuerde utilizar la contraseña que ingreso en la plataforma de actualización de datos.<br>
       Tambien puede comunicarse con el área de T.I.para solicitar un restablecimiento de contraseña.';
    }elseif ($tipo_mensaje == "5") {
        $alertType = "alert-warning";
        $mensaje = ' El usuario no tiene una contraseña definida, por favor actualícela en el siguiente <a href="http://190.144.42.83:81/hermes/def_password.php" class="alert-link">enlace</a> solo le tomara unos pocos minutos.';
    }elseif ($tipo_mensaje == '6') {
        $alertType = 'alert-warning';
        $mensaje = '<strong> Por favor verifica el captcha</strong>';
    }elseif ($tipo_mensaje == '7') {
        $alertType = 'alert-warning';
        $mensaje = '<strong> Se produjo un error al comprobar el captcha, intentelo de nuevo.</strong>';
    }else {
      $mostrar_mensaje = false;
    }
  }
 ?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Auditoria operacional - Administradores</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Merriweather:700i" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.2.0/js/all.js" integrity="sha384-4oV5EgaV02iISL2ban6c/RmotsABqE4yZxZLcYMAdG7FAPsyHYAPpywE9PJo+Khy" crossorigin="anonymous"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
    function seleccionarSala(){
      document.getElementById("select_sala").disabled = false;
    }
    </script>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-primary" style="margin-top:15%;">
            <div class="panel-heading">
              <center><strong><h3 class="panel-title" style="font-weight:bold;">Gestión Operacional</h3></strong></center>
            </div>
            <div class="panel-body">
              <form role="form" action="../validar_usuario.php" method="post">
                <fieldset>
                    <div class="row">
                      <div class="col-md-5">
                          <label for="usuario_administrador">Ingreso auditoria operacional:</label>
                          <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-user" style="color: #002F87"></span></span>
                            <input type="number" name="usuario_administrador" id="usuario" class="form-control" placeholder="Cédula o Documento de identidad" autocomplete="off" required>
                          </div>
                          <small>* Ingreso para administradores de sala.</small>
                        </div>
                        <br>
                        <div class="col-md-7">
                          <div class="form-group">
                            <div class="">
                              <label for="select_sala">Habilitar salas especiales.</label>
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <input type="radio" name="radioSala" onclick="seleccionarSala()">
                                </span>
                                <select class="form-control" name="select_sala" id="select_sala" required disabled>
                                  <option value="">Lista de salas</option>
                                  <?php
                                  $sql_salas = "SELECT se.centro_costo,sa.sala_nombre FROM salas_especiales se
                                      INNER JOIN queryx_seven.salas sa ON SE.centro_costo= sa.centro_costo and se.sociedad_ID=sa.sociedad_ID
                                      WHERE se.sociedad_ID='4' and sa.activo=1 ORDER BY se.centro_costo";
                                      $query_salas = $link_maxlibreta->query($sql_salas);
                                      $resul = $query_salas->fetch_object();
                                      do {
                                      $cod_sala = $resul->centro_costo;
                                      $sala_nombre = $resul->sala_nombre;

                                      echo '<option value='.$cod_sala.'>'.$cod_sala.' - '.$sala_nombre.'</option>';

                                    }while ($resul = $query_salas->fetch_object())

                                   ?>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                      <div class="col-md-5">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-lock" style="color: #002F87"></span></span>
                          <input type="password" name="claveUsuario" id="claveUsuario" value="" autocomplete="off" class="form-control" placeholder="Contraseña" required>
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-5">
                        <div class="g-recaptcha" data-sitekey="6LcJuqMUAAAAAAUN3Kn7_CAdVZ_GwlnnhiU9-1BO"></div>
                      </div>
                      <!-- <div class="col-md-7">
                        <div class="alert alert-info" role="alert">
                          <strong>Nota:</strong> Solo los administradores que manejen mas de una sala deben acceder a la opción <strong>“Habilitar salas especiales”.</strong>
                        </div>
                      </div> -->
                    </div>
                  <br>
                  <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                      <button type="submit" class="btn btn-primary btn-lg">Ingresar</button>
                    </div>
                  </div>
                </fieldset>
              </form>
            </div>
          </div>

        </div>
        <div class="col-md-6 col-md-offset-3">
          <?php if ($mostrar_mensaje): ?>
            <div class="alert <?php echo $alertType; ?> alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <i class="fas fa-times-circle fa-lg"></i><?php echo $mensaje; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>
  </body>
</html>
