<?php
  require_once('../conexionesDB/conexion.php');
  session_start();
  if(!isset($_SESSION['userID']))
  {
  	?>
   	<script>
  	alert("Sesión inactiva");
  	location.href="index.php";
  	</script>
      <?php
  }
  else {
    //echo "string".session_id();
  }
  $link_personal=Conectarse_personal();
  if (!(empty($_GET['mensaje'])))
  {
    $mensaje = $_GET['mensaje'];
  }
  else {
    $mensaje = '0';
  }
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<title>CLIENTE INTERNO</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
    <ol class="breadcrumb">
  		<li><a href="../logout.php?origen=4">Cerrar Sesión</a></li>
  		<li class="active">Principal</li>
  	</ol>
    <?php if($mensaje == '1'){ ?>
    <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">x</button>
        La entrevista se ha ingresado exitosamente
    </div>
    <?php } ?>
    <div class="container">
      <legend align="center"><?php echo $_SESSION['nombre']." - ".$_SESSION['cargo']; ?></legend>
      <div class="row">
        <div class="col-md-4 col-md-offset-2">
          <div class="panel-group" id="accordion">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Entrevista empleados retirados</a>
                </h4>
              </div>
              <div id="collapse1" class="panel-collapse collapse in">
                <div class="panel-body">
                  <form role="form" action="formato_entrevista.php" method="post">
                    <fieldset>
                      <div class="form-group">
                        <label for="userId">Seleccione el rango de fechas para iniciar la búsqueda de empleados retirados:</label>
                      </div>
                      <div class="form-group">
                        <label for="fechaInicial">Fecha Inicial:</label>
                        <input type="date" name="fechaInicial" class="form-control" value="" required>
                      </div>
                      <div class="form-group">
                        <label for="fechaFinal">Fecha Final</label>
                        <input type="date" name="fechaFinal" class="form-control" value="" required>
                      </div>
                      <button type="submit" class="btn btn-primary">Buscar <i class="glyphicon glyphicon-search"></i></button>
                    </fieldset>
                  </form>
                </div>
              </div>
            </div>
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Histórico de entrevistas empleados retirados</a>
                </h4>
              </div>
              <div id="collapse2" class="panel-collapse collapse">
                <div class="panel-body">
                  <form role="form" action="imprimir_entrevista.php" method="post">
                    <fieldset>
                      <div class="form-group">
                        <label for="usuarioId">Ingrese el número de identificación del empleado:</label>
                          <input type="number" name="usuarioId" class="form-control" placeholder="Cédula o Documento de identidad" required>
                      </div>
                      <button type="submit" class="btn btn-primary">Buscar <i class="glyphicon glyphicon-search"></i></button>
                    </fieldset>
                  </form>
                  <span style="color:red"><?php if (isset($mensaje)) {
                    if ($mensaje == '1') {
                      echo "Verifique el documento del empleado a consultar e intente nuevamente.";
                    }elseif ($mensaje == '2') {
                      echo "No existen entrevistas registradas para el documento ingresado.";
                    }
                  } ?></span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="table-responsive">
            <table class="table table-sm table-bordered">
              <thead>
                <tr class="bg-info">
                  <th>Identificación</th>
                  <th>Fecha de retiro</th>
                  <th>Ciudad</th>
                  <th>Fecha de entrevista</th>
                </tr>
              </thead>
              <tbody>
              <?php
                //consulta de concepto de sala
                $sql_resumen="SELECT empleadoRetiradoID, fecha_retiro, nombreCiudad, fechaEntrevista FROM entrevista_retiro ORDER BY fechaEntrevista DESC LIMIT 10";
                $query_resumen=$link_personal->query($sql_resumen);
                $resumen=$query_resumen->fetch_object();  ///consultar

                if (empty($resumen)) {
                  echo 'No existen registros';
                }
                else
                {
                  do{
              ?>
                        <tr>
                          <td><?php echo ($resumen->empleadoRetiradoID); ?></td>
                          <td><?php echo  ($resumen->fecha_retiro); ?></td>
                          <td><?php echo ($resumen->nombreCiudad); ?></td>
                          <td><?php echo  ($resumen->fechaEntrevista); ?></td>
                        </tr>
              <?php
                  }while($resumen=$query_resumen->fetch_object());
                  $query_resumen->close();
                }
                $link_personal->close();
              ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
