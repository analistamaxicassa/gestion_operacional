<?php
	require_once('../conexionesDB/conexion.php');
	ini_set("session.gc_maxlifetime","2400");
	session_start();
	$link_personal = Conectarse_personal();
	$link_queryx_seven = Conectarse_queryx_mysql();
	$link_caronte = Conectarse_caronte();

	$userID = $_SESSION['userID'];
	$userName = $_SESSION['nombre'];
	$sociedad = $_SESSION['cod_sociedad'];
	$cod_cargo = $_SESSION['cod_cargo'];

	$fecha = new DateTime('now');
	$fechaActual = $fecha->format('Y-m-d');
	$fecha->modify('-1 month');
	$fecha = $fecha->format('Y-m-d');
	$mensaje_error = false;

	//consulta para mostrar PDV que puedan gestionar los Analistas de Operaciones Comerciales AOC
	$sql_operaciones = "SELECT fs.cod_sala as centro_costo ,sa.sala_nombre
								FROM funcionario_salas fs INNER JOIN queryx_seven.salas sa
								ON fs.cod_sala=sa.centro_costo and fs.sociedad_ID=sa.sociedad_ID
								WHERE fs.sociedad_ID = '$sociedad' AND fs.cod_cargo = $cod_cargo
								AND fs.cod_usuario='$userID' AND fs.estado = 1 ORDER BY fs.cod_sala";
	$sql_salas = $sql_operaciones;
	$query_lista_salas = $link_caronte->query($sql_operaciones);
	$salas = $query_lista_salas->fetch_object();
	if (empty($salas)) {

			//Código agregado para conusltar sucursales de maxicassa a evaluar de acuerdo al usuario ingreso
			$sqlSalas= "SELECT sa.centro_costo,sa.sala_nombre FROM salas sa INNER JOIN usuarios_sala us ON sa.centro_costo = us.cod_sala WHERE us.cod_usuario = '$userID'
								and us.Sociedad_ID=sa.sociedad_ID AND sa.sociedad_ID='$sociedad' order by sa.centro_costo ASC";
			// echo $sqlSalas;
			// exit();
			$query_lista_salas = $link_queryx_seven->query($sqlSalas);
			if ($query_lista_salas == false) {
						$mensaje_error = true;
						$texto_mensaje = '<strong>Ocurrió un error al consultar la tabla salas,</strong> intente ingresar de nuevo o comuníquese con el área de sistemas para recibir ayuda con este problema.';
			} else{
			$salas = $query_lista_salas->fetch_object();
			if(empty($salas)){
				$sqlSalas = "SELECT centro_costo, sala_nombre FROM salas WHERE activo = '1' and (sociedad_ID=4 or sociedad_ID=$sociedad) ORDER BY centro_costo";
				$query_lista_salas = $link_queryx_seven->query($sqlSalas);
				if ($query_lista_salas == false) {
					$mensaje_error = true;
					$texto_mensaje = '<strong>Ocurrió un error al consultar la tabla salas,</strong> intente ingresar de nuevo o comuníquese con el área de sistemas para recibir ayuda con este problema.';
				}
			}
		}
	}

	if ($mensaje_error == false) {
		$sql_resumen = "SELECT  gs.codigo_gestion, gs.centro_costo,sa.sala_nombre,gs.fecha,gs.cod_variable,par.Descripcion as variable, gs.cod_concepto,AVG(gs.calificacion) as calificacion
										FROM gestion_salas gs INNER JOIN queryx_seven.salas sa ON gs.centro_costo=sa.centro_costo
										AND gs.sociedad_ID=sa.sociedad_ID INNER JOIN caronte_bd.funcionario_salas fs ON gs.centro_costo=fs.cod_sala
                    INNER JOIN variables_conceptos vc ON gs.cod_concepto=vc.cod_concepto
										INNER JOIN  parametros par ON gs.cod_variable= par.id_parametro
										WHERE gs.fecha BETWEEN '$fecha' AND '$fechaActual'
                    AND gs.estado_gestion<>98 AND fs.cod_usuario='$userID'
                    group by gs.centro_costo,gs.fecha ORDER BY gs.fecha DESC";
		// echo $sql_resumen."<br>";
		$query_resumen = $link_personal->query($sql_resumen);
		if ($query_resumen == false) {
			$mensaje_error = true;
			$texto_mensaje = '<strong>Ocurrió un error al consultar las evaluaciones,</strong> intente ingresar de nuevo o comuníquese con el área de sistemas para recibir ayuda con este problema.';
		}
		$resumen = $query_resumen->fetch_object();
	}
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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" integrity="sha384-kW+oWsYx3YpxvjtZjFXqazFpA7UP/MbiY4jvs+RWZo2+N94PFZ36T6TFkc9O3qoB" crossorigin="anonymous"></script>


		<script type="text/javascript" src="clases\principal.js"></script>
		<script src="clases\bootbox\bootbox.min.js"></script>
    <script src="clases\bootbox\bootbox.locales.min.js"></script>
		<style media="screen">
      table .modal{
       font-size: 12px;
      }
			/* .modal{
    display: block !important; /* I added this to see the modal, you don't need this */
			} */

		/* Important part */
		.modal-dialog{
    overflow-y: initial !important
		}
		.modal-body{
    overflow-x: auto;
    overflow-y: auto;
		}
    </style>
  </head>
	<body>
				<?php if ($mensaje_error): ?>
					<div class="alert alert-danger" role="alert">
						<i class="fas fa-times-circle"></i> <?php echo $texto_mensaje; ?>
					</div>
					<?php exit(); ?>
				<?php endif; ?>

	<div class="container">
		 <div class="col-md-12">
			<div class="row">
				<h4>Bienvenido <?php echo $userName." - ".$_SESSION['cargo']; ?></h4>
				<br><br>
			</div>
			<br><br>
			<form role="form" action="reportes_sala.php" method="post">
				<div class="row">
							<div class="offset-md-2 col-sm-6 col-md-6">
								<select class="form-control" id="sala" name="sala" required>
									<option value="">Seleccione una sala</option>
									<?php
									$sql_salas = "SELECT fs.cod_sala as centro_costo ,sa.sala_nombre
									FROM funcionario_salas fs INNER JOIN queryx_seven.salas sa
									ON fs.cod_sala=sa.centro_costo and fs.sociedad_ID=sa.sociedad_ID
									WHERE fs.sociedad_ID = '$sociedad' AND fs.cod_cargo = $cod_cargo
									AND fs.cod_usuario='$userID' AND fs.estado = 1 ORDER BY fs.cod_sala";
									$query_salas = $link_caronte->query($sql_salas);

									while ($salas = $query_salas->fetch_object()) {
										$centro_costo = $salas->centro_costo;
										$nombre_sala = $salas->sala_nombre;
										?>
										<option value="<?php echo $centro_costo;?>"> <?php echo  $centro_costo." - ".$nombre_sala; ?></option>
										<?php
									}
									?>
								</select>
							</div>
							<div class="col-md-3">
									<button type="submit" class="btn btn-primary"><i class="fas fa-search fa-lg"></i> Consultar</button>
							</div>
						</div>
					</form>
				</div>
				<br><br>
				<div class="card mb-6">
					<div class="row">
						<div class="col-md-12">
							    <div class="panel panel-primary">
							      <div class="panel-heading">
												<center><h4><strong>Vista General Histórica</strong></h4></center>
							      </div>
										<div class="panel-body">
												<?php if (empty($resumen)){ ?>
													<div class="alert alert-info" role="alert">
														<h6><i class="fas fa-history fa-lg"></i> <?php echo 'No se encuentran nuevos registros entre <b>'.$fecha.' y '.$fechaActual.'</b>'; ?></h6>
													</div>
												<?php } else{ ?>
													<div class="alert alert-success" role="alert">
														<h6><i class="fas fa-history fa-lg"></i> <?php echo 'Rango histrórico de registros entre <b>'.$fecha.' y '.$fechaActual.'</b>'; ?></h6>
													</div>
													<div class="table-responsive">
														<table class="table table-bordered">
															<thead class="text-center bg-info text-white">
																<tr class="bg-info">
																	<th>Centro Costo</th>
																	<th>Sala</th>
																	<th>Fecha</th>
																	<th>Promedio Calificaciones</th>
																	<th>Opciones</th>
																</tr>
															</thead>
															<tbody>
																<?php
																  $contador=0;
																do {
																	$contador += 1;
																	$codigo_sala = $resumen->centro_costo;
																	$nom_sala = $resumen->sala_nombre;
																	$fecha_gestion = $resumen->fecha;
																	$calificacion = $resumen->calificacion;
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
																		<td><?php echo $codigo_sala; ?></td>
																		<td><?php echo $nom_sala; ?></td>
																		<td><?php echo $fecha_gestion ?></td>
																		<td><?php echo $promedio_cal; ?></td>
																		 <td><button class="btn btn-info btn-lg" class="form-control" data-toggle='modal' data-target='#modal_general_<?php echo $contador; ?>' id="ver_detalle"><i class="fas fa-eye"></i></button></td>
																	</tr>
																	</tbody>
																	<div class="modal fade bd-example-modal-lg" id="modal_general_<?php echo $contador; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:100%;" >
																		<div class="modal-dialog modal-lg" role="document" style="width:100%;">
																			<div class="modal-content">
																			 	<div class="modal-header">
																					<h4 class="modal-title" id="myModalLabel">Detalle Gestión Operacional</h4>
																					</button>
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
																									WHERE gs.fecha = '$fecha_gestion'
																									AND gs.estado_gestion<>98 AND GS.centro_costo='$codigo_sala'
																									group by gs.cod_variable ORDER BY gs.fecha DESC";

																									$query_det_resumen = $link_personal->query($sql_det_resumen);
																									$resul_det_resumen = $query_det_resumen->fetch_object();

																									if (!empty($resul_det_resumen)) {
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
																	</div>
																<?php
																}while ($resumen = $query_resumen->fetch_object())
																?>
														</table>
													</div>
												<?php } ?>
							    		</div>
							  		</div>
									</div>
								</div>
							</div>
				</div>
			</body>
</html>
