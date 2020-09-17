<?php
	require_once('../conexionesDB/conexion.php');
	session_start();
	$link_personal=Conectarse_personal();

	$userID = $_SESSION['userID'];
	$userName = $_SESSION['nombre'];

	$sqlr = "SELECT * FROM cliente_interno_queryx";
	//=$link_personal->query($sqlr);
	//$rs_qryr=$qry_sqlr->fetch_object();

	$fecha = new DateTime('now');
	$fechaActual = $fecha->format('Y-m-d');
	$fecha->modify('-2 month');
	$fecha = $fecha->format('Y-m-d');


	if (isset($rs_qryr))
	{
		$sqle = "delete from cliente_interno_queryx";
		$qry_sqle=$link_personal->query($sqle);
	}

	if ($userID == "51911317") {
		$sqlSalas = "SELECT cc, nombre FROM salas WHERE cc = '128' OR cc = '802' OR cc = '801' OR cc = '153' OR cc = '105' OR cc = '103' OR cc = '126' OR cc = '102' OR cc = '803' OR cc = '836' OR cc = '126'";
	} else {
		$sqlSalas = "SELECT cc, nombre FROM salas WHERE activo = '1' AND Jefeoperacion = '$userID'";
	}
	$resultadoSalas=$link_personal->query($sqlSalas);

	//consulta de concepto de sala
	$sql_resumen = "SELECT salas.nombre, cs.fecha, COUNT(cs.id) AS conceptos_evaluados, SUM(cs.calificacion) AS suma_calf FROM concepto_sala AS cs INNER JOIN salas ON cs.cc = salas.cc WHERE (DATE(cs.fecha) BETWEEN '$fecha' AND '$fechaActual') GROUP BY cs.fecha, salas.nombre ORDER BY cs.fecha DESC";
	//$sql_resumen = "SELECT DISTINCT(salas.nombre), cs.fecha FROM concepto_sala AS cs INNER JOIN salas ON cs.cc = salas.cc WHERE (DATE(cs.fecha) BETWEEN '$fecha' AND '$fechaActual') ORDER BY cs.fecha DESC";
	//echo $sql_resumen."<br>";
	$query_resumen=$link_personal->query($sql_resumen);
	$resumen=$query_resumen->fetch_object();

?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Auditoria Operacional</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
	<body>
		<div align="center">
			<form role="form" action="informe_sala.php" method="post">
				<fieldset>
					<legend style="color: #002F87;"><?php echo $userName." - ".$_SESSION['cargo']; ?></legend>
					<div class="input-group col-sm-2">
						<select class="form-control" id="sala" name="sala" required>
							<option value="">Seleccione una sala</option>
							<?php
							while ($salas=$resultadoSalas->fetch_object()) {
							?>
							<option value="<?php echo $salas->cc;?>"> <?php echo  $salas->nombre; ?></option>
							<?php
							}
							?>
						</select>
			      <div class="input-group-btn">
			        <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
			      </div>
			    </div>
				</fieldset>
	  	</form>
		</div>
		<br>
			<div class="container col-md-6 col-md-offset-3">
			  <div class="panel-group" id="accordion">
			    <div class="panel panel-primary">
			      <div class="panel-heading">
			        <h4 class="panel-title">
			          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Histórico de evaluaciones</a>
			        </h4>
			      </div>
			      <div id="collapse1" class="panel-collapse collapse in">
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
														</tr>
									<?php
											}while($resumen=$query_resumen->fetch_object());
										}
									?>
									</tbody>
								</table>
							</div>
		    		</div>
			    <div class="panel panel-primary">
			      <div class="panel-heading">
			        <h4 class="panel-title">
			          <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Búsqueda por empleado</a>
			        </h4>
			      </div>
			      <div id="collapse2" class="panel-collapse collapse">
			        <div class="panel-body">
								<form role="form" action="informe_busqueda.php" method="post">
									<fieldset>
										<div class="form-group">
											<label for="usuario">Documento empleado:</label>
											<input type="number" name="empleado" id="empleado" class="form-control" placeholder="Cédula o Documento de identidad" required>
										</div>
										<div class="form-group">
											<label for="empresa">Empresa empleado</label>
											<select class="form-control" name="empresa" id="empresa" required>
												<option value="">Seleccione una empresa</option>
												<option value="10">Maxicassa</option>
												<option value="60">Pegomax</option>
												<option value="40">Tu Cassa</option>
												<option value="20">Innovapack</option>
												<option value="70">Temporal</option>
											</select>
										</div>
											<input type="submit" class="btn btn-primary" value="Consultar por empleado">
									</fieldset>
								</form>
			        </div>
			      </div>
			    </div>
			  </div>
			</div>
		</div>
	</body>
</html>
<?php
	$resultadoSalas->close();
	$query_resumen->close();
	$link_personal->close();
 ?>
