
<?php 
error_reporting(0);
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
$cedulanueva=$_POST['cedula'];


	//consulta tabla cliente interno
	$sql1="SELECT * FROM `cliente_interno` where cedula = '$cedulanueva' ";
			$qry_sql1=$link->query($sql1);
			$rs_qry1=$qry_sql1->fetch_object();  ///consultar 

		if (empty($rs_qry1)) {
		   	$sql3="INSERT INTO `personal`.`cliente_interno` (`ID`, `sala`, `cedula`, `tipo_sala`, `educacion`, `hijosyedades`, `motivacion`, `proyeccion`, `ayudas`, `evaluador`, `fecha_evaluacion`, `evaluacion`, `fortalezas`, `debilidades`, `recomendaciones`, `ap_conocimientos`, `ap_estudios`, `ap_presentacion`, `ac_horarios`, `ac_colaboracion`, `proyeccion_laboral`, `observacion`, `obfsamudio`, `fechafsamudio`) VALUES (NULL, NULL, '$cedulanueva', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);";
$qry_sql3=$link->query($sql3);
			
			//exit();
		}


//conexion
try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit();
		}

 $query = "SELECT EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE
,EMP.EMP_ESTADO_CIVIL ECIVIL, CA.CARGO_NOMBRE, TO_CHAR((SYSDATE - EMP_FECHA_INGRESO)/30,9999)/12 ANTIGUEDAD, EMP.EMP_TIPO_CONTRATO TIPO_CONTRATO
, CASE WHEN TO_CHAR((SYSDATE - EMP_FECHA_INGRESO)/30,9999)/12 < 2 THEN CF.COF_VALOR ELSE (SUM(AC.ACUM_VALOR_LOCAL))/2 END AS PROMEDIO, CC.CENCOS_NOMBRE CC
FROM EMPLEADO EMP,TRH_ACUMULADO AC,CARGO CA, CONCEPTOS CO, conceptos_fijos cf, centro_costo cc
WHERE EMP.EMP_ESTADO <> 'R'  AND EMP.EMP_CODIGO = '$cedulanueva' and EMP.EMP_CARGO = CA.CARGO_CODIGO  AND EMP.EMP_CODIGO = AC.EMP_CODIGO  AND
AC.ACUM_FECHA_PAGO > SYSDATE - 60  AND AC.CON_CODIGO = CO.CON_CODIGO AND
CO.CON_NATU = 'DEV' AND EMP.EMP_ESTADO <> 'R'  AND EMP.EMP_CODIGO = '$cedulanueva' AND AC.CON_CODIGO <> '130'
and CF.EMP_CODIGO = EMP.EMP_CODIGO and CC.CENCOS_CODIGO = EMP.EMP_CC_CONTABLE
GROUP BY EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2, EMP.EMP_ESTADO_CIVIL,  CA.CARGO_NOMBRE, TO_CHAR((SYSDATE - EMP_FECHA_INGRESO)/30,9999)/12, EMP.EMP_TIPO_CONTRATO,  CF.COF_VALOR, CC.CENCOS_NOMBRE" ;

		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch();	
		
		$nombre=$row['NOMBRE'];
		$ecivil=$row['ECIVIL'];
		$cargo=$row['CARGO_NOMBRE'];
		$antiguedad=$row['ANTIGUEDAD'];
		$contrato=$row['TIPO_CONTRATO'];
		$salario=$row['PROMEDIO'];
		$cc=$row['CC'];
		
	
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CLIENTE INTERNO</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
 
<link rel="stylesheet" type="text/css" href="../estilos.css"/>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <script>
   function guardarciactualiza (cedula, txtecivil, hyedades, educacion, qlomotiva, proyecciones, sala, tipo_sala, salario, ayudas, evaluador, fevaluacion, nota, fortalezas, debilidades, recomendacion, ap_conocimiento, ap_estudios, ap_presentacion, horarios, colaboracion, proylaboral, observ)
        {	
				var parametros = {
				"cedula": cedula,
				"txtecivil": txtecivil,
				"hyedades": hyedades,
				"educacion": educacion,
				"qlomotiva": qlomotiva,
				"proyecciones": proyecciones,
				"sala": sala,
				"tipo_sala": tipo_sala,
				"salario": salario,
				"ayudas": ayudas,
				"evaluador": evaluador,
				"fevaluacion": fevaluacion,
				"nota": nota,
				"fortalezas": fortalezas,
				"debilidades": debilidades,
				"recomendacion": recomendacion,
				"ap_conocimiento": ap_conocimiento,
				"ap_estudios": ap_estudios,
				"ap_presentacion": ap_presentacion,
				"horarios": horarios,
				"colaboracion": colaboracion,
				"proylaboral": proylaboral,
				"observ": observ,
				};
                $.ajax({
                data: parametros,
                url: 'guardarciactualiza.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
						alert("P R O C E S A D O")
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta").html(response);
						document.getElementById('guardar').disabled=true;
									
						
                    }
        
        });
        }
		  </script>
          
</head>
<body>

<table width="80%" border="0" cellpadding="0" cellspacing="0"><tr>
         <td width="16%" height="46" class="encabezados" align="center"><img src="../gh/img/logo-gh.png" width="260" height="92"></td>
    <td width="100" align="center" class="encabezados">PROCESO DE GESTION HUMANA</td>
         <td width="25%" align="right"><img src="../gh/img/maxicassa.png" width="268" height="98" class="formulario"></td>
       </tr>
       </table>
 
<div id="accordion">
  
    <form action="http://190.144.42.83:9090/plantillas/cliente_interno/actualizar_ci.php" method="post">
 
    <input type="submit"  name="nueva_actualizacion" id="nueva_consulta"   value="NUEVA ACTUALIZACION">	
   
</form>
<h3>Datos personales  	
  </h3>
  <div>
    <p>
      <label for="cedulanueva"></label>
      <strong>No CEDULA</strong>
      <input name="cedulanueva" type="text" class="subtitulos" id="cedulanueva" value="<?php echo $cedulanueva; ?>" readonly>
	<div id="Oculto"></div>
	
    
<table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="80%">
     <tr>
      <td class="encabezados" colspan="4" align="left" valign="middle"><strong>NOMBRE</strong></td>
      <td class="header" colspan="6"  align="justify" ><label for="txtnombre"></label>
        <input name="txtnombre" type="text" id="txtnombre" style="background-color:#CCC"  value="<?php echo $nombre; ?>" size="100" readonly ></td>
    </tr>
    <tr>
      <td class="encabezados" colspan="4" align="left" valign="middle"><strong>Estado Civil</strong></td> 
      <td width="612" class="header" colspan="6"  align="justify" ><label for="txtecivil"></label>
      <input name="txtecivil" type="text" id="txtecivil"  value="<?php if ($ecivil == 'SOL')
	  		 $ecivil = "SOLTERO"; 
		  if ($ecivil == 'CAS')
		    $ecivil = "CASADO";
		  if ($ecivil == 'DIV')
		    $ecivil = "DIVERCIADO";
		  if ($ecivil== 'SEP')
		    $ecivil = "SEPARADO";
		  if ($ecivil == 'ND')
		    $ecivil = "NO DEFINIDO";
		  if ($ecivil == 'UNI') 
		   $ecivil = "UNION LIBRE";
	  echo utf8_encode($ecivil); ?>" size="100"></td>      
      </tr> 
    <tr>
      <td class="encabezados" colspan="4" align="left" valign="middle"><strong>Hijos y Edades</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" valign="middle"><label for="hyedades"></label>
        <input name="hyedades" type="text" id="hyedades" size="100" value="<?php echo utf8_encode($rs_qry1->hijosyedades); ?>"></td> 
     </tr> 
 <tr>
      <td class="encabezados" colspan="4" align="left" valign="middle"><strong>Educacion</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" valign="middle"><label for="educacion"></label>
        <input name="educacion" type="text" id="educacion" size="100" value="<?php echo utf8_encode($rs_qry1->educacion); ?>" ></td>      
      </tr>
      <tr>
      <td class="encabezados" colspan="4" align="left" valign="middle"><strong>Que lo motiva</strong></td> 
      <td width="612" class="header" colspan="6" align="justify"  valign="middle"><label for="qlomotiva"></label>
        <input name="qlomotiva" type="text" id="qlomotiva" size="100" value="<?php echo utf8_encode($rs_qry1->motivacion); ?>"></td>
     </tr>
      <tr>
      <td class="encabezados" colspan="4" align="left" valign="middle"><strong>Proyecciones</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" valign="middle"><label for="proyecciones"></label>
        <input name="proyecciones" type="text" id="proyecciones" size="100" value="<?php echo utf8_encode($rs_qry1->proyeccion); ?>"></td> 
     </tr>
      
  </table>

    </p>
  </div>
  <h3>Datos labores</h3>
  <div>
    <p>
   <table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="80%">
    <tr>
      <td class="encabezados" colspan="4" align="left" valign="middle"><strong>Cargo</strong></td> 
      <td width="606" class="header" colspan="6"  align="justify" ><label for="txtcargo"></label>
      <input name="txtcargo" type="text" id="txtcargo" style="background-color:#CCC"   value="<?php echo $cargo; ?>" size="100" readonly></td>      </tr> 
    <tr>
      <td class="encabezados" colspan="4" align="left" valign="middle"><strong>Antiguedad</strong></td> 
      <td width="606" class="header" colspan="6" align="justify" valign="middle"><label for="txtantiguedad"></label>
        <input name="txtantiguedad" type="text" id="txtantiguedad" style="background-color:#CCC"   value="<?php echo substr($antiguedad,0,2); ?>" size="10" readonly>
        Años</td> 
     </tr> 
 <tr>
      <td class="encabezados" colspan="4" align="left" valign="middle"><strong>Contrato</strong></td> 
      <td width="606" class="header" colspan="6" align="justify" valign="middle"><label for="txtcontrato"></label>
	  <input name="txtcontrato" type="text" id="txtcontrato" style="background-color:#CCC"  value="<?php if ($contrato == 1)
	  		  $contrato = "Termino indefinido"; 
		  if ($contrato == 2)
		    $contrato = "Termino fijo";
		  if ($contrato == 4) 
		   $contrato = "Aprendiz";
	  
	  echo utf8_encode($contrato); ?>" size="100" readonly></td>      </tr>
      <tr>
        <td class="encabezados" colspan="4" align="left" valign="middle"><strong>Sala</strong></td>
        <td class="header" colspan="6" align="justify"  valign="middle" ><label for="centrocosto"></label>
          <input name="centrocosto" type="text" id="centrocosto"  style="background-color:#CCC"  value="<?php echo $cc; ?>" size="50" readonly>
          <label for="sala"></label>
          <select name="sala" id="sala">
              <option value="555">CERAAGUACHICA</option>
              <option value="521">CERAALCIBIA</option>
              <option value="641">CERAARMENIA</option>
              <option value="742">CERAATALAYA</option>
              <option value="701">CERABUCARAMANGA</option>
              <option value="501">CERABARRANQUILLA</option>
              <option value="402">CERABELLO</option>
              <option value="105">CERABOSA</option>
              <option value="201">CERACALI</option>
              <option value="741">CERACUCUTA</option>
              <option value="802">CERADUITAMA</option>
              <option value="523">CERA EL EDEN</option>
              <option value="151">CERAGIRARDOT</option>
              <option value="552">CERAGUATAPURI</option>
              <option value="822">CERAIBAGUE</option>
              <option value="821">CERAJARDIN</option>
              <option value="554">CERAKENNEDY</option>
              <option value="502">CERALA43</option>
              <option value="522">CERAMAGANGUE</option>
              <option value="671">CERAMANIZALEZ</option>
              <option value="441">CERAMONTERIA</option>
              <option value="152">CERAMOSQUERA</option>
              <option value="601">CERAPEREIRA</option>
              <option value="591">CERARIOHACHA</option>
              <option value="401">CERASAN BENITO</option>
              <option value="104">CERASANTA LUCIA</option>
              <option value="571">CERASANTA MARTA</option>
              <option value="541">CERASINCELEJO</option>
              <option value="803">CERASOGAMOSO</option>
              <option value="103">CERASUBA</option>
              <option value="801">CERATUNJA REAL</option>
              <option value="553">CERAVALLEDUPAR</option>
              <option value="102">CERAVENECIA</option>
              <option value="836">CERAVILLAVICENCIO</option>
              <option value="153">CERAZIPAQUIRA</option>
              <option value="128">MAXBOSA</option>
              <option value="221">MAXCALI</option>
              <option value="511">MAXCALLE 30</option>
              <option value="531">MAXCARTAGENA</option>
              <option value="533">MAXEL EDEN</option>
              <option value="127">MAXFONTIBON</option>
              <option value="721">MAXLA AURORA</option>
              <option value="532">MAXLA HEROICA</option>
              <option value="722">MAXLA ROSITA</option>
              <option value="456">MAXMONTERIA</option>
              <option value="864">MAXNEIVA</option>
              <option value="596">MAXRIOHACHA</option>
              <option value="546">MAXSINCELEJO</option>
              <option value="222">MAXTULUA</option>
              <option value="126">MAXVENECIA</option>
              <option value="723">MAXYARIGUIES</option>
              <option value="736">TU CASSA BUCARAMANGA</option>
              <option value="143">TU CASSA CARVAJAL</option>
              <option value="518">TU CASSA MALAMBO</option>
              <option value="099M">ADMON MAXICASSA</option>
              <option value="099P">PEGOMAX</option>
              <option value="099I">INNOVAPACK</option>
      </select>
        </td>
      </tr>
      <tr>
      <td class="encabezados" colspan="4" align="left" valign="middle"><strong>Tipo de sala</strong></td> 
      <td width="606" class="header" colspan="6" align="justify"  valign="middle"><label for="tipo_sala"></label>
        <input name="tipo_sala" type="text" id="tipo_sala" size="100" value="<?php echo utf8_encode($rs_qry1->tipo_sala); ?>"></td>
     </tr>
      <tr>
      <td class="encabezados" colspan="4" align="left" valign="middle"><strong>Salario Promedio (2 meses)</strong></td> 
      <td width="606" class="header" colspan="6" align="justify"  valign="middle"><label for="salario"></label>
        <input name="salario" type="text" id="salario" style="background-color:#CCC"  value="<?php echo "$".number_format($salario, 0, ',', '.'); ?>" size="100" readonly></td>
     </tr>

      <tr>
      <td class="encabezados" colspan="4" align="left" valign="middle"><strong>Ayudas recibidad por la empresa</strong></td> 
      <td width="606" class="header" colspan="6" align="justify" valign="middle"><label for="ayudas"></label>
        <input name="ayudas" type="text" id="ayudas" size="100" value="<?php echo utf8_encode($rs_qry1->ayudas); ?>"></td> 
     </tr>
   
    </table>

    </p>
  </div>
  <h3>Calificacion</h3>
  <div>
    <p>
   <table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="80%" height="82%">
    <tr>
      <td  class="encabezados" colspan="4" align="left" valign="middle"><strong>Evaluador</strong></td> 
      <td width="612" class="header" colspan="6"  align="justify" ><label for="evaluador"></label>
      <input name="evaluador" type="text" id="evaluador" size="100" value="<?php echo utf8_encode($rs_qry1->evaluador); ?>"></td>      </tr> 
    <tr>
      <td class="encabezados" colspan="4" align="left" valign="middle"><strong>Fecha de evaluacion</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" valign="middle"><label for="fevaluacion"></label>
        <input type="text" name="fevaluacion" id="fevaluacion" value="<?php echo utf8_encode($rs_qry1->fecha_evaluacion); ?>"></td> 
  </tr> 
 <tr>
      <td class="encabezados" colspan="4" align="left" valign="middle"><strong>Nota de Evaluacion</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" valign="middle"><label for="nota"></label>
      <input type="text" name="nota" id="nota" value="<?php echo utf8_encode($rs_qry1->evaluacion); ?>"></td>      </tr>
      <tr>
      <td class="encabezados" colspan="4" align="left" valign="middle"><strong>Fortalezas</strong></td> 
      <td width="612" class="header" colspan="6" align="justify"  valign="middle"><label for="fortalezas"></label>
        <input name="fortalezas" type="text" id="fortalezas" size="100" value="<?php echo utf8_encode($rs_qry1->fortalezas); ?>"></td>
     </tr>
      <tr>
      <td class="encabezados" colspan="4" align="left" valign="middle"><strong>Debilidades</strong></td> 
      <td width="612" class="header" colspan="6" align="justify"  valign="middle"><input name="debilidades" type="text" id="debilidades" size="100" value="<?php echo utf8_encode($rs_qry1->debilidades); ?>"></td>
     </tr>

      <tr>
      <td class="encabezados" colspan="4" align="left" valign="middle"><strong>Recomendaciones</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" valign="middle"><input name="recomendacion" type="text" id="recomendacion" size="100" value="<?php echo utf8_encode($rs_qry1->recomendaciones); ?>"></td> 
     </tr>
      <tr>
      <td colspan="3" rowspan="3" align="left" valign="middle" class="encabezados"><strong>Aptitud</strong></td>
      <td width="208" align="left" valign="middle" class="header">Conocimiento del Producto/Puesto</td> 
      <td width="612" colspan="6" align="justify" valign="middle" class="header"><input name="ap_conocimiento" type="text" id="ap_conocimiento" size="100" value="<?php echo utf8_encode($rs_qry1->ap_conocimientos); ?>"></td> 
     </tr>
      <tr>
        <td class="header" align="left" valign="middle">Estudios</td>
        <td width="612" colspan="6" align="justify" valign="middle" class="header"><input name="ap_estudios" type="text" id="ap_estudios" size="100" value="<?php echo utf8_encode($rs_qry1->ap_estudios); ?>"></td>
      </tr>
      <tr>
        <td class="header" align="left" valign="middle">Presentacion</td>
        <td width="612" colspan="6" align="justify" valign="middle" class="header"><input name="ap_presentacion" type="text" id="ap_presentacion" size="100" value="<?php echo utf8_encode($rs_qry1->ap_presentacion); ?>"></td>
      </tr>
      <tr>
      <td colspan="3" rowspan="2" align="left" valign="middle" class="encabezados"><strong>Actitud</strong></td>
      <td class="header" align="left" valign="middle">Horarios</td> 
      <td width="612" colspan="6" align="justify" valign="middle" class="header"><input name="horarios" type="text" id="horarios" size="100" value="<?php echo utf8_encode($rs_qry1->ac_horarios); ?>"></td> 
     </tr>
      <tr>
        <td class="header" align="left" valign="middle">Colaboracion</td>
        <td width="612" colspan="6" align="justify" valign="middle" class="header"><input name="colaboracion" type="text" id="colaboracion" size="100" value="<?php echo utf8_encode($rs_qry1->ac_colaboracion); ?>"></td>
      </tr>
    <tr>
      <td class="encabezados" colspan="4" align="left" valign="middle"><strong>Proyeccion Laboral</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" valign="middle"><input name="proylaboral" type="text" id="proylaboral" size="100" value="<?php echo utf8_encode($rs_qry1->proyeccion_laboral); ?>"></td> 
  </tr>
      <tr>
      <td class="encabezados" colspan="4" align="left" valign="middle"><strong>Observaciones</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" valign="middle"><input name="observ" type="text" id="observ" size="100" value="<?php echo utf8_encode($rs_qry1->observacion); ?>"></td> 
     </tr>
      <tr>
        <td height="50" colspan="4" align="left" valign="middle" class="header">&nbsp;</td>
        <td class="subtitulos" colspan="6" align="justify" valign="middle">&nbsp;</td>
    </tr>
      <tr>
           
        <td height="28" colspan="4" align="left" valign="middle" class="header">&nbsp;</td>
        <td class="header" colspan="6" align="center" valign="middle"><input align="right" name="guardar" type="button" class="botones" onclick= "guardarciactualiza($('#cedulanueva').val(), $('#txtecivil').val(), $('#hyedades').val(), $('#educacion').val(), $('#qlomotiva').val(), $('#proyecciones').val(), $('#sala').val(), $('#tipo_sala').val(), $('#salario').val(), $('#ayudas').val(), $('#evaluador').val(), $('#fevaluacion').val(), $('#nota').val(), $('#fortalezas').val(), $('#debilidades').val(), $('#recomendacion').val(), $('#ap_conocimiento').val(), $('#ap_estudios').val(), $('#ap_presentacion').val(), $('#horarios').val(), $('#colaboracion').val(), $('#proylaboral').val(), $('#observ').val());" id="guardar" value="GUARDAR" /></td>
  </tr>
</table>

    </p>
  </div>
</div>
                
<footer style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold">

 </footer>
 
 

