<?php
  require_once('../conexionesDB/conexion.php');
  $link_personal = Conectarse_personal();
  $link_caronte=Conectarse_caronte();
  $link_queryx_seven = Conectarse_queryx_mysql();
  session_start();

  $sociedad_ID = $_SESSION['cod_sociedad'];


  if(!isset($_SESSION['userID']))
	{
		?>
		<script>
		alert("Sesión inactiva");
		location.href="index.php";
		</script>
			<?php
	}
	else
  {

    if (isset($_GET['fecha'])) {
      $fecha = $_GET['fecha'];
    }
    $centro_operacion = $_SESSION['centro_operacion'];
    if (strpos($centro_operacion,'-'))
    {
        list($empresa, $location, $area) = explode("-", $centro_operacion);
    }
  else
    {
      $location = $centro_operacion;
    }

    $sql_sala = "SELECT centro_costo,sala_nombre FROM salas WHERE centro_costo='$location' and sociedad_ID='$sociedad_ID'";
  	$query_sala = $link_queryx_seven->query($sql_sala);
  	$resul_sala = $query_sala->fetch_object();
  	$nombre_sala = $resul_sala->sala_nombre;

	}

  //CONSULTA DETALLE DE LAS GESTIONES POR CENTRO DE COSTO Y FECHA
  $sql_seguimientos="SELECT gs.codigo_gestion, gs.centro_costo,gs.fecha,gs.cod_variable,pa.Descripcion as nom_variable ,
                      gs.cod_concepto,vc.descripcion_con as nom_concepto,
                      gs.calificacion,gs.hallazgo,gs.acciones,gs.fecha_control,
                      gs.estado_gestion,para.Descripcion as nom_estado,gs.cod_sol_hermes,gs.observacion
                      FROM gestion_salas gs INNER JOIN parametros pa ON gs.cod_variable= pa.id_parametro
                      INNER JOIN variables_conceptos vc ON GS.cod_concepto=vc.cod_concepto
                      INNER JOIN parametros para ON gs.estado_gestion = para.id_parametro
                      WHERE gs.centro_costo='$location' and gs.fecha='$fecha'";
                      // exit($sql_seguimientos);
  $query_seguimientos = $link_personal->query($sql_seguimientos);
  $resul = $query_seguimientos->fetch_object();

	?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cliente Interno</title>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" integrity="sha384-kW+oWsYx3YpxvjtZjFXqazFpA7UP/MbiY4jvs+RWZo2+N94PFZ36T6TFkc9O3qoB" crossorigin="anonymous"></script>

    <script src="clases\bootbox\bootbox.min.js"></script>
    <script src="clases\bootbox\bootbox.locales.min.js"></script>
    <script type="text/javascript" src="clases\informe_auditoria.js"></script>
    </head>
  <body>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="inicio.php"><strong>INICIO</strong></a></li>
        <li class="breadcrumb-item">Informe Gestión operacional</li>
      </ol>
    </nav>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6 offset-md-1">
          <label><strong>Informe de Gestión Operacional: <?php echo $nombre_sala; ?></strong></label>
        </div>
      </div>
      <br><br>
        <div class="row">
        <div class="col-md-11 offset-md-1">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
             <thead class="text-center bg-info text-white">
             <tr class="bg-info">
              <th>Código</th>
              <th>Fecha</th>
              <th>variable</th>
              <th>Concepto</th>
              <th>calificacion</th>
              <th>Fecha Control</th>
              <th>Cod. Hermes</th>
              <th>Estado</th>
              <th>Detalles</th>
              <th>Det. Hermes</th>
              <th>Seguimientos</th>
            </tr>
            </thead>
          <tbody>
            <?php
            if (!empty($resul)) {
              $contador=0;
            do {
              $contador += 1;
              $codigo_gestion = $resul->codigo_gestion;
              $fecha  = $resul->fecha;
              $variable  = $resul->nom_variable;
              $concepto  = $resul->nom_concepto;
              $calificacion  = $resul->calificacion;

              $calificacion  = $resul->calificacion;
              if ($calificacion >= 9) {
                $color_fila = 'table-success';
              }elseif ($calificacion >= 7 and $calificacion <= 8) {
                $color_fila = 'table-warning';
              }elseif($calificacion >= 0 and $calificacion <= 6) {
                $color_fila = 'table-danger';
              }else {
                $color_fila = 'table-success';
              }

              $hallazgo = $resul->hallazgo;
              $acciones = $resul->acciones;
              $fecha_control = $resul->fecha_control;
              $cod_sol_hermes  = $resul->cod_sol_hermes;
              $estado  = $resul->nom_estado;
              $observacion = $resul->observacion;

              //consulta de detalles de la solicitud
              $detalles_solicitud = false;
              $sql_det_hermes = "SELECT sol.solicitud_id, sol.descripcion,sol.prioridad,pa.Descripcion as nom_prioridad, sol.solicitante,
              em.emp_nombre as nom_solicitante,sol.ejecutante,emp.emp_nombre as nom_ejecutante,
              sol.responsable,emple.emp_nombre as nom_responsable,sol.informado,
              empleado.emp_nombre as nom_informado, sol.fecha_inicial,sol.fecha_cumpliento
              FROM solicitud sol INNER JOIN parametros pa ON sol.prioridad=pa.id_parametro
              INNER JOIN queryx_seven.empleado em ON sol.solicitante=em.emp_codigo
              INNER JOIN queryx_seven.empleado emp ON sol.ejecutante = emp.emp_codigo
              INNER JOIN queryx_seven.empleado emple ON sol.responsable = emple.emp_codigo
              INNER JOIN queryx_seven.empleado ON sol.informado = empleado.emp_codigo
              WHERE sol.solicitud_id = $cod_sol_hermes";
              // exit($sql_det_hermes);
              $query_det_hermes = $link_caronte->query($sql_det_hermes);
              if ($query_det_hermes == false) {
                echo "no hay datos de detalle de solicitud";
                exit();
              }
              $resul_datos = $query_det_hermes->fetch_object();
              if (!empty($resul_datos)) {

                $detalles_solicitud= true;
                $solicitud_id = $resul_datos->solicitud_id;
                $descripcion = $resul_datos->descripcion;
                $prioridad = $resul_datos->nom_prioridad;
                $nom_solicitante = $resul_datos->nom_solicitante;
                $nom_ejecutante = $resul_datos->nom_ejecutante;
                $nom_responsable = $resul_datos->nom_responsable;
                $nom_informado = $resul_datos->nom_informado;
                $fecha_creacion = $resul_datos->fecha_inicial;
                $fecha_creacion = date("d/m/Y", strtotime($fecha_creacion));
                $fecha_cumpliento = $resul_datos->fecha_cumpliento;
                $fecha_cumpliento = date("d/m/Y", strtotime($fecha_cumpliento));
              }


              ?>
             <tr class="<?php echo $color_fila; ?>">
               <td><?php echo $codigo_gestion; ?></td>
               <td><?php echo $fecha;?></td>
               <td><?php echo $variable;?></td>
               <td><?php echo $concepto;?></td>
               <td><?php echo $calificacion;?></td>
               <td><?php echo $fecha_control;?></td>
               <td><?php echo $cod_sol_hermes;?></td>
               <td><?php echo $estado;?></td>
               <td><button class="btn btn-info btn-lg" class="form-control" data-toggle='modal' data-target='#modal_detalle_<?php echo $contador; ?>' id="ver_detalle"><i class="fas fa-eye"></i></button></td>
               <?php if ($detalles_solicitud){ ?>
               <td><button class="btn btn-success btn-lg" class="form-control" data-toggle='modal' data-target='#detalle_hermes_<?php echo $contador; ?>' id="ver_detalle_sol"><i class="far fa-eye"></i></button></td>
             <?php }else{ ?>
               <td></td>
             <?php } ?>
               <td><button class="btn btn-primary btn-lg" class="form-control" data-toggle='modal' data-target='#seguimientos_<?php echo $contador; ?>' id="ver_seguimientos"><i class="fas fa-plus"></i></button></td>
             </tr>
           </tbody>
           <div class="modal fade bd-example-modal-lg" id="modal_detalle_<?php echo $contador; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:100%" >
             <div class="modal-dialog modal-lg" role="document" style="width:100%">
               <div class="modal-content">
                 <div class="modal-header">
                   <h4 class="modal-title" id="myModalLabel">Detalle Gestión Operacional</h4>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                   </button>
                 </div>
                 <div class="modal-body">
                   <div class="panel-body">
                     <div class="row">
                       <div class="col-md-3">
                         <label for="fecha_visita"><strong>Fecha de inspección:</strong></label>
                         <input type="date" id="fecha_visita" name="fecha_visita" value="<?php echo $fecha; ?>" class="form-control" readonly>
                       </div>
                       <div class="col-md-4">
                         <label for="cod_variable"><strong>Variable:</strong></label>
                         <input type="text" class= "form-control" name="variable_<?php echo $contador; ?>" value="<?php echo $variable; ?>" readonly>
                       </div>
                       <div class="col-md-4">
                         <label><strong>Concepto a Evaluar:</strong></label>
                         <!-- <div id="concepto_evaluar"></div> -->
                           <input type="text" class= "form-control" name="concepto_<?php echo $contador; ?>" value="<?php echo $concepto; ?>" readonly>
                       </div>
                     </div>
                     <br>
                     <?php
                     $sql_temas = "SELECT tg.codigo_gestion,tg.codigo_tema,ct.descripcion_tema
                                   FROM temas_gestion tg INNER JOIN conceptos_temas ct
                                   ON tg.codigo_tema = ct.cod_tema and codigo_gestion=$codigo_gestion";
                     $query_temas = $link_personal->query($sql_temas);
                     $resul_temas = $query_temas->fetch_object();
                     ?>
                     <div class="row">
                       <div class="col-md-8">
                         <label><strong>Tema(s)  Seleccionado(s):</strong></label>
                           <!-- <input type="text" class= "form-control" name="tema_<?php //echo $contador; ?>" value="<?php echo $tema; ?>" readonly> -->
                           <?php
                           if (!empty($resul_temas)) {
                             do {
                               $nombretema= $resul_temas->descripcion_tema;

                               echo '<input type="text" class= "form-control" name="tema_'.$contador.'" value="'.$nombretema.'" readonly>';

                             } while (  $resul_temas = $query_temas->fetch_object());
                           }
                           ?>
                       </div>
                       <div class="col-md-4">
                         <label for="calificacion"><strong>Calificación:</strong></label>
                         <input type="number" class="form-control"  name="calificacion<?php echo $contador; ?>" value="<?php echo $calificacion; ?>" readonly>
                       </div>
                     </div>
                     <br>
                     <div class="row">
                       <div class="col-md-6">
                         <label for="hallazgo"><strong>Hallazgo:</strong></label>
                         <textarea  name="hallazgo_<?php echo $contador; ?>" cols="4" rows="7" class="form-control" readonly><?php echo $hallazgo; ?></textarea>
                       </div>
                       <div class="col-md-6">
                         <label for="tarea"><strong>Acciones:</strong></label>
                         <textarea  name="acciones_<?php echo $contador; ?>" cols="4" rows="7" class="form-control" readonly><?php echo $acciones; ?></textarea>
                       </div>
                     </div><br>
                     <div class="row">
                       <div class="col-md-3">
                         <label for="fcontrol"><strong>Fecha control:</strong></label>
                         <input type="date" class="form-control" name="fecha_control_<?php echo $contador; ?>" value="<?php echo $fecha_control; ?>" readonly>
                         <!-- <input type="hidden" id="evaluador" name="evaluador" value="<?php //echo $cod_usuario; ?>">
                         <input type="hidden" name="sala" value="<?php //echo $codigo_sala; ?>"> -->
                       </div>
                       <div class="col-md-8">
                         <label for="observacion"><strong>Observaciones:</strong></label>
                         <textarea name="observacion_<?php echo $contador; ?>" cols="4" rows="5" class="form-control" readonly><?php echo $observacion; ?></textarea>
                       </div>
                     </div><br><br>
                   </div>
                 </div>
                 <div class="modal-footer">
                   <button type="button" class="btn btn-secundary" onclick="cerrar2(<?php echo $contador; ?>)">Cerrar</button>
                 </div>
               </div>
             </div>
           </div>

           <!-- MODAL PARA MOSTRAR DETALLE DE LA SOLICITUD EN HERMES -->
           <div class="modal fade bd-example-modal-lg" id="detalle_hermes_<?php echo $contador; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:100%" >
             <div class="modal-dialog modal-lg" role="document" style="width:100%">
               <div class="modal-content">
                 <div class="modal-header">
                   <h4 class="modal-title" id="myModalLabel">Detalle Solicitud Hermes</h4>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                   </button>
                 </div>
                 <div class="modal-body">
                   <div class="panel-body">
                     <div class="row">
                       <div class="col-md-3">
                         <label><strong>Código Hermes</strong></label>
                         <input type="text" class="form-control" name="cod_solicitud_<?php echo $contador; ?>" value="<?php echo $solicitud_id; ?>" readonly>
                       </div>
                     </div>
                     <br>
                     <div class="row">
                       <div class="col-md-6">
                         <label><strong>Solicitante:</strong></label>
                         <input type="text" class="form-control" name="solicitante_<?php echo $contador; ?>" value="<?php echo $nom_solicitante;?>" readonly>
                       </div>
                       <div class="col-md-6">
                         <label><strong>Ejecutor: </strong></label>
                         <input type="text" class="form-control" name="ejecutor_<?php echo $contador; ?>" value="<?php echo $nom_ejecutante;?>" readonly>
                       </div>
                     </div>
                     <br>
                     <div class="row">
                       <div class="col-md-6">
                         <label><strong> Responsable:</strong></label>
                         <input type="text" class="form-control" name="responsable_<?php echo $contador; ?>" value="<?php echo $nom_responsable;?>" readonly>
                       </div>
                       <div class="col-md-6">
                         <label><strong>Informado</strong></label>
                         <input type="text" class="form-control" name="informado_<?php echo $contador; ?>" value="<?php echo $nom_informado;?>" readonly>
                       </div>
                     </div>
                     <br>
                     <div class="row">
                       <div class="col-md-3">
                         <label><strong>Prioridad</strong></label>
                         <input type="text" class="form-control" name="prioridad_<?php echo $contador; ?>" value="<?php echo $prioridad; ?>" readonly>
                       </div>
                       <div class="col-md-3">
                         <label><strong>Fecha Solicitud</strong></label>
                         <input type="text" class="form-control" name="fecha_creacion_<?php echo $contador; ?>" value="<?php echo $fecha_creacion; ?>" readonly>
                       </div>
                       <div class="col-md-3">
                         <label><strong>Fecha Cumplimiento</strong></label>
                         <input type="text" class="form-control" name="fecha_cumpliento_<?php echo $contador; ?>" value="<?php echo $fecha_cumpliento; ?>" readonly>
                       </div>
                       <div class="col-md-3">
                         <label><strong>Estado</strong></label>
                         <input type="text" class="form-control" name="estado_sol_<?php echo $contador; ?>" value="<?php echo $estado; ?>" readonly>
                       </div>
                     </div>
                     <br>
                     <div class="row">
                       <label><strong>Descripción</strong></label>
                       <div class="col-md-12">
                         <textarea class="form-control" name="descripcion" rows="5" cols="80" readonly><?php echo $descripcion; ?></textarea>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="modal-footer">
                   <button type="button" class="btn btn-secundary" onclick="cerrar_det_sol(<?php echo $contador; ?>)">Cerrar</button>
                 </div>
               </div>
             </div>
           </div>


           <!-- MODAL PARA VER Y AGREGAR SEGUIMIENTOS A LAS GESTIONES    -->
           <input type="hidden" id="codigo_gestion_<?php echo $contador; ?>" name="codigo_gestion_<?php echo $contador; ?>" value="<?php echo $codigo_gestion; ?>" >
           <div class="modal fade bd-example-modal-lg" id="seguimientos_<?php echo $contador; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:100%" >
             <div class="modal-dialog modal-lg" role="document" style="width:100%">
               <div class="modal-content">
                 <div class="modal-header">
                   <h4 class="modal-title" id="myModalLabel">Seguimientos a Gestión sala</h4>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                   </button>
                 </div>
                 <div class="modal-body">
                   <label><strong><h5>Seguimiento de la gestión</h5></strong></label>
                     <?php
                     $sql_consulta_segui = "SELECT ss.cod_seguimiento,ss.fecha,ss.estado,par.Descripcion as nom_estado,
                                           ss.descripcion,emp.emp_nombre from segui_gestion_salas ss
                                           INNER JOIN parametros par ON SS.estado= par.id_parametro
                                           INNER JOIN queryx_seven.empleado emp ON ss.usuario_registro=emp.emp_codigo
                                           where ss.cod_gestion='$codigo_gestion'";
                     $query_consulta_segui = $link_personal->query($sql_consulta_segui);
                     $resul_consulta_segui = $query_consulta_segui->fetch_object();

                     if (!empty($resul_consulta_segui)) {
                       $conta_segui=0;
                       do {
                         $conta_segui += 1;
                         $cod_seguimiento = $resul_consulta_segui->cod_seguimiento;
                         $fecha_segui = $resul_consulta_segui->fecha;
                         $estado_segui = $resul_consulta_segui->nom_estado;
                         $descripcion_segui = $resul_consulta_segui->descripcion;
                         $nombre_usuario = $resul_consulta_segui->emp_nombre;
                     ?>
                   <div class="row">
                     <div class="col-md-2">
                       <label for="fecha"><strong>Fecha </strong></label>
                       <input type="text" class="form-control" name="fecha_segui_<?php echo $conta_segui; ?>" value="<?php echo $fecha_segui; ?>" readonly>
                     </div>
                     <div class="col-md-2">
                       <label for="fecha"><strong>Estado</strong></label>
                       <input type="text" class="form-control" name="estado_segui_<?php echo $conta_segui; ?>" value="<?php echo $estado_segui; ?>" readonly>
                     </div>
                     <div class="col-md-5">
                       <label for="fecha"><strong>Seguimiento</strong></label>
                       <textarea type="text" class="form-control" name="seguimiento_<?php echo $conta_segui; ?>" readonly> <?php echo $descripcion_segui; ?></textarea>
                     </div>
                     <div class="col-md-3">
                       <label for="fecha"><strong>Usuario</strong></label>
                       <textarea type="text" class="form-control" name="seguimiento_<?php echo $conta_segui; ?>" readonly> <?php echo $nombre_usuario; ?></textarea>
                     </div>
                   </div>
                   <br>
                   <?php
                         } while ($resul_consulta_segui = $query_consulta_segui->fetch_object());
                       }else { ?>
                         <div class="row">
                           <div class="col-md-6 offset-md-2">
                             <label>Aún no hay seguimientos </label>
                           </div>
                         </div>
                   <?php    }
                   ?>
                   <hr>
                   <label><strong><h5>Nuevo Seguimiento</h5></strong></label>
                   <div class="row">
                     <div class="col-md-3 offset-md-1">
                       <label><strong></strong></label>
                       <select class="form-control" id="estado_segui_<?php echo $contador; ?>" name="estado_segui_<?php echo $contador; ?>">
                         <!-- <option value="">Seleccione</option> -->
                         <?php
                         $sql_estados = "SELECT id_parametro, Descripcion FROM parametros
                                         WHERE Tipo_ID='12' AND Estado=1 ORDER BY id_parametro";
                         $query_estados = $link_personal->query($sql_estados);
                         $resul_estados = $query_estados->fetch_object();
                         do {
                           $cod_estado = $resul_estados->id_parametro;
                           $nom_estado = $resul_estados->Descripcion;

                         if ($estado_segui == $cod_estado) {
                             echo '<option value='.$cod_estado.' selected>'.$nom_estado.'</option>';
                         }else {
                           echo '<option value='.$cod_estado.'>'.$nom_estado.'</option>';
                         }

                         } while ($resul_estados = $query_estados->fetch_object());
                         ?>
                       </select>
                     </div>
                     <div class="col-md-8">
                       <textarea class="form-control" id="nuevo_seguimiento_<?php echo $contador; ?>" name="nuevo_seguimiento_<?php echo $contador; ?>" rows="4" cols="60" placeholder="Describa el seguimiento"></textarea>
                     </div>
                   </div>
                 </div>
                 <div class="modal-footer">
                   <button type="button" class="btn btn-primary" onclick="guardar_seguimiento(<?php echo $contador; ?>)">Guardar Seguimiento</button>
                   <button type="button" class="btn btn-secundary" onclick="cerrar_mod_segui(<?php echo $contador; ?>)">Cerrar</button>
                 </div>
               </div>
             </div>
           </div>
              <?php
              } while ($resul= $query_seguimientos->fetch_object());
            }else {
              echo "<tr><td>No se encuentran gestiones realizadas para el PDV</td></tr>";
              exit();
            }
            ?>
            </table>
          </div>
        </div>
     </div>
  </div>

    <!-- <div class="table-responsive col-md-12">
      <table class="table table-bordered">
        <thead>
          <tr class="bg-primary">
            <th style="text-align:center">Fecha</th>
            <th style="text-align:center">Concepto</th>
            <th style="text-align:center">Calificación</th>
            <th style="text-align:center">Hallazgo</th>
            <th style="text-align:center">Tarea</th>
            <th style="text-align:center">Responsable</th>
            <th style="text-align:center">Fecha Control</th>
            <th style="text-align:center">Estado</th>
          </tr>
        </thead>
        <tbody> -->
        <?php
          //consulta de concepto de sala
          // $sql_resumen="SELECT cs.fecha,cs.concepto_esp,par.Descripcion, cs.calificacion,cs.hallazgo,cs.tarea,cs.responsable,cs.fecha_control,cs.ESTADO
          // FROM concepto_sala cs INNER JOIN parametros par ON cs.concepto_esp=par.id_parametro
          //  WHERE cs.cc='$location' AND cs.fecha = '$fecha' ORDER BY cs.calificacion DESC";
          // $query_resumen=$link_personal->query($sql_resumen);
          // $resumen=$query_resumen->fetch_object();  ///consultar
          //
          // if (empty($resumen)) {
          //   echo 'No existen registros';
          // }
          // else
          // {
          //   do{
        ?>
                  <!-- <tr>
                    <td><?php //echo ($resumen->fecha); ?></td>
                    <td><?php //echo  ($resumen->Descripcion); ?></td>
                    <td><?php //echo ($resumen->calificacion); ?></td>
                    <td><?php //echo  ($resumen->hallazgo); ?></td>
                    <td><?php //echo  ($resumen->tarea); ?></td>
                    <td><?php //echo  ($resumen->responsable); ?></td>
                    <td><?php //echo ($resumen->fecha_control); ?></td>
                    <td><?php //echo  ($resumen->ESTADO); ?></td>
                  </tr> -->
        <?php
          //   }while($resumen=$query_resumen->fetch_object());
          //   $query_resumen->close();
          // }
        ?>
        <!-- </tbody>
      </table>
    </div> -->
</body>
</html>
