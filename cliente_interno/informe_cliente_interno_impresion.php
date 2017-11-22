
<?php
error_reporting(0);
 $sala = $_REQUEST['sala'];

require_once('../PAZYSALVO/conexion_ares.php');
$link=Conectarse();


//llenar la tabla temporal



	//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}


		// vacia la tabla temporal

			$sql20="DELETE FROM cliente_interno_queryx";
			$qry_sql20=$link->query($sql20);
			//$rs_qry20=$qry_sql20->fetch_object();  ///consultar


// consultar codigo sala
$sqlb2="SELECT `ci_print`, tipo_sala, nombre, localidad FROM `salas` WHERE `cc` = '$sala'";
			$qry_sqlb2=$link->query($sqlb2);
			$rs_qryb2=$qry_sqlb2->fetch_object();  ///consultar

			$salaok = $rs_qryb2->ci_print;
			$tipo_sala = $rs_qryb2->tipo_sala;
			$nombre_sala = $rs_qryb2->nombre;
			$localidad_sala = $rs_qryb2->localidad;






//consulta PERSONAL DE SALA

 $queryA="SELECT EM.EMP_CODIGO CEDULA FROM EMPLEADO EM
WHERE EM.EMP_CC_CONTABLE LIKE '$salaok%' AND EM.EMP_ESTADO <> 'R' ORDER BY EM.EMP_CODIGO
";
		$stmtA = $dbh->prepare($queryA);
		$stmtA->execute();
		$rowA = $stmtA->fetch();

do{
	//echo "<br>";
	 $cedula=$rowA['CEDULA'];
//consulta en cliente interno
//	echo "<br>";
$sql2="SELECT cedula FROM `cliente_interno` WHERE cedula = '$cedula'";
			$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar

			//echo "<br>";


// consulta en queryx y llenado en mysql tabla cliente interno queryx
	//echo "<br>";
$queryX = "SELECT EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE
,EMP.EMP_ESTADO_CIVIL ECIVIL, CA.CARGO_NOMBRE, TO_CHAR((SYSDATE - EMP_FECHA_INGRESO)/30,9999)/12 ANTIGUEDAD, EMP.EMP_TIPO_CONTRATO TIPO_CONTRATO
, CASE WHEN TO_CHAR((SYSDATE - EMP_FECHA_INGRESO)/30,9999)/12 < 2 THEN CF.COF_VALOR ELSE (SUM(AC.ACUM_VALOR_LOCAL))/2 END AS PROMEDIO, CC.CENCOS_NOMBRE CC
FROM EMPLEADO EMP,TRH_ACUMULADO AC,CARGO CA, CONCEPTOS CO, conceptos_fijos cf, centro_costo cc
WHERE EMP.EMP_ESTADO <> 'R'  AND EMP.EMP_CODIGO = '$cedula' and EMP.EMP_CARGO = CA.CARGO_CODIGO  AND EMP.EMP_CODIGO = AC.EMP_CODIGO  AND
AC.ACUM_FECHA_PAGO > SYSDATE - 60  AND AC.CON_CODIGO = CO.CON_CODIGO AND
CO.CON_NATU = 'DEV' AND EMP.EMP_ESTADO <> 'R'  AND EMP.EMP_CODIGO = '$cedula' AND AC.CON_CODIGO <> '130'
and CF.EMP_CODIGO = EMP.EMP_CODIGO and CC.CENCOS_CODIGO = EMP.EMP_CC_CONTABLE
GROUP BY EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2, EMP.EMP_ESTADO_CIVIL,  CA.CARGO_NOMBRE, TO_CHAR((SYSDATE - EMP_FECHA_INGRESO)/30,9999)/12, EMP.EMP_TIPO_CONTRATO,  CF.COF_VALOR, CC.CENCOS_NOMBRE" ;

		$stmtX = $dbh->prepare($queryX);
		$stmtX->execute();
		$rowX = $stmtX->fetch();

		$nombreemp=$rowX['NOMBRE'];
		$ecivil=$rowX['ECIVIL'];
		$cargonombre=$rowX['CARGO_NOMBRE'];
		$ant=$rowX['ANTIGUEDAD'];
		$tcontrato=$rowX['TIPO_CONTRATO'];
		$promediosalario=$rowX['PROMEDIO'];
		$centrocostos=$rowX['CC'];


 $sqla2="SELECT group_concat(`nombre_hijo`, `f_nacimiento`) `hijos` FROM personal.hijos WHERE `cod_empleado` like '%$cedula%' GROUP BY `cod_empleado`";
//echo "<br>";
//seleccionan los campos
$qrya2=$link->query($sqla2);
$rsa2=$qrya2->fetch_object();
//$total_registros=$qry->num_rows;
if  (empty($rsa2->hijos))
		{
			$hijos="0";
		}

		$hijos = $rsa2->hijos;


 $sql3="INSERT INTO `personal`.`cliente_interno_queryx` (`cedulaq`, `nombreq`, `estado_civil`, `cargo`, `antiguedad`, `tipo_contrato`, `promedio`, `ccq`, `hijos`) VALUES ('$cedula', '$nombreemp', '$ecivil', '$cargonombre', '$ant', '$tcontrato', '$promediosalario', '$centrocostos', '$hijos');";
$qry_sql3=$link->query($sql3);

//	echo "<br>";


	}
	while($rowA = $stmtA->fetch())

	?>

    <?php

//	echo "<br>";
 $sql="SELECT ee.id, cedulaq, nombreq, estado_civil, cargo, antiguedad, tipo_contrato, promedio, ccq, educacion, hijos, motivacion, proyeccion, ayudas, evaluador, fecha_evaluacion, evaluacion, fortalezas, debilidades, recomendaciones, ap_conocimientos, ap_estudios, ap_presentacion, ac_horarios, ac_colaboracion, proyeccion_laboral, observacion
	  FROM cliente_interno ci inner join cliente_interno_queryx ciq on ci.cedula = ciq.cedulaq left join evaluacion_empleado ee on ciq.cedulaq = ee.cedula
		order by id ";
	 // 	echo "<br>";
			$qry=$link->query($sql);
			$rs=$qry->fetch_object();






	 ?>


       <?php

//consulta PERSONAL DE SALA ROTATIVOS

$queryB="SELECT EM.EMP_CODIGO CEDULA1 FROM EMPLEADO EM WHERE EM.EMP_LOCALIDAD = '$localidad_sala' AND EM.EMP_ESTADO <> 'R' and EM.EMP_CC_CONTABLE like '%-099-0202%'  ORDER BY EM.EMP_CODIGO
";
		$stmtB = $dbh->prepare($queryB);
		$stmtB->execute();
		$rowB = $stmtB->fetch();

do{
	//echo "<br>";
	 $cedulaB=$rowB['CEDULA1'];
//consulta en cliente interno
//	echo "<br>";
$sqlB="SELECT cedula FROM `cliente_interno` WHERE cedula = '$cedulaB'";
			$qry_sqlB=$link->query($sqlB);
			$rs_qryB=$qry_sqlB->fetch_object();  ///consultar

			//echo "<br>";


// consulta en queryx y llenado en mysql tabla cliente interno queryx
	//echo "<br>";
$queryC = "SELECT EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE
,EMP.EMP_ESTADO_CIVIL ECIVIL, CA.CARGO_NOMBRE, TO_CHAR((SYSDATE - EMP_FECHA_INGRESO)/30,9999)/12 ANTIGUEDAD, EMP.EMP_TIPO_CONTRATO TIPO_CONTRATO
, CASE WHEN TO_CHAR((SYSDATE - EMP_FECHA_INGRESO)/30,9999)/12 < 2 THEN CF.COF_VALOR ELSE (SUM(AC.ACUM_VALOR_LOCAL))/2 END AS PROMEDIO, CC.CENCOS_NOMBRE CC
FROM EMPLEADO EMP,TRH_ACUMULADO AC,CARGO CA, CONCEPTOS CO, conceptos_fijos cf, centro_costo cc
WHERE EMP.EMP_ESTADO <> 'R'  AND EMP.EMP_CODIGO = '$cedulaB' and EMP.EMP_CARGO = CA.CARGO_CODIGO  AND EMP.EMP_CODIGO = AC.EMP_CODIGO  AND
AC.ACUM_FECHA_PAGO > SYSDATE - 60  AND AC.CON_CODIGO = CO.CON_CODIGO AND
CO.CON_NATU = 'DEV' AND EMP.EMP_ESTADO <> 'R'  AND EMP.EMP_CODIGO = '$cedulaB' AND AC.CON_CODIGO <> '130'
and CF.EMP_CODIGO = EMP.EMP_CODIGO and CC.CENCOS_CODIGO = EMP.EMP_CC_CONTABLE
GROUP BY EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2, EMP.EMP_ESTADO_CIVIL,  CA.CARGO_NOMBRE, TO_CHAR((SYSDATE - EMP_FECHA_INGRESO)/30,9999)/12, EMP.EMP_TIPO_CONTRATO,  CF.COF_VALOR, CC.CENCOS_NOMBRE" ;

		$stmtC = $dbh->prepare($queryC);
		$stmtC->execute();
		$rowC = $stmtC->fetch();

		$nombreemp1=$rowC['NOMBRE'];
		$ecivil1=$rowC['ECIVIL'];
		$cargonombre1=$rowC['CARGO_NOMBRE'];
		$ant1=$rowC['ANTIGUEDAD'];
		$tcontrato1=$rowC['TIPO_CONTRATO'];
		$promediosalario1=$rowC['PROMEDIO'];
		$centrocostos1=$rowC['CC'];


 $sqlaD="SELECT group_concat(`nombre_hijo`, `f_nacimiento`) `hijos` FROM personal.hijos WHERE `cod_empleado` like '%$cedulaB%' GROUP BY `cod_empleado`";
//echo "<br>";
//seleccionan los campos
$qryaD=$link->query($sqlaD);
$rsaD=$qryaD->fetch_object();
//$total_registros=$qry->num_rows;
if  (empty($rsaD->hijos))
		{
			$hijos1="0";
		}

		$hijos1 = $rsaD->hijos;

$sqlE="INSERT INTO `personal`.`cliente_interno_queryx` (`cedulaq`, `nombreq`, `estado_civil`, `cargo`, `antiguedad`, `tipo_contrato`, `promedio`, `ccq`, `hijos`) VALUES ('$cedulaB', '$nombreemp1', '$ecivil1', '$cargonombre1', '$ant1', '$tcontrato1', '$promediosalario1', '$centrocostos1', '$hijos1');";
$qry_sqlE=$link->query($sqlE);

	//echo "<br>";


	}
	while($rowB = $stmtB->fetch())

	?>

    <?php

//	echo "<br>";
$sqlF="SELECT ee.id, cedulaq, nombreq, estado_civil, cargo, antiguedad, tipo_contrato, promedio, ccq, educacion, hijos, motivacion, proyeccion, ayudas, evaluador, fecha_evaluacion, evaluacion, fortalezas, debilidades, recomendaciones, ap_conocimientos, ap_estudios, ap_presentacion, ac_horarios, ac_colaboracion, proyeccion_laboral, observacion
	  FROM cliente_interno ci inner join cliente_interno_queryx ciq on ci.cedula = ciq.cedulaq left join evaluacion_empleado
	   ee on ciq.cedulaq = ee.cedula
		order by id ";
	  //	echo "<br>";
			$qryF=$link->query($sqlF);
			$rsF=$qryF->fetch_object();






	 ?>




<!doctype html>
<html lang="en">
<head>


<style type='text/css'>
tr:nth-child(odd) {
    background-color:#f2f2f2;
}
tr:nth-child(even) {
    background-color:#fbfbfb;
}
</style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CLIENTE INTERNO</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="../estilos.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
	  <script>
		 function consultarhist_empleado(cedula, sala)
		 {
				var parametros = {
				"cedula": cedula,
				"sala": sala,
				};
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/cliente_interno/informe_hist_empleado.php',
                type: 'post',
                   beforeSend: function ()
                   {
                        $("#respuestahist_evaluacion").html("Validando, espere por favor...");
                    },

                    success: function (response)
                    {
                        $("#respuestahist_evaluacion").html(response);
					//document.getElementById('tbl_ppal').style.display="none"
                    }


        });
        }

		  </script>



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
</head>
<body>>



  <table width="200" border="1" style="font-size:12px">
     <tr>
       <td>SALA</td>
       <td colspan="6"  style="font-size:16px"><?php echo $nombre_sala; ?></td>
       <td  style="font-size:16px">Tipo Sala:</td>
       <td colspan="16"  style="font-size:16px"><?php echo $tipo_sala ; ?></td>
     </tr>
     <tr style="background:#CCC">
       <td>NOMBRE</td>
       <td>CARGO</td>
       <td>TIEMPO</td>
       <td>T. CONTRATO</td>
       <td>EDUCACION</td>
       <td>ESTADO CIVIL</td>
       <td>HIJOS Y EDADES</td>
       <td>MOTIVACION</td>
       <td>PROYECCIONES</td>
       <td>AYUDAS RECIBIDAS</td>
       <td>DEVENGADO PROMEDIO</td>
       <td>QUIEN EVALUA</td>
       <td>FECHA ULT EVALUACION</td>
       <td>EVALUACION</td>
       <td>FORTALEZAS</td>
       <td>DEBILIDADES</td>
       <td>RECOMENDACINES</td>
       <td>CONOCIMIENTO DE PRODUCTO</td>
       <td>ESTUDIOS</td>
       <td>PRESENTACION</td>
       <td>HORARIOS</td>
       <td>COLABORACION</td>
       <td>PROYECCION LABORAL</td>
       <td>OBSERVACION</td>
     </tr>

     <?php

	//echo "<br>";



do{


	if (empty($rs)) {

					 $nombreq = "";
					 $estado_civil = "";
					 $cargo = "";
					 $antiguedad = "";
					 $tipo_contrato = "";
					 $promedio = "";
					 $educacion = "";
					 $motivacion = "";
					 $proyeccion = "";
					 $ayudas = "";
					 $evaluador = "";
					 $fecha_evaluacion = "";
					 $evaluacion = "";
					 $fortalezas = "";
					 $debilidades = "";
					 $recomendaciones = "";
					 $ap_conocimientos = "";
					 $ap_estudios = "";
					 $ap_presentacion = "";
					 $ac_horarios = "";
					 $ac_colaboracion = "";
					 $proyeccion_laboral = "";
					 $observacion = "";
					  $hijos = "";


					}

		else {
			     	$nombreq = $rs->nombreq;
					 $estado_civil = $rs->estado_civil;
					 $cargo = $rs->cargo;
					 $antiguedad = $rs->antiguedad;
					 $tipo_contrato = $rs->tipo_contrato;
					 $promedio = $rs->promedio;
					 $educacion = $rs->educacion;
					 $motivacion = $rs->motivacion;
					 $proyeccion = $rs->proyeccion;
					 $ayudas = $rs->ayudas;
					 $evaluador = $rs->evaluador;
					 $fecha_evaluacion = $rs->fecha_evaluacion;
					 $evaluacion = $rs->evaluacion;
					 $fortalezas = $rs->fortalezas;
					 $debilidades = $rs->debilidades;
					 $recomendaciones = $rs->recomendaciones;
					 $ap_conocimientos = $rs->ap_conocimientos;
					 $ap_estudios = $rs->ap_estudios;
					 $ap_presentacion = $rs->ap_presentacion;
					 $ac_horarios = $rs-> ac_horarios;
					 $ac_colaboracion = $rs->ac_colaboracion;
					 $proyeccion_laboral = $rs->proyeccion_laboral;
					 $observacion = $rs-> observacion;
					 $hijos = $rs-> hijos;


					}



	 ?>

<tr>
    </td>
</tr>




     <tr>
       <td><?php echo utf8_encode($nombreq); ?></td>
       <td><?php echo utf8_encode($cargo); ?></td>
       <td><?php echo substr($antiguedad,0,2); ?>Años</td>
       <td><?php if ($tipo_contrato == 1)
	  		  $contrato = "Termino indefinido";
		  if ($tipo_contrato == 2)
		    $contrato = "Termino fijo";
		  if ($tipo_contrato == 4)
		   $contrato = "Aprendiz";

	  echo utf8_encode($contrato); ?></td>
       <td><?php echo utf8_encode($educacion); ?></td>
       <td><?php if ($estado_civil == 'SOL')
	  		  $estado_civil = "SOLTERO";
		  if ($estado_civil == 'CAS')
		    $estado_civil = "CASADO";
		  if ($estado_civil == 'DIV')
		    $estado_civil = "DIVERCIADO";
		  if ($estado_civil == 'SEP')
		    $estado_civil = "SEPARADO";
		  if ($estado_civil == 'ND')
		    $estado_civil = "NO DEFINIDO";
		  if ($estado_civil == 'UNI')
		   $estado_civil = "UNION LIBRE";
	  echo utf8_encode($estado_civil); ?></td>
       <td><?php echo $hijos; ?></td>
       <td><?php echo utf8_encode($motivacion); ?></td>
       <td><?php echo utf8_encode($proyeccion); ?></td>
       <td><?php echo utf8_encode($ayudas); ?></td>
       <td><?php echo "$".number_format($promedio, 0, ',', '.'); ?></td>
       <td><?php echo utf8_encode($evaluador); ?></td>
       <td><?php echo $fecha_evaluacion; ?></td>
       <td><?php echo $evaluacion; ?></td>
       <td><?php echo utf8_encode($fortalezas); ?></td>
       <td><?php echo utf8_encode($debilidades); ?></td>
       <td><?php echo utf8_encode($recomendaciones); ?></td>
       <td><?php echo $ap_conocimientos; ?></td>
       <td><?php echo $ap_estudios; ?></td>
       <td><?php echo $ap_presentacion; ?></td>
       <td><?php echo $ac_horarios; ?></td>
       <td><?php echo $ac_colaboracion; ?></td>
       <td><?php echo utf8_encode($proyeccion_laboral); ?></td>
       <td><?php echo utf8_encode($observacion); ?></td>
     </tr>





    <?php
}
	while($rs=$qry->fetch_object())

	 ?>

</table>



<!-- AQUI INICIA TEMPORALES -->
  <table width="200" border="1" style="font-size:12px">
     <tr>
       <td class="subtitulos">ROTATIVOS DE CIUDAD</td>
    </tr>
     <tr style="background:#CCC">
       <td>NOMBRE</td>
       <td>CARGO</td>
       <td>TIEMPO</td>
       <td>T. CONTRATO</td>
       <td>EDUCACION</td>
       <td>ESTADO CIVIL</td>
       <td>HIJOS Y EDADES</td>
       <td>MOTIVACION</td>
       <td>PROYECCIONES</td>
       <td>AYUDAS RECIBIDAS</td>
       <td>DEVENGADO PROMEDIO</td>
       <td>QUIEN EVALUA</td>
       <td>FECHA ULT EVALUACION</td>
       <td>EVALUACION</td>
       <td>FORTALEZAS</td>
       <td>DEBILIDADES</td>
       <td>RECOMENDACINES</td>
       <td>CONOCIMIENTO DE PRODUCTO</td>
       <td>ESTUDIOS</td>
       <td>PRESENTACION</td>
       <td>HORARIOS</td>
       <td>COLABORACION</td>
       <td>PROYECCION LABORAL</td>
       <td>OBSERVACION</td>
     </tr>

     <?php

	//echo "<br>";



do{


	if (empty($rsF)) {

					 $nombreq1 = "";
					 $estado_civil1 = "";
					 $cargo1 = "";
					 $antiguedad1 = "";
					 $tipo_contrato1 = "";
					 $promedio1 = "";
					 $educacion1 = "";
					 $motivacion1 = "";
					 $proyeccion1 = "";
					 $ayudas1 = "";
					 $evaluador1 = "";
					 $fecha_evaluacion1 = "";
					 $evaluacion1 = "";
					 $fortalezas1 = "";
					 $debilidades1 = "";
					 $recomendaciones1 = "";
					 $ap_conocimientos1 = "";
					 $ap_estudios1 = "";
					 $ap_presentacion1 = "";
					 $ac_horarios1 = "";
					 $ac_colaboracion1 = "";
					 $proyeccion_laboral1 = "";
					 $observacion1 = "";
					  $hijos1 = "";


					}

		else {
			     	 $nombreq1 = $rsF->nombreq;
					 $estado_civil1 = $rsF->estado_civil;
					 $cargo1 = $rsF->cargo;
					 $antiguedad1 = $rsF->antiguedad;
					 $tipo_contrato1 = $rsF->tipo_contrato;
					 $promedio1 = $rsF->promedio;
					 $educacion1 = $rsF->educacion;
					 $motivacion1 = $rsF->motivacion;
					 $proyeccion1 = $rsF->proyeccion;
					 $ayudas1 = $rsF->ayudas;
					 $evaluador1 = $rsF->evaluador;
					 $fecha_evaluacion1 = $rsF->fecha_evaluacion;
					 $evaluacion1 = $rsF->evaluacion;
					 $fortalezas1 = $rsF->fortalezas;
					 $debilidades1 = $rsF->debilidades;
					 $recomendaciones1 = $rsF->recomendaciones;
					 $ap_conocimientos1 = $rsF->ap_conocimientos;
					 $ap_estudios1 = $rsF->ap_estudios;
					 $ap_presentacion1 = $rsF->ap_presentacion;
					 $ac_horarios1 = $rsF-> ac_horarios;
					 $ac_colaboracion1 = $rsF->ac_colaboracion;
					 $proyeccion_laboral1 = $rsF->proyeccion_laboral;
					 $observacion1 = $rsF-> observacion;
					 $hijos1 = $rsF-> hijos;


					}



	 ?>

<tr>
    </td>
</tr>




     <tr>
       <td><?php echo utf8_encode($nombreq1); ?></td>
       <td><?php echo utf8_encode($cargo1); ?></td>
       <td><?php echo substr($antiguedad1,0,2); ?>Años</td>
       <td><?php if ($tipo_contrato1 == 1)
	  		  $contrato1 = "Termino indefinido";
		  if ($tipo_contrato1 == 2)
		    $contrato1 = "Termino fijo";
		  if ($tipo_contrato1 == 4)
		   $contrato1 = "Aprendiz";

	  echo utf8_encode($contrato1); ?></td>
       <td><?php echo utf8_encode($educacion1); ?></td>
       <td><?php if ($estado_civil1 == 'SOL')
	  		  $estado_civil1 = "SOLTERO";
		  if ($estado_civil1 == 'CAS')
		    $estado_civil1 = "CASADO";
		  if ($estado_civil1 == 'DIV')
		    $estado_civil1 = "DIVERCIADO";
		  if ($estado_civil1 == 'SEP')
		    $estado_civil1 = "SEPARADO";
		  if ($estado_civil1 == 'ND')
		    $estado_civil1 = "NO DEFINIDO";
		  if ($estado_civil1 == 'UNI')
		   $estado_civil1 = "UNION LIBRE";
	  echo utf8_encode($estado_civil1); ?></td>
       <td><?php echo $hijos; ?></td>
       <td><?php echo utf8_encode($motivacion1); ?></td>
       <td><?php echo utf8_encode($proyeccion1); ?></td>
       <td><?php echo utf8_encode($ayudas1); ?></td>
       <td><?php echo "$".number_format($promedio1, 0, ',', '.'); ?></td>

       <td><?php echo utf8_encode($evaluador1); ?></td>
       <td><?php echo $fecha_evaluacion1; ?></td>
       <td><?php echo $evaluacion1; ?></td>
       <td><?php echo utf8_encode($fortalezas1); ?></td>
       <td><?php echo utf8_encode($debilidades1); ?></td>
       <td><?php echo utf8_encode($recomendaciones1); ?></td>
       <td><?php echo $ap_conocimientos1; ?></td>
       <td><?php echo $ap_estudios1; ?></td>
       <td><?php echo $ap_presentacion1; ?></td>
       <td><?php echo $ac_horarios1; ?></td>
       <td><?php echo $ac_colaboracion1; ?></td>
       <td><?php echo utf8_encode($proyeccion_laboral1); ?></td>
       <td><?php echo utf8_encode($observacion); ?></td>
     </tr>





    <?php
}



	while($rsF=$qryF->fetch_object())

	 ?>

</table>









   <input type="button" name="imprimir" id="prn" value="imprimir" onClick="imprSelec('validador');" >
 </div>
<footer style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold">



</footer>
