<?php
require_once("conexion/conexion.php");
$anio = trim($_REQUEST['anioinf']);
$tipo = trim($_REQUEST['tipo']);
$empresa = trim($_REQUEST['empresag']);
//$anio =  '02';

?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Graficador Entrevistas de retiro</title>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<style type="text/css">
#container {
	height: 800px; 
	min-width: 310px; 
	max-width: 800px;
	margin: 0 auto;
}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column',
            margin: 95,
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 25,
                depth: 70
            }
        },
        title: {
            text: 'INFORME DE RETIROS POR MOTIVO'
        },
        subtitle: {
            text: '<?php
				 if ($tipo=='between 0 AND 4') 
					{ echo "PRIMER TRIMESTRE "."$anio";
					};
				 if ($tipo=='between 4 AND 7') 
					{ echo "SEGUNDO TRIMESTRE "."$anio";
					};
				 if ($tipo=='between 7 AND 10') 
					{ echo "TERCER TRIMESTRE "."$anio";
					};
				 if ($tipo=='between 9 AND 13') 
					{ echo "CUARTO TRIMESTRE "."$anio";
					};
				 if ($tipo=='<7') 
					{ echo "PRIMER SEMESTRE "."$anio";
					};
				 if ($tipo=='>6') 
					{ echo "SEGUNDA SEMESTRE "."$anio";
					};
				 if ($tipo=='<>222') 
					{ echo "ANUAL "."$anio";
					};
					 ?>'
        },
        plotOptions: {
            column: {
                depth: 25
            }
        },
        xAxis: {
            categories: [
			<?php
			
			$sql=mysql_query("SELECT   motivo,  COUNT(motivo) cantidad FROM `entrevista_retiro` WHERE mes $tipo and    anio = '$anio' and empresa = '$empresa'
GROUP BY motivo
ORDER BY motivo");
				while($res=mysql_fetch_array($sql)){			
			
?>					
			
			['<?php echo $res['motivo']; ?>'],
<?php
}
?>
			]
        },
        yAxis: {
            title: {
                text: null
            }
        },
        series: [{
            name: 'motivos',
            data: [
			
			<?php
$sql=mysql_query("SELECT   motivo,  COUNT(motivo) cantidad FROM `entrevista_retiro` WHERE mes $tipo and    anio = '$anio' and empresa = '$empresa'
GROUP BY motivo
ORDER BY motivo");
while($res=mysql_fetch_array($sql)){			
?>			
			
			[<?php echo $res['cantidad'] ?>],
			
<?php
}

?>
		]
        }]
    });
});
		</script>
	</head>
	<body>

<script src="../entrevista_retiro/Highcharts-4.1.5/js/highcharts.js"></script>
<script src="../entrevista_retiro/Highcharts-4.1.5/js/highcharts-3d.js"></script>
<script src="../entrevista_retiro/Highcharts-4.1.5/js/modules/exporting.js"></script>

<div id="container" style="height: 400px"></div>
	</body>
</html>
