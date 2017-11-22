<?php
	require_once('../conexionesDB/conexion.php');
	$link_libreta=Conectarse_libreta();
	session_start();
	
	//conexion
  $sqls = "SELECT cc, nombre FROM salas WHERE activo = '1' and (nombre like 'CERA%' || nombre like 'MAX%' ) order by nombre";
	$qry_sqls=$link_libreta->query($sqls);
	$rs_qrys=$qry_sqls->fetch_object();
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>ARES::Maxicassa</title>
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="https://fonts.googleapis.com/css?family=Merriweather:700i" rel="stylesheet">
  </head>
  <body>
		<div class="row">
			<br>
			<div class="col-md-4 col-md-offset-2">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title" style="font-size: 12px;">Histórico de evaluaciones</h3>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr class="bg-info">
										<th>Fecha</th>
										<th>Sala</th>
									</tr>
								</thead>
								<tbody>
								<?php
									//consulta de concepto de sala
									$sql_resumen = "SELECT eval.log_eval_ID AS id, eval.hora_evaluacion AS fecha, ing.usuario_ID AS usuario, s.nombre AS sala
									FROM log_evaluacion AS eval INNER JOIN log_ingresos AS ing ON eval.ingreso_ID = ing.ingreso_ID INNER JOIN salas AS s ON eval.sala = s.cc";
									$query_resumen=$link_libreta->query($sql_resumen);
									$resumen=$query_resumen->fetch_object();  ///consultar

									if (empty($resumen)) {
										echo 'No existen registros';
									}
									else
									{
										do{
								?>
													<tr>
														<td><?php echo $resumen->fecha; ?></td>
														<td><?php echo $resumen->sala; ?></td>
														<td><a href="informe_libreta.php?id=<?php echo $resumen->id?>&sala=<?php echo $resumen->sala; ?>"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a></td>
													</tr>
								<?php
										}while($resumen=$query_resumen->fetch_object());
										$query_resumen->close();
									}
									$link_libreta->close();
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
	  		<div class="panel panel-primary">
	  			<div class="panel-heading">
	  				<h3 class="panel-title" style="font-size: 12px;"><?php echo strtok($_SESSION['nombre'], ' ').' - '.$_SESSION['cargo']; ?></h3>
	  			</div>
	  			<div class="panel-body">
	  				<form role="form" action="lista_chequeo.php" method="post">
	  					<fieldset>
	  						<div class="form-group">
	  							<label for="sala">Ingrese la sala a evaluar:</label>
	  							<select class="form-control" name="mySala" required>
	  								<option value=""> Seleccione una sala</option>
	  								<?php
	  										do{
	  							  ?>
	  				        <option value="<?php echo $rs_qrys->cc."-".$rs_qrys->nombre;?>"><?php echo $rs_qrys->nombre; ?></option>
	  							  <?php
	  											}while($rs_qrys=$qry_sqls->fetch_object());
	  							  ?>
	  				      </select>
	  						</div>
	  						<button type="submit" name="evaluarSala" class="btn btn-primary btn-small"><i class="fa fa-plus"> CREAR</i></button>
	  					</fieldset>
	  				</form>
	  			</div>
	  		</div>
	  	</div>
		</div>
</html>
