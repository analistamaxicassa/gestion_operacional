<?php
  if (!(empty($_GET['mensaje']))) {
    $mensaje = $_GET['mensaje'];
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

    <title>Auditoria operacional</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Merriweather:700i" rel="stylesheet">

    <link href="../CSS/login.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>

  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <div class="login-panel panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Maxicassa</h3>
            </div>
            <div class="panel-body">
              <form role="form" action="validarusuario.php" method="post">
                <fieldset>
                  <div class="form-group">
                    <label for="usuario">Ingreso a cliente interno:</label>
                      <input type="number" name="usuario" id="usuario" class="form-control" placeholder="Cédula o Documento de identidad" autocomplete="off" required>
                  </div>
                  <div class="form-group">
                    <input type="password" name="claveUsuario" id="claveUsuario" value="" autocomplete="off" class="form-control" placeholder="Contraseña" required>
                  </div>
                  <input type="submit" class="btn btn-primary">
                </fieldset>
              </form>
            </div>
          </div>
          <span style="color:red"><?php if (isset($mensaje)) {
            if ($mensaje == '1') {
              echo "Usuario Incorrecto";
            }elseif ($mensaje == '2') {
              echo "Usuario Inactivo";
            }
          } ?></span>
        </div>
      </div>
    </div>
    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>
  </body>
</html>
