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
	$fecha->modify('-2 month');
	$fecha = $fecha->format('Y-m-d');
	$mensaje_error = false;

	//consulta para mostrar PDV que puedan gestionar los Analistas de Operaciones Comerciales AOC
	$sql_operaciones = "SELECT fs.cod_sala as centro_costo ,sa.sala_nombre
								FROM funcionario_salas fs INNER JOIN queryx_seven.salas sa
								ON fs.cod_sala=sa.centro_costo and fs.sociedad_ID=sa.sociedad_ID
								WHERE fs.sociedad_ID = '$sociedad' AND fs.cod_cargo = $cod_cargo
								AND fs.cod_usuario='$userID' AND fs.estado = 1 ORDER BY fs.cod_sala";
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
		// $sql_resumen = "SELECT gs.centro_costo,sa.sala_nombre,gs.fecha,count(cod_concepto) conceptos_evaluados,sum(calificacion) as acumulado
		// 								FROM gestion_salas gs INNER JOIN queryx_seven.salas sa ON gs.centro_costo=sa.centro_costo
		// 								AND gs.sociedad_ID=sa.sociedad_ID
		// 								INNER JOIN caronte_bd.funcionario_salas fs ON gs.centro_costo=fs.cod_sala
		// 								WHERE gs.fecha BETWEEN '$fecha' AND '$fechaActual' AND fs.cod_usuario='$userID'
    //                 GROUP BY sa.sala_nombre
		// 								ORDER BY gs.fecha DESC";
		$sql_resumen = "SELECT DISTINCT gs.centro_costo,sa.sala_nombre,gs.fecha,par.Descripcion as variable,gs.cod_concepto,vc.descripcion_con, gs.calificacion
										FROM gestion_salas gs INNER JOIN queryx_seven.salas sa ON gs.centro_costo=sa.centro_costo
										AND gs.sociedad_ID=sa.sociedad_ID
										INNER JOIN caronte_bd.funcionario_salas fs ON gs.centro_costo=fs.cod_sala
                    INNER JOIN variables_conceptos vc ON gs.cod_concepto=vc.cod_concepto
										INNER JOIN  parametros par ON gs.cod_variable= par.id_parametro
										WHERE gs.fecha BETWEEN '$fecha' AND '$fechaActual' AND fs.cod_usuario='$userID'
                    AND GS.estado_gestion<>98
										ORDER BY gs.fecha DESC";
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
		<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
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
							while ($salas = $query_lista_salas->fetch_object()) {
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
			<div class="container col-md-10 col-md-offset-2">
			  <!-- <div class="panel-group" id="accordion"> -->
			    <div class="panel panel-primary">
			      <div class="panel-heading">
			        <h4 class="panel-title">
			          <!-- <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Histórico de evaluaciones</a>-->
								<center><label style="color: #002F87;">Histórico de evaluaciones</label></center>
			        </h4>
			      </div>
			      <!-- <div id="collapse1" class="panel-collapse collapse in"> -->
							<?php if (empty($resumen)){ ?>
								<div class="alert alert-info" role="alert">
									<h6><i class="fas fa-history fa-lg"></i> <?php echo 'No se encuentran nuevos registros entre <b>'.$fecha.' y '.$fechaActual.'</b>'; ?></h6>
								</div>
							<?php } else{ ?>
								<div class="table-responsive">
									<table class="table table-bordered">
										<thead class="text-center bg-info text-white">
											<tr class="bg-info">
												<th>Código</th>
												<th style="width:200px;">Sala</th>
												<th style="width:150px;">Fecha</th>
												<th style="width:350px;">Variable</th>
												<th style="width:400px;">concepto</th>
												<th style="width:50px;">Calificación</th>
											</tr>
										</thead>
										<tbody>
											<?php do{
												$codigo_sala = $resumen->centro_costo;
												$nom_sala = $resumen->sala_nombre;
												$fecha_gestion = $resumen->fecha;
												$variable = $resumen->variable;
												$nom_concepto = $resumen->descripcion_con;
												$calificacion = $resumen->calificacion;
												if ($calificacion >= 9) {
													$color_fila = 'table-success';
												}elseif ($calificacion >= 7 and $calificacion <= 8) {
													$color_fila = 'table-warning';
												}elseif($calificacion >= 0 and $calificacion <= 6) {
													$color_fila = 'table-danger';
												}
												// $acumulado = $resumen->acumulado;
												// $promedio = number_format(($acumulado/$num_items),2,'.','');
												?>
												<tr class="<?php echo $color_fila; ?>">
													<td><?php echo $codigo_sala; ?></td>
													<td><?php echo $nom_sala; ?></td>
													<td><?php echo $fecha_gestion ?></td>
													<td><?php echo $variable ?></td>
													<td><?php echo $nom_concepto; ?></td>
													<td><?php echo $calificacion; ?></td>
												</tr>
											<?php }while($resumen = $query_resumen->fetch_object()); ?>
										</tbody>
									</table>
								</div>
							<?php } ?>
		    		<!-- </div> -->
			    <!-- <div class="panel panel-primary">
			      <div class="panel-heading">
			        <h4 class="panel-title">
			          <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Búsqueda por empleado</a>
			        </h4>
			      </div> -->
			      <!-- <div id="collapse2" class="panel-collapse collapse">
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
			      </div> -->
			    <!-- </div> -->
			  </div>
			<!-- </div> -->
		</div>
	</body>
</html>
<?php
	$query_lista_salas->close();
	$query_resumen->close();
	$link_personal->close();
 ?>
