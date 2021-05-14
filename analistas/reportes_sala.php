<?php
  require_once('../conexionesDB/conexion.php');
  $link_personal = Conectarse_personal();
  $link_queryx_seven = Conectarse_queryx_mysql();
  $link_caronte = Conectarse_caronte();

  ini_set("session.gc_maxlifetime","2400");
  session_start();
  $sociedad = $_SESSION['cod_sociedad'];
  if(!isset($_SESSION['userID']))
  {
    header('Location: ../index.php');
    exit();
  }else {

    $usuario = $_SESSION['userID'];
  }

  if (isset($_POST['sala']))
  {
    $sala = $_POST['sala'];
  }
  elseif (isset($_GET['sala']))
  {
    $sala = $_GET['sala'];
  }

  $fechaActual = new DateTime('now');
	$fechaActual = $fechaActual->format('Y-m-d');

  $sqltipo = "SELECT centro_costo, sala_nombre FROM salas WHERE centro_costo='$sala' and activo='1' AND sociedad_ID='$sociedad'";
	$qry_sqltipo = $link_queryx_seven->query($sqltipo);
	$rs_qrytipo = $qry_sqltipo->fetch_object();

  @$nombre_sala = $rs_qrytipo->sala_nombre;

  $sql_resumen = "SELECT fecha, COUNT(id) AS conceptos_evaluados, SUM(calificacion) AS suma_calf FROM concepto_sala
  WHERE cc = '$sala' GROUP BY fecha ORDER BY fecha DESC";
	$query_resumen = $link_personal->query($sql_resumen);
	$resumen = $query_resumen->fetch_object();

?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Auditoria Operacional</title>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" integrity="sha384-kW+oWsYx3YpxvjtZjFXqazFpA7UP/MbiY4jvs+RWZo2+N94PFZ36T6TFkc9O3qoB" crossorigin="anonymous"></script>

    <script type="text/javascript" src="clases\reportes_sala.js"></script>
    <script src="clases\bootbox\bootbox.min.js"></script>
    <script src="clases\bootbox\bootbox.locales.min.js"></script>
    <style media="screen">
      table{
        font-size: 13px;
      }
      .modal-dialog{
      overflow-y: initial
      }
      .modal-body{
      overflow-x: auto;
      overflow-y: auto;
      }
    </style>
  </head>
  <body>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="principal.php"><i class="fas fa-chevron-circle-left fa-lg"></i> <strong>INICIO</strong></a></li>
        <li class="breadcrumb-item active" aria-current="page"><strong><?php echo @$nombre_sala; ?></strong></li>
      </ol>
    </nav>
    <div class="container">
        <div class="row">
          <div class="col-md-11 offset-md-1">
            <!-- <div class="card mb-6"> -->
              <div class="card-body text-white bg-info">
                <!-- <form class="" action="nuevo_reporte.php" method="post"> -->
                  <div class="form-group">
                    <input type="hidden" id="usuario_radica" value="<?php echo $usuario; ?>">
                      <input type="hidden" id="codigo_sala" name="codigo_sala" value="<?php echo $sala; ?>">
                    <input type="hidden" name="resumen_conceptos" value="0">
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label for="nombre_sala">Sala:</label>
                        <div class="input-group input-group-sm mb-1">
                          <div class="input-group-prepend">
                            <span class="input-group-text text-info"><i class="fas fa-map-pin fa-lg"></i></span>
                          </div>
                          <input type="text" name="nombre_sala" class="form-control" value="<?php echo $nombre_sala; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label for="fecha_inspeccion">Nueva fecha de inspección:</label>
                        <div class="input-group input-group-sm mb-1">
                          <div class="input-group-prepend">
                            <span class="input-group-text text-info"><i class="fas fa-calendar-alt fa-lg"></i></span>
                          </div>
                          <input type="date" id="fecha_inspeccion" name="fecha_inspeccion" class="form-control" value="<?php echo $fechaActual; ?>" required>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="card-body text-white bg-info">
                      <div class="col-md-4 offset-md-4">
                        <button type="button" class="btn btn-outline-light" onclick="crear_seguimiento()"><strong>CREAR NUEVO SEGUIMIENTO</strong></button>
                      </div>
                    </div>
                  </div>
              </div>
            <!-- </div> -->
          </div>
        </div>
        <br><br>
        <?php
        $sql_seguimientos = "SELECT ss.cod_seguimiento, ss.centro_costo,sa.sala_nombre, ss.fecha, ss.num_conceptos, ss.estado
                            FROM seguimiento_salas ss INNER JOIN queryx_seven.salas sa ON SS.centro_costo=sa.centro_costo
                            WHERE ss.centro_costo='$sala' AND sa.sociedad_ID=4   ORDER BY ss.cod_seguimiento DESC";
        // exit($sql_seguimientos);
        $query_seguimientos = $link_personal->query($sql_seguimientos);
        $resul_seguimientos = $query_seguimientos->fetch_object();

        $sql_segui_activo = "SELECT ss.cod_seguimiento, ss.centro_costo,sa.sala_nombre, ss.fecha, ss.num_conceptos, ss.estado
                            FROM seguimiento_salas ss INNER JOIN queryx_seven.salas sa ON SS.centro_costo=sa.centro_costo
                            WHERE ss.centro_costo='$sala' AND sa.sociedad_ID=4 AND ss.estado=1";
        $query_segui_activo = $link_personal->query($sql_segui_activo);
        $resul_segui_activo = $query_segui_activo->fetch_object();
        @$cod_segui_activo = $resul_segui_activo->cod_seguimiento;

         ?>
         <h4><strong><center>Seguimientos</center></strong></h4>
        <div class="row">
          <div class="col-md-11 offset-md-1">
              <!-- <div class="card mb-6"> -->

                  <div class="form-group">
                      <div class="panel panel-primary">
                        <div class="table-responsive">
                          <table class="table table-bordered">
                            </thead>
                              <th>CODIGO</th>
                              <th>CENTRO COSTO</th>
                              <th>FECHA</th>
                              <th>NUM. CONCEPTOS</th>
                              <th>ESTADO</th>
                              <th>NUEVO</th>
                              <th>CERRAR</th>
                              <th>INFORME</th>
                              </thead>
                              <tbody>
                                <?php
                                if (!empty($resul_seguimientos)) {
                                do {
                                  $cod_seguimiento = $resul_seguimientos->cod_seguimiento;
                                  $sala_nombre = $resul_seguimientos->sala_nombre;
                                  $fecha = $resul_seguimientos->fecha;
                                  $num_conceptos = $resul_seguimientos->num_conceptos;
                                  if (!isset($num_conceptos) || empty($num_conceptos)) {
                                    $num_conceptos=0;
                                  }
                                  $estado_segui = $resul_seguimientos->estado;
                                  $nom_estado = "";

                                  if ($estado_segui == 1) {
                                    $nom_estado = "ACTIVO";
                                  }elseif ($estado_segui == 2) {
                                    $nom_estado = "CERRADO";
                                  }
                                ?>
                                <tr>
                                  <td><?php echo $cod_seguimiento; ?></td>
                                  <td><?php echo $sala_nombre;?></td>
                                  <td><?php echo $fecha; ?></td>
                                  <td><?php echo $num_conceptos; ?></td>
                                  <input type="hidden" id="num_conceptos" value="<?php echo $num_conceptos; ?>">
                                  <td><?php  echo $nom_estado;?></td>
                                  <?php if ($estado_segui == 1){ ?>
                                    <td>
                                      <form class="" action="nuevo_reporte.php" method="post">
                                        <input type="hidden" id="codigo_sala" name="codigo_sala" value="<?php echo $sala; ?>">
                                        <input type="hidden" name="nombre_sala" value="<?php echo $nombre_sala; ?>">
                                        <input type="hidden" id="cod_seguimiento" name="cod_seguimiento" value="<?php echo $cod_seguimiento; ?>">
                                        <button type="submit" class="btn btn-success"><strong>NUEVA GESTIÓN</strong></button>
                                      </form>
                                    </td>
                                    <td><button class="btn btn-primary" onclick="cerrar_seguimiento()">CERRAR</button></td>
                                  <?php }else{ ?>
                                    <td></td>
                                    <td></td>
                                  <?php } ?>

                                  <form class="" action="generar_informe.php" method="post">
                                    <input type="hidden" name="cod_seguimiento" value="<?php echo $cod_seguimiento; ?>">
                                    <td><button type="submit" class="btn btn-danger"><i class="fas fa-file-pdf fa-lg"></i></button></td>
                                  </form>
                                </tr>
                                <?Php
                                  } while ($resul_seguimientos = $query_seguimientos->fetch_object());
                                }else {
                                  ?>
                                  <tr>
                                    <td>No hay Seguimientos</td>
                                  </tr>
                                <?php
                                }
                                 ?>
                              </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                <!-- </div> -->
                  <?php
                    if (isset($cod_segui_activo) && !empty($cod_segui_activo)) {


                      $sql_gestiones = "SELECT DISTINCT gs.codigo_gestion,gs.centro_costo,sa.sala_nombre,gs.fecha,gs.fecha_inspeccion,par.Descripcion as variable,
                  											gs.cod_concepto,vc.descripcion_con, gs.calificacion,gs.hallazgo,gs.acciones,
                  											gs.fecha_control,gs.observacion,gs.cod_sol_hermes,gs.estado_gestion,para.Descripcion as nom_estado
                  											FROM gestion_salas gs INNER JOIN queryx_seven.salas sa ON gs.centro_costo=sa.centro_costo
                  											AND gs.sociedad_ID=sa.sociedad_ID
                  											INNER JOIN caronte_bd.funcionario_salas fs ON gs.centro_costo=fs.cod_sala
                  											INNER JOIN variables_conceptos vc ON gs.cod_concepto=vc.cod_concepto
                  											INNER JOIN  parametros par ON gs.cod_variable= par.id_parametro
                  											INNER JOIN parametros para 	on 	gs.estado_gestion=para.id_parametro
                                        WHERE gs.centro_costo='$sala' AND gs.cod_seguimiento=$cod_segui_activo
                                        ORDER BY gs.fecha DESC";
                                        // exit($sql_gestiones);
                      $query_gestiones = $link_personal->query($sql_gestiones);
                      $resul_gestiones = $query_gestiones->fetch_object();


                  ?>
                  <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                      <thead class="text-center bg-info text-white " >
                        <tr class="bg-info">
                          <th>Código</th>
                          <th>Fecha</th>
                          <th>Variable</th>
                          <th>Concepto</th>
                          <th>Acciones</th>
                          <th>Calificación</th>
                          <th>Estado</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                        if (!empty($resul_gestiones)) {

                          $contador=0;
                        do{
                          $contador += 1;
                          $codigo_gestion = $resul_gestiones->codigo_gestion;
                          $nom_sala = $resul_gestiones->sala_nombre;
                          $fecha_gestion = $resul_gestiones->fecha;
                          $variable = $resul_gestiones->variable;
                          $nom_concepto = $resul_gestiones->descripcion_con;
                          $calificacion = $resul_gestiones->calificacion;
                          $acciones = $resul_gestiones->acciones;
                          $nom_estado = $resul_gestiones->nom_estado;
                          if ($calificacion >= 9) {
                            $color_fila = '#DFF0D8';
                          }elseif ($calificacion >= 7 and $calificacion <= 8) {
                            // $color_fila = 'bg-warning';
                            $color_fila= '#FCF8E3';
                          }elseif($calificacion >= 0 and $calificacion <= 6) {
                            $color_fila = '#FCF8E3';
                          }
                          ?>
                          <tr style="background-color:<?php echo $color_fila; ?>">
                            <td><?php echo $codigo_gestion; ?></td>
                            <!-- <td><?php //echo $nom_sala; ?></td> -->
                            <td style="width:100px;"><?php echo $fecha_gestion ?></td>
                            <td><?php echo $variable ?></td>
                            <td><?php echo $nom_concepto; ?></td>
                            <td><?php echo $acciones; ?></td>
                            <td><?php echo $calificacion; ?></td>
                            <td><?php echo $nom_estado; ?></td>
                          </tr>
                        <?php }while(  $resul_gestiones = $query_gestiones->fetch_object());
                      }
                    }?>
                      </tbody>
                    </table>
                  </div>
              <!-- </div> -->
          </div>
        </div>
        <br><br>
        <div class="row">
          <div class="col-md-11 offset-md-1">
              <div class="card mb-6">
                  <div class="form-group">
                    <div class="panel panel-primary">
                      <h4><strong><center>Consulta Gestiones Por Filtros</center></strong></h4>
                        <input type="hidden" name="codigo_sala" value="<?php echo $new_sala; ?>">
                        <div class="row">
                          <div class="col-md-3 offset-md-1">
                            <label><strong>Fecha inicial</strong></label>
                            <input type="date" id="finicial" name="finicial" value="<?php echo date("Y-m-")."01"?>" class="form-control" required>
                          </div>
                          <div class="col-md-3 ">
                            <label><strong>Fecha final</strong></label>
                            <input type="date" id="ffinal" name="ffinal" value="<?php echo date("Y-m-d")?>" class="form-control" required>
                          </div>
                          <div class="col-md-4">
                            <label><strong>Estado Gestiones:</strong></label>
                            <select class="form-control"  id="estado" name="estado">
                              <option value="">Seleccione</option>
                              <?php
                              $sql_estados= "SELECT id_parametro,Descripcion FROM parametros
                              WHERE Tipo_ID=12 and Estado=1 ORDER BY id_parametro";
                              $query_estados = $link_personal->query($sql_estados);
                              $resul_estados = $query_estados->fetch_object();
                              if (!empty($resul_estados)) {
                                do {
                                  $cod_parametro = $resul_estados->id_parametro;
                                  $descripcion = $resul_estados->Descripcion;

                                  echo '<option value="'.$cod_parametro.'">'.$descripcion.'</option>';

                                } while ($resul_estados = $query_estados->fetch_object());
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-md-4 offset-md-1">
                            <label><strong>Variables:</strong></label>
                            <select class="form-control"  id="variable" name="variable">
                              <option value="">Seleccione</option>
                              <?php
                              $sql_variables = "SELECT id_parametro,Descripcion FROM parametros
                              WHERE Tipo_ID=11 and Estado=1 ORDER BY id_parametro";
                              $query_variable = $link_personal->query($sql_variables);
                              $resul_variable = $query_variable->fetch_object();
                              if (!empty($resul_variable)) {
                                do {
                                  $cod_parametro = $resul_variable->id_parametro;
                                  $descripcion = $resul_variable->Descripcion;

                                  echo '<option value="'.$cod_parametro.'">'.$descripcion.'</option>';

                                } while ($resul_variable = $query_variable->fetch_object());
                              }
                              ?>
                            </select>
                          </div>
                            <div class="col-md-4 offset-md-2">
                              <button type="submit" class="btn btn-success" name="buscar" style="margin-top:25px;" value="1" onclick="buscar_gestiones()"><i class="fas fa-search fa-lg" ></i> BUSCAR</button>
                            </div>
                          </div>
                          <br>
                          <div id="resultados_gestiones"></div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
    </div>
  </body>
</html>
