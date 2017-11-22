<script>
	alert(''+empresag);
</script>
<?php
	echo "<br>".$_POST['empresag'];
	require_once("conexion/conexion.php");
	$anio = trim($_REQUEST['anioinf']);
	$tipo = trim($_REQUEST['tipo']);
	$empresa = trim($_REQUEST['empresag']);

	//$anio =  '02';
	/*
	echo $sql=("SELECT   mes,  COUNT(MES) cantidad FROM `entrevista_retiro` WHERE mes $tipo and    anio = '$anio'
	GROUP BY MES
	ORDER BY MES");
	*/
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Graficas de entrevistas de retiro</title>

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
            text: 'INFORME DE RETIROS X MES'
        },
        subtitle: {
            text: '<?php
				 if ($tipo=='between 0 AND 4')
					{ echo "PRIMER TRIMESTRE "."$anio"." "."$empresa";
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
				$sql1=mysql_query("SELECT mes, COUNT(MES) cantidad FROM entrevista_retiro WHERE mes $tipo and anio = '$anio' and empresa = '$empresa'
				GROUP BY MES
				ORDER BY MES");
				while($res=mysql_fetch_array($sql1)){
	?>
			['<?php
				 if ($res['mes']=='1')
					{ echo "ENERO";
					};
				 if ($res['mes']=='2')
					{ echo "FEBRERO";
					};
				 if ($res['mes']=='3')
					{ echo "MARZO";
					};
				 if ($res['mes']=='4')
					{ echo "ABRIL";
					};
				 if ($res['mes']=='5')
					{ echo "MAYO";
					};
				 if ($res['mes']=='6')
					{ echo "JUNIO";
					};
				 if ($res['mes']=='7')
					{ echo "JULIO";
					};
						 if ($res['mes']=='8')
					{ echo "AGOSTO";
					};
				 if ($res['mes']=='9')
					{ echo "SEP/BRE";
					};
				 if ($res['mes']=='10')
					{ echo "OCT/BRE";
					};
				 if ($res['mes']=='11')
					{ echo "NOV/BRE";
					};
				 if ($res['mes']=='12')
					{ echo "DIC/BRE";
					};

			 ?>'],
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
            name: 'meses',
            data: [

			<?php
				$sql=mysql_query("SELECT   mes,  COUNT(MES) cantidad FROM `entrevista_retiro` WHERE mes $tipo and    anio = '$anio' and empresa = '$empresa'
				GROUP BY MES
				ORDER BY MES");
				while($res=mysql_fetch_array($sql)){
?>
			[<?php echo $res['cantidad'] ?>],
<?php } ?>
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
