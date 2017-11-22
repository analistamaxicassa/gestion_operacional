

<?php 
error_reporting(0);

 $cedular=$_REQUEST['cedula'];
 $cedulaent=$_REQUEST['cedulaent'];
 
$hoy = date('Y-m-d') ;




//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

	//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		
//eliminar tabla temporal
		$sql20="DELETE FROM `personal`.`empleados_retiradostmp`";
			$qry_sql20=$link->query($sql20);
			
$query1 = "SELECT CA.CARGO_NOMBRE, EMP.EMP_FECHA_RETIRO, EMP.EMP_FECHA_INI_CONTRATO, SO.NOMBRE_SOCIEDAD, EMP.EMP_JEFE_CODIGO,
 (select E.EMP_NOMBRE||' '||E.EMP_APELLIDO1||' '||e.EMP_APELLIDO2
from empleado e where E.emp_codigo = EMP.EMP_JEFE_CODIGO) NOMBREJEFE, CC.CENCOS_NOMBRE CCQ
FROM EMPLEADO EMP, cargo ca, sociedad so, centro_costo cc
WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO and EMP.EMP_SOCIEDAD = SO.COD_SOCIEDAD and EMP.EMP_CC_CONTABLE = CC.CENCOS_CODIGO 
and EMP.EMP_CODIGO = '$cedular'" ;

		$stmt1 = $dbh->prepare($query1);
		$stmt1->execute();
		$row1 = $stmt1->fetch();	
		
		$cargo=$row1['CARGO_NOMBRE'];
		$fretiro=$row1['EMP_FECHA_RETIRO'];
		$fingreso=$row1['EMP_FECHA_INI_CONTRATO'];
		$sociedad=$row1['NOMBRE_SOCIEDAD'];
		$nombrejefe=$row1['NOMBREJEFE'];
		$nombrecc=$row1['CCQ'];
		//$cc = explode("-",$row1['CCQ']);
 		//	$nombrecc = $cc[3];
		
$query2 = "SELECT  E.EMP_NOMBRE||' '||E.EMP_APELLIDO1||' '||e.EMP_APELLIDO2 NOMBREENTREVISTA, CA.CARGO_NOMBRE CARGOENTREVISTA from empleado e, cargo ca where E.EMP_CARGO = CA.CARGO_CODIGO AND E.EMP_CODIGO = '$cedulaent'" ;

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
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

 <script>
   function guardarentrevista (mes, cedular, cargo, nombrecc, sociedad, motivo, b1p1, b1p2,  b1p3, b1p4,  b1p5, b1p6, b2p1, b2p2, b2p3, b2p4, b2p5, b2p6, b2p7, b2p8, b2p9, actitud, colaboracion,  bloque3, bloque4, bloque5, nombreentrevista, cargoentrevista) 
   { alert(actitud), alert(colaboracion)
				var ob1p1= $('input:radio[name=RadioGroup1]:checked').val();
				var ob1p2= $('input:radio[name=RadioGroup2]:checked').val();
				var ob1p3= $('input:radio[name=RadioGroup3]:checked').val();
	            var ob1p4= $('input:radio[name=RadioGroup4]:checked').val();
			    var ob1p5= $('input:radio[name=RadioGroup5]:checked').val();
				var ob1p6= $('input:radio[name=RadioGroup6]:checked').val();
				var ob2p1= $('input:radio[name=RadioGroup7]:checked').val();
				var ob2p2= $('input:radio[name=RadioGroup8]:checked').val();
				var ob2p3= $('input:radio[name=RadioGroup9]:checked').val();
				var ob2p4= $('input:radio[name=RadioGroup10]:checked').val();
				var ob2p5= $('input:radio[name=RadioGroup11]:checked').val();
				var ob2p6= $('input:radio[name=RadioGroup12]:checked').val();
				var ob2p7= $('input:radio[name=RadioGroup13]:checked').val();
				var ob2p8= $('input:radio[name=RadioGroup14]:checked').val();
				var ob2p9= $('input:radio[name=RadioGroup15]:checked').val();

				var parametros = {
			
				"mes": mes,
				"cedular": cedular,
				"cargo": cargo,
				"nombrecc": nombrecc,
				"sociedad": sociedad,
				"motivo": motivo,
				"ob1p1": ob1p1,
				"ob1p2": ob1p2,
				"ob1p3": ob1p3,
				"ob1p4": ob1p4,
				"ob1p5": ob1p5,
				"ob1p6": ob1p6,				
				"b1p1": b1p1,
				"b1p2": b1p2,
				"b1p3": b1p3,
				"b1p4": b1p4,
				"b1p5": b1p5,
				"b1p6": b1p6,
				"ob2p1": ob2p1,
				"ob2p2": ob2p2,
				"ob2p3": ob2p3,
				"ob2p4": ob2p4,
				"ob2p5": ob2p5,
				"ob2p6": ob2p6,
				"ob2p7": ob2p7,
				"ob2p8": ob2p8,
				"ob2p9": ob2p9,
				"b2p1": b2p1,
				"b2p2": b2p2,
				"b2p3": b2p3,
				"b2p4": b2p4,
				"b2p5": b2p5,
				"b2p6": b2p6,
				"b2p7": b2p7,  
				"b2p8": b2p8,
				"b2p9": b2p9,
				"actitud": actitud,
				"colaboracion": colaboracion,
				"bloque3": bloque3,
				"bloque4": bloque4,
				"bloque5": bloque5,
				"nombreentrevista": nombreentrevista,
				"cargoentrevista": cargoentrevista,
				};
				alert("todo bien")
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/entrevista_retiro/guardarentrevista.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
						alert("P R O C E S A D O")
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta").html(response);
						//document.getElementById('guardar').disabled=true;
									
						
                    }
        
        });
        }

		  </script>

</head>
<body>
<p>
<div align="center"><img src="../cliente_interno/img/<?php echo $cedular; ?>.jpg" width="100" height="100"></div> 
  
  <table width="830" border="0" align="center"  style="border-collapse:collapse">
   
    <tr>
      <td  colspan="4" align="left" valign="middle"><strong>CARGO</strong></td>
      <td colspan="6"  align="justify" ><?php echo utf8_encode($row1['CARGO_NOMBRE']); ?></td>
    </tr>
    <tr>
      <td  colspan="4" align="left" valign="middle"><strong>CENTRO DE COSTO</strong></td> 
    <td width="612" colspan="6"  align="justify" ><?php echo utf8_encode($nombrecc); ?></td>      
    </tr> 
    <tr>
      <td  colspan="4" align="left" valign="middle"><strong>FECHA DE INGRESO</strong></td> 
      <td width="612"  colspan="6" align="justify" valign="middle"><?php echo fechaletra($row1['EMP_FECHA_INI_CONTRATO']); ?></td> 
    </tr> 
 <tr>
      <td  colspan="4" align="left" valign="middle"><strong>FECHA DE RETIRO</strong></td> 
    <td width="612"  colspan="6" align="justify" valign="middle"><?php echo fechaletra($row1['EMP_FECHA_RETIRO']); ?></td>      
    </tr>
    <tr>
      <td  colspan="4" align="left" valign="middle"><strong>EMPRESA</strong></td> 
      <td width="612" colspan="6" align="justify"  valign="middle"><?php echo utf8_encode($row1['NOMBRE_SOCIEDAD']); ?></td>
    </tr>
    <tr>
      <td  colspan="4" align="left" valign="middle"><strong>JEFE INMEDIATO</strong></td> 
      <td width="612" colspan="6" align="justify" valign="middle"><?php echo utf8_encode($row1['NOMBREJEFE']); ?></td> 
    </tr>
    <tr>
      <td  colspan="4" align="left" valign="middle">MOTIVO DE RETIRO</td>
      <td colspan="6" align="justify" valign="middle"><label for="motivo"></label>
         <select name="motivo" id="motivo">
         <option value="">seleccione... </option>
         <option value="CAMBIO DE REGIMEN LABORAL A INTEGRAL">CAMBIO DE REGIMEN LABORAL A INTEGRAL</option>
         <option value="DESPIDO CON JUSTA CAUSA">DESPIDO CON JUSTA CAUSA</option>
         <option value="DESPIDO SIN JUSTA CAUSA">DESPIDO SIN JUSTA CAUSA</option>
         <option value="ELIMINACION DE CARGO">ELIMINACION DE CARGO</option>
         <option value="FALLECIMIENTO">FALLECIMIENTO</option>
         <option value="PENSION">PENSION</option>
         <option value="RENUNCIA">RENUNCIA</option>
         <option value="VENCIMIENTO DE CONTRATO">VENCIMIENTO DE CONTRATO</option>
         <option value="PERIODO DE PRUEBA">PERIODO DE PRUEBA</option>
         <option value="MUTUO ACUERDO">MUTUO ACUERDO</option>
         <option value="NO TERMINO PROCESO DE SELECCION">NO TERMINO PROCESO DE SELECCION</option>
      </select></td>
    </tr>
    
  </table>
  </p>
    <p>
<table width="830" border="0" align="center" style="border-collapse:collapse">
    <tr>
      <td  colspan="4"  align="center" class="encabezados" >QUE INFLUENCIA TUVIERON LOS SIGUIENTES ASPECTOS EN SU DECISION DE RETIRO</td>
    </tr>
    <tr>
      
      <td width="290"  align="center" >&nbsp;</td>
      <td width="97"  align="center" >SI</td>
      <td width="99"  align="center" >NO</td>
      <td width="326"  align="center" >ESPECIFIQUE</td>
  </tr>
    <tr align="left">
      <td   >Oferta de mejor cargo</td>
      <td colspan="2"  ><table width="200">
        <tr>
          <td align="center"><label>
            <input type="radio" name="RadioGroup1" value="si" id="RadioGroup1_0">
           </label></td>
      
       
          <td align="center"><label>
            <input type="radio" name="RadioGroup1" value="no" id="RadioGroup1_1">
            </label></td>
        </tr>
      </table></td>
      <td ><label for="b1p1"></label>
      <input name="b1p1" type="text" id="b1p1" size="50"></td>
    </tr>
    <tr>
      <td>Oferta de mejor salario</td>
      <td colspan="2" ><table width="200">
        <tr>
          <td align="center"><label>
            <input type="radio" name="RadioGroup2" value="si" id="RadioGroup1_2">
          </label></td>
          <td align="center"><label>
            <input type="radio" name="RadioGroup2" value="no" id="RadioGroup1_3">
          </label></td>
        </tr>
      </table></td>
      <td><label for="b1p2"></label>
      <input name="b1p2" type="text" id="b1p2" size="50"></td>
    </tr>
    <tr>
      <td>Mejores posibilidades de desarrollo</td>
      <td colspan="2" ><table width="200">
        <tr>
          <td align="center"><label>
            <input type="radio" name="RadioGroup3" value="si" id="RadioGroup1_4">
          </label></td>
          <td align="center"><label>
            <input type="radio" name="RadioGroup3" value="no" id="RadioGroup1_5">
          </label></td>
        </tr>
      </table></td>
      <td ><label for="b1p3"></label>
      <input name="b1p3" type="text" id="b1p3" size="50"></td>
    </tr>
    <tr>
      <td >Mejores condiciones fisicas para su trabajo</td>
      <td colspan="2"  ><table width="200">
        <tr>
          <td align="center"><label>
            <input type="radio" name="RadioGroup4" value="si" id="RadioGroup1_6">
          </label></td>
          <td align="center"><label>
            <input type="radio" name="RadioGroup4" value="no" id="RadioGroup1_7">
          </label></td>
        </tr>
      </table></td>
      <td ><label for="b1p4"></label>
      <input name="b1p4" type="text" id="b1p4" size="50"></td>
    </tr>
    <tr>
      <td>Relaciones interpersonales</td>
      <td colspan="2" ><table width="200">
        <tr>
          <td align="center"><label>
            <input type="radio" name="RadioGroup5" value="si" id="RadioGroup1_8">
          </label></td>
          <td align="center"><label>
            <input type="radio" name="RadioGroup5" value="no" id="RadioGroup1_9">
          </label></td>
        </tr>
      </table></td>
      <td><label for="b1p5"></label>
      <input name="b1p5" type="text" id="b1p5" size="50"></td>
    </tr>
    <tr>
      <td>Relaciones con sus superiores</td>
      <td colspan="2"><table width="200">
        <tr>
          <td align="center"><label>
            <input type="radio" name="RadioGroup6" value="si" id="RadioGroup1_10">
          </label></td>
          <td align="center"><label>
            <input type="radio" name="RadioGroup6" value="no" id="RadioGroup1_11">
          </label></td>
        </tr>
      </table></td>
      <td><label for="b1p6"></label>
      <input name="b1p6" type="text" id="b1p6" size="50"></td>
    </tr>
     <tr>
      <td  colspan="4" align="justify" valign="middle"></td> 
     </tr>
   
</table>

    </p>
</div>
<table width="830" border="0" align="center" style="border-collapse:collapse">
  <tr>
    <td  colspan="4"  align="left" class="encabezados" ><p>EN EL TIEMPO LABORADO EN LA EMPRESA</p>
    <p> INFLUYERON EN SU PRODUCTIVIDAD LOS SIGUIENTES FACTORES</p></td>
  </tr>
  <tr>
    <td width="364"  align="center" >&nbsp;</td>
    <td width="66"  align="center" >SI</td>
    <td width="67"  align="center" >NO</td>
    <td width="315"  align="center" >ESPECIFIQUE</td>
  </tr>
  <tr align="left">
    <td   >Falta de herramientas de trabajo</td>
    <td colspan="2"  ><table width="200">
      <tr>
        <td align="center"><label>
          <input type="radio" name="RadioGroup7" value="si" id="RadioGroup1_12">
        </label></td>
        <td align="center"><label>
          <input type="radio" name="RadioGroup7" value="no" id="RadioGroup1_13">
        </label></td>
      </tr>
    </table></td>
    <td ><label for="b2p1"></label>
    <input name="b2p1" type="text" id="b2p1" size="50"></td>
  </tr>
  <tr>
    <td>Falta de direccion o supervisión</td>
    <td colspan="2" ><table width="200">
      <tr>
        <td align="center"><label>
          <input type="radio" name="RadioGroup8" value="si" id="RadioGroup1_14">
        </label></td>
        <td align="center"><label>
          <input type="radio" name="RadioGroup8" value="no" id="RadioGroup1_15">
        </label></td>
      </tr>
    </table></td>
    <td><label for="b2p2"></label>
    <input name="b2p2" type="text" id="b2p2" size="50"></td>
  </tr>
  <tr>
    <td>Cantidad y calidad de informacion</td>
    <td colspan="2" ><table width="200">
      <tr>
        <td align="center"><label>
          <input type="radio" name="RadioGroup9" value="si" id="RadioGroup1_16">
        </label></td>
        <td align="center"><label>
          <input type="radio" name="RadioGroup9" value="no" id="RadioGroup1_17">
        </label></td>
      </tr>
    </table></td>
    <td ><label for="b2p3"></label>
    <input name="b2p3" type="text" id="b2p3" size="50"></td>
  </tr>
  <tr>
    <td >Confusión de responsabilidades</td>
    <td colspan="2"  ><table width="200">
      <tr>
        <td align="center"><label>
          <input type="radio" name="RadioGroup10" value="si" id="RadioGroup1_18">
        </label></td>
        <td align="center"><label>
          <input type="radio" name="RadioGroup10" value="no" id="RadioGroup1_19">
        </label></td>
      </tr>
    </table></td>
    <td><label for="b2p4"></label>
    <input name="b2p4" type="text" id="b2p4" size="50"></td>
  </tr>
  <tr>
    <td>Dificultad para coordinar con otras áreas</td>
    <td colspan="2" ><table width="200">
      <tr>
        <td align="center"><label>
          <input type="radio" name="RadioGroup11" value="si" id="RadioGroup1_20">
        </label></td>
        <td align="center"><label>
          <input type="radio" name="RadioGroup11" value="no" id="RadioGroup1_21">
        </label></td>
      </tr>
    </table></td>
    <td><label for="b2p5"></label>
    <input name="b2p5" type="text" id="b2p5" size="50"></td>
  </tr>
  <tr>
    <td>Falta de entrenamiento</td>
    <td colspan="2" ><table width="200">
      <tr>
        <td align="center"><label>
          <input type="radio" name="RadioGroup12" value="si" id="RadioGroup1_22">
        </label></td>
        <td align="center"><label>
          <input type="radio" name="RadioGroup12" value="no" id="RadioGroup1_23">
        </label></td>
      </tr>
    </table></td>
    <td><label for="b2p6"></label>
    <input name="b2p6" type="text" id="b2p6" size="50"></td>
  </tr>
  <tr>
    <td>Demoras en la toma de desiciones</td>
    <td colspan="2" ><table width="200">
      <tr>
        <td align="center"><label>
          <input type="radio" name="RadioGroup13" value="si" id="RadioGroup1_24">
        </label></td>
        <td align="center"><label>
          <input type="radio" name="RadioGroup13" value="no" id="RadioGroup1_25">
        </label></td>
      </tr>
    </table></td>
    <td><label for="b2p7"></label>
    <input name="b2p7" type="text" id="b2p7" size="50"></td>
  </tr>
  <tr>
    <td>Directrices poco claras</td>
    <td colspan="2" ><table width="200">
      <tr>
        <td align="center"><label>
          <input type="radio" name="RadioGroup14" value="si" id="RadioGroup1_26">
        </label></td>
        <td align="center"><label>
          <input type="radio" name="RadioGroup14" value="no" id="RadioGroup1_27">
        </label></td>
      </tr>
    </table></td>
    <td><label for="b2p8"></label>
    <input name="b2p8" type="text" id="b2p8" size="50"></td>
  </tr>
  <tr>
    <td>Otro </td>
    <td colspan="2" ><table width="200">
      <tr>
        <td align="center"><label>
          <input type="radio" name="RadioGroup15" value="si" id="RadioGroup1_28">
        </label></td>
        <td align="center"><label>
          <input type="radio" name="RadioGroup15" value="no" id="RadioGroup1_29">
        </label></td>
      </tr>
    </table></td>
    <td><label for="b2p9"></label>
    <input name="b2p9" type="text" id="b2p9" size="50"></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>Percepcion del Entrevistador sobre el candidato</td>
    <td colspan="3" >
      <select name="actitud" id="actitud">
      <option value="">seleccione... </option>
      <option value="BUENA ACTITUD">Buena Actitud</option>
       <option value="MALA ACTITUD">Mala Actitud</option>
    </select>
       <select name="colaboracion" id="colaboracion">
       <option value="">seleccione... </option>
      <option value="COLABORADOR">Colaborador</option>
       <option value="POCO COLABORADOR">Poco Colaborador</option>
    </select></td>
  </tr>
  <tr>
    <td  colspan="4" align="justify" valign="middle"></td>
  </tr>
</table>
 
<p>&nbsp;</p>
<table width="830" border="0" align="center" style="border-collapse:collapse">
<tr>
    <td  colspan="4"  align="center" class="encabezados" >Enumere los aspectos positivos de la empresa</td>
  </tr>
  <tr>
    <td height="74" colspan="4"  align="center" >
       <select name="bloque3" id="bloque3">
       <option value="">seleccione... </option>
      <option value="Relacion con superiores">Relacion con superiores</option>
      <option value="Trabajo en equipo">Trabajo en equipo</option>
      <option value="Experiencia y reconocimiento en el sector">Experiencia y reconocimiento en el sector</option>
      <option value="Tipo de contrato">Tipo de contrato</option>
      <option value="Estabilidad">Estabilidad</option>
      <option value="Cumplimiento en pago">Cumplimiento en pago</option>
      <option value="Garantias legales">Garantias legales</option>
      <option value="Fondo de empleados">Fondo de empleados</option>
      <option value="Otras">Otras</option>
    </select></td>
  </tr>
  <tr>
    <td  colspan="4"  align="center" class="encabezados" >Enumere los aspectos a mejorar de la empresa y qué recomendaciones haría</td>
  </tr>
  <tr>
    <td height="74" colspan="4"  align="center" >    
      <select name="bloque4" id="bloque4">
      <option value="">seleccione... </option>
      <option value="Falta de retroalimentacion y seguimiento de superiores">Falta de retroalimentacion y seguimiento de superiores</option>
      <option value="Falta de capacitacion y entrenamiento al cargo">Falta de capacitacion y entrenamiento al cargo</option>
      <option value="Horarios extensos">Horarios extensos</option>
      <option value="Falta de herramientas de trabajo">Falta de herramientas de trabajo</option>
      <option value="Salario no acordes a cargo laboral">Salario no acordes a cargo laboral</option>
      <option value="Demoras en toma de desiciones administrativa">Demoras en toma de desiciones administrativa</option>
      <option value="Falta de reconocimeinto y crecimiento">Falta de reconocimeinto y crecimiento</option>
      <option value="Relacion con los superiores">Relacion con los superiores</option>
      <option value="Otras">Otras</option>
    </select></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="left" class="encabezados" >Observaciones y comentarios</td>
  </tr>
  <tr>
    <td height="75" colspan="4" ><label for="bloque5"></label>
    <textarea name="bloque5" id="bloque5"></textarea></td>
  </tr>
  <tr>
    <td height="61"><?php echo utf8_encode($row2['NOMBREENTREVISTA']); ?></td>
    <td colspan="3" >&nbsp;</td>
  </tr>
  <tr>
    <td width="364"><p>Nombre de quien realiza la entrevista</p></td>
    <td colspan="3" >Firma</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">Cargo <?php echo utf8_encode($row2['CARGOENTREVISTA']); ?></td>
  </tr>
  <tr>
    <td>Fecha de la entrevista </td>
    <td colspan="3" ><?php echo  ($hoy ); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" ><span class="header">
<input align="right" name="guardar" type="button" class="botones" onclick= "guardarentrevista (<?php echo 	substr($fretiro, 3, 2); ?>, <?php echo($cedular); ?>, '<?php echo($cargo); ?>', '<?php echo($nombrecc); ?>', '<?php echo($row1['NOMBRE_SOCIEDAD']); ?>',  $('#motivo').val(), $('#b1p1').val(), $('#b1p2').val(), $('#b1p3').val(), $('#b1p4').val(), $('#b1p5').val(), $('#b1p6').val(), $('#b2p1').val(), $('#b2p2').val(), $('#b2p3').val(), $('#b2p4').val(), $('#b2p5').val(), $('#b2p6').val(), $('#b2p7').val(), $('#b2p8').val(), $('#b2p9').val(), $('#actitud').val(), $('#colaboracion').val(), $('#bloque3').val(), $('#bloque4').val(), $('#bloque5').val(),  '<?php echo($row2['NOMBREENTREVISTA']); ?>',  '<?php echo($row2['CARGOENTREVISTA']); ?>' );" id="guardar" value="GUARDAR" />
    </span></td>


    
  </tr>
  <tr>
    <td  colspan="4" align="justify" valign="middle"></td>
  </tr>
</table>
 <div id="respuesta" ></div>
<p>


