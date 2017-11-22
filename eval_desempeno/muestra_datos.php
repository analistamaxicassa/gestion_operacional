<<?php
	require_once('../conexionesDB/conexion.php');
	$link_queryx = Conectarse_queryx();
	session_start();
	//recojo variables
	$cedulaent=$_SESSION['userID'];
	$cedulaepre= $_GET['cedula'];
	//$cedulaent="1010185420";
	//$cedulaepre= "1012417013";

	$cedulae=  trim(str_replace("'","",$cedulaepre));

	//$cedulae='1007301759';
	//$cedulaent='52522883';
	$hoy = date('Y-m-d') ;

	//funcion fechas
	require_once("../PAZYSALVO/FuncionFechas.php");
	require_once('../PAZYSALVO/conexion_ares.php');
	$link=Conectarse_personal();

	// verifica que el empleado ya se realizo evaluacion en la fecha actual
 $sql2a="SELECT *  FROM `eval_desempeno` WHERE `ced_evaluado` = '$cedulae' and fecha_evaluacion = '$hoy'";

			$qry_sql2a=$link->query($sql2a);
			$rs2a=$qry_sql2a->fetch_object();

			if (empty($rs2a->id))
				{
				}
			else {
				echo "Al empleado ya se le realizo la evaluacion en el dia de hoy <br>";


 ?>
			<a href='http://190.144.42.83:9090/plantillas/solicitudes/index.php'>	Solicitudes de Gestion Humana</a>
	<?php
				exit();
				}

	$query1 = "SELECT EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_NOMBRE, CA.CARGO_CODIGO,  EMP.EMP_FECHA_INI_CONTRATO,  SO.NOMBRE_SOCIEDAD, EMP.EMP_JEFE_CODIGO,
	CC.CENCOS_NOMBRE CCQ, CG.GRADO_OCUPACION ROLEMP, ROUND (MONTHS_BETWEEN(SYSDATE,EMP.EMP_FECHA_INI_CONTRATO),0) MESES
	FROM EMPLEADO EMP, cargo ca, sociedad so, centro_costo cc, GRADO_CARGO CG
	WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO and EMP.EMP_SOCIEDAD = SO.COD_SOCIEDAD and EMP.EMP_CC_CONTABLE = CC.CENCOS_CODIGO and EMP.EMP_CARGO = CG.GRADO_CARGO
	and EMP.EMP_CODIGO = '$cedulae'";

	$stid = oci_parse($link_queryx, $query1);
	oci_execute($stid);
	$usuario = oci_fetch_object($stid);
	if ($usuario != false)
	{
		$nombre=$usuario->NOMBRE;
		$cargo=$usuario->CARGO_NOMBRE;
		$codcargo=$usuario->CARGO_CODIGO;
		$fingreso=$usuario->EMP_FECHA_INI_CONTRATO;
		$sociedad=$usuario->NOMBRE_SOCIEDAD;
		$nombrecc=$usuario->CCQ;
		$rolEmp=$usuario->ROLEMP;
		$meses=$usuario->MESES;
	}
	//$cc = explode("-",$row1['CCQ']);
		//	$nombrecc = $cc[3];

	$query2 = "SELECT  E.EMP_NOMBRE||' '||E.EMP_APELLIDO1||' '||e.EMP_APELLIDO2 NOMBREENTREVISTA, E.EMP_EMAIL,  CA.CARGO_NOMBRE CARGOENTREVISTA from empleado e, cargo ca where E.EMP_CARGO = CA.CARGO_CODIGO AND E.EMP_CODIGO = '$cedulaent'" ;
	$stid = oci_parse($link_queryx, $query2);
	oci_execute($stid);
	$usuario = oci_fetch_object($stid);
	if ($usuario != false)
	{
		$nombreEntrevista=$usuario->NOMBREENTREVISTA;
		$cargoEntrevista=$usuario->CARGOENTREVISTA;
		$empEmail=$usuario->EMP_EMAIL;
	}

	$query3a = "SELECT GRADO_OCUPACION from GRADO_CARGO where grado_cargo  = '$codcargo' and  rownum = 1 ";

	$stid = oci_parse($link_queryx, $query3a);
	oci_execute($stid);
	$usuario = oci_fetch_object($stid);
	if ($usuario != false)
	{
		$rol=$usuario->GRADO_OCUPACION;
	}
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Evaluacion de Desempeño</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="../estilos.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script>
      function ingresar()
			{
		 		document.getElementById('formulario').submit();
			}
	 		function guardared(cedula, cargo, nombreent, sociedad, fevaluacion, aspecto)
      {
				//alert(aspecto);
				var parametros = {
				"sala": sala,
				"concepto_det": concepto_det,
				"calificacion": calificacion,
				"hallazgo": hallazgo,
				"tarea": tarea,
				"responsable": responsable,
				"fcontrol": fcontrol,
				"autor": autor,
				};
          $.ajax({
          data: parametros,
          url: 'guardarcs.php',
          type: 'post',
             beforeSend: function ()
              {
                $("#respuesta").html("Validando, espere por favor...");
              },
              success: function (response)
              {
                  $("#respuesta").html(response);
			 					{
						    	document.getElementById('guardar').disabled=true;
                	$("#validador").html(response);
                }
              }
      		});
      }
			function mostrar(periodo)
			{// alert(periodo);
				var dperiodo = 	document.getElementById('periodo').value;
				if (dperiodo == 'Cambio temporal a empresa')
					{
						document.getElementById('contrata_empresa').style.visibility = "visible";
						document.getElementById('textcontrata').style.visibility = "visible";
						document.getElementById('condiciones').style.visibility = "visible";
						document.getElementById('textcondiciones').style.visibility = "visible";
					}
				else {
						document.getElementById('condiciones').style.visibility = "hidden";
						document.getElementById('textcondiciones').style.visibility = "hidden";
						document.getElementById('contrata_empresa').style.visibility = "hidden" ;
						document.getElementById('textcontrata').style.visibility = "hidden";
					}
			}


 $.datepicker.regional['es'] = {
     closeText: 'Cerrar',
     prevText: '<Ant',
     nextText: 'Sig>',
     currentText: 'Hoy',
     monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
     monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
     dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
     dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
     dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
     weekHeader: 'Sm',
     dateFormat: 'yy/mm/dd',
     firstDay: 1,
     isRTL: false,
     showMonthAfterYear: false,
     yearSuffix: ''
     };
     $.datepicker.setDefaults($.datepicker.regional['es']);

 	 $(function () {
     $("#fseguimiento" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  yearRange: '-100:+0'
       });
    });
    </script>
</head>
<body>
<p>
 <form method="post" action=  "guardareval_desem.php">


<table width="97%" border="1" align="center">
      <tr>
        <th colspan="5" rowspan="3" scope="col">EVALUACION DE DESEMPEÑO</th>
        <th width="22%" scope="col">Código: FRH-06</th>
      </tr>
      <tr>
        <th width="22%" scope="col">Versión: 3 (actualizado agosto / 12)</th>
      </tr>
      <tr>
        <th width="22%" scope="col">Página: 1 de 1</th>
      </tr>
      <tr>
        <th width="9%" scope="col">Nombre </th>
        <th width="33%" colspan="1" scope="col"><label for="nombre"></label>
        <input name="nombre" type="text" id="nombre" value=" <?php echo utf8_encode($nombre); ?>" size="48">
        <input type="hidden"  name="cedulae" value="<?php echo $cedulae ?>" id="cedulae" readonly>
        </th>
        <th width="17%" scope="col">Cargo del Evaluado</th>
        <th colspan="3" align="left" scope="col"><p>
          <label for="codcargo"></label>
          <input name="codcargo" type="text" id="codcargo" size="5" align="left" value="<?php echo utf8_encode($codcargo); ?>">
          <input name="cargo" type="text" id="cargo" value=" <?php echo utf8_encode($cargo); ?>" size="50" readonly>
        <input type="hidden"  name="rol" value="<?php echo $rolEmp ?>" id="rol" readonly></p></th>
      </tr>
      <tr>
        <th scope="col">F Ingreso </th>
        <th colspan="-1" scope="col"><input name="ingreso" type="text" id="ingreso" value="<?php echo fechaletra($fingreso); ?>" size="50" readonly></th>
        <th scope="col">Tiempo de Vinculación</th>
        <th colspan="3" scope="col"  align="left"><label>
          <input name="tiempo_vinculacion" type="text" id="tiempo_vinculacion" value="<?php echo $meses." MESES"; ?>">
        </label></th>
      </tr>
      <tr>
        <th scope="col">Sala</th>
        <th colspan="-1" scope="col"><input name="nombrecc" type="text" id="nombrecc" value="<?php echo utf8_encode($nombrecc); ?>" size="50" readonly></th>
        <th scope="col">Periodo</th>
        <th colspan="3" scope="col" align="left"><select name="periodo" class="encabezados" id="periodo" onBlur="mostrar(this.value)"  >
          <option value="">seleccione..</option>
          <option value="Periodo de prueba">Periodo de prueba</option>
          <option value="Semestral">Evaluacion periódica</option>
          <option value="Cambio temporal a empresa">Cambio de Temporal a Empresa</option>
          <option value="Nivelacion de Sueldo">Nivelación de Sueldo</option>
          <option value="Promocion y/o Ascenso">Promoción y/o Ascenso</option>
        </select></th>
      </tr>
      <tr>
        <th height="8" colspan="6"  scope="col"></th>
      </tr>
      <tr>
        <th scope="col">Evaluador</th>
        <th colspan="-1" scope="col"><input name="nombreent" type="text" id="cedulaent" value="<?php echo utf8_encode($nombreEntrevista); ?>" size="50" readonly >
        <input type="hidden"  name="cedulaent" value="<?php echo $cedulaent ?>" id="cedulaent" readonly></th>
        <th scope="col">Fecha de Evaluación</th>
        <th colspan="3" scope="col" align="left"><input name="fevaluacion" type="text" id="fevaluacion" value="<?php echo $hoy; ?>" size="50" readonly></th>
      </tr>
      <tr>
        <th scope="col">Email Evaluador</th>
        <th colspan="-1" scope="col"><input name="email" type="text" id="email"  value="<?php echo utf8_encode($empEmail); ?>" size="50"></th>
        <th scope="col">Cargo del evaluador</th>
        <th colspan="3" scope="col" align="left"><label for="periodo"></label>
          <input name="cargoent" type="text" align="left" id="cargoent" value="<?php echo utf8_encode($cargoEntrevista); ?>" size="50" readonly></th>
      </tr>
      <tr>
        <td height="55" colspan="6" style="font-size:16px"><p>Para la evaluación que se realizará a continuación tenga en cuenta los siguientes criterios:<strong> ALGUNAS VECES </strong>(menos del 40% del tiempo), <strong>FRECUENTEMENTE</strong> (entre el 40% y 70% del tiempo), <strong>CASI SIEMPRE </strong>(entre el 70% y 90% del tiempo), <strong>SIEMPRE</strong> (entre el 90% y 100% del tiempo) </p></td>
      </tr>

</table>
    <table width="97%" border="0" align="center">
      <tr>


                    <td width="497" class="encabezados">ASPECTOS </td>
                    <td colspan="2" class="encabezados">DEFINICIONES</td>
                    <td width="148" class="encabezados">&nbsp;</td>
                    <td width="162" class="encabezados">PROMEDIO</td>

      </tr>
                  <tr>
             <?php
 $sql4 = "SELECT id, aspecto, definicion FROM ed_def_aspectos order by id" ;
			$qry_sql4=$link->query($sql4);
			$rs_qry4=$qry_sql4->fetch_object();  ///consultar



			do{
			$daspecto  = $rs_qry4->id;
			?>

                    <td class="subtitulos"><?php echo $rs_qry4->aspecto; ?></td>
                    <td colspan="4" class="subtitulos"><?php echo $rs_qry4->definicion; ?></td>
                  </tr>


                  <tr>
                    <td class="encabezados">&nbsp;</td>
                    <td class="encabezados">Valoracion</td>
                    <td colspan="2" class="encabezados">Aspectos a resaltar </td>
                    <td class="encabezados">Aspectos a mejorar </td>
                  </tr>

             <?php


//		$sql3 = "SELECT asp.id id, das.aspecto, das.definicion, operacion FROM ed_aspectos asp inner join ed_def_aspectos das on asp.aspecto = das.id where asp.aspecto = '$daspecto' and ( cargo = '$codcargo' or cargo = '999')  " ;

		$sql3 = "select id, operacion FROM `ed_aspectos` WHERE rol in ('$rol','999') and cargo in ('$codcargo','','999')  and aspecto = '$daspecto'" ;
		$qry_sql3=$link->query($sql3);
		$rs_qry3=$qry_sql3->fetch_object();  ///consultar
		echo $sql3."<br>";
		do{


	?>

    <tr>
      <td align="left" valign="middle"><textarea name="operacion<?php echo utf8_encode($rs_qry3->id); ?>" cols="80" readonly><?php echo utf8_encode($rs_qry3->operacion); ?></textarea></td>
      <td width="160" align="center" valign="middle">



      <select name="valoracion<?php echo utf8_encode($rs_qry3->id); ?>" />

        <option value="" style="font-size:10px">...</option>
        <option value="0.25" style="font-size:10px">ALGUNAS VECES</option>
        <option value="0.50" style="font-size:10px">FRECUENTEMENTE</option>
        <option value="0.75" style="font-size:10px">CASI SIEMPRE</option>
      <option value="1" style="font-size:10px">SIEMPRE</option></td>
      <td colspan="2" align="left" valign="middle"><p>
        <label>
          <textarea name="resaltar<?php echo utf8_encode($rs_qry3->id); ?>" cols="2" rows="3" id="resaltar"></textarea>
      </label>
      </p></td>
      <td align="left" valign="middle"><textarea name="mejorar<?php echo utf8_encode($rs_qry3->id); ?>" cols="3" rows="3" id="mejorar"></textarea></td>
      </tr>

  <?php
		}
		while($rs_qry3=$qry_sql3->fetch_object());


//}
		}
		while($rs_qry4=$qry_sql4->fetch_object());

?>
  <tr>
      <td colspan="5">Oportunidades  de Mejoramiento:  Compromisos que asume el Evaluado para mejorar su desempeño.</td>
    <tr>
      <td colspan="4"><label for="mejoras"></label>
      <textarea name="mejoras" cols="80" id="mejoras"></textarea></td>
      <td><label>
        Fecha de seguimiento:
        <input type="text" name="fseguimiento"  class="text" id="fseguimiento" value="" required>

      </label></td>
    <tr>
      <td colspan="5">Necesidades de Capacitación:
        <input name="capacitacion" type="text" id="capacitacion" size="128"></td>
    <tr>
      <td colspan="5">Observaciones del evaluado</td>
    <tr>
      <td colspan="5"><label for="obs_evaluado"></label>
      <textarea name="obs_evaluado" id="obs_evaluado"></textarea></td>
    <tr>
      <td colspan="5">

         <input name="textcontrata" type="text" id="textcontrata" value="Continua el proceso por la empresa:" size="37" readonly style="visibility:hidden">

<select name="contrata_empresa" id="contrata_empresa" style="visibility:hidden">
          <option value="">...</option>
          <option value="SI">SI</option>
          <option value="NO">NO</option>
      </select> <input name="textcondiciones" type="text" id="textcondiciones" value="Especifique las nuevas condiciones salariales si existen -->" size="55" readonly style="visibility:hidden"> <label>
        <input name="condiciones" type="text" id="condiciones" size="70" style="visibility:hidden">
      </label>

      </td>
    <tr>
      <td colspan="5"><label for="contrata_empresa"></label>
        <label for="capacitacion"></label></td>
   </table>
     <input name="ingresar" type="submit" class="botones" id="ingresar" value="INGRESAR" />
</form>
      <p>&nbsp;</p>
	</body>
</html>
