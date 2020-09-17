<?php
  require_once('../conexionesDB/conexion.php');
  $link_personal = Conectarse_personal();
  $link_caronte=Conectarse_caronte();
  $link_queryx_seven = Conectarse_queryx_mysql();
  ini_set("session.gc_maxlifetime","2400");
  session_start();

  $mostrar_mensaje = false;
  if (isset($_GET['mensaje'])) {
    $tipo_mensaje = $_GET['mensaje'];
    $mostrar_mensaje = true;
    if ($tipo_mensaje == 1) {
      $color = 'alert-success';
      $texto_mensaje = '<i class="fab fa-angellist fa-lg"></i> Se ha creado el registro con éxito.';
    } elseif ($tipo_mensaje == 2) {
      $color = 'alert-danger';
      $texto_mensaje = '<i class="fas fa-calendar-times fa-lg"></i> No se pudo crear su solicitud, se presentaron errores al crear el registro, intenter de nuevo en un momento.';
    }elseif ($tipo_mensaje ==3) {
      $color = 'alert-warning';
      $texto_mensaje = '<strong> No hay datos suficientes, falló la creación del seguimiento </strong>';
    }else {
     $mostrar_mensaje = false;
   }

 }

  $cod_usuario = 	$_SESSION['userID'];
  $cod_cargo = $_SESSION['cod_cargo'];
  $codigo_sala = $_REQUEST['codigo_sala'];
  $nombre_sala = $_POST['nombre_sala'];
  // @$resumen_conceptos = $_POST['resumen_conceptos'];
  $fechaActual = new DateTime('now');
  $fecha_inspeccion = $fechaActual->format('Y-m-d');
	$fechaActual = $fechaActual->format('Y-m-d');
  $mostrar_observa=0;

  //información para el modal de creación de solicitudes
  $centro_costo = $_SESSION['centro_costo'];
  list($empresa, $sala, $area) = explode('-', $centro_costo);
  $cargo_solicitante = $_SESSION['cargo'];
  $nombre_solicitante = $_SESSION['nombre'];
  $solicitante = $nombre_solicitante." - ".$cargo_solicitante;

  $sql_sociedad="SELECT sociedad_ID  from sociedad WHERE COD_SOCIEDAD='$empresa'";
  $query_sociedad=$link_queryx_seven->query($sql_sociedad);
  $result_sociedad = $query_sociedad->fetch_object();
  $cod_empresa =$result_sociedad->sociedad_ID;

  $sql_sala = "SELECT sl.centro_costo,CONCAT(sl.sala_nombre,' - ',soc.NOMBRE_SOCIEDAD) as ubicacion ,sl.sociedad_ID,soc.COD_SOCIEDAD
              FROM salas sl inner join sociedad soc on sl.sociedad_ID=soc.sociedad_ID WHERE sl.activo=1
              AND soc.COD_SOCIEDAD<>50 AND soc.COD_SOCIEDAD<>70 ORDER BY ubicacion";
  $query_sala = $link_queryx_seven->query($sql_sala);

  //validacion para mostrar observaciones confidenciales
   if ($cod_cargo == 151 || $cod_cargo == 152 || $cod_cargo == 146 || $cod_cargo == 242 || $cod_cargo == 159 || $cod_cargo == 200)
   {
     $mostrar_observa=1;
  }

  // if ($resumen_conceptos == "0") {
  //   $resumen = false;
  // } else {
  //   $sql_resumen="SELECT cs.fecha,cs.concepto_esp,par.Descripcion, cs.calificacion,cs.hallazgo,cs.tarea,cs.responsable,cs.fecha_control,cs.observacion_conf,cs.ESTADO
  //   FROM concepto_sala cs INNER JOIN parametros par ON cs.concepto_esp=par.id_parametro WHERE cs.cc='$codigo_sala' and cs.fecha='$fecha_inspeccion' ORDER BY fecha DESC";
  //   $query_resumen=$link_personal->query($sql_resumen);
  //   $resumen = $query_resumen->fetch_object();
  //
  // }

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Auditoria Operacional</title>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Merriweather:700i" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
	   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" integrity="sha384-kW+oWsYx3YpxvjtZjFXqazFpA7UP/MbiY4jvs+RWZo2+N94PFZ36T6TFkc9O3qoB" crossorigin="anonymous"></script>

    <script type="text/javascript" src="clases\nuevo_reporte.js"></script>
    <script src="clases\bootbox\bootbox.min.js"></script>
    <script src="clases\bootbox\bootbox.locales.min.js"></script>
  </head>
  <body>
    <?php if ($mostrar_mensaje): ?>
      <div class="alert <?php echo $color; ?> alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo $texto_mensaje; ?>
      </div>
    <?php endif; ?>
    <ol class="breadcrumb">
      <li><a href="reportes_sala.php?sala=<?php echo $codigo_sala;?>"><i class="fas fa-chevron-circle-left"></i> <strong><?php echo $nombre_sala; ?></strong></a></li>
      <li class="active"><strong>NUEVA EVALUACIÓN</strong></li>
    </ol>
    <?php //if (empty($resumen)): ?>
    <?php //else: ?>
      <!-- <div class="table-responsive col-md-12 col-sm-12">
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
          <?php // do{ ?>
                    <tr>
                      <td><?php //echo  ($resumen->Descripcion); ?></td>
                      <td><?php //echo ($resumen->calificacion); ?></td>
                      <td><?php //echo  ($resumen->hallazgo); ?></td>
                      <td><?php //echo  ($resumen->tarea); ?></td>
                      <td><?php //echo  ($resumen->responsable); ?></td>
                      <td><?php //echo ($resumen->fecha_control); ?></td>
                      <?php //if ($mostrar_observa == 1): ?>
                      <td><?php //echo ($resumen->observacion_conf); ?></td>
                      <?php //else:?>
                      <td></td>
                      <?php //endif; ?>
                      <td><?php //echo  ($resumen->ESTADO); ?></td>
                    </tr>
          <?php
               // }while($resumen = $query_resumen->fetch_object());

          ?>
          </tbody>
        </table>
      </div> -->
    <?php //endif; ?>
<br>
<input type="hidden" id="userID" value="<?php echo $_SESSION["userID"]; ?>">
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <center><h3 class="panel-title"><strong><?php echo $nombre_sala; ?></strong></h3></center>
                </div>
                <div class="panel-body">
                    <div class="row">
                      <div class="col-md-3">
                        <label for="fecha_visita">Fecha de inspección:</label>
                        <input type="date" id="fecha_visita" name="fecha_visita" value="<?php echo date("Y-m-d"); ?>" class="form-control" readonly>
                      </div>
                      <div class="col-md-4">
                        <label for="cod_variable">* Variable:</label>
                        <select id="cod_variable" name="cod_variable" class="form-control" onchange="buscar_concepto()" required>
                          <option value="">Seleccione...</option>
                          <?php
                          $sql_variable = "SELECT id_parametro,Descripcion FROM parametros WHERE Tipo_ID=11 AND Estado=1";
                          $query = $link_personal->query($sql_variable);
                          while($valores=$query->fetch_object())
                          {
                            echo '<option value="'.$valores->id_parametro.'">'.$valores->Descripcion.'</option>';
                          }
                          ?>
                        </select>
                      </div>
                      <div class="col-md-4">
                        <label><strong>Concepto a Evaluar:</strong></label>
                        <div id="concepto_evaluar"></div>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-2">
                        <label for="nota"><strong>Calificación actual:</strong></label>
                        <input type="number" class="form-control" id="calificacion_ant" name="calificacion_ant" readonly>
                        <small><input type="radio" id="radiocalifica" name="radiocalifica" onchange="editcalificacion(this)"> Actualizar Calificación.</small>
                        <input type="hidden" id="codigo_sol_califica" name="codigo_sol_califica">
                      </div>
                      <div class="col-md-2">
                        <label for="nota"><strong>Nueva Calificación:</strong></label>
                        <input type="number" class="form-control" id="calificacion" name="calificacion" min="1" max="10" step="1" required>
                      </div>
                      <div class="col-md-8">
                        <label><strong>Tema a revisar:</strong></label>
                        <div id="tema_revisar"></div>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="hallazgo"><strong>Hallazgo:</strong></label>
                        <textarea id="hallazgo" name="hallazgo" cols="4" rows="7" class="form-control" placeholder="Describa el hallazgo" required></textarea>
                      </div>
                      <div class="col-md-6">
                          <label for="tarea"><strong>Acciones:</strong></label>
                          <textarea id="acciones" name="acciones" cols="4" rows="7" class="form-control" placeholder="Describa las acciones realizadas" required></textarea>
                      </div>
                    </div><br>
                    <div class="row">
                      <div class="col-md-3">
                        <label for="fcontrol"><strong>Fecha control:</strong></label>
                        <input type="date" id="fecha_control" name="fecha_control" value="<?php echo $fechaActual; ?>" class="form-control" required>
                        <input type="hidden" id="evaluador" name="evaluador" value="<?php echo $cod_usuario; ?>">
                        <input type="hidden" id= "sala" name="sala" value="<?php echo $codigo_sala; ?>">
                      </div>
                      <div class="col-md-8">
                        <label for="observacion"><strong>Observaciones:</strong></label>
                        <textarea id="observacion" name="observacion" cols="4" rows="5" class="form-control" placeholder="Agregue la observación"></textarea>
                      </div>
                    </div><br><br>
                    <div class="row">
                      <div class="col-md-3 offset-md-2">
                        <button class="btn btn-info btn-lg" class="form-control" data-toggle='modal' data-target='#modal' id="crear_solicitud" ><i class="fas fa-plus"></i> Crear Solicitud</button>
                      </div>
                      <div class="col-md-3 offset-md-2">
                        <button class="btn btn-primary btn-lg" name="enviar" onclick="guardar_gestion();" ondblclick="this.disabled='disabled'" id="guardar_gestion" disabled>Guardar Gestión</button>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:100%" >
      <div class="modal-dialog modal-lg" role="document" style="width:100%">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Registro solicitudes HERMES</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="form-group">
                <div class="col-md-8">
                  <label for="">Datos del solicitante:</label>
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-paper-plane fa-lg" style="color:#002F87;"></i></span>
                    <input type="text" readonly class="form-control" name="solicitante" value="<?php echo $solicitante; ?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <label for="sala">Ubicación:</label>
                  <select class="form-control" name="sala" id="sala" disabled="true">
                    <?php
                    while ($datos_sala = $query_sala->fetch_object()) {

                      $centro_costo = $datos_sala->centro_costo;
                      $sala_nombre = $datos_sala->ubicacion;
                      $codigo_sociedad = $datos_sala->sociedad_ID;
                      $cod_sociedad = $datos_sala->COD_SOCIEDAD;

                      if (($centro_costo == $codigo_sala) && ($cod_sociedad == $empresa)) { ?>
                        <option value="<?php echo $centro_costo.'-'.$codigo_sociedad; ?>" selected ><?php echo $sala_nombre; ?></option>
                        <?php
                      }
                      else
                      { ?>
                        <option value="<?php echo $centro_costo.'-'.$codigo_sociedad; ?>"><?php echo $sala_nombre; ?></option>
                        <?php
                      } ?>
                    <?php } ?>
                  </select>
                  <input type="radio" name="radioSala" id="radioSala" onchange="editarSala(this)"><small> Cambiar mi ubicación para esta solicitud.</small>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="descripcion">Descripción:</label>
                  <textarea class="form-control" rows="3" id="descripcion" name="descripcion" placeholder="Ingrese una descripción concreta de su solicitud." required></textarea>
                  <input type="hidden" id="sala_queryx" name="sala_queryx" value="<?php echo $sala.'-'.$cod_empresa; ?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <label for="prioridad">Prioridad:</label>
                <select class="form-control" id="prioridad" name="prioridad" required>
                  <option value="">Seleccionar prioridad</option>
                  <?php
                  $query=$link_caronte->query("select id_parametro,Descripcion from parametros WHERE tipo_ID=1");
                  while($valores=$query->fetch_object())
                  {
                    echo '<option value="'.$valores->id_parametro.'">'.$valores->Descripcion.'</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-8">
                <div id="form" class="form-group" enctype="multipart/form-data">
                  <label for="">Adjuntar archivo (Foto y/o Descripción):</label>
                  <form id="form1" action="" enctype="multipart/form-data" method="post">
                    <input type="file" id="file_adjunto" name="file_adjunto">
                  </form>
                  <small>*Solo se permite subir archivos PDF que no superen los 8 Megabytes.</small>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="ejecutor">Ejecutor:</label>
                  <i class="fa fa-question-circle fa-1x" data-toggle="tooltip" onclick="desplegarTooltip()" style="color:#33ffff;" title="Escriba el nombre de la persona que tiene la responsabilidad de ejecutar su solicitud."></i>
                  <input class="form-control" placeholder="Ejecutor" id="ejecutor" name="ejecutor" onKeyUp="filtrar_nombres()" type="text" id="ejecutor" autocomplete="off" required>
                  <input type="hidden" id="ejecutorID" name="ejecutorID">
                </div>
                <div id="resultadosEjecutor"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="responsable">Responsable:</label>
                  <i class="fa fa-question-circle fa-1x" data-toggle="tooltip" onclick="desplegarTooltip()" style="color:#33ffff;"  title="Escriba el nombre del jefe de área de la persona seleccionada en el campo anterior."></i>
                  <input class="form-control" placeholder="Responsable" id="responsable" name="responsable" onKeyUp="filtrar_nombres()" type="text" id="responsable" autocomplete="off" required>
                  <input type="hidden" id="responsableID" name="responsableID">
                </div>
                <div id="resultadosResponsable"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="informado">Informado:</label>
                  <i class="fa fa-question-circle fa-1x" data-toggle="tooltip" onclick="desplegarTooltip()" style="color:#33ffff;" title="Escriba el nombre un gerente o director que esté relacionado con el área que atiende su solicitud."></i>
                  <input class="form-control" placeholder="Informado" id="informado" name="informado" onKeyUp="filtrar_nombres()" type="text" id="informado" autocomplete="off" required>
                  <input type="hidden" id="informadoID" name="informadoID">
                </div>
                <div id="resultadosInformado"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group" hidden="true">
                  <label for="estado">Estado:</label>
                  <select class="form-control" name="estado" id="estado" required>
                    <option value="">Seleccionar estado</option>
                    <option value="4" selected>Iniciado</option>
                    <?php
                    $query=$link_caronte->query("select id_parametro,Descripcion from parametros WHERE tipo_ID=2");
                    while($valores=$query->fetch_object())
                    {
                      echo '<option value="'.$valores->id_parametro.'">'.$valores->Descripcion.'</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <center><button class="btn btn-primary btn-lg" name="enviar" onclick="guardar_solicitud();" ondblclick="this.disabled='disabled'">Guardar</button></center>
            <button type="button" class="btn btn-secundary" onclick="cerrar()">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <?php
      //consulta de los seguimientos por centro de COSTO
      $sql_seguimientos = "SELECT gs.codigo_gestion, gs.centro_costo,gs.fecha,gs.cod_variable,pa.Descripcion as nom_variable ,gs.cod_concepto,vc.descripcion_con as nom_concepto,
                            gs.cod_tema, ct.descripcion_tema as nom_tema,gs.calificacion,gs.hallazgo,gs.acciones,gs.fecha_control,gs.estado_gestion,para.Descripcion as nom_estado,gs.cod_sol_hermes,gs.observacion
                            FROM gestion_salas gs INNER JOIN parametros pa ON gs.cod_variable= pa.id_parametro
                            INNER JOIN variables_conceptos vc ON GS.cod_concepto=vc.cod_concepto
                            INNER JOIN conceptos_temas ct ON gs.cod_tema = ct.cod_tema
                            INNER JOIN caronte_bd.solicitud sol ON gs.cod_sol_hermes=sol.solicitud_id
                            INNER JOIN parametros para ON gs.estado_gestion = para.id_parametro
                            WHERE gs.centro_costo='$codigo_sala'";
      // exit($sql_seguimientos);
      $query_seguimientos = $link_personal->query($sql_seguimientos);
      $resul = $query_seguimientos->fetch_object();

       ?>
       <div class="col-md-12">
         <div class="table-responsive">
           <table class="table table-bordered table-hover">
            <thead>
            <tr class="bg-primary">
             <th>Fecha</th>
             <th>variable</th>
             <th>Concepto</th>
             <th>Tema</th>
             <th>calificacion</th>
             <th>Fecha Control</th>
             <th>Cod. Hermes</th>
             <th>Estado</th>
             <th>Detalles</th>
             <th>Det. Hermes</th>
           </tr>
           </thead>
         <tbody>
           <?php
           if (!empty($resul)) {
             $contador=0;
           do {
             $contador += 1;
             $fecha  = $resul->fecha;
             $variable  = $resul->nom_variable;
             $concepto  = $resul->nom_concepto;
             $tema  = $resul->nom_tema;
             $calificacion  = $resul->calificacion;
             $hallazgo = $resul->hallazgo;
             $acciones = $resul->acciones;
             $fecha_control = $resul->fecha_control;
             $cod_sol_hermes  = $resul->cod_sol_hermes;
             $estado  = $resul->nom_estado;
             $observacion = $resul->observacion;

             //consulta de detalles de la solicitud
             $detalles_solicitud=false;
             $sql_det_hermes = "SELECT sol.descripcion,sol.prioridad,pa.Descripcion as nom_prioridad, sol.solicitante,
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
            <tr>
              <td><?php echo $fecha;?></td>
              <td><?php echo $variable;?></td>
              <td><?php echo $concepto;?></td>
              <td><?php echo $tema;?></td>
              <td><?php echo $calificacion;?></td>
              <td><?php echo $fecha_control;?></td>
              <td><?php echo $cod_sol_hermes;?></td>
              <td><?php echo $estado;?></td>
              <td><button class="btn btn-info btn-lg" class="form-control" data-toggle='modal' data-target='#modal_detalle_<?php echo $contador; ?>' id="ver_detalle"><i class="fas fa-eye"></i></button></td>
              <?php if ($detalles_solicitud): ?>
              <td><button class="btn btn-success btn-lg" class="form-control" data-toggle='modal' data-target='#detalle_hermes_<?php echo $contador; ?>' id="ver_detalle_sol"><i class="fas fa-eye"></i></button></td>
            <?php endif; ?>
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
                    <!-- <fieldset> -->
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
                          <input type="text" class= "form-control" name="concepto_<?php echo $contador; ?>" value="<?php echo $concepto; ?>" readonly>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-8">
                        <label><strong>Tema a revisar:</strong></label>
                          <input type="text" class= "form-control" name="tema_<?php echo $contador; ?>" value="<?php echo $tema; ?>" readonly>
                      </div>
                      <div class="col-md-4">
                        <label for="nota"><strong>Calificación:</strong></label>
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
                      <div class="col-md-6">
                        <label>Solicitante</label>
                        <input type="text" class="form-control" name="solicitante_<?php echo $contador; ?>" value="<?php echo $nom_solicitante;?>" readonly>
                      </div>
                      <div class="col-md-6">
                        <label>Ejecutor:</label>
                        <input type="text" class="form-control" name="ejecutor_<?php echo $contador; ?>" value="<?php echo $nom_ejecutante;?>" readonly>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <label>Responsable:</label>
                        <input type="text" class="form-control" name="responsable_<?php echo $contador; ?>" value="<?php echo $nom_responsable;?>" readonly>
                      </div>
                      <div class="col-md-6">
                        <label>Informado</label>
                        <input type="text" class="form-control" name="informado_<?php echo $contador; ?>" value="<?php echo $nom_informado;?>" readonly>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-3">
                        <label>Prioridad</label>
                        <input type="text" class="form-control" name="prioridad_<?php echo $contador; ?>" value="<?php echo $prioridad; ?>" readonly>
                      </div>
                      <div class="col-md-3">
                        <label>Fecha Solicitud</label>
                        <input type="text" class="form-control" name="fecha_creacion_<?php echo $contador; ?>" value="<?php echo $fecha_creacion; ?>" readonly>
                      </div>
                      <div class="col-md-3">
                        <label>Fecha Cumplimiento</label>
                        <input type="text" class="form-control" name="fecha_cumpliento_<?php echo $contador; ?>" value="<?php echo $fecha_cumpliento; ?>" readonly>
                      </div>
                      <div class="col-md-3">
                        <label>Estado</label>
                        <input type="text" class="form-control" name="estado_sol_<?php echo $contador; ?>" value="<?php echo $estado; ?>" readonly>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <label>Descripción</label>
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
             <?php
             } while ($resul= $query_seguimientos->fetch_object());
           }else {
             echo "<tr><td>No se encuentran registros</td></tr>";
             exit();
           }
           ?>
           </table>
         </div>
       </div>
    </div>
</div>
  <!-- <div class="container"> -->


</body>
</html>
