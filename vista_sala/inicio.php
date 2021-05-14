<?php
	require_once('../conexionesDB/conexion.php');
	session_start();
	$link_personal=Conectarse_personal();
	$link_queryx_seven = Conectarse_queryx_mysql();

	$userID = $_SESSION['userID'];
	$userName = $_SESSION['nombre'];
	$userCargo = $_SESSION['cargo'];
	$sociedad_ID = $_SESSION['cod_sociedad'];
  $centro_operacion = $_SESSION['centro_operacion'];
	if (strpos($centro_operacion,'-'))
	{
	 list($empresa, $location, $area) = explode("-", $centro_operacion);
 	}
 else
 	{
	$location= $centro_operacion;

	}
	$sql_sala = "SELECT centro_costo,sala_nombre FROM salas WHERE centro_costo='$location' and sociedad_ID='$sociedad_ID'";
	$query_sala = $link_queryx_seven->query($sql_sala);
	$resul_sala = $query_sala->fetch_object();
	$nombre_sala = $resul_sala->sala_nombre;



	$fecha = new DateTime('now');
	$fechaActual = $fecha->format('Y-m-d');
	$fecha->modify('-2 month');
	$fecha = $fecha->format('Y-m-d');

	//$sqlSalas = "SELECT cc, nombre FROM salas WHERE activo = '1' AND Jefeoperacion = '$userID'";
	//$resultadoSalas=$link_personal->query($sqlSalas);

	//consulta de concepto de sala
	// $sql_resumen = "SELECT salas.sala_nombre, cs.fecha, COUNT(cs.id) AS conceptos_evaluados, SUM(cs.calificacion) AS suma_calf FROM concepto_sala AS cs
	// INNER JOIN queryx_seven.salas ON cs.cc = salas.centro_costo WHERE cs.cc = '$location' GROUP BY cs.fecha, salas.sala_nombre ORDER BY cs.fecha DESC";

	$sql_resumen ="SELECT gs.centro_costo,sa.sala_nombre,gs.fecha,count(codigo_gestion) item_evaluados,sum(calificacion) as acumulado
										FROM gestion_salas gs INNER JOIN queryx_seven.salas sa ON gs.centro_costo=sa.centro_costo
										AND gs.sociedad_ID=sa.sociedad_ID
										WHERE GS.centro_costo='$location'
										GROUP BY gs.fecha, sa.sala_nombre
										ORDER BY gs.fecha DESC";
	// echo $sql_resumen."<br>";
	$query_resumen = $link_personal->query($sql_resumen);
	$resumen = $query_resumen->fetch_object();

	// CONSULTA DE ACCIONES PENDIENTES
	// $sql_acciones ="SELECT gs.codigo_gestion,gs.centro_costo,gs.cod_concepto,vc.descripcion_con,
	// 								gs.hallazgo,gs.acciones,gs.fecha_control
	// 								FROM gestion_salas gs INNER JOIN variables_conceptos vc
	// 								ON gs.cod_concepto=vc.cod_concepto
	// 								where gs.centro_costo='$location' ORDER BY fecha_control";
	// // echo $sql_acciones."<br>";
	// $query_acciones = $link_personal->query($sql_acciones);
	// $acciones = $query_acciones->fetch_object();

?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="../CSS/panel.css" rel="stylesheet">
		<title>Auditoria Operacional</title>
		<!-- <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" integrity="sha384-kW+oWsYx3YpxvjtZjFXqazFpA7UP/MbiY4jvs+RWZo2+N94PFZ36T6TFkc9O3qoB" crossorigin="anonymous"></script> -->

		<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

		<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" integrity="sha384-kW+oWsYx3YpxvjtZjFXqazFpA7UP/MbiY4jvs+RWZo2+N94PFZ36T6TFkc9O3qoB" crossorigin="anonymous"></script>
  </head>
	<body>
		<br>
		<div class="col-md-10 col-md-offset-1">
			<div class="row" align="center">
				<legend>BIENVENIDO: <?php echo $userName." - ".$userCargo; ?></legend>
				<legend>Ubicación: <?php echo $nombre_sala; ?></legend>
			</div>
			<div class="panel-group" id="accordion">
				<div class="panel panel-primary">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><center>Histórico de Evaluaciones</center></a>
							</h4>
						</div>
					  <div id="collapse1" class="panel-collapse collapse in">
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr class="bg-info">
											<th>Código</th>
											<th>Sala</th>
											<th>Fecha</th>
											<th>numero Gestiones</th>
											<th>Promedio Calificaciones</th>
											<th>Detalles</th>
										</tr>
									</thead>
									<tbody>
									<?php
										if (empty($resumen)) {
											echo 'No se encuentran nuevos registros para la sala </b>';
										}
										else
										{
											do{
												$codigo_sala = $resumen->centro_costo;
												$nom_sala = $resumen->sala_nombre;
												$fecha_gestion = $resumen->fecha;
												$num_items = $resumen->item_evaluados;
												$acumulado = $resumen->acumulado;
												$promedio = number_format(($acumulado/$num_items),2,'.','');
									?>
														<tr>
															<td><?php echo $codigo_sala; ?></td>
															<td><?php echo $nom_sala; ?></td>
															<td><?php echo $fecha_gestion ?></td>
															<td><?php echo $num_items; ?></td>
															<td><?php echo $promedio; ?></td>
															<td><a href="informe_auditoria.php?fecha=<?php echo $resumen->fecha?>"><i class="fas fa-eye fa-lg"></i></a></td>
														</tr>
									<?php
											}while($resumen = $query_resumen->fetch_object());
										}
									?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
			</div>

			<div class="panel panel-primary">
				<div class="panel-heading">
				<center><h3 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Búsqueda de gestión</a>
				</h3></center>
				</div>
				<div id="collapse2" class="panel-collapse collapse">
				<div class="panel-body">
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
						<div class="col-md-3 ">
										 <label>Estado Gestiones:</label>
										 <select class="form-control" name="estado">
										 	<option value="">Seleccione</option>
										 <?php
										 $sql_estados= "SELECT id_parametro,Descripcion FROM parametros
										 								WHERE Tipo_ID=12 and Estado=1 ORDER BY id_parametro";
										 // exit($sql_estados);
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
					</div>
						<br>
						<div class="row">
							<div class="col-md-4 col-md-offset-4">
								<button type="submit" name="buscar" class="btn btn-success" value="1"><i class="fas fa-search fa-lg" ></i> INFORME GENERAL</button>
							</div>
						</div>
					</form>
					<br><br>
					<?php
					if (isset($_POST['buscar']) && !empty($_POST['buscar'])) {


						if (isset($_POST['finicial'],$_POST['ffinal'],$_POST['estado']) && $_POST['estado'] != "" ){

							$fecha_inicial = $_POST['finicial'];
							$fecha_final = $_POST['ffinal'];
							$centro_costo = $_POST['estado'];

							$sql_acciones = "SELECT gs.codigo_gestion,gs.centro_costo,gs.cod_concepto,vc.descripcion_con,
															gs.hallazgo,gs.acciones,gs.fecha_control,pa.Descripcion as estado
															FROM gestion_salas gs INNER JOIN variables_conceptos vc
															ON gs.cod_concepto=vc.cod_concepto
															INNER JOIN parametros pa ON gs.estado_gestion= pa.id_parametro
															WHERE gs.centro_costo='$location'
										          AND gs.fecha BETWEEN '$fecha_inicial' and '$fecha_final'
										          AND gs.estado_gestion=$estado
										          ORDER BY fecha_control";

						}elseif (isset($_POST['finicial'],$_POST['ffinal'])) {

							$fecha_inicial = $_POST['finicial'];
							$fecha_final = $_POST['ffinal'];

							$sql_acciones = "SELECT gs.codigo_gestion,gs.centro_costo,gs.cod_concepto,vc.descripcion_con,
															gs.hallazgo,gs.acciones,gs.fecha_control,pa.Descripcion as estado
															FROM gestion_salas gs INNER JOIN variables_conceptos vc
															ON gs.cod_concepto=vc.cod_concepto
															INNER JOIN parametros pa ON gs.estado_gestion= pa.id_parametro
															WHERE gs.centro_costo='$location'
															AND gs.fecha BETWEEN '$fecha_inicial' and '$fecha_final'
															ORDER BY fecha_control";
							}
								// exit($sql_acciones);
							$query_acciones = $link_personal->query($sql_acciones);
							$acciones = $query_acciones->fetch_object();
							if (empty($acciones)) {
								echo 'No se encontraron datos con los criterios ingresados';
							}else {
						  ?>
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr class="bg-info">
										<th>Código</th>
										<th width="10%">Concepto</th>
										<th width="30%">Hallazgo</th>
										<th width="20%">Acciones</th>
										<th>fecha Control</th>
										<th>Estado</th>
										<th>Detalles</th>
									</tr>
								</thead>
								<tbody>
								<?php
								   $contador=0;
										do{
											$contador += 1;
											$codigo_gestion = $acciones->codigo_gestion;
											$concepto = $acciones->descripcion_con;
											$hallazgo = $acciones->hallazgo;
											$accion = $acciones->acciones;
											$fecha_seguimiento = $acciones->fecha_control;
											$estado_segui = $acciones->estado;
								?>
													<tr>
														<td><?php echo $codigo_gestion; ?></td>
														<td><?php echo $concepto; ?></td>
														<td><?php echo $hallazgo; ?></td>
														<td><?php echo $accion; ?></td>
														<td><?php echo $fecha_seguimiento; ?></td>
														<td><?php echo $estado_segui; ?></td>
														<!-- <td><button class="btn btn-primary btn-lg" class="form-control" data-toggle='modal' data-target='#seguimientos_<?php echo $contador; ?>' id="ver_seguimientos"><i class="fas fa-plus"></i></button></td> -->
													</tr>
												</tbody>
									<?php
											}while($acciones = $query_acciones->fetch_object());
										}
									?>

							</table>
						</div>
				<?php }  ?>
				</div>
			</div>
		</div>
		</div>
	<!-- </div> -->
	</body>
</html>
<?php
	//$resultadoSalas->close();
	// $query_resumen->close();
	$link_personal->close();
 ?>
