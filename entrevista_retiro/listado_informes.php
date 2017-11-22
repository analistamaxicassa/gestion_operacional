<?php
  $anio = $_REQUEST['anio'];
  if($anio == ''){echo "No existen datos, verifique";}
  $mestodo =  $_REQUEST['mes'];

  switch($mestodo)
  {
  case 'EFM':
  $mes = 'between 0 AND 4';
  break;

  case 'AMJ':
  $mes = 'between 4 AND 7';
  break;

  case 'JAS':
  $mes = 'between 7 AND 10';
  break;

  case 'OND':
  $mes = 'between 9 AND 13';
  break;

  case'1SEMESTRE':
  $mes = '<7';
  break;

  case '2SEMESTRE':
  $mes = '>6';
  break;

  default:
  $mes= substr($mestodo, 0, 2);
  }

  $concepto =  $_REQUEST['concepto'];
  $empresa =   $_REQUEST['empresa'];

  require_once('../conexionesDB/conexion.php');
  $link=Conectarse_personal();
  $link_queryx = Conectarse_queryx();

  if($concepto == 'renuncia')
  {
    $sql1="SELECT SUM(b1p1) as b1p1, SUM(b1p2)as b1p2, SUM(b1p3)as b1p3, SUM(b1p4)as b1p4, SUM(b1p5)as b1p5, SUM(b1p6)as b1p6, SUM(b2p1) as b2p1, SUM(b2p2)as b2p2, SUM(b2p3)as b2p3, SUM(b2p4)as b2p4, SUM(b2p5)as b2p5, SUM(b2p6)as b2p6, SUM(b2p7)as b2p7, SUM(b2p8)as b2p8, SUM(b2p9)as b2p9 FROM entrevista_retiro
    where motivo = 'RENUNCIA' and mes = $mes and anio = $anio and empresa = '$empresa'";
    //echo "RENUNCIA".$sql1."<br>";
    $qry_sql1=$link->query($sql1);
    $rs_qry1=$qry_sql1->fetch_object();  //consultar
  }
  else
  {
    $sql1="SELECT SUM(b1p1) as b1p1, SUM(b1p2)as b1p2, SUM(b1p3)as b1p3, SUM(b1p4)as b1p4, SUM(b1p5)as b1p5, SUM(b1p6)as b1p6, SUM(b2p1) as b2p1, SUM(b2p2)as b2p2, SUM(b2p3)as b2p3, SUM(b2p4)as b2p4, SUM(b2p5)as b2p5, SUM(b2p6)as b2p6, SUM(b2p7)as b2p7, SUM(b2p8)as b2p8, SUM(b2p9)as b2p9
    FROM entrevista_retiro where mes = $mes and anio = $anio and empresa = '$empresa'";
    //echo $sql1."<br>";
    $qry_sql1=$link->query($sql1);
    $rs_qry1=$qry_sql1->fetch_object();  //consultar
	}
  if (false)
  {
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
  }
  $i=0;
	//conexion sql

  $sql="SELECT DISTINCT(motivo), COUNT(motivo) AS qmotivo FROM entrevista_retiro
  WHERE mes = '$mes' AND anio = '$anio' AND empresa = '$empresa' GROUP BY motivo ORDER BY qmotivo DESC";
  echo "<br>".$sql;
  $qry_sql=$link->query($sql);
  $rs_qry=$qry_sql->fetch_object();  ///consultar

  if (empty($rs_qry))
  {
    echo 'No existen registros para mostrar';
    //$datelimite = 0;
    exit;
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>

<style type='text/css'>
tr:nth-child(odd) {
    background-color:#f2f2f2;
}
tr:nth-child(even) {
	background-color: #fbfbfb;


}


</style>


<script>
    function graficarinf(numero)
{

		if (numero == 1)
		{
			 var mes = document.getElementById('mesxx').value;

			window.open('graficoa.php?mes='+mes+'', "Graficador", "width=700, height=400")
		}
		if (numero == 2)
		{
			window.open('graficob.php?mes='+mes+'', "Graficador", "width=750, 			height=550")
		}
		if (numero == 3)
			{
				window.open('graficoc.php?mes='+mes+'', "Graficador", "width=750, 			height=550")
			}
		if (numero == 4)
		{   var mes = document.getElementById('mesxx').value;
			window.open('graficod.php?mes='+mes+'', "Graficador", "width=750, 			height=550")
		}
		if (numero == 5)
		{   var mes = document.getElementById('mesxx').value;
			window.open('graficoe.php?mes='+mes+'', "Graficador", "width=750, 			height=550")
		}
		if (numero == 6)
		{   var mes = document.getElementById('mesxx').value;
			window.open('graficof.php?mes='+mes+'', "Graficador", "width=750, 			height=550")
		}
		if (numero == 7)
		{   var mes = document.getElementById('mesxx').value;
			window.open('graficog.php?mes='+mes+'', "Graficador", "width=750, 			height=550")
		}
else {}	;
}
        </script>




<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>informes de Entrevistas de retiro</title>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="../estilos.css"/>
</head>

<body>

<div id="validador">
<h2 class="encabezados">INFORME  DE ENTREVISTAS DE RETIRADO
</h2>
<blockquote>
  <blockquote>
    <blockquote>
      <blockquote>
        <blockquote>
          <blockquote>
            <blockquote>
              <blockquote>
                <blockquote>
                  <blockquote>
                    <blockquote>
                      <p>
                        Mes de:  <?php echo substr($mestodo, 3);?>

                        <input name="mesxx" type="text" id="mesxx" size="15" value=" <?php echo $mes; ?>" style="visibility:hidden;" />

                      </p>
                    </blockquote>
                  </blockquote>
                </blockquote>
              </blockquote>
            </blockquote>
          </blockquote>
        </blockquote>
      </blockquote>
    </blockquote>
  </blockquote>
  <p align="center">	Cantidad de entrevistados:
<?php
  $sql0="SELECT COUNT(cedula_retirado) AS qentrevistado FROM entrevista_retiro WHERE mes = '$mes'  and anio = '$anio' and empresa = '$empresa'";
  $qry_sql0=$link->query($sql0);
  $rs_qry0=$qry_sql0->fetch_object();  //consultar

  echo $rs_qry0->qentrevistado;
 ?>
  </p>
</blockquote>
<table width="60%" align="center"  border="1">
  <tr>
    <th class="encabezados" scope="row">MOTIVOS DE RETIRO</th>


	 <?php

	 if ($concepto == 'renuncia')
	 {
 $sql="SELECT DISTINCT(motivo), COUNT(motivo) AS qmotivo FROM entrevista_retiro WHERE mes = '$mes' and motivo = '$concepto' and empresa = '$empresa'";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  //consultar
	 }
	 else
	 {
$sql="SELECT DISTINCT(motivo), COUNT(motivo) AS qmotivo FROM entrevista_retiro WHERE mes = '$mes' and empresa = '$empresa' GROUP BY motivo ORDER BY qmotivo DESC";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  //consultar

		 }



	if (empty($rs_qry)) {
   						 echo 'No existen registros para mostrar';
							//$datelimite = 0;
							exit;
								}
?>

 <th class="encabezados" scope="row"><input type="button" name="grafica1" id="grafica1" onclick="graficarinf(1)" value="Graficar" /></th>
  </tr>
 <?php
	do{
?>



  <tr  align="left">
    <th width="82%" scope="row"> <?php echo $rs_qry->motivo; ?></th>
    <td width="18%"><?php echo $rs_qry->qmotivo; ?></td>
  </tr>

  <?php
}
while($rs_qry=$qry_sql->fetch_object());
?>
</table>

<table width="60%"   align="center" border="1">
  <tr>
    <th colspan="2" scope="row" align="left">El siguiente enunciado solo aplica a Renuncia</th>
  </tr>
  <tr>
    <th class="encabezados" scope="row"><p>QUE INFLUENCIA TUVIERON LOS SIGUIENTES ASPECTOS EN SU  DESICION DE RETIRO?</p>
        </th>
    <th class="encabezados" scope="row" ><p>
      <input  type="button" name="grafica2" id="grafica2" value="Graficar" onclick="graficarinf(2)" />
    </p></th>
  </tr>

  <?php
 $sql1="SELECT `DESCRIPCION`, `RESPUESTAB1` FROM `resultado_encuesta` where `PREGUNTAB1` like 'b1%' ORDER BY `RESPUESTAB1` DESC ";
			$qry_sql1=$link->query($sql1);
			$rs_qry1=$qry_sql1->fetch_object();  ///consultar


	if (empty($rs_qry1)) {
   						 echo 'No existen registros para mostrar';
							//$datelimite = 0;
							exit;
								}
	do{
?>



  <tr  align="left">
    <th width="82%" scope="row"> <?php echo utf8_encode($rs_qry1->DESCRIPCION); ?></th>
    <td width="18%"><?php echo $rs_qry1->RESPUESTAB1; ?></td>
  </tr>

  <?php
}
while($rs_qry1=$qry_sql1->fetch_object());
?>
</table>
<p>&nbsp;</p>
  <table width="60%"   align="center" border="1">
  <tr>
    <th class="encabezados" scope="row"><p>EN EL TIEMPO LABORADO EN LA EMPRESA INFLUYERON EN SU  PRODUCTIVIDAD LOS SIGUIENTES FACTORES?</p></th>
    <th class="encabezados" scope="row"><input type="button" name="grafica3" id="grafica3" value="Graficar" onclick="graficarinf(3)" /></th>
  </tr>
<?php
  $sql2="SELECT `DESCRIPCION`, `RESPUESTAB1` FROM `resultado_encuesta` where `PREGUNTAB1` like 'b2%' ORDER BY `RESPUESTAB1` DESC ";
	$qry_sql2=$link->query($sql2);
	$rs_qry2=$qry_sql2->fetch_object();  ///consultar

	if (empty($rs_qry2))
  {
    echo 'No existen registros para mostrar';
    //$datelimite = 0;
    exit;
	}
	do{
?>



  <tr  align="left">
    <th width="82%" scope="row"> <?php echo utf8_encode($rs_qry2->DESCRIPCION); ?></th>
    <td width="18%"><?php echo $rs_qry2->RESPUESTAB1; ?></td>
  </tr>

  <?php
}
while($rs_qry2=$qry_sql2->fetch_object());
?>
</table>

<p>&nbsp;</p>

<table width="60%" align="center"  border="1">
    <tr>
      <th class="encabezados" scope="row">ASPECTOS POSITIVOS DE LA EMPRESA</th>
      <th class="encabezados" scope="row"><input type="button" name="grafica4" id="grafica4" value="Todos" onclick="graficarinf(4)"  />
      <input type="submit" name="grafica6" id="grafica6" value="Renuncia" onclick="graficarinf(6)"  /></th>
    </tr>
    <?php

	if ($concepto == 'renuncia')
{

$sql11="SELECT bloque3, count(bloque3) qbloque3 FROM entrevista_retiro WHERE mes $mes and motivo = '$concepto' and empresa = '$empresa' group by bloque3 order by count(bloque3) desc ";
			$qry_sql11=$link->query($sql11);
			$rs_qry11=$qry_sql11->fetch_object();  ///consultar
}
else
{
 $sql11="SELECT bloque3, count(bloque3) qbloque3 FROM entrevista_retiro WHERE mes $mes and empresa = '$empresa' group by bloque3 order by count(bloque3) desc ";
			$qry_sql11=$link->query($sql11);
			$rs_qry11=$qry_sql11->fetch_object();  ///consultar
	}


  if (empty($rs_qry11)) {
    echo 'No existen registros para mostrar';
    //$datelimite = 0;
    exit;
	}
	do{
?>
    <tr  align="left">
      <th width="82%" scope="row"> <?php echo $rs_qry11->bloque3; ?></th>
      <td width="18%"><?php echo $rs_qry11->qbloque3; ?></td>
    </tr>
<?php
    }while($rs_qry11=$qry_sql11->fetch_object());
?>
  </table>
  <p>&nbsp;</p>

  <table width="60%" align="center"  border="1">
    <tr>
      <th class="encabezados" scope="row">ASPECTOS A MEJORAR</th>
      <th class="encabezados" scope="row"><input type="button" name="grafica5" id="grafica5" value="Todos" onclick="graficarinf(5)"  />
      <input type="submit" name="grafica7" id="grafica7" value="Renuncia" onclick="graficarinf(7)"  /></th>
    </tr>
<?php
  if ($concepto == 'renuncia')
  {
    $sql12="SELECT `bloque4`, count(bloque4) qbloque4 FROM `entrevista_retiro` WHERE mes $mes and motivo = '$concepto' and empresa = '$empresa' group by bloque4 order by count(bloque4) desc ";
    $qry_sql12=$link->query($sql12);
    $rs_qry12=$qry_sql12->fetch_object();  ///consultar
  }
  else
  {
    $sql12="SELECT `bloque4`, count(bloque4) qbloque4 FROM `entrevista_retiro` WHERE `mes` $mes and empresa = '$empresa' group by bloque4 order by count(bloque4) desc ";
    $qry_sql12=$link->query($sql12);
    $rs_qry12=$qry_sql12->fetch_object();  ///consultar
  }

  if (empty($rs_qry12)) {
    echo 'No existen registros para mostrar';
    //$datelimite = 0;
    exit;
	}
	do{
?>
  <tr  align="left">
    <th width="82%" scope="row"> <?php echo $rs_qry12->bloque4; ?></th>
    <td width="18%"><?php echo $rs_qry12->qbloque4; ?></td>
  </tr>
<?php
    }while($rs_qry12=$qry_sql12->fetch_object());
?>
  </table>

  <p>&nbsp;</p>
  <table width="80%"   align="center" border="1">
  <tr>
    <th colspan="4" class="encabezados" scope="row"><p>OBSERVACIONES FINALES DEL ENTREVISTADOR</p></th>
  </tr>
<?php
  // Informe de aspectos a mejorar
  if ($concepto == 'renuncia')
  {
    $sql13="SELECT `cargo_retirado`, `nombrecc`, `motivo`, `bloque5` FROM `entrevista_retiro`  WHERE `mes` $mes and motivo = '$concepto' and empresa = '$empresa' order by nombrecc ";
    $qry_sql13=$link->query($sql13);
    $rs_qry13=$qry_sql13->fetch_object();  //consultar
  }
  else
  {
    $sql13="SELECT `cargo_retirado`, `nombrecc`, `motivo`, `bloque5` FROM `entrevista_retiro`  WHERE mes $mes and empresa = '$empresa' order by nombrecc ";
    $qry_sql13=$link->query($sql13);
    $rs_qry13=$qry_sql13->fetch_object();  //consultar
  }

	if (empty($rs_qry13)) {
    echo 'No existen registros para mostrar';
    //$datelimite = 0;
    exit;
	}
	do{
?>
  <tr  align="left">
    <th width="15%" scope="row"> <?php echo $rs_qry13->nombrecc; ?></th>
	<td width="18%"><?php echo $rs_qry13->cargo_retirado; ?></td>
    <td width="22%"><?php echo $rs_qry13->motivo; ?></td>
    <td width="45%"><?php echo $rs_qry13->bloque5; ?></td>
  </tr>
<?php
    }while($rs_qry13=$qry_sql13->fetch_object());
?>
</table>

  <p>&nbsp;</p>
  <table  align="center" width="70%" border="1">
    <tr>
      <th bgcolor="#666666"  scope="col">INFORMACION GENERAL</th>
    </tr>
  </table>
  <p>&nbsp;</p>

  <table width="35%" align="center"  border="1">
  <tr>
    <th colspan="2" class="encabezados" scope="row">RETIROS POR EMPRESA</th>
  </tr>
	 <?php
  // consulta queryx
  $query4="SELECT SO.NOMBRE_SOCIEDAD, COUNT(SO.NOMBRE_SOCIEDAD) QCARGO FROM EMPLEADO EMP,  sociedad so
  WHERE EMP.EMP_SOCIEDAD = SO.COD_SOCIEDAD and EMP.EMP_ESTADO = 'R' AND TO_CHAR(EMP.EMP_FECHA_RETIRO,'MM') $mes
  AND TO_CHAR(EMP.EMP_FECHA_RETIRO,'YYYY') = TO_CHAR(sysdate,'YYYY') AND EMP.EMP_CARGO not in ('112','133') and
  GROUP BY SO.NOMBRE_SOCIEDAD, EMP.EMP_SOCIEDAD ORDER BY EMP.EMP_SOCIEDAD";

  $stid = oci_parse($link_queryx, $query4);
  oci_execute($stid);
  $rowx4 = oci_fetch_object($stid);

if ($rowx4 == false)
  {
    echo 'No existen registros para mostrar';
    //$datelimite = 0;
    exit;
  }
	do{
?>
  <tr  align="left">
   	<th width="30%" scope="row"> <?php echo $rowx4->NOMBRE_SOCIEDAD; ?></th>
    <td width="33%" align="center"><?php echo $rowx4->QCARGO; ?></td>
  </tr>
<?php
    }while($rowx4 = oci_fetch_object($stid) != false);
    oci_free_statement($stid);
?>
  </table>
  <p>&nbsp;</p>

  <table width="35%" align="center"  border="1">
    <tr>
      <th colspan="2" class="encabezados" scope="row">RETIROS POR EMPRESA MOTIVO RENUNCIA</th>
    </tr>
<?php
  // CONSULTA DE RENUNCIADOS
  $query14="SELECT empresa, COUNT(motivo) qmotivor FROM `entrevista_retiro` WHERE `motivo` = 'RENUNCIA' and mes  $mes and empresa = $empresa GROUP BY EMPRESA";
  $qry_sql14=$link->query($query14);
  $rs_qry14=$qry_sql14->fetch_object();  ///consultar

	if (empty($rs_qry14)) {
    echo 'No existen registros para mostrar';
    exit;
	}
	do{
?>
  <tr  align="left">
   	<th width="30%" scope="row"> <?php echo $rs_qry14->empresa; ?></th>
    <td width="33%" align="center"><?php echo $rs_qry14->qmotivor; ?></td>
  </tr>
<?php
    }while($rs_qry14=$qry_sql14->fetch_object());
?>
</table>
<p>&nbsp;</p>
<table width="70%" align="center"  border="1">
  <tr>
    <th colspan="3" class="encabezados" scope="row">RETIROS POR CARGOS</th>
  </tr>
<?php

// consulta queryx
  $query3="SELECT SO.NOMBRE_SOCIEDAD, CA.CARGO_NOMBRE,  COUNT(CA.CARGO_NOMBRE) QCARGO
  FROM EMPLEADO EMP, CARGO CA, sociedad so
  WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO AND EMP.EMP_SOCIEDAD = SO.COD_SOCIEDAD and
  EMP.EMP_ESTADO = 'R' AND TO_CHAR(EMP.EMP_FECHA_RETIRO,'MM') $mes AND TO_CHAR(EMP.EMP_FECHA_RETIRO,'YYYY') = TO_CHAR(sysdate,'YYYY')
  AND EMP.EMP_CARGO not in ('112','133')
  GROUP BY SO.NOMBRE_SOCIEDAD, CA.CARGO_NOMBRE, EMP.EMP_SOCIEDAD
  ORDER BY  EMP.EMP_SOCIEDAD, QCARGO DESC";
  $stmt3 = oci_parse($link_queryx, $query3);
  oci_execute($stmt3);
  $rowx3 = oci_fetch_object($stmt3);

	if ($rowx3 == false) {
    echo 'No existen registros para mostrar';
    //$datelimite = 0;
    exit;
	}
	do{
?>
  <tr  align="left">
   	<th width="30%" scope="row"> <?php echo $rowx3['NOMBRE_SOCIEDAD']; ?></th>
    <th width="37%" scope="row"> <?php echo $rowx3['CARGO_NOMBRE']; ?></th>
    <td width="33%"><?php echo $rowx3['QCARGO']; ?></td>
  </tr>
<?php
}while($rowx3 = oci_fetch_object($stmt3) != false);
oci_free_statement($stmt3);
?>
</table>
<p>&nbsp;</p>
  <table width="70%" align="center"  border="1">
  <tr>
    <th colspan="3" class="encabezados" scope="row">RETIROS DE CARGOS POR SALA</th>
  </tr>
<?php
  $query15="SELECT REGEXP_SUBSTR(CC.CENCOS_NOMBRE,'[^-]+',1,2) CCNOMBRE,  CA.CARGO_NOMBRE, COUNT(SO.NOMBRE_SOCIEDAD) QCARGO
  FROM EMPLEADO EMP,  sociedad so, centro_costo cc,  CARGO CA
  WHERE EMP.EMP_SOCIEDAD = SO.COD_SOCIEDAD and EMP.EMP_CC_CONTABLE = CC.CENCOS_CODIGO and  EMP.EMP_CARGO = CA.CARGO_CODIGO
  and EMP.EMP_ESTADO = 'R' AND TO_CHAR(EMP.EMP_FECHA_RETIRO,'MM') $mes
  AND TO_CHAR(EMP.EMP_FECHA_RETIRO,'YYYY') = TO_CHAR(sysdate,'YYYY') AND EMP.EMP_CARGO not in ('112','133') and EMP.EMP_SOCIEDAD = '10'
  GROUP BY REGEXP_SUBSTR(CC.CENCOS_NOMBRE,'[^-]+',1,2),  CA.CARGO_NOMBRE, EMP.EMP_SOCIEDAD
  ORDER BY REGEXP_SUBSTR(CC.CENCOS_NOMBRE,'[^-]+',1,2), CA.CARGO_NOMBRE";
  $stmt15 = oci_parse($link_queryx, $query15);
	oci_execute($stmt15);
	$rowx15 = oci_fetch_object($stmt15);

	if ($rowx15 == false) {
    echo 'No existen registros ppara mostrar';
    //$datelimite = 0;
    exit;
	}
	do{
?>
  <tr  align="left">
    <th width="24%" scope="row"> <?php echo $rowx15->CCNOMBRE; ?></th>
    <th width="38%" scope="row"> <?php echo $rowx15->CARGO_NOMBRE; ?></th>
    <th width="38%" scope="row"> <?php echo $rowx15->QCARGO; ?></th>
  </tr>
<?php
    }while($rowx15 = oci_fetch_object($stmt15) != false);
  oci_free_statement($stmt15);
  oci_close($link_queryx);
?>
</table>
<p>&nbsp;</p>
</p>
</body>
</html>
