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
		<title>Highcharts Example</title>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'INFORME DE ASPECTOS POSITIVOS'
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
        xAxis: {
            categories: [
<?php
$sql=mysql_query("SELECT bloque3, count(bloque3) qbloque3 FROM entrevista_retiro WHERE mes $tipo and anio = $anio and `bloque3` <> '' and empresa = '$empresa' group by bloque3 order by count(bloque3) desc");
while($res=mysql_fetch_array($sql)){			
?>
			
			['<?php echo utf8_encode($res['bloque3']) ?>'],
			
<?php
}
?>
			
			],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: '',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' Empleados'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'horizontal',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Aspectos',
            data: [
			<?php
$sql=mysql_query("SELECT bloque3, count(bloque3) qbloque3 FROM entrevista_retiro WHERE mes $tipo and anio = $anio and `bloque3` <> '' and empresa = '$empresa' group by bloque3 order by count(bloque3) desc");
while($res=mysql_fetch_array($sql)){			
?>			
			[<?php echo $res['qbloque3'] ?>],
		
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
<script src="Highcharts-4.1.5/js/highcharts.js"></script>
<script src="Highcharts-4.1.5/js/modules/exporting.js"></script>

<div id="container" style="min-width: 600px; max-width: 800px; height: 400px; margin: 0 auto"></div>
<br><br>

	</body>
</html>

