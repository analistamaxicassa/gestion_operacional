<?php
  require_once('../conexionesDB/conexion.php');
  $link_personal = Conectarse_personal();
  $link_queryx_seven = Conectarse_queryx_mysql();
  $link_caronte=Conectarse_caronte();

  ini_set("session.gc_maxlifetime","2400");
  session_start();
  $sociedad = $_SESSION['cod_sociedad'];
  if(!isset($_SESSION['userID']))
  {
    header('Location: ../index.php');
    exit();
  }

  if (isset($_POST['sala']))
  {
    $sala = $_POST['sala'];
  }
  elseif (isset($_GET['sala']))
  {
    $sala = $_GET['sala'];
  }
  if (isset($_GET['codigo'])) {

      $cod_seguimiento = $_GET['codigo'];
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


  $sql_seguimientos = "SELECT  gs.codigo_gestion,gs.cod_seguimiento, gs.centro_costo,sa.sala_nombre,gs.fecha, gs.cod_concepto,avg(gs.calificacion) as calificacion
										   FROM gestion_salas gs INNER JOIN queryx_seven.salas sa ON gs.centro_costo=sa.centro_costo
										   AND gs.sociedad_ID=sa.sociedad_ID INNER JOIN variables_conceptos vc ON gs.cod_concepto=vc.cod_concepto
										   INNER JOIN  parametros par ON gs.cod_variable= par.id_parametro
										   WHERE gs.centro_costo='$sala' GROUP BY gs.fecha ORDER BY gs.fecha DESC";
  // exit($sql_seguimientos);
  $query_seguimientos = $link_personal->query($sql_seguimientos);
  $resul_seguimientos = $query_seguimientos->fetch_object();

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
      table .modal{
        font-size: 12px;
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
          <div class="card mb-6">
            <div class="card-body text-white bg-info">
                <div class="form-group">
                    <input type="hidden" id="codigo_sala" name="codigo_sala" value="<?php echo $sala; ?>">
                  <input type="hidden" name="resumen_conceptos" value="0">
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6 offset-md-3">
                      <label for="nombre_sala"><strong>PUNTO DE VENTA:</strong></label>
                      <div class="input-group input-group-sm mb-1">
                        <div class="input-group-prepend">
                          <span class="input-group-text text-info"><i class="fas fa-map-pin fa-lg"></i></span>
                        </div>
                        <input type="text" name="nombre_sala" class="form-control" value="<?php echo $nombre_sala; ?>" readonly>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </div>
          <br><br>
          <h4><strong><center>Seguimientos</center></strong></h4>
          <div class="card mb-6">
            <!-- <div class="card-body text-white bg-info"> -->
              <div class="form-group">
                  <div class="panel panel-primary">
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead class="text-center bg-info text-white"><tr class="bg-info">
                          <tr class="bg-info">
                            <th>CENTRO COSTO</th>
                            <th>NOMBRE SALA</th>
                            <th>FECHA</th>
                            <th>CALIFICACIÓN</th>
                            <th>VER</th>
                          </tr>
                          </thead>
                          <tbody>
                            <?php
                            if (!empty($resul_seguimientos)) {
                              $contador=0;
                            do {
                              $contador += 1;
                              $centro_costo = $resul_seguimientos->centro_costo;
                              $sala_nombre = $resul_seguimientos->sala_nombre;
                              $fecha = $resul_seguimientos->fecha;
                              $calificacion = $resul_seguimientos->calificacion;
                              $promedio_cal = number_format($calificacion,2,',','.');
                              if ($promedio_cal > 8) {
                                $color_fila = 'table-success';
                              }elseif ($promedio_cal > 6 and $promedio_cal <= 8) {
                                $color_fila = 'table-warning';
                              }elseif($promedio_cal >= 0 and $promedio_cal <= 6) {
                                $color_fila = 'table-danger';
                              }else {
                                $color_fila = 'table-success';
                              }

                            ?>
                            <tr class="<?php echo $color_fila; ?>">
                              <td><?php echo $centro_costo; ?></td>
                              <td><?php echo $sala_nombre;?></td>
                              <td><?php echo $fecha; ?></td>
                              <td><?php echo $promedio_cal; ?></td>
                              <td><button class="btn btn-info btn-lg" class="form-control" data-toggle='modal' data-target='#modal_general_<?php echo $contador; ?>' id="ver_detalle"><i class="fas fa-eye"></i></button></td>
                            </tr>
                          </tbody>
                            <div class="modal fade bd-example-modal-lg" id="modal_general_<?php echo $contador; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:100%;" >
                            <div class="modal-dialog modal-lg" role="document" style="width:100%;">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title" id="myModalLabel">Detalle Gestión Operacional</h4>
                                </div>
                                  <div class="modal-body">
                                    <div class="panel-body">
                                      <div class="row">

                                        <div class="col-md-4">
                                          <label><strong>SALA</strong></label>
                                        </div>
                                        <div class="col-md-2">
                                          <label><strong>FECHA</strong></label>
                                        </div>
                                        <div class="col-md-3">
                                          <label><strong>VARIABLE</strong></label>
                                        </div>
                                        <div class="col-md-2">
                                          <label><strong>CALIFICACIÓN</strong></label>
                                        </div>
                                      </div>

                                          <?php
                                          $sql_det_resumen = "SELECT  gs.codigo_gestion, gs.centro_costo,sa.sala_nombre,gs.fecha,gs.cod_variable,par.Descripcion as variable,
                                          gs.cod_concepto,AVG(gs.calificacion) as calificacion
                                          FROM gestion_salas gs INNER JOIN queryx_seven.salas sa ON gs.centro_costo=sa.centro_costo
                                          AND gs.sociedad_ID=sa.sociedad_ID INNER JOIN variables_conceptos vc ON gs.cod_concepto=vc.cod_concepto
                                          INNER JOIN  parametros par ON gs.cod_variable= par.id_parametro
                                          WHERE gs.fecha = '$fecha'
                                          AND gs.estado_gestion<>98 AND GS.centro_costo='$sala'
                                          group by gs.cod_variable ORDER BY gs.fecha DESC";

                                          $query_det_resumen = $link_personal->query($sql_det_resumen);
                                          $resul_det_resumen = $query_det_resumen->fetch_object();

                                          if (!empty($resul_det_resumen)) {
                                            // print_r($sql_det_resumen);
                                            $contador2 = 0;

                                          do {
                                            $contador2 += 1;
                                            $det_centro_costo = $resul_det_resumen->centro_costo;
                                            $det_sala_nombre = $resul_det_resumen->sala_nombre;
                                            $det_fecha = $resul_det_resumen->fecha;
                                            $det_cod_variable = $resul_det_resumen->cod_variable;
                                            $det_variable = $resul_det_resumen->variable;
                                            $det_calificacion = $resul_det_resumen->calificacion;
                                            $det_calificacion = number_format($det_calificacion,2,',','.');
                                            if ($det_calificacion > 8) {
                                              $color_fila = '#C3E6CB';
                                            }elseif ($det_calificacion > 6 and $det_calificacion <= 8) {
                                              $color_fila = '#FFEEBA';
                                            }elseif($det_calificacion >= 0 and $det_calificacion <= 6) {
                                              $color_fila = '#F5C6CB';
                                            }else {
                                              $color_fila = '#C3E6CB';
                                            }
                                            ?>
                                            <div class="row">
                                                <div class="col-md-4">
                                                  <input type="hidden" id="det_centro_costo_<?php echo $contador.'_'.$contador2; ?>" name="det_centro_costo_<?php echo $contador.'_'.$contador2; ?>" value="<?php echo $det_centro_costo; ?>">
                                                  <input type="text" class="form-control" style="background-color:<?php echo $color_fila;?>" id="det_sala_nombre_<?php echo $contador2; ?>" name="det_sala_nombre_<?php echo $contador2; ?>" value="<?php echo $det_sala_nombre; ?>" readonly>
                                                </div>
                                                <div class="col-md-2">
                                                  <input type="text" class="form-control" style="background-color:<?php echo $color_fila;?>" id="det_fecha_<?php echo $contador.'_'.$contador2; ?>" name="det_fecha_<?php echo $contador.'_'.$contador2; ?>" value="<?php echo $det_fecha; ?>" readonly>
                                                </div>
                                                <div class="col-md-3">
                                                  <input type="hidden" id="det_cod_variable_<?php echo $contador.'_'.$contador2; ?>" name="det_cod_variable_<?php echo $contador.'_'.$contador2; ?>"  value="<?php echo $det_cod_variable; ?>" >
                                                  <input type="text" class="form-control" style="background-color:<?php echo $color_fila;?>" id="det_variable_<?php echo $contador2; ?>" name="det_variable_<?php echo $contador2; ?>" value="<?php echo $det_variable; ?>" readonly>
                                                </div>
                                                <div class="col-md-2">
                                                  <input type="text" class="form-control" style="background-color:<?php echo $color_fila;?>" id="det_calificacion_<?php echo $contador2; ?>" name="det_calificacion_<?php echo $contador2; ?>" value="<?php echo $det_calificacion; ?>" readonly>
                                                </div>
                                                <div class="col-md-1">
                                                  <button class="btn btn-info" id="buscar_<?php echo $contador.'_'.$contador2; ?>"  onclick="buscar_gestiones(<?php echo $contador; ?>,<?php echo $contador2;?>);ver_gestiones(<?php echo $contador; ?>,<?php echo $contador2;?>)"><i class="fas fa-chevron-circle-down fa-lg"></i></button>
                                                  <button class="btn btn-info" id="ocultar_<?php echo $contador.'_'.$contador2; ?>"  onclick="ocultar_gestiones(<?php echo $contador; ?>,<?php echo $contador2;?>)" style="display:none;"><i class="fas fa-chevron-circle-up fa-lg"></i></button>
                                                </div>
                                            </div>
                                            <br>
                                            <div id="resultados_gestiones_<?php echo $contador.'_'.$contador2; ?>" style="display:none;"></div>
                                            <?Php
                                            } while ($resul_det_resumen = $query_det_resumen->fetch_object());
                                         }
                                           ?>
                                      </div>
                                    </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secundary" onclick="cerrar(<?php echo $contador; ?>)">Cerrar</button>
                                </div>
                              </div>
                              </div>
                            </div>
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

                      </table>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
  </body>
</html>
