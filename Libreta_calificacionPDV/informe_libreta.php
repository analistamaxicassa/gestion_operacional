<?php
  require_once('../conexionesDB/conexion.php');
  $link=Conectarse_libreta();
  session_start();
/*
  $fecha = new DateTime('NOW');
  $fechaActual = $fecha->format('Y-m-d');
  $tipoEvaluacion = 'Libreta de calificacion';
  $ingreso_ID = $_SESSION['ingreso_ID'];
  $userID = $_SESSION['userID'];
	$centro_operacion = $_POST['centro_operacion'];
  $salaName = $_POST['salaName'];

  //evalua si ya existe un reporte de dia actual
  $sqlrv = "SELECT log_eval_ID AS id FROM log_evaluacion WHERE Date(hora_evaluacion) = '$fechaActual' AND sala = '$centro_operacion'";
	$qry_sqlrv=$link->query($sqlrv);
	$rs_qryrv=$qry_sqlrv->fetch_object();  ///consultar

if(empty($rs_qryrv->id))
{
  $inserLog = "INSERT INTO log_evaluacion (ingreso_ID, tipo_evaluacion, sala) VALUES ('$ingreso_ID','$tipoEvaluacion','$centro_operacion')";
  $query_log=$link->query($inserLog);

  $selectID = "SELECT LAST_INSERT_ID() AS idlog FROM log_evaluacion WHERE ingreso_ID = '$ingreso_ID'";
  $resultID=$link->query($selectID);
	$myID=$resultID->fetch_object();
  $idlog = $myID->idlog;

  //Obtener el número de preguntas de la libreta
  $sqlQuestion = "SELECT COUNT(id) AS preguntas FROM check_list_pva" ;
	$resultCount=$link->query($sqlQuestion);
	$numberPreguntas=$resultCount->fetch_object();
  $numeroPreguntas = $numberPreguntas->preguntas;

  $a=0;
  while ( $a++ < ($numeroPreguntas))
  {
    $check_listf = $_POST['check_list'.$a];
  	$RadioGroup1f = $_POST['RadioGroup1'.$a];
  	$observacionf = utf8_encode($_POST['observacion'.$a]);
    $insertList = "INSERT INTO check_list_resultado (ingreso_ID, check_list, calificacion, observacion) VALUES ('$idlog', '$check_listf', '$RadioGroup1f', '$observacionf')";
  	$qry_sql3=$link->query($insertList);
  }
*/
  $idlog = $_GET['id'];
  $salaName = $_GET['sala'];

  $sqlFecha = "SELECT DATE(eval.hora_evaluacion) AS fecha FROM log_evaluacion AS eval WHERE
  eval.log_eval_ID = '$idlog'";
  $dateLibreta=$link->query($sqlFecha);
	$fechaLibreta=$dateLibreta->fetch_object();
  $fecha = $fechaLibreta->fecha;
  //MUESTRA RESULTADOS
  $sqlResult ="SELECT sum(result.calificacion) AS taspecto, pva.aspecto AS aspecto FROM check_list_resultado AS result INNER JOIN check_list_pva AS pva
  ON result.check_list = pva.id INNER JOIN log_evaluacion AS eval ON result.ingreso_ID = eval.log_eval_ID where
  result.ingreso_ID = '$idlog' group by pva.aspecto";

  $libreta=$link->query($sqlResult);
	$miLibreta=$libreta->fetch_object();  //consultar

	$sqlObservacion ="SELECT pva.aspecto AS aspecto, result.observacion AS observacion, result.calificacion AS nota, pva.operacion AS operacion,
  result.check_list AS numero, DATE(eval.hora_evaluacion) AS fecha FROM check_list_resultado AS result INNER JOIN check_list_pva AS pva
  ON result.check_list = pva.id INNER JOIN log_evaluacion AS eval ON result.ingreso_ID = eval.log_eval_ID where
  result.ingreso_ID = '$idlog' and result.observacion <> '' ORDER BY aspecto";
  //echo $sqlObservacion."<br>";
	$observaciones=$link->query($sqlObservacion);
	$misObservaciones=$observaciones->fetch_object(); //consultar

	$sql4 ="SELECT sum(result.calificacion) tgeneral FROM check_list_resultado AS result INNER JOIN log_evaluacion AS eval ON result.ingreso_ID = eval.log_eval_ID
  where result.ingreso_ID = '$idlog'";
  //echo $sql4."<br>";
	$qry_sql4=$link->query($sql4);
	$rs_qry4=$qry_sql4->fetch_object();  //consultar

?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Libreta de Calificaciones PDV</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../estilos.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  </head>
<body>
<br>
<h3 align="center">Libreta de Calificaciones <?php echo "(".$fecha.")"; ?></h3>
<p align="center"><?php echo $salaName; ?></p>
<div id="validador">
<table width="200" border="1" align="center">
  <tr>
    <td>
<p align="center">&nbsp;</p>
<table width="80%">
<table width="95%" border="1" align="center">
<?php
		do{
?>
   <tr>
    <td width="92" height="33"><?php echo $miLibreta->aspecto; ?></td>
    <td width="92"><?php echo $miLibreta->taspecto; ?>/50</td>
  </tr>

  <?php
		}
		while($miLibreta=$libreta->fetch_object());
?>
</table>
<table width="300" border="1" align="center">
  <tr>
    <td width="92" class="subtitulos" >TOTAL SALA</td>
    <td width="92" align="center" class="subtitulos" ><?php echo $rs_qry4->tgeneral; ?>/250</td>
  </tr>
</table>
</td>
  <td width="75%" ><?php require_once('pentagono.php');?></td>
  </tr>
</table>
<br>
<div class="table-responsive col-md-12">
  <table class="table table-bordered">
    <thead>
      <tr class="bg-primary">
        <th>Ítem</th>
        <th>Aspecto</th>
        <th>Observación</th>
        <th>Calificación</th>
      </tr>
    </thead>
    <tbody>
      <?php
        do{
          if (!(empty($misObservaciones)))
          {
      ?>
      <tr>
        <td><?php echo ($misObservaciones->numero)." - ".($misObservaciones->operacion); ?></td>
        <td><?php echo $misObservaciones->aspecto; ?></td>
        <td><?php echo $misObservaciones->observacion; ?></td>
        <td><?php echo $misObservaciones->nota; ?></td>
      </tr>
      <?php
          }
        }while($misObservaciones=$observaciones->fetch_object());
      ?>
    </tbody>
  </table>
</div>
<p>&nbsp;</p>
<p align="center">&nbsp;</p>
<h3>&nbsp;</h3>
<p align="center"></p>

  </div>


</body>
</html>
