<?php
	require_once('../conexionesDB/conexion.php');
	//TODO Revisar si se debe utilizar el require_once
	//require_once('guardarevaluacion.php');

	$link=Conectarse_libreta();
	$ejey = '';

	// muestra los aspectos
	$sql4 = "SELECT sum(result.calificacion) AS taspecto, pva.aspecto AS aspecto FROM check_list_resultado AS result INNER JOIN check_list_pva AS pva
  ON result.check_list = pva.id INNER JOIN log_evaluacion AS eval ON result.ingreso_ID = eval.log_eval_ID where
  result.ingreso_ID = '$idlog' group by pva.aspecto";
	$qry_sql4=$link->query($sql4);
	$rs_qry4=$qry_sql4->fetch_object();

	do{
		  $ejex = ($rs_qry4->taspecto);
			$ejey=$ejey.$ejex.",";
		}while($rs_qry4=$qry_sql4->fetch_object());
		$datof = substr($ejey,0,-1);
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Gráfico de pentágono</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {

    $('#container').highcharts({

        chart: {
            polar: true,
            type: 'line'
        },

        title: {
            text: 'PENTÁGONO DE SALA',
            x: -80
        },

        pane: {
            size: '80%'
        },

        xAxis: {
            categories: ['COMUNICACIÓN','GENTE','LUGAR','PRODUCTO','VALOR AGREGADO'],
            tickmarkPlacement: 'on',
            lineWidth: 0
        },

        yAxis: {
            gridLineInterpolation: 'pentagon',
            lineWidth: 0,
            min: 0
        },

        tooltip: {
            shared: true,
            pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y:,.0f}</b><br/>'
        },

        legend: {
            align: 'right',
            verticalAlign: 'top',
            y: 70,
            layout: 'vertical'
        },

        series: [{
            name: '.',
            data: [<?php echo substr($ejey,0,-1);?>],
            pointPlacement: 'on'
        }]
    });
});
		</script>
	</head>
	<body>
<script src="../js/highcharts.js"></script>
<script src="../js/highcharts-more.js"></script>
<script src="../js/modules/exporting.js"></script>

<div id="container" style="min-width: 500px; max-width: 600px; height: 400px; margin: 0 auto"></div>

	</body>
</html>
