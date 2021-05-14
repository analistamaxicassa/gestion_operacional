<?php
	require_once('../conexionesDB/conexion.php');
	ini_set("session.gc_maxlifetime","2400");
	session_start();
	$link_personal = Conectarse_personal();
	$link_queryx_seven = Conectarse_queryx_mysql();
	$link_caronte = Conectarse_caronte();

	if(!isset($_SESSION['userID']))
	{
	  header('Location: index.php');
	  exit();
	}

	$userID = $_SESSION['userID'];
	$userName = $_SESSION['nombre'];
	$sociedad = $_SESSION['cod_sociedad'];
	$cod_cargo = $_SESSION['cod_cargo'];

	$fecha = new DateTime('now');
	$fechaActual = $fecha->format('Y-m-d');
	$fecha->modify('-2 month');
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
		$sql_resumen = "SELECT  gs.centro_costo,sa.sala_nombre,gs.fecha_inspeccion,gs.cod_variable,par.Descripcion as variable, gs.cod_concepto, AVG(gs.calificacion) AS calificacion
										FROM gestion_salas gs INNER JOIN queryx_seven.salas sa ON gs.centro_costo=sa.centro_costo
										AND gs.sociedad_ID=sa.sociedad_ID
										INNER JOIN caronte_bd.funcionario_salas fs ON gs.centro_costo=fs.cod_sala
                    INNER JOIN variables_conceptos vc ON gs.cod_concepto=vc.cod_concepto
										INNER JOIN  parametros par ON gs.cod_variable= par.id_parametro
										WHERE gs.fecha BETWEEN '$fecha' AND '$fechaActual' AND fs.cod_usuario='$userID'
                    AND GS.estado_gestion<>98
										GROUP by gs.centro_costo,sa.sala_nombre ORDER BY gs.fecha DESC";
		//echo $sql_resumen."<br>";
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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" integrity="sha384-kW+oWsYx3YpxvjtZjFXqazFpA7UP/MbiY4jvs+RWZo2+N94PFZ36T6TFkc9O3qoB" crossorigin="anonymous"></script>
  </head>
	<body>
				<?php if ($mensaje_error): ?>
					<div class="alert alert-danger" role="alert">
						<i class="fas fa-times-circle"></i> <?php echo $texto_mensaje; ?>
					</div>
					<?php exit(); ?>
				<?php endif; ?>

	<div align="center">
			<form role="form" action="reportes_sala.php" method="post">
				<fieldset>
					<legend style="color: #002F87;"><?php echo $userName." - ".$_SESSION['cargo']; ?></legend>
					<br><br>
					<div class="input-group col-sm-5 col-md-5">
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
			      <div class="input-group-btn">
			        <button type="submit" class="btn btn-primary"><i class="fas fa-search fa-lg"></i> Seleccionar</button>
			      </div>
			    </div>
					<br><br>
				</fieldset>
	  	</form>
		</div>
		<br>
			<div class="col-md-10 col-md-offset-1">
				  <div class="panel-group" id="accordion">
				    <div class="panel panel-primary">
				      <div class="panel-heading">
				        <h4 class="panel-title">
				          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><center>Vista general Histórica</center></a>
				        </h4>
				      </div>
				      <div id="collapse1" class="panel-collapse collapse in">
								<div class="panel-body">
									<?php if (empty($resumen)){ ?>
										<div class="alert alert-info" role="alert">
											<h5><i class="fas fa-history fa-lg"></i> <?php echo 'No se encuentran nuevos registros entre <b>'.$fecha.' y '.$fechaActual.'</b>'; ?></h5>
										</div>
									<?php } else{ ?>
										<div class="alert alert-success" role="alert">
											<h5><i class="fas fa-history fa-lg"></i> <?php echo 'Rengo histórico de registros entre <b>'.$fecha.' y '.$fechaActual.'</b>'; ?></h5>
										</div>
										<div class="table-responsive">
											<table class="table table-bordered">
												<thead class="text-center bg-info text-white">
													<tr class="bg-info">
														<th>Código</th>
														<th >Sala</th>
														<th >Fecha</th>
														<th >Promedio Calificaciones</th>
													</tr>
												</thead>
												<tbody>
													<?php do{
														$codigo_sala = $resumen->centro_costo;
														$nom_sala = $resumen->sala_nombre;
														$fecha_gestion = $resumen->fecha_inspeccion;
														$calificacion = $resumen->calificacion;
														$promedio_cal = number_format($calificacion,2,',','.');
														if ($promedio_cal >= 9) {
															$color_fila = 'table-success';
														}elseif ($promedio_cal >= 7 and $calificacion <= 8) {
															$color_fila = 'table-warning';
														}elseif($promedio_cal >= 0 and $calificacion <= 6) {
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
														</tr>
													<?php }while($resumen = $query_resumen->fetch_object()); ?>
													<?php } ?>
												</tbody>
											</table>
										</div>
				    		</div>
							</div>
				  </div>
				<div class="panel panel-primary">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapse2"><center>Consulta con filtros</center></a>
							</h4>
						</div>
						<div id="collapse2" class="panel-collapse collapse">
									<legend style="color: #002F87;"><center>Consulta gestiones por filtros</center></legend>
									<form class="" action="" method="post">

									<div class="row">
										<div class="col-md-3 col-md-offset-1">
												<label>Fecha inicial</label>
														<input type="date" name="finicial" value="<?php echo date("Y-m-")."01"?>" class="form-control" required>
										</div>
										<div class="col-md-3 ">
													 <label>Fecha final</label>
														<input type="date" name="ffinal" value="<?php echo date("Y-m-d")?>" class="form-control" required>
											</div>
											<div class="col-md-5">
												<label for="sala">Seleccione centro de costo</label>
												<select class="form-control" id="sala" name="sala">
													<option value="">Seleccione una sala</option>
													<?php
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
										</div>
										<br>
										<div class="row">
											<div class="col-md-3 col-md-offset-1">
															 <label>Estado Gestiones:</label>
															 <select class="form-control" name="estado">
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
																<!-- <input type="date" name="ffinal" value="<?php //echo date("Y-m-d")?>" class="form-control" required> -->
											</div>
											<div class="col-md-4 col-md-offset-1">
												<button type="submit" class="btn btn-success" name="buscar" style="margin-top:25px;" value="1"><i class="fas fa-search fa-lg" ></i> INFORME GENERAL</button>
											</div>
										</div>
									</form>
									<br><br>
									<?php
									if (isset($_POST['buscar']) && !empty($_POST['buscar'])) {
										if (isset($_POST['finicial'],$_POST['ffinal'],$_POST['sala'],$_POST['estado']) && $_POST['estado'] != "") {

										$fecha_inicial = $_POST['finicial'];
										$fecha_final = $_POST['ffinal'];
										$centro_costo = $_POST['sala'];
										$estado = $_POST['estado'];


										$sql_detalle = "SELECT DISTINCT gs.codigo_gestion,gs.centro_costo,sa.sala_nombre,gs.fecha,gs.fecha_inspeccion,par.Descripcion as variable,
											gs.cod_concepto,vc.descripcion_con, gs.calificacion,gs.hallazgo,gs.acciones,
											gs.fecha_control,gs.observacion,gs.cod_sol_hermes,gs.estado_gestion,para.Descripcion as nom_estado
											FROM gestion_salas gs INNER JOIN queryx_seven.salas sa ON gs.centro_costo=sa.centro_costo
											AND gs.sociedad_ID=sa.sociedad_ID
											INNER JOIN caronte_bd.funcionario_salas fs ON gs.centro_costo=fs.cod_sala
											INNER JOIN variables_conceptos vc ON gs.cod_concepto=vc.cod_concepto
											INNER JOIN  parametros par ON gs.cod_variable= par.id_parametro
											INNER JOIN parametros para 	on 	gs.estado_gestion=para.id_parametro
											WHERE gs.fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND gs.centro_costo = '$centro_costo'
											AND gs.estado_gestion='$estado'
											ORDER BY gs.fecha DESC";



										}elseif (isset($_POST['finicial'],$_POST['ffinal'],$_POST['sala']) && !empty($_POST['sala'])) {
											$fecha_inicial = $_POST['finicial'];
											$fecha_final = $_POST['ffinal'];
											$centro_costo = $_POST['sala'];

											$sql_detalle = "SELECT DISTINCT gs.codigo_gestion,gs.centro_costo,sa.sala_nombre,gs.fecha,gs.fecha_inspeccion,par.Descripcion as variable,
												gs.cod_concepto,vc.descripcion_con, gs.calificacion,gs.hallazgo,gs.acciones,
												gs.fecha_control,gs.observacion,gs.cod_sol_hermes,gs.estado_gestion,para.Descripcion as nom_estado
												FROM gestion_salas gs INNER JOIN queryx_seven.salas sa ON gs.centro_costo=sa.centro_costo
												AND gs.sociedad_ID=sa.sociedad_ID
												INNER JOIN caronte_bd.funcionario_salas fs ON gs.centro_costo=fs.cod_sala
												INNER JOIN variables_conceptos vc ON gs.cod_concepto=vc.cod_concepto
												INNER JOIN  parametros par ON gs.cod_variable= par.id_parametro
												INNER JOIN parametros para 	on 	gs.estado_gestion=para.id_parametro
												WHERE gs.fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND gs.centro_costo = '$centro_costo'
												AND gs.estado_gestion<>98
												ORDER BY gs.fecha DESC";

											}elseif (isset($_POST['finicial'],$_POST['ffinal'])) {
												$fecha_inicial = $_POST['finicial'];
												$fecha_final = $_POST['ffinal'];

												$sql_detalle = "SELECT DISTINCT gs.codigo_gestion,gs.centro_costo,sa.sala_nombre,gs.fecha,gs.fecha_inspeccion,par.Descripcion as variable,
													gs.cod_concepto,vc.descripcion_con, gs.calificacion,gs.hallazgo,gs.acciones,
													gs.fecha_control,gs.observacion,gs.cod_sol_hermes,gs.estado_gestion,para.Descripcion as nom_estado
													FROM gestion_salas gs INNER JOIN queryx_seven.salas sa ON gs.centro_costo=sa.centro_costo
													AND gs.sociedad_ID=sa.sociedad_ID
													INNER JOIN caronte_bd.funcionario_salas fs ON gs.centro_costo=fs.cod_sala
													INNER JOIN variables_conceptos vc ON gs.cod_concepto=vc.cod_concepto
													INNER JOIN  parametros par ON gs.cod_variable= par.id_parametro
													INNER JOIN parametros para 	on 	gs.estado_gestion=para.id_parametro
													WHERE gs.fecha BETWEEN '$fecha_inicial' AND '$fecha_final'
													AND gs.estado_gestion<>98
													ORDER BY gs.fecha DESC";
												}
											// exit($sql_detalle);
											$consulta_excel = $sql_detalle;
											$query_detalle = $link_personal->query($sql_detalle);
											$resul_detalle = $query_detalle->fetch_object();
											if (empty($resul_detalle)) {
												echo '<label>No se encontraron datos con los criterios ingresados</label><br>';
											}else {
												?>
												<form action="informe_gestiones_excel.php" method="post">
		                        <div class="form-row">
		                           <div class="col-md-4">
		                             <input type="hidden" name="consulta_sql" value="<?php echo $consulta_excel; ?>">
		                           </div>
		                        </div>
		                        <div class="row">
		                           <div class="form-group col-md-4 offset-md-3">
		                             <button type="submit" style="margin-top:25px;" class="btn btn-info btn-block" name="informe"><i class="fas fa-download fa-lg"></i><strong>DESCARGAR INFORME</strong></button>
		                           </div>
		                        </div>
		                     </form>
												<div class="table-responsive">
													<table class="table table-bordered table-sm">
														<thead class="text-center bg-info text-white " >
															<tr class="bg-info">
																<th>Código</th>
																<th>Sala</th>
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
															  $contador=0;
															do{
																$contador += 1;
																$codigo_gestion = $resul_detalle->codigo_gestion;
																$nom_sala = $resul_detalle->sala_nombre;
																$fecha_gestion = $resul_detalle->fecha;
																$variable = $resul_detalle->variable;
																$nom_concepto = $resul_detalle->descripcion_con;
																$calificacion = $resul_detalle->calificacion;
																$acciones = $resul_detalle->acciones;
																$nom_estado = $resul_detalle->nom_estado;
																if ($calificacion >= 9) {
																	$color_fila = 'bg-success';
																}elseif ($calificacion >= 7 and $calificacion <= 8) {
																	$color_fila = 'bg-warning';
																}elseif($calificacion >= 0 and $calificacion <= 6) {
																	$color_fila = 'bg-danger';
																}
																?>
																<tr class="<?php echo $color_fila; ?>">
																	<td><?php echo $codigo_gestion; ?></td>
																	<td><?php echo $nom_sala; ?></td>
																	<td><?php echo $fecha_gestion ?></td>
																	<td><?php echo $variable ?></td>
																	<td><?php echo $nom_concepto; ?></td>
																	<td><?php echo $acciones; ?></td>
																	<td><?php echo $calificacion; ?></td>
																	<td><?php echo $nom_estado; ?></td>
																</tr>
															<?php }while($resul_detalle = $query_detalle->fetch_object()); ?>
														</tbody>
													</table>
												</div>
											<?php
											}
										}
									 ?>
										<br>
									</div>
						</div>
					</div>
				</div>
			</body>
</html>
<?php
	$query_lista_salas->close();
	$query_resumen->close();
	$link_personal->close();
 ?>
