<?php
require_once("conexion/conexion.php");
$anio = trim($_REQUEST['anioinf']);
$tipo = trim($_REQUEST['tipo']);
$empresa = trim($_REQUEST['empresag']);

   
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();


$sql1="SELECT SUM(`b1p1`) as b1p1, SUM(`b1p2`)as b1p2, SUM(`b1p3`)as b1p3, SUM(`b1p4`)as b1p4, SUM(`b1p5`)as b1p5, SUM(`b1p6`)as b1p6, SUM(`b2p1`) as b2p1, SUM(`b2p2`)as b2p2, SUM(`b2p3`)as b2p3, SUM(`b2p4`)as b2p4, SUM(`b2p5`)as b2p5, SUM(`b2p6`)as b2p6, SUM(`b2p7`)as b2p7, SUM(`b2p8`)as b2p8, SUM(`b2p9`)as b2p9   FROM `entrevista_retiro`  where mes $tipo and anio = $anio and empresa = '$empresa'";
			$qry_sql1=$link->query($sql1);
			$rs_qry1=$qry_sql1->fetch_object();  ///consultar 
			
$sql5="UPDATE resultado_encuesta SET RESPUESTAB1 = '$rs_qry1->b1p1' WHERE  PREGUNTAB1 =  'B1P1'";
$qry_sql5=$link->query($sql5);

  $sql6="UPDATE resultado_encuesta SET RESPUESTAB1 = '$rs_qry1->b1p2' WHERE  PREGUNTAB1 =  'B1P2'";
  $qry_sql6=$link->query($sql6);
  
  $sql7="UPDATE resultado_encuesta SET RESPUESTAB1 = '$rs_qry1->b1p3' WHERE  PREGUNTAB1 =  'B1P3'";
$qry_sql7=$link->query($sql7);  

  $sql8="UPDATE resultado_encuesta SET RESPUESTAB1 = '$rs_qry1->b1p4' WHERE  PREGUNTAB1 =  'B1P4'"; 
  $qry_sql8=$link->query($sql8);
  
  $sql9="UPDATE resultado_encuesta SET RESPUESTAB1 = '$rs_qry1->b1p5' WHERE  PREGUNTAB1 =  'B1P5'";
  $qry_sql9=$link->query($sql9);
    
  $sql10="UPDATE resultado_encuesta SET RESPUESTAB1 = '$rs_qry1->b1p6' WHERE  PREGUNTAB1 =  'B1P6'"; 
  $qry_sql10=$link->query($sql10);
  
  
  $sql16="UPDATE resultado_encuesta SET RESPUESTAB1 = '$rs_qry1->b2p1' WHERE  PREGUNTAB1 =  'B2P1'";
$qry_sql16=$link->query($sql16);

  $sql17="UPDATE resultado_encuesta SET RESPUESTAB1 = '$rs_qry1->b2p2' WHERE  PREGUNTAB1 =  'B2P2'";
  $qry_sql17=$link->query($sql17);
  
  $sql18="UPDATE resultado_encuesta SET RESPUESTAB1 = '$rs_qry1->b2p3' WHERE  PREGUNTAB1 =  'B2P3'";
$qry_sql18=$link->query($sql18);  

  $sql19="UPDATE resultado_encuesta SET RESPUESTAB1 = '$rs_qry1->b2p4' WHERE  PREGUNTAB1 =  'B2P4'"; 
  $qry_sql19=$link->query($sql19);
  
  $sql20="UPDATE resultado_encuesta SET RESPUESTAB1 = '$rs_qry1->b2p5' WHERE  PREGUNTAB1 =  'B2P5'";
  $qry_sql20=$link->query($sql20);
    
  $sql21="UPDATE resultado_encuesta SET RESPUESTAB1 = '$rs_qry1->b2p6' WHERE  PREGUNTAB1 =  'B2P6'"; 
  $qry_sql21=$link->query($sql21);

  $sql22="UPDATE resultado_encuesta SET RESPUESTAB1 = '$rs_qry1->b2p7' WHERE  PREGUNTAB1 =  'B2P7'"; 
  $qry_sql22=$link->query($sql22);

   $sql23="UPDATE resultado_encuesta SET RESPUESTAB1 = '$rs_qry1->b2p8' WHERE  PREGUNTAB1 =  'B2P8'"; 
  $qry_sql23=$link->query($sql23);
  
   $sql24="UPDATE resultado_encuesta SET RESPUESTAB1 = '$rs_qry1->b2p9' WHERE  PREGUNTAB1 =  'B2P9'"; 
  $qry_sql24=$link->query($sql24);


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
            text: 'INFORME DE FACTORES DE PRODUCTIVIDAD'
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
$sql=mysql_query("SELECT `DESCRIPCION`, `RESPUESTAB1` FROM `resultado_encuesta` where `PREGUNTAB1` like 'b2%' ORDER BY `RESPUESTAB1` DESC");
while($res=mysql_fetch_array($sql)){			
?>
			
			['<?php echo utf8_encode($res['DESCRIPCION']) ?>'],
			
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
            valueSuffix: 'Empleados'
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
            name: 'Factores',
            data: [
			<?php
$sql=mysql_query("SELECT `DESCRIPCION`, `RESPUESTAB1` FROM `resultado_encuesta` where `PREGUNTAB1` like 'b2%' ORDER BY `RESPUESTAB1` DESC");
while($res=mysql_fetch_array($sql)){			
?>			
			[<?php echo $res['RESPUESTAB1'] ?>],
		
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

