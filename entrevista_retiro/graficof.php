<?php
require_once("conexion/conexion.php");
$mes = trim($_REQUEST['mes']);

//$sent= $_REQUEST['cedula'];

//$sentencia= $_POST['sentencia'];
//echo "esta es la".$sent;



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
            text: 'INFORME MENSUAL'
        },
        subtitle: {
            text: '<?php
			if( $mes == "= '01'")
				{echo "ENERO";}
			if( $mes == "= '02'")
				{
				echo "FEBRERO";
				}
			if( $mes == "= '03'")
				{
				echo  "MARZO";
				}
			if( $mes == "= '04'")
				{
				echo "ABRIL";
				}
			if( $mes == "= '05'")
				{
				echo "MAYO";
				}
			if( $mes == "= '06'")
				{
				echo  "JUNIO";
				}
			if( $mes == "= '06'")
				{
				echo  "JULIO";
				}
			if( $mes == "= '07'")
				{
				echo  "JULIO";
				}
			if( $mes == "= '08'")
				{
				echo  "AGOSTO";
				}					
			if( $mes == "= '09'")
				{
				echo  "SEP/BRE";
				}					
			if( $mes == "= '10'")
				{
				echo  "OCTUBRE";
				}					
			if( $mes == "= '11'")
				{
				echo  "NOV/BRE";
				}					
			if( $mes == "= '12'")
				{
				echo  "DIC/BRE";
				}
				
				
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
			
				$sql=mysql_query("SELECT bloque3, count(bloque3) qbloque3 FROM entrevista_retiro WHERE mes $mes and motivo = 'RENUNCIA' group by bloque3 order by count(bloque3) desc");
				while($res=mysql_fetch_array($sql)){			
			
?>					
			
			['<?php echo $res['bloque3']; ?>'],
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
$sql=mysql_query("SELECT bloque3, count(bloque3) qbloque3 FROM entrevista_retiro WHERE mes $mes and motivo = 'RENUNCIA' group by bloque3 order by count(bloque3) desc ");
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

<script src="../entrevista_retiro/Highcharts-4.1.5/js/highcharts.js"></script>
<script src="../entrevista_retiro/Highcharts-4.1.5/js/highcharts-3d.js"></script>
<script src="../entrevista_retiro/Highcharts-4.1.5/js/modules/exporting.js"></script>

<div id="container" style="height: 400px"></div>
	</body>
</html>
