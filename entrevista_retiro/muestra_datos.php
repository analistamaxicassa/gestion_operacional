<?php
	require_once('../conexionesDB/conexion.php');
	$link=Conectarse_personal();
	$link_queryx = Conectarse_queryx();

	$cedulaent="1010185420";
	$cedulaepre= $_POST['empleadoRetirado'];
	$hoy = new DateTime('now');

	//eliminar tabla temporal
	$sql20="TRUNCATE TABLE personal.empleados_retiradostmp";
	$qry_sql20=$link->query($sql20);

	$query1 = "SELECT EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_NOMBRE, CC.CENCOS_NOMBRE CCQ,
	CC.CCOS_VAL_ALF1 CIUDAD, to_char(EMP.EMP_FECHA_INI_CONTRATO,'YYYY-MM-DD') FECHA_INI, to_char(EMP.EMP_FECHA_RETIRO,'YYYY-MM-DD') EMP_FECHA_RETIRO,
	SO.NOMBRE_SOCIEDAD, EMP.EMP_CC_CONTABLE, EMP.EMP_CARGO, EMP.EMP_JEFE_CODIGO FROM EMPLEADO EMP, CARGO CA, SOCIEDAD SO, CENTRO_COSTO CC
	WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO and EMP.EMP_SOCIEDAD = SO.COD_SOCIEDAD and EMP.EMP_CC_CONTABLE = CC.CENCOS_CODIGO
	and EMP.EMP_CODIGO = '$cedulaepre'";
	//echo "<br>".$query1;
	$stmt1 = oci_parse($link_queryx, $query1);
	oci_execute($stmt1);
	$row1 = oci_fetch_object($stmt1);
	$nombre = $row1->NOMBRE;
	$cargo = $row1->CARGO_NOMBRE;
	$fecha_retiro = $row1->EMP_FECHA_RETIRO;
	$fecha_ingreso = $row1->FECHA_INI;
	$sociedad = $row1->NOMBRE_SOCIEDAD;
	$ciudad = $row1->CIUDAD;
	$centro_costo = $row1->EMP_CC_CONTABLE;
	$cod_cargo = $row1->EMP_CARGO;
	//$nombrecc=$row1->CCQ;
	oci_free_statement($stmt1);
	//$cc = explode("-",$row1['CCQ']);
	//echo "------".$fecha_ingreso;

	$query2 = "SELECT  E.EMP_NOMBRE||' '||E.EMP_APELLIDO1||' '||e.EMP_APELLIDO2 NOMBREENTREVISTA, CA.CARGO_NOMBRE CARGOENTREVISTA from empleado e, cargo ca where E.EMP_CARGO = CA.CARGO_CODIGO AND E.EMP_CODIGO = '$cedulaepre'" ;
	$stmt2 = oci_parse($link_queryx, $query2);
	oci_execute($stmt2);
	$row2 = oci_fetch_object($stmt2);
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Entrevista de retiro</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather:700i">
		<link rel="stylesheet" href="../CSS/panel.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script>
	    function filtrar_nombres()
	    {
	    	var min_length = 4;
	      var temp1 = $('#ejecutor').val();
	      var nombre = "";

	      if((isNaN(temp1) || isEmpty(temp1)) && temp1.length < 16)
	      {
	        nombre = temp1;
	        if (nombre.length >= min_length)
	        {
	          $.ajax({
	          url: '../validar_nombres.php',
	      		type: 'POST',
	      		data: {nombre:nombre},
	      		success:function(data){
	      			$('#resultadosEjecutor').show();
	      			$('#resultadosEjecutor').html(data);
	      		}
	      		});
	      	} else {
	      			$('#resultadosEjecutor').hide();
	      	}
	      }
	    }
	    function set_item(item)
	    {
	      $('#ejecutor').val(item);
	    	$('#resultadosEjecutor').hide();
	    }

	    function pasar_id(id)
	    {
	    	$('#ejecutorID').val(id);
	    }

			function desplegarTooltip()
	    {
	      $('[data-toggle="tooltip"]').tooltip();
	    }
		</script>
	</head>
<body>
	<ol class="breadcrumb">
		<li><a href="main.php">Principal</a></li>
		<li class="active">Entrevista de retiro</li>
	</ol>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="max-panel panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Maxicassa</h3>
					</div>
					<div class="panel-body">
						<form>
							<fieldset>
								<legend>Datos personales: <?php echo "<b>".$nombre."</b>"; ?></legend>
								Doc. Identidad: <p class="thick"><?php echo $cedulaepre; ?></p>
								Cargo: <p class="thick"><?php echo $cargo; ?></p>
								Ciudad: <p class="thick"><?php echo $ciudad; ?></p>
								Empresa: <p class="thick"><?php echo $sociedad; ?></p>
								Fecha Ingreso: <p class="thick"><?php echo $fecha_ingreso; ?></p>
								Fecha Retiro: <p class="thick"><?php if(empty($fecha_retiro)){$fecha_retiro = "No se registra la fecha de retiro";} echo $fecha_retiro; ?></p>
							</fieldset>
						</form>
						<form role="form" action="guardar_entrevista.php" method="post">
							<fieldset>
								<div class="form-group">
									<label for="ejecutor">Jefe inmediato:</label>
									<i class="fa fa-question-circle fa-1x" data-toggle="tooltip" onclick="desplegarTooltip()" style="color:#33ffff;" title="Digite el nombre del jefe inmediato y seleccione la persona de la lista."></i>
									<input class="form-control" placeholder="Ingrese un nombre para iniciar la búsqueda." name="ejecutor" onKeyUp="filtrar_nombres()" type="text" id="ejecutor" autocomplete="off" required>
									<input type="hidden" id="ejecutorID" name="ejecutorID">
								</div>
								<div id="resultadosEjecutor"></div>
								<div class="form-group">
									<label for="motivo">Motivo de retiro</label>
									<select name="motivo" id="motivo" class="form-control" required>
										<option value="">Seleccione un motivo de retiro</option>
										<option value="Cambio de régimen laboral a integral">Cambio de régimen laboral a integral.</option>
										<option value="Despido con justa causa">Despido con justa causa.</option>
										<option value="Despido sin justa causa">Despido sin justa causa.</option>
										<option value="Eliminación del cargo">Eliminación del cargo.</option>
										<option value="Fallecimiento">Fallecimiento.</option>
										<option value="Pensión">Pensión.</option>
										<option value="Renuncia">Renuncia.</option>
										<option value="Vencimiento de contrato">Vencimiento de contrato.</option>
										<option value="Periodo de prueba">Periodo de prueba.</option>
										<option value="Mutuo acuerdo">Mutuo acuerdo.</option>
										<option value="No termino el proceso de selección">No termino el proceso de selección.</option>
						      </select>
								</div>
							</fieldset>
							<fieldset>
								<legend>¿Qué influencia tuvieron los siguientes aspectos en su decisión de retiro?</legend>
								<div class="form-group">
									<label for="a1p1_detalle">Oferta de mejor cargo: </label>
									<label class="radio-inline">
							      <input type="radio" name="a1p1" value="1" required> Si
							    </label>
							    <label class="radio-inline">
							      <input type="radio" name="a1p1" value="0" required> No
							    </label>
									<input type="text" name="a1p1_detalle" placeholder="Especifique por qué este aspecto influencio en su decisión de retiro." class="form-control">
								</div>
								<div class="form-group">
									<label for="a1p2_detalle">Oferta de mejor salario: </label>
									<label class="radio-inline">
							      <input type="radio" name="a1p2" value="1" required> Si
							    </label>
							    <label class="radio-inline">
							      <input type="radio" name="a1p2" value="0" required> No
							    </label>
									<input type="text" name="a1p2_detalle" placeholder="Especifique por qué este aspecto influencio en su decisión de retiro." class="form-control">
								</div>
								<div class="form-group">
									<label for="a1p3_detalle">Mejores posibilidades de desarrollo: </label>
									<label class="radio-inline">
							      <input type="radio" name="a1p3" value="1" required> Si
							    </label>
							    <label class="radio-inline">
							      <input type="radio" name="a1p3" value="0" required> No
							    </label>
									<input type="text" name="a1p3_detalle" placeholder="Especifique por qué este aspecto influencio en su decisión de retiro." class="form-control">
								</div>
								<div class="form-group">
									<label for="a1p4_detalle">Mejores condiciones físicas para su trabajo: </label>
									<label class="radio-inline">
							      <input type="radio" name="a1p4" value="1" required> Si
							    </label>
							    <label class="radio-inline">
							      <input type="radio" name="a1p4" value="0" required> No
							    </label>
									<input type="text" name="a1p4_detalle" placeholder="Especifique por qué este aspecto influencio en su decisión de retiro." class="form-control">
								</div>
								<div class="form-group">
									<label for="a1p5_detalle">Relaciones interpersonales: </label>
									<label class="radio-inline">
							      <input type="radio" name="a1p5" value="1" required> Si
							    </label>
							    <label class="radio-inline">
							      <input type="radio" name="a1p5" value="0" required> No
							    </label>
									<input type="text" name="a1p5_detalle" placeholder="Especifique por qué este aspecto influencio en su decisión de retiro." class="form-control">
								</div>
								<div class="form-group">
									<label for="a1p6_detalle">Relaciones con sus superiores: </label>
									<label class="radio-inline">
							      <input type="radio" name="a1p6" value="1" required> Si
							    </label>
							    <label class="radio-inline">
							      <input type="radio" name="a1p6" value="0" required> No
							    </label>
									<input type="text" name="a1p6_detalle" placeholder="Especifique por qué este aspecto influencio en su decisión de retiro." class="form-control">
								</div>
							</fieldset>
							<fieldset>
								<legend>En el tiempo laborado en la empresa, seleccione cuales de los siguientes factores influyeron negativamente en su productividad</legend>
								<div class="form-group">
									<label for="f1p1_detalle">Falta de herramientas de trabajo: </label>
									<label class="radio-inline">
							      <input type="radio" name="f1p1" value="1" required> Si
							    </label>
							    <label class="radio-inline">
							      <input type="radio" name="f1p1" value="0" required> No
							    </label>
									<input type="text" name="f1p1_detalle" placeholder="Especifique por qué este factor influencio negativamente en su productividad." class="form-control">
								</div>
								<div class="form-group">
									<label for="f1p2_detalle">Cantidad y calidad de información: </label>
									<label class="radio-inline">
							      <input type="radio" name="f1p2" value="1" required> Si
							    </label>
							    <label class="radio-inline">
							      <input type="radio" name="f1p2" value="0" required> No
							    </label>
									<input type="text" name="f1p2_detalle" placeholder="Especifique por qué este factor influencio negativamente en su productividad." class="form-control">
								</div>
								<div class="form-group">
									<label for="f1p3_detalle">Confusión de responsabilidades: </label>
									<label class="radio-inline">
							      <input type="radio" name="f1p3" value="1" required> Si
							    </label>
							    <label class="radio-inline">
							      <input type="radio" name="f1p3" value="0" required> No
							    </label>
									<input type="text" name="f1p3_detalle" placeholder="Especifique por qué este factor influencio negativamente en su productividad." class="form-control">
								</div>
								<div class="form-group">
									<label for="f1p4_detalle">Dificultad para coordinar con otras áreas: </label>
									<label class="radio-inline">
							      <input type="radio" name="f1p4" value="1" required> Si
							    </label>
							    <label class="radio-inline">
							      <input type="radio" name="f1p4" value="0" required> No
							    </label>
									<input type="text" name="f1p4_detalle" placeholder="Especifique por qué este factor influencio negativamente en su productividad." class="form-control">
								</div>
								<div class="form-group">
									<label for="f1p5_detalle">Falta de entrenamiento: </label>
									<label class="radio-inline">
							      <input type="radio" name="f1p5" value="1" required> Si
							    </label>
							    <label class="radio-inline">
							      <input type="radio" name="f1p5" value="0" required> No
							    </label>
									<input type="text" name="f1p5_detalle" placeholder="Especifique por qué este factor influencio negativamente en su productividad." class="form-control">
								</div>
								<div class="form-group">
									<label for="f1p6_detalle">Demoras en la toma de decisiones: </label>
									<label class="radio-inline">
							      <input type="radio" name="f1p6" value="1" required> Si
							    </label>
							    <label class="radio-inline">
							      <input type="radio" name="f1p6" value="0" required> No
							    </label>
									<input type="text" name="f1p6_detalle" placeholder="Especifique por qué este factor influencio negativamente en su productividad." class="form-control">
								</div>
								<div class="form-group">
									<label for="f1p7_detalle">Directrices poco claras: </label>
									<label class="radio-inline">
							      <input type="radio" name="f1p6" value="1" required> Si
							    </label>
							    <label class="radio-inline">
							      <input type="radio" name="f1p6" value="0" required> No
							    </label>
									<input type="text" name="f1p7_detalle" placeholder="Especifique por qué este factor influencio negativamente en su productividad." class="form-control">
								</div>
								<div class="form-group">
									<label for="f1p8_detalle">Falta de dirección o supervisión: </label>
									<label class="radio-inline">
							      <input type="radio" name="f1p8" value="1" required> Si
							    </label>
							    <label class="radio-inline">
							      <input type="radio" name="f1p8" value="0" required> No
							    </label>
									<input type="text" name="f1p8_detalle" placeholder="Especifique por qué este factor influencio negativamente en su productividad." class="form-control">
								</div>
								<div class="form-group">
									<label for="f1p9_detalle">Otro factor: </label>
									<label class="radio-inline">
							      <input type="radio" name="f1p9" value="1" required> Si
							    </label>
							    <label class="radio-inline">
							      <input type="radio" name="f1p9" value="0" required> No
							    </label>
									<input type="text" name="f1p9_detalle" placeholder="Especifique el factor y por qué este factor influencio negativamente en su productividad." class="form-control">
								</div>
							</fieldset>
							<fieldset>
								<legend>Percepción sobre el entrevistado</legend>
								<div class="form-group">
									<label for="actitud">Actitud:</label>
									<select class="form-control" name="actitud">
										<option value="Buena">Buena</option>
										<option value="Mala">Mala</option>
									</select>
								</div>
								<div class="form-group">
									<label for="disposicion">Disposición:</label>
									<select class="form-control" name="disposicion">
										<option value="Colaborador">Colaborador</option>
										<option value="Indiferente">Indiferente</option>
									</select>
								</div>
							</fieldset>
							<fieldset>
								<div class="form-group">
									<label for="aspectosPositivos">Aspectos positivos de la empresa:</label>
									<select class="form-control" name="aspectosPositivos" required>
										<option value="">Seleccione un aspecto</option>
										<option value="Relación con superiores">Relación con superiores</option>
							      <option value="Trabajo en equipo">Trabajo en equipo</option>
							      <option value="Experiencia y reconocimiento en el sector">Experiencia y reconocimiento en el sector</option>
							      <option value="Tipo de contrato">Tipo de contrato</option>
							      <option value="Estabilidad">Estabilidad</option>
							      <option value="Cumplimiento en pago">Cumplimiento en pago</option>
							      <option value="Garantías legales">Garantías legales</option>
							      <option value="Fondo de empleados">Fondo de empleados</option>
							      <option value="No refiere">No refiere</option>
									</select>
								</div>
								<div class="form-group">
									<label for="aspectosMejorar">Aspectos a mejorar y recomendaciones para la empresa:</label>
									<select class="form-control" name="aspectosMejorar" required>
										<option value="">Seleccione un aspecto</option>
										<option value="Falta de retroalimentación y seguimiento de superiores">Falta de retroalimentación y seguimiento de superiores</option>
							      <option value="Falta de capacitación y entrenamiento al cargo">Falta de capacitación y entrenamiento al cargo</option>
							      <option value="Horarios extensos">Horarios extensos</option>
							      <option value="Falta de herramientas de trabajo">Falta de herramientas de trabajo</option>
							      <option value="Salario no acorde a cargo laboral">Salario no acorde a cargo laboral</option>
							      <option value="Demoras en toma de decisiones administrativas">Demoras en toma de decisiones administrativas</option>
							      <option value="Falta de reconocimiento y crecimiento">Falta de reconocimiento y crecimiento</option>
							      <option value="Relación con los superiores">Relación con los superiores</option>
							      <option value="Rotación de personal">Rotación de personal</option>
							      <option value="No refiere">No refiere</option>
									</select>
								</div>
								<div class="form-group">
									<label for="observacion">Observaciones y comentarios</label>
									<textarea name="observacion" class="form-control"></textarea>
								</div>
								<div class="form-group">
									<label for="fechaEntrevista">Fecha de la entrevista:</label>
									<input type="date" name="fechaEntrevista" value="<?php echo $hoy->format('Y-m-d'); ?>" class="form-control" required>
								</div>
								<div class="form-group">
									<input type="hidden" name="codCargo" value="<?php echo $cod_cargo; ?>">
									<input type="hidden" name="centroCosto" value="<?php echo $centro_costo; ?>">
									<input type="hidden" name="nombreCiudad" value="<?php echo $ciudad; ?>">
									<input type="hidden" name="fecha_ingreso" value="<?php echo $fecha_ingreso; ?>">
									<input type="hidden" name="fecha_retiro" value="<?php echo $fecha_retiro; ?>">
									<input type="hidden" name="empleadoRetiradoID" value="<?php echo $cedulaepre; ?>">
								</div>
							</fieldset>
								<button type="submit" class="btn btn-primary">Enviar <i class="fa fa-paper-plane-o"></i></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>


  <form method="post" action="guardarentrevista.php" enctype="multipart/form-data" id="formulario">

	</form>
<?php
	oci_free_statement($stmt2);
	oci_close($link_queryx);
?>
