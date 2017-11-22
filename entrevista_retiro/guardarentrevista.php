<?php
error_reporting(0);
require_once('../conexionesDB/conexion.php');
$link_personal=Conectarse_personal();
//session_start();

$cedular=$_REQUEST['cedula'];
// $cedulaent=$_REQUEST['cedulaent'];

//recojo variables
echo $mes= $_POST['mes1'];
$anio= $_POST['anio'];
$cedular=$_POST['cedular'];
$cargo= $_POST['cargo'];
$nombrecc= $_POST['nombrecc'];
$empresa= $_POST['sociedad'];
$motivo=$_POST['motivo'];
$actitud=$_POST['actitud'];
$colaboracion=$_POST['colaboracion'];
$bloque3= $_POST['bloque3'];
$bloque4= $_POST['bloque4'];
$bloque5=$_POST['bloque5'];
$nombreent=$_POST['nombreent'];
$cargoent=$_POST['cargoent'];
$ob1p1=$_POST['RadioGroup1'];
$ob1p2=$_POST['RadioGroup2'];
$ob1p3=$_POST['RadioGroup3'];
$ob1p4=$_POST['RadioGroup4'];
$ob1p5=$_POST['RadioGroup5'];
$ob1p6=$_POST['RadioGroup6'];
$ob2p1=$_POST['RadioGroup7'];
$ob2p2=$_POST['RadioGroup8'];
$ob2p3=$_POST['RadioGroup9'];
$ob2p4=$_POST['RadioGroup10'];
$ob2p5=$_POST['RadioGroup11'];
$ob2p6=$_POST['RadioGroup12'];
$ob2p7=$_POST['RadioGroup13'];
$ob2p8=$_POST['RadioGroup14'];
$ob2p9=$_POST['RadioGroup15'];
$b1p1=$_POST['b1p1'];
$b1p2=$_POST['b1p2'];
$b1p3=$_POST['b1p3'];
$b1p4=$_POST['b1p4'];
$b1p5=$_POST['b1p5'];
$b1p6=$_POST['b1p6'];
$b2p1=$_POST['b2p1'];
$b2p2=$_POST['b2p2'];
$b2p3=$_POST['b2p3'];
$b2p4=$_POST['b2p4'];
$b2p5=$_POST['b2p5'];
$b2p6=$_POST['b2p6'];
$b2p7=$_POST['b2p7'];
$b2p8=$_POST['b2p8'];
$b2p9=$_POST['b2p9'];

$hoy=date("d/m/y");

	//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}

echo  $sql="INSERT INTO `personal`.`entrevista_retiro` (`id`, `mes`, `anio`,`cedula_retirado`, `cargo_retirado`, `nombrecc`, `empresa`, `motivo`, `b1p1`, `b1p2`, `b1p3`, `b1p4`, `b1p5`, `b1p6`, `comb1p1`, `comb1p2`, `comb1p3`, `comb1p4`, `comb1p5`, `comb1p6`,  `b2p1`, `b2p2`, `b2p3`, `b2p4`, `b2p5`, `b2p6`, `b2p7`, `b2p8`, `b2p9`, `comb2p1`, `comb2p2`, `comb2p3`, `comb2p4`, `comb2p5`, `comb2p6`, `comb2p7`, `comb2p8`, `comb2p9`,  `actitud`, `colaboracion`, `bloque3`, `bloque4`, `bloque5`, `cedula_ent`, `cargo_ent`, `fecha_ent`) VALUES (NULL, '$mes', '$anio', '$cedular', '$cargo', '$nombrecc', '$empresa', '$motivo', '$ob1p1', '$ob1p2', '$ob1p3', '$ob1p4', '$ob1p5', '$ob1p6', '$b1p1', '$b1p2', '$b1p3', '$b1p4', '$b1p5', '$b1p6',  '$ob2p1', '$ob2p2', '$ob2p3', '$ob2p4', '$ob2p5', '$ob2p6', '$ob2p7', '$ob2p8', '$ob2p9', '$b2p1', '$b2p2', '$b2p3', '$b2p4', '$b2p5', '$b2p6', '$b2p7', '$b2p8', '$b2p9', '$actitud', '$colaboracion', '$bloque3', '$bloque4', '$bloque5', '$nombreent', '$cargoent', '$hoy');";

$qry_sql=$link_personal->query($sql);

$sql1 = "SELECT * FROM `entrevista_retiro` WHERE `cedula_retirado` = '$cedular'";
$qry_sql1=$link_personal->query($sql1);
$rs_qry1=$qry_sql1->fetch_object();  ///consultar

 $query2 = "SELECT EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, EMP.EMP_FECHA_INGRESO INGRESO, EMP.EMP_FECHA_RETIRO RETIRO
FROM EMPLEADO EMP
WHERE emp.emp_codigo = '$cedular'
" ;

		$stmt2 = $dbh->prepare($query2);
		$stmt2->execute();
		$row2 = $stmt2->fetch();


?>
<!doctype html>
<html lang="en">
<head>


<style type='text/css'>
tr:nth-child(odd) {
    background-color:#f2f2f2;
}
tr:nth-child(even) {
	background-color: #fbfbfb;


}

</style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Entrevista de Retiro</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="../estilos.css">
 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

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


<form  id="formulario">
<div id="validador">

	 <table width="830" border="0" align="center"  style="border-collapse:collapse">
    <tr>
      <td align="center" style="font-style:italic" >&nbsp;</td>
    </tr>
    <tr>
      <td  colspan="4"  align="center" class="encabezados"  >ENTREVISTA DE RETIRO</td>
    </tr>
    <tr>
      <td align="center" style="font-style:italic" >&nbsp;</td>
    </tr>
    <tr>

    </tr>
     <tr>

    </tr>
    </table>

  <table width="830" border="0" align="center"  style="border-collapse:collapse">
    <tr>
      <td  colspan="4" align="left" valign="middle"><strong>NOMBRE</strong></td>
      <td colspan="6"  align="justify" ><?php echo utf8_encode($row2['NOMBRE']); ?></td>
    </tr>
    <tr>
      <td  colspan="4" align="left" valign="middle"><strong>CARGO</strong></td>
      <td colspan="6"  align="justify" ><input name="cargo" type="text" id="cargo" value=" <?php echo $rs_qry1->cargo_retirado; ?>" size="50" readonly />
        <input type="hidden"  name="cedular" value="<?php echo $cedular; ?>" id="cedular" readonly /></td>
    </tr>
    <tr>
      <td  colspan="4" align="left" valign="middle"><strong>CENTRO DE COSTO</strong></td>
      <td width="612" colspan="6"  align="justify" ><input name="nombrecc" type="text" id="nombrecc" value="<?php echo utf8_encode($nombrecc); ?>" size="50" readonly /></td>
    </tr>
    <tr>
      <td  colspan="4" align="left" valign="middle"><strong>FECHA DE INGRESO</strong></td>
      <td width="612"  colspan="6" align="justify" valign="middle"><?php echo ($row2['INGRESO']); ?></td>
    </tr>
    <tr>
      <td  colspan="4" align="left" valign="middle"><strong>FECHA DE RETIRO</strong></td>
      <td width="612"  colspan="6" align="justify" valign="middle"><?php echo ($row2['RETIRO']); ?>
        </td>
    </tr>
    <tr>
      <td  colspan="4" align="left" valign="middle"><strong>EMPRESA</strong></td>
      <td width="612" colspan="6" align="justify"  valign="middle"><input name="sociedad" type="text" id="sociedad"  value="<?php echo $empresa; ?>" size="50" readonly /></td>
    </tr>
    <tr>
      <td  colspan="4" align="left" valign="middle">&nbsp;</td>
      <td width="612" colspan="6" align="justify" valign="middle"></td>
    </tr>
    <tr>
      <td  colspan="4" align="left" valign="middle">MOTIVO DE RETIRO</td>
      <td colspan="6" align="justify" valign="middle"><?php echo $motivo; ?>
        </td>
    </tr>
  </table>
  </p>
  <table width="830" border="0" align="center" style="border-collapse:collapse">
    <tr>
      <td  colspan="4"  align="center" class="encabezados" >QUE INFLUENCIA TUVIERON LOS SIGUIENTES ASPECTOS EN SU DECISION DE RETIRO</td>
    </tr>
    <tr align="left">
      <td width="290"   >Oferta de mejor cargo</td>
      <td width="196" colspan="2"  ><?php if ($rs_qry1->b1p1 == '1')
		  							echo "SI";
									else
		  							  echo "NO";

									  ; ?></td>
      <td width="326" ><?php echo $rs_qry1->comb1p1; ?></td>
    </tr>
    <tr>
      <td>Oferta de mejor salario</td>
      <td colspan="2" ><?php if ($rs_qry1->b1p2 == '1')
		  							echo "SI";
									else
		  							  echo "NO";

									  ; ?></td>
      <td><label for="b1p2"><?php echo $rs_qry1->comb1p2; ?></label></td>
    </tr>
    <tr>
      <td>Mejores posibilidades de desarrollo</td>
      <td colspan="2" ><?php if ($rs_qry1->b1p3 == '1')
		  							echo "SI";
									else
		  							  echo "NO";

									  ; ?></td>
      <td ><label for="b1p3"><?php echo $rs_qry1->comb1p3; ?></label></td>
    </tr>
    <tr>
      <td >Mejores condiciones fisicas para su trabajo</td>
      <td colspan="2"  ><?php if ($rs_qry1->b1p4 == '1')
		  							echo "SI";
									else
		  							  echo "NO";

									  ; ?></td>
      <td ><label for="b1p4"><?php echo $rs_qry1->comb1p4; ?></label></td>
    </tr>
    <tr>
      <td>Relaciones interpersonales</td>
      <td colspan="2" ><?php if ($rs_qry1->b1p5 == '1')
		  							echo "SI";
									else
		  							  echo "NO";

									  ; ?></td>
      <td><label for="b1p5"><?php echo $rs_qry1->comb1p5; ?></label></td>
    </tr>
    <tr>
      <td>Relaciones con sus superiores</td>
      <td colspan="2"><?php if ($rs_qry1->b1p6 == '1')
		  							echo "SI";
									else
		  							  echo "NO";

									  ; ?></td>
      <td><label for="b1p6"><?php echo $rs_qry1->comb1p6; ?></label></td>
    </tr>
    <tr>
      <td  colspan="4" align="justify" valign="middle"></td>
    </tr>
  </table>
  </p>
  <table width="830" border="0" align="center" style="border-collapse:collapse">
    <tr>
      <td  colspan="4"  align="left" class="encabezados" ><p>FACTORES QUE INFLUYERON EN SU PRODUCTIVIDAD </p></td>
    </tr>
    <tr align="left">
      <td width="364"   >Falta de herramientas de trabajo</td>
      <td width="133" colspan="2"  ><?php if ($rs_qry1->b2p1 == '1')
		  							echo "SI";
									else
		  							  echo "NO";

									  ; ?></td>
      <td width="315" ><label for="b2p1"><?php echo $rs_qry1->comb2p1; ?></label></td>
    </tr>
    <tr>
      <td>Falta de direccion o supervisión</td>
      <td colspan="2" ><?php if ($rs_qry1->b2p2 == '1')
		  							echo "SI";
									else
		  							  echo "NO";

									  ; ?></td>
      <td><label for="b2p2"><?php echo $rs_qry1->comb2p2; ?></label></td>
    </tr>
    <tr>
      <td>Cantidad y calidad de informacion</td>
      <td colspan="2" ><?php if ($rs_qry1->b2p3 == '1')
		  							echo "SI";
									else
		  							  echo "NO";

									  ; ?></td>
      <td ><label for="b2p3"><?php echo $rs_qry1->comb2p3; ?></label></td>
    </tr>
    <tr>
      <td >Confusión de responsabilidades</td>
      <td colspan="2"  ><?php if ($rs_qry1->b2p4 == '1')
		  							echo "SI";
									else
		  							  echo "NO";

									  ; ?></td>
      <td><label for="b2p4"><?php echo $rs_qry1->comb2p4; ?></label></td>
    </tr>
    <tr>
      <td>Dificultad para coordinar con otras áreas</td>
      <td colspan="2" ><?php if ($rs_qry1->b2p5 == '1')
		  							echo "SI";
									else
		  							  echo "NO";

									  ; ?></td>
      <td><label for="b2p5"><?php echo $rs_qry1->comb2p5; ?></label></td>
    </tr>
    <tr>
      <td>Falta de entrenamiento</td>
      <td colspan="2" ><?php if ($rs_qry1->b2p6 == '1')
		  							echo "SI";
									else
		  							  echo "NO";

									  ; ?></td>
      <td><label for="b2p6"><?php echo $rs_qry1->comb2p6; ?></label></td>
    </tr>
    <tr>
      <td>Demoras en la toma de desiciones</td>
      <td colspan="2" ><?php if ($rs_qry1->b2p7 == '1')
		  							echo "SI";
									else
		  							  echo "NO";

									  ; ?></td>
      <td><label for="b2p7"><?php echo $rs_qry1->comb2p7; ?></label></td>
    </tr>
    <tr>
      <td>Directrices poco claras</td>
      <td colspan="2" ><?php if ($rs_qry1->b2p8 == '1')
		  							echo "SI";
									else
		  							  echo "NO";

									  ; ?></td>
      <td><label for="b2p8"><?php echo $rs_qry1->comb2p8; ?></label></td>
    </tr>
    <tr>
      <td>Otro </td>
      <td colspan="2" ><?php if ($rs_qry1->b2p9 == '1')
		  							echo "SI";
									else
		  							  echo "NO";

									  ; ?></td>
      <td><label for="b2p9"><?php echo $rs_qry1->comb2p9; ?></label></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>Percepcion del Entrevistador sobre el candidato</td>
      <td colspan="3" > <?php echo $rs_qry1->actitud; ?> <?php echo $rs_qry1->colaboracion; ?>
      </td>
    </tr>
    <tr>
      <td  colspan="4" align="justify" valign="middle"></td>
    </tr>
  </table>
  <table width="830" border="0" align="center" style="border-collapse:collapse">
    <tr>
      <td  colspan="4" class="encabezados" >Aspectos positivos de la empresa </td>
      <td><?php echo $rs_qry1->bloque3; ?></td>
    </tr>
    <tr>
      <td  colspan="4"  class="encabezados" >Aspectos a mejorar  y  recomendaciones para la empresa</td>
      <td  class="encabezados" ><?php echo $rs_qry1->bloque4; ?></td>
    </tr>
    <tr>
      <td colspan="5"  align="center" >&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5" align="left" class="encabezados" >Observaciones y comentarios</td>
    </tr>
    <tr>
      <td colspan="5" ><?php echo $rs_qry1->bloque5; ?>
        </td>
    </tr>
    <tr>
      <td height="61"><?php echo utf8_encode($nombreent); ?></td>
      <td>&nbsp;</td>
      <td colspan="3" >&nbsp;</td>
    </tr>
    <tr>
      <td width="301"><p>Nombre de quien realiza la entrevista</p></td>
      <td width="78">&nbsp;</td>
      <td colspan="3" >Firma</td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5">Cargo
       <?php echo utf8_encode($cargoent); ?></td>
    </tr>
    <tr>
      <td>Fecha de la entrevista </td>
      <td>&nbsp;</td>
      <td colspan="3" ><?php echo  ($hoy ); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td  colspan="5" align="justify" valign="middle"></td>
      <td width="77"  colspan="4" align="justify" valign="middle"><input name="imprimir" type="submit" class="botones" id="prn" onclick="imprSelec('validador');" value="imprimir" /></td>
    </tr>
  </table>

  </div>
</form>
