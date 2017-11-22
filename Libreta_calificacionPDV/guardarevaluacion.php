<?php
  require_once('../conexionesDB/conexion.php');
  $link=Conectarse_libreta();
  session_start();

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

  //MUESTRA RESULTADOS
  $sqlResult ="SELECT sum(result.calificacion) AS taspecto, pva.aspecto AS aspecto FROM check_list_resultado AS result INNER JOIN check_list_pva AS pva
  ON result.check_list = pva.id INNER JOIN log_evaluacion AS eval ON result.ingreso_ID = eval.log_eval_ID where
  result.ingreso_ID = '$idlog' group by pva.aspecto";

  $libreta=$link->query($sqlResult);
	$miLibreta=$libreta->fetch_object();  //consultar

	$sqlObservacion ="SELECT pva.aspecto AS aspecto, result.observacion AS observacion FROM check_list_resultado AS result INNER JOIN check_list_pva AS pva
  ON result.check_list = pva.id INNER JOIN log_evaluacion AS eval ON result.ingreso_ID = eval.log_eval_ID where
  result.ingreso_ID = '$idlog' and result.observacion <> '' ORDER BY aspecto";
	$observaciones=$link->query($sqlObservacion);
	$misObservaciones=$observaciones->fetch_object();  //consultar

	$sql4 ="SELECT sum(result.calificacion) tgeneral FROM check_list_resultado AS result INNER JOIN log_evaluacion AS eval ON result.ingreso_ID = eval.log_eval_ID
  where result.ingreso_ID = '$idlog'";
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
    <link rel="stylesheet" type="text/css" href="../estilos.css">
    <script type="text/javascript">
    function imprSelec(validador){
      var ficha=document.getElementById(validador);
      var ventimp=window.open(' ','popimpr');
    	ventimp.document.write(ficha.innerHTML);
    	ventimp.document.close();
    	ventimp.print();
    	ventimp.close();
    }
    </script>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  </head>
<body>
<table  align="right" width="200" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="centro_operacion" value="<?php echo $centro_operacion; ?>"></td>
    <td><input name="imprimir" type="submit" class="botones" id="prn" onclick="imprSelec('validador');" value="imprimir" /></td>
  </tr>
</table>
<h3 align="center">&nbsp;</h3>
<h3 align="center">Libreta de Calificaciones</h3>
<p align="center"><?php echo ($salaName); ?></p>
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
    <td width="92" height="33"><?php echo utf8_encode($miLibreta->aspecto); ?></td>
    <td width="92"><?php echo ($miLibreta->taspecto); ?>/50</td>
  </tr>

  <?php
		}
		while($miLibreta=$libreta->fetch_object());
?>
</table>
<table width="300" border="1" align="center">



  <tr>
    <td width="92" class="subtitulos" >TOTAL SALA</td>
    <td width="92" align="center" class="subtitulos" ><?php echo ($rs_qry4->tgeneral); ?>/250</td>
  </tr>
</table>

</td>
    <td width="75%" ><?php require_once('pentagono.php');?></td>
  </tr>
</table>

<p></p>
<p>&nbsp;</p>
<table  align="center" width="90%" border="0">
 <th scope="row"></th>
 <tr>
   <th scope="row">&nbsp;</th>
 </table>


<table  align="center" width="90%" border="1">
  <tr>
    <td class="encabezados">INFORME DE OBSERVACIONES</td>
    <?php
		do{
      if (!(empty($misObservaciones)))
      {
	?>
  </tr>
  <tr>
    <td class="subtitulos"><?php echo utf8_encode($misObservaciones->aspecto); ?></td>
  </tr>
  <tr>
    <td><?php echo utf8_encode($misObservaciones->observacion); ?></td>
  </tr>

<?php }
  }while($misObservaciones=$observaciones->fetch_object());
}
else
{
  echo "LA LIBRETA DE CALIFICACION EN LA FECHA: ".$fechaActual." DE LA SALA ".$salaName." YA FUE GENERADA";
}

?>

</table>
<p>&nbsp;</p>
<p><a href="principal.php">SALIR</a></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p align="center">&nbsp;</p>
<h3>&nbsp;</h3>
<p align="center"></p>

  </div>


</body>
</html>
