
<?php 
error_reporting(0);
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
$cedulanueva=$_POST['cedula'];
$sala= $_POST['sala'];

session_start();  
$cedingreso = $_SESSION['ced'];

if($_SESSION['us'] == '2') {
	
	?>
	
	  <script>
		alert( "USTED NO TIENE PERMISOS PARA INGRESAR A ESTA SECCION")
	location.href="selecciona_sala.php"
	
	  </script>
      <?php
	exit();
	}

  
//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		
				// nombre de evaluador
		 $query = "SELECT EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE
	FROM EMPLEADO EMP WHERE  EMP.EMP_CODIGO = '$cedingreso'" ;

		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch();	
		
		$nombreemp=$row['NOMBRE'];



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
   function guardarevaluacion (cedula, evaluador,  nota, fortalezas, debilidades, recomendacion, ap_conocimiento, ap_estudios, ap_presentacion, horarios, colaboracion, proylaboral, observ)
        {	alert(cedula)
				var parametros = {
				"cedula": cedula,
				"evaluador": evaluador,
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
                url: 'guardarevaluacion.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
						//alert("P R O C E S A D O")
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

 
<div id="accordion">
  
<h3>&nbsp;</h3>
<div>
  <p>
   <table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="80%" height="82%">
    <tr>
      <td  class="encabezados" colspan="4" align="left" valign="middle"><strong>Evaluador</strong></td> 
      <td width="612" colspan="6"  align="justify" bgcolor="#999999" class="header" ><label for="evaluador"></label>
      <input name="evaluador" type="text" id="evaluador" size="100" value="<?php echo $nombreemp?>"  readonly="readonly" /></td>      </tr>
    <tr>
      <td  class="encabezados" colspan="4" align="left" valign="middle">Evaluado</td>
      <td colspan="6"  align="justify" bgcolor="#999999" class="header" ><?php echo $nombre?></td>
    </tr> 
 <tr>
      <td class="encabezados" colspan="4" align="left" valign="middle"><strong>Nota de Evaluacion</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"> <label for="nota"></label>
        <label>
          <select name="nota" id="nota">
          <option value="A">A</option>
          <option value="B">B</option>
          <option value="C">C</option>
        </select>
    </label></td>  
     </tr>
      <tr>
      <td class="encabezados" colspan="4" align="left" bgcolor="#999999" valign="middle"><strong>Fortalezas</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><label for="fortalezas"></label>
        <input name="fortalezas" type="text" id="fortalezas" size="100"></td>
     </tr>
      <tr>
      <td class="encabezados" colspan="4" align="left"  bgcolor="#999999" valign="middle"><strong>Debilidades</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><input name="debilidades" type="text" id="debilidades" size="100"></td>
     </tr>

      <tr>
      <td class="encabezados" colspan="4" align="left" valign="middle"><strong>Recomendaciones</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><input name="recomendacion" type="text" id="recomendacion" size="100" ></td> 
     </tr>
      <tr>
      <td colspan="3" rowspan="3" align="left" bgcolor="#999999" valign="middle" class="encabezados"><strong>Aptitud</strong></td>
      <td width="208" align="left" valign="middle" class="header">Conocimiento del Producto/Puesto</td> 
      <td width="612" colspan="6" align="justify" bgcolor="#999999" valign="middle" class="header"><label>
        <select name="ap_conocimiento" id="ap_conocimiento">
         <option value="">Seleccione..</option>
          <option value="A">A</option>
          <option value="A+">A+</option>
          <option value="B">B</option>
          <option value="B+">B+</option>
          <option value="C">C</option>
        </select>
      </label></td> 
     </tr>
      <tr>
        <td class="header" align="left" valign="middle">Estudios</td>
        <td width="612" colspan="6" align="justify" bgcolor="#999999" valign="middle" class="header"><label>
          <select name="ap_estudios" id="ap_estudios">
            <option value="">Seleccione..</option>
          <option value="A">A</option>
          <option value="A+">A+</option>
          <option value="B">B</option>
          <option value="B+">B+</option>
          <option value="C">C</option>
          </select>
        </label></td>
      </tr>
      <tr>
        <td class="header" align="left" valign="middle">Presentacion</td>
        <td width="612" colspan="6" align="justify" bgcolor="#999999" valign="middle" class="header"><label>
          <select name="ap_presentacion" id="ap_presentacion">
            <option value="">Seleccione..</option>
          <option value="A">A</option>
          <option value="A+">A+</option>
          <option value="B">B</option>
          <option value="B+">B+</option>
          <option value="C">C</option>
          </select>
        </label></td>
      </tr>
      <tr>
      <td colspan="3" rowspan="2" align="left" valign="middle" class="encabezados"><strong>Actitud</strong></td>
      <td class="header" align="left" valign="middle">Horarios</td> 
      <td width="612" colspan="6" align="justify" bgcolor="#999999" valign="middle" class="header"><label>
        <select name="horarios" id="horarios">
          <option value="">Seleccione..</option>
          <option value="A">A</option>
          <option value="A+">A+</option>
          <option value="B">B</option>
          <option value="B+">B+</option>
          <option value="C">C</option>
        </select>
      </label></td> 
     </tr>
      <tr>
        <td class="header" align="left" valign="middle">Colaboracion</td>
        <td width="612" colspan="6" align="justify" bgcolor="#999999" valign="middle" class="header"><label>
          <select name="colaboracion" id="colaboracion">
            <option value="">Seleccione..</option>
          <option value="A">A</option>
          <option value="A+">A+</option>
          <option value="B">B</option>
          <option value="B+">B+</option>
          <option value="C">C</option>
          </select>
        </label></td>
      </tr>
    <tr>
      <td class="encabezados" colspan="4" align="left" valign="middle"><strong>Proyeccion Laboral</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><input name="proylaboral" type="text" id="proylaboral" size="100" ></td> 
  </tr>
      <tr>
      <td class="encabezados" colspan="4" align="left" valign="middle"><strong>Observaciones</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><input name="observ" type="text" id="observ" size="100" ></td> 
     </tr>
     
        <tr>
        <td height="28" colspan="4" align="left" valign="middle" class="header">&nbsp;</td>
        <td class="header" colspan="6" align="center" valign="middle"><input align="right" name="guardar" type="button" class="botones" onclick= "guardarevaluacion(<?php echo($cedulanueva); ?>, $('#evaluador').val(),  $('#nota').val(), $('#fortalezas').val(), $('#debilidades').val(), $('#recomendacion').val(), $('#ap_conocimiento').val(), $('#ap_estudios').val(), $('#ap_presentacion').val(), $('#horarios').val(), $('#colaboracion').val(), $('#proylaboral').val(), $('#observ').val());" id="guardar" value="GUARDAR" /></td>
  </tr>
  <tr>
	<td width="10"><A href="informe_sala.php?sala=<?php echo $sala;?>">REGRESAR</A>
    </td>
</tr> 

</table>

    </p>
  </div>

  
</div>
                
<footer style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold">

 </footer>
 
 

