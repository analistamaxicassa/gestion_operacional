<?php
	require_once('../conexionesDB/conexion.php');
  $link_personal=Conectarse_personal();

  $sociedad = $_POST['sociedad'];
  $ciudad = $_POST['ciudad'];
	$fechaInicial = $_POST['fechaInicial'];
  $fechaFinal = $_POST['fechaFinal'];
	$tipoGrafica = $_POST['tipoGrafica'];

	if (isset($_POST['cargoEmpleado']))
	 {
		$cargo = $_POST['cargoEmpleado'];
		$cargoLength = count($cargo);
		echo "String ".$cargoLength."<br>";
		$i = 0;
		do {
			if ($tipoGrafica == '1') {
				$sql = "SELECT MonthName(fecha_retiro) AS ejeY FROM entrevista_retiro
			    WHERE (fecha_retiro BETWEEN '$fechaInicial' AND '$fechaFinal') group by Month(fecha_retiro)";
			  $sql2 = "SELECT count(entrevistaID) AS ejeX FROM entrevista_retiro
			    WHERE (fecha_retiro BETWEEN '$fechaInicial' AND '$fechaFinal') group by Month(fecha_retiro)";
				$title = "Retiros por mes";
				$etiqueta = "# empleados retirados por mes";
			}elseif ($tipoGrafica == '2') {
				$sql = "SELECT motivo AS ejeY FROM entrevista_retiro
			    WHERE (fecha_retiro BETWEEN '$fechaInicial' AND '$fechaFinal') group by motivo";
			  $sql2 = "SELECT count(entrevistaID) AS ejeX FROM entrevista_retiro
			    WHERE (fecha_retiro BETWEEN '$fechaInicial' AND '$fechaFinal') group by motivo";
				$title = "Retiros por motivo";
				$etiqueta = "# empleados retirados por motivo";
			}elseif ($tipoGrafica == '3') {
				$sql = "SELECT aspectosPositivos AS ejeY FROM entrevista_retiro
			    WHERE (fecha_retiro BETWEEN '$fechaInicial' AND '$fechaFinal') group by aspectosPositivos";
			  $sql2 = "SELECT count(entrevistaID) AS ejeX FROM entrevista_retiro
			    WHERE (fecha_retiro BETWEEN '$fechaInicial' AND '$fechaFinal') group by aspectosPositivos";
				$title = "Aspectos positivos";
				$etiqueta = "# empleados por aspecto";
			}elseif ($tipoGrafica == '4') {
				$sql = "SELECT aspectosMejorar AS ejeY FROM entrevista_retiro
			    WHERE (fecha_retiro BETWEEN '$fechaInicial' AND '$fechaFinal') group by aspectosMejorar";
			  $sql2 = "SELECT count(entrevistaID) AS ejeX FROM entrevista_retiro
			    WHERE (fecha_retiro BETWEEN '$fechaInicial' AND '$fechaFinal') group by aspectosMejorar";
				$title = "Informe de aspectos a mejorar";
				$etiqueta = "# empleados por aspecto";
			}
			$i++;
			echo "string ".$i;
		} while ($i < $cargoLength);
	}
	else
	{
		if ($tipoGrafica == '1') {
			$sql = "SELECT MonthName(fecha_retiro) AS ejeY FROM entrevista_retiro
		    WHERE (fecha_retiro BETWEEN '$fechaInicial' AND '$fechaFinal') group by Month(fecha_retiro)";
		  $sql2 = "SELECT count(entrevistaID) AS ejeX FROM entrevista_retiro
		    WHERE (fecha_retiro BETWEEN '$fechaInicial' AND '$fechaFinal') group by Month(fecha_retiro)";
			$title = "Retiros por mes";
			$etiqueta = "# empleados retirados por mes";
		}elseif ($tipoGrafica == '2') {
			$sql = "SELECT motivo AS ejeY FROM entrevista_retiro
		    WHERE (fecha_retiro BETWEEN '$fechaInicial' AND '$fechaFinal') group by motivo";
		  $sql2 = "SELECT count(entrevistaID) AS ejeX FROM entrevista_retiro
		    WHERE (fecha_retiro BETWEEN '$fechaInicial' AND '$fechaFinal') group by motivo";
			$title = "Retiros por motivo";
			$etiqueta = "# empleados retirados por motivo";
		}elseif ($tipoGrafica == '3') {
			$sql = "SELECT aspectosPositivos AS ejeY FROM entrevista_retiro
		    WHERE (fecha_retiro BETWEEN '$fechaInicial' AND '$fechaFinal') group by aspectosPositivos";
		  $sql2 = "SELECT count(entrevistaID) AS ejeX FROM entrevista_retiro
		    WHERE (fecha_retiro BETWEEN '$fechaInicial' AND '$fechaFinal') group by aspectosPositivos";
			$title = "Aspectos positivos";
			$etiqueta = "# empleados por aspecto";
		}elseif ($tipoGrafica == '4') {
			$sql = "SELECT aspectosMejorar AS ejeY FROM entrevista_retiro
		    WHERE (fecha_retiro BETWEEN '$fechaInicial' AND '$fechaFinal') group by aspectosMejorar";
		  $sql2 = "SELECT count(entrevistaID) AS ejeX FROM entrevista_retiro
		    WHERE (fecha_retiro BETWEEN '$fechaInicial' AND '$fechaFinal') group by aspectosMejorar";
			$title = "Informe de aspectos a mejorar";
			$etiqueta = "# empleados por aspecto";
		}
	}
  //echo $sql."<br>";
  $query_mes=$link_personal->query($sql);
	$query_retirados=$link_personal->query($sql2);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Entrevistas de retiro</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.js"></script>
		<link href="../CSS/panel.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Merriweather:700i" rel="stylesheet">
    <style media="screen">
      .chart-container {
        position: relative;
        margin: auto;
        height: 80vh;
        width: 80vw;
      }
    </style>
  </head>
  <body>
		<ol class="breadcrumb">
      <li><a href="informe_entrevista.php">Informes gráficos</a></li>
      <li class="active">Gráficos</li>
    </ol>
    <div class="container col-md-12">
			<div class="max-panel panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Maxicassa</h3>
				</div>
				<div class="panel-body">
					<canvas id="myChart"></canvas>
				</div>
			</div>
      <div class="chart-container">

      </div>
    </div>
    <script>
      var ctx = document.getElementById("myChart");
			var r = Math.floor(Math.random() * 256);
			var g = Math.floor(Math.random() * 256);
			var b = Math.floor(Math.random() * 256);

			var densityData = {
			  label: 'Density',
			  data: [5427, 5243, 5514, 3933, 1326, 687, 1271, 1638],
			  backgroundColor: [
			    'rgba(0, 99, 132, 0.6)',
			    'rgba(30, 99, 132, 0.6)',
			    'rgba(60, 99, 132, 0.6)',
			    'rgba(90, 99, 132, 0.6)',
			    'rgba(120, 99, 132, 0.6)',
			    'rgba(150, 99, 132, 0.6)',
			    'rgba(180, 99, 132, 0.6)',
			    'rgba(210, 99, 132, 0.6)',
			    'rgba(240, 99, 132, 0.6)'
			  ],
			  borderColor: [
			    'rgba(0, 99, 132, 1)',
			    'rgba(30, 99, 132, 1)',
			    'rgba(60, 99, 132, 1)',
			    'rgba(90, 99, 132, 1)',
			    'rgba(120, 99, 132, 1)',
			    'rgba(150, 99, 132, 1)',
			    'rgba(180, 99, 132, 1)',
			    'rgba(210, 99, 132, 1)',
			    'rgba(240, 99, 132, 1)'
			  ],
			  borderWidth: 2,
			  hoverBorderWidth: 0
			};

      var myChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
          labels: ['SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE'],
          datasets: [
					{
            label: 'ADMINISTRADOR DE SALA',
            data: [10, 15, 0],
            backgroundColor: 'rgba(0, 47, 135, 0.2)',
            borderColor: 'rgba(0, 47, 135, 1)',
            borderWidth: 1
          },
					{
            label: 'AUXILIAR ADMINISTRATIVO',
            data: [12, 7, 10],
            backgroundColor: 'rgba('+r+', '+g+', '+b+', 0.2)',
            borderColor: 'rgba(0, 47, 135, 1)',
            borderWidth: 1
          },
					{
            label: 'ASESOR COMERCIAL',
            data: [20, 0, 2],
            backgroundColor: 'rgba('+r+', '+g+', '+b+', 0.2)',
            borderColor: 'rgba('+r+', '+g+', '+b+', 1)',
            borderWidth: 1
          }
        ]
        },
        options: {
          title: {
            display: true,
            text: 'Retiros por mes - Bogotá'
          },
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero:true
              }
            }],
            xAxes: [{
              ticks: {
                stepSize: 1,
                beginAtZero:true
              }
            }]
          }
        }
      });
    </script>
  </body>
</html>
