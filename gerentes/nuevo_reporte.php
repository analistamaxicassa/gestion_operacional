<?php
  require_once('../conexionesDB/conexion.php');
  $link_personal=Conectarse_personal();
  ini_set("session.gc_maxlifetime","2400");
  session_start();

  $cod_cargo = $_SESSION['cod_cargo'];
  $codigo_sala = $_POST['codigo_sala'];
  $nombre_sala = $_POST['nombre_sala'];
  $fecha_inspeccion = $_POST['fecha_inspeccion'];
  $resumen_conceptos = $_POST['resumen_conceptos'];
  $fechaActual = new DateTime('now');
	$fechaActual = $fechaActual->format('Y-m-d');
  $mostrar_observa=0;
  //validacion para mostrar observaciones confidenciales
   if ($cod_cargo == 151 || $cod_cargo == 152 || $cod_cargo == 146 || $cod_cargo == 242 || $cod_cargo == 159 || $cod_cargo == 200)
   {
     $mostrar_observa=1;
  }

  if ($resumen_conceptos == "0") {
    $resumen = false;
  } else {
    $sql_resumen="SELECT cs.fecha,cs.concepto_esp,par.Descripcion, cs.calificacion,cs.hallazgo,cs.tarea,cs.responsable,cs.fecha_control,cs.observacion_conf,cs.ESTADO
    FROM concepto_sala cs INNER JOIN parametros par ON cs.concepto_esp=par.id_parametro WHERE cs.cc='$codigo_sala' and cs.fecha='$fecha_inspeccion' ORDER BY fecha DESC";
    $query_resumen=$link_personal->query($sql_resumen);
    $resumen = $query_resumen->fetch_object();

  }

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Auditoria Operacional</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" integrity="sha384-kW+oWsYx3YpxvjtZjFXqazFpA7UP/MbiY4jvs+RWZo2+N94PFZ36T6TFkc9O3qoB" crossorigin="anonymous"></script>
  </head>
  <body>
    <ol class="breadcrumb">
      <li><a href="reportes_sala.php?sala=<?php echo $codigo_sala;?>"><i class="fas fa-chevron-circle-left"></i> <strong><?php echo $nombre_sala; ?></strong></a></li>
      <li class="active"><strong>NUEVA EVALUACIÓN</strong></li>
    </ol>
    <?php if (empty($resumen)): ?>

    <?php else: ?>
      <div class="table-responsive col-md-12 col-sm-12">
        <table class="table table-bordered">
          <thead>
            <tr class="bg-primary">
              <th>Concepto</th>
              <th>Calificación</th>
              <th>Hallazgo</th>
              <th>Tarea</th>
              <th>Responsable</th>
              <th>Fecha Control</th>
              <th>Observación Privada</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody>
          <?php do{ ?>
                    <tr>
                      <td><?php echo  ($resumen->Descripcion); ?></td>
                      <td><?php echo ($resumen->calificacion); ?></td>
                      <td><?php echo  ($resumen->hallazgo); ?></td>
                      <td><?php echo  ($resumen->tarea); ?></td>
                      <td><?php echo  ($resumen->responsable); ?></td>
                      <td><?php echo ($resumen->fecha_control); ?></td>
                      <?php if ($mostrar_observa == 1): ?>
                      <td><?php echo ($resumen->observacion_conf); ?></td>
                      <?php else:?>
                      <td></td>
                      <?php endif; ?>
                      <td><?php echo  ($resumen->ESTADO); ?></td>
                    </tr>
          <?php
              }while($resumen=$query_resumen->fetch_object());
              $query_resumen->close();
          ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>

<?php
  $sqla = "SELECT email, nombre FROM email_permisos where cc = '10-$codigo_sala'";
	$qry_sqla = $link_personal->query($sqla);
	$rs_qrya = $qry_sqla->fetch_object();  ///consultar
	$rs_qrya->email;
?>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong><?php echo $nombre_sala; ?></strong></h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="guardar_concepto.php" method="post" accept-charset="utf-8">
                        <fieldset>
                            <div class="form-group">
                              <label for="fecha_visita">Fecha de inspección:</label>
                              <input type="date" name="fecha_visita" value="<?php echo $fecha_inspeccion; ?>" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                              <label for="concepto_det">Concepto:</label>
                              <select name="concepto_det" class="form-control" required>
                                <option value="">Seleccione un concepto</option>
                                <?php
                                $query = $link_personal->query("select id_parametro,Descripcion from parametros WHERE tipo_ID=1 AND Estado=1");
                                while($valores=$query->fetch_object())
                                {
                                  echo '<option value="'.$valores->id_parametro.'">'.$valores->Descripcion.'</option>';
                                }
                                ?>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="nota">Calificación:</label>
                              <select name="nota" class="form-control" required>
                                <option value="">Seleccione un valor para la calificación</option>
                                <option value="5">5</option>
                                <option value="4.5">4.5</option>
                                <option value="4">4</option>
                                <option value="3.5">3.5</option>
                                <option value="3">3</option>
                                <option value="2.5">2.5</option>
                                <option value="2">2</option>
                                <option value="1.5">1.5</option>
                                <option value="1">1</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="hallazgo">Hallazgo:</label>
                              <textarea name="hallazgo" cols="4" rows="4" class="form-control" placeholder="Describa el hallazgo" required></textarea>
                            </div>
                            <div class="form-group">
                              <label for="tarea">Tarea:</label>
                              <textarea name="tarea" cols="4" rows="7" class="form-control" placeholder="Describa la tarea" required></textarea>
                            </div>
                            <div class="form-group">
                              <label for="responsable">Responsable:</label>
                              <select name="responsable" class="form-control" required>
                                <option value="">Seleccione un responsable</option>
                                <option value="<?php echo $rs_qrya->email;?>">ADMINISTRADOR</option>
                                <?php
                                $query=$link_personal->query("select Email,Descripcion from parametros WHERE tipo_ID=2 AND Estado=1");
                                while($valores=$query->fetch_object())
                                {
                                  echo '<option value="'.$valores->Email.'">'.$valores->Descripcion.'</option>';
                                }
                                ?>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="fcontrol">Fecha control:</label>
                              <input type="date" name="fcontrol" value="<?php echo $fechaActual; ?>" class="form-control" required>
                              <input type="hidden" name="evaluador" value="<?php echo utf8_encode($_SESSION['nombre']); ?>">
                              <input type="hidden" name="sala" value="<?php echo $codigo_sala; ?>">
                            </div>
                            <div class="form-group">
                              <label for="fobserconf">Observacion Confidencial (sólo será visible para la gerencia):</label>
                              <!-- <label for="tarea">Tarea:</label> -->
                              <textarea name="Observacion_conf" cols="4" rows="5" class="form-control" placeholder="Agregue la observación"></textarea>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Guardar">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
  </body>
</html>
