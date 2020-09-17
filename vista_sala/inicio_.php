<?php
	require_once('../conexionesDB/conexion.php');
	session_start();
	$link_personal=Conectarse_personal();

	$userID = $_SESSION['userID'];
	$userName = $_SESSION['nombre'];
	$userCargo = $_SESSION['cargo'];
  $centro_operacion = $_SESSION['centro_operacion'];
	if (strpos($centro_operacion,'-'))
	{
	 list($empresa, $location, $area) = explode("-", $centro_operacion);
 	}
 else
 	{
	$location= $centro_operacion;
	}

	$fecha = new DateTime('now');
	$fechaActual = $fecha->format('Y-m-d');
	$fecha->modify('-2 month');
	$fecha = $fecha->format('Y-m-d');

	//$sqlSalas = "SELECT cc, nombre FROM salas WHERE activo = '1' AND Jefeoperacion = '$userID'";
	//$resultadoSalas=$link_personal->query($sqlSalas);

	//consulta de concepto de sala
	$sql_resumen = "SELECT salas.nombre, cs.fecha, COUNT(cs.id) AS conceptos_evaluados, SUM(cs.calificacion) AS suma_calf FROM concepto_sala AS cs
	INNER JOIN salas ON cs.cc = salas.cc WHERE cs.cc = '$location' GROUP BY cs.fecha, salas.nombre ORDER BY cs.fecha DESC";
	// echo $sql_resumen."<br>";
	$query_resumen=$link_personal->query($sql_resumen);
	$resumen=$query_resumen->fetch_object();

?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="../CSS/panel.css" rel="stylesheet">
		<title>Auditoria Operacional</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
	<body>
		<br>
		<div class="row col-md-12" align="right">
			<a class="btn btn-danger" href="../logout.php?origen=1"><i class="glyphicon glyphicon-log-out"></i> Salir</a>
		</div>
		<div class="col-md-10 col-md-offset-1">
			<div class="row" align="center">
				<legend>BIENVENIDO: <?php echo $userName." - ".$userCargo; ?></legend>
			</div>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Histórico de evaluaciones</h3>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr class="bg-info">
									<th>Nombre</th>
									<th>Fecha</th>
									<th># Conceptos evaluados</th>
									<th>Promedio calificaciones</th>
								</tr>
							</thead>
							<tbody>
							<?php
								if (empty($resumen)) {
									echo 'No se encuentran nuevos registros entre <b>'.$fecha.' y '.$fechaActual.'</b>';
								}
								else
								{
									do{
							?>
												<tr>
													<td><?php echo utf8_encode($resumen->nombre); ?></td>
													<td><?php echo ($resumen->fecha); ?></td>
													<td><?php echo ($resumen->conceptos_evaluados)."/23"; ?></td>
													<td><?php echo number_format((($resumen->suma_calf)/115)*5, 2, '.', ''); ?></td>
													<td><a href="informe_auditoria.php?fecha=<?php echo $resumen->fecha?>"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a></td>
												</tr>
							<?php
									}while($resumen=$query_resumen->fetch_object());
								}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<?php
	//$resultadoSalas->close();
	$query_resumen->close();
	$link_personal->close();
 ?>
