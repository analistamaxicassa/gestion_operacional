
<?php 


error_reporting(0);
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
//echo $cedulanueva=$_POST['cedula'];
$cedulanueva= $_REQUEST['cedula'];


session_start();
	



if($_SESSION['us'] == '1') {
	
	?>
	
	  <script>
		alert( "USTED NO TIENE PERMISOS PARA INGRESAR A ESTA SECCION")
	location.href="selecciona_sala.php"
	
	  </script>
      <?php
	exit();
	}

	//consulta tabla cliente interno
	$sql1="SELECT * FROM `cliente_interno` where cedula = '$cedulanueva' ";
			$qry_sql1=$link->query($sql1);
			$rs_qry1=$qry_sql1->fetch_object();  ///consultar 

		if (empty($rs_qry1)) {
		$sql3="INSERT INTO `personal`.`cliente_interno` (`ID`, `sala`, `cedula`, `educacion`, `hijosyedades`, `motivacion`, `proyeccion`, `ayudas`) VALUES (NULL, NULL, '$cedulanueva', NULL, NULL, NULL, NULL, NULL);";
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
   function guardardpersonal (cedula,sala, hijos_edades, educacion, q_lo_motiva, proyecciones, ayudas)
        {	
				var parametros = {
				"cedula": cedula,
				"cc": sala,
				"hijos_edades": hijos_edades,
				"educacion": educacion,
				"q_lo_motiva": q_lo_motiva,
				"proyecciones": proyecciones,
				"ayudas": ayudas,
				};
                $.ajax({
                data: parametros,
                url: 'guardardpersonales.php',
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
<div id="respuesta"></div>

<div id="accordion">
  
<h2>ACTUALIZACION DE DATOS PERSONALES</h2>
  <div>
    <p>
    <table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="80%" height="82%">
    

    
         <tr>
           <td height="27" colspan="4" align="left" valign="middle" class="encabezados"><strong>Sala</strong></td>
           <td class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><label for="ccsala" ></label>
             <select name="sala" id="sala">
              <option value="<?php echo utf8_encode($rs_qry1->sala); ?>"><?php echo utf8_encode($rs_qry1->sala); ?></option>
              <option value="555">CERAAGUACHICA</option>
              <option value="521">CERAALCIBIA</option>
              <option value="641">CERAARMENIA</option>
              <option value="742">CERAATALAYA</option>
              <option value="701">CERABUCARAMANGA</option>
              <option value="501">CERABARRANQUILLA</option>
              <option value="402">CERABELLO</option>
              <option value="105">CERABOSA</option>
              <option value="201">CERACALI</option>
              <option value="802">CERADUITAMA</option>
              <option value="523">CERA EL EDEN</option>
              <option value="151">CERAGIRARDOT</option>
              <option value="552">CERAGUATAPURI</option>
              <option value="822">CERAIBAGUE</option>
              <option value="821">CERAJARDIN</option>
              <option value="554">CERAKENNEDY</option>
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
              <option value="T736">TU CASSA BUCARAMANGA</option>
              <option value="T143">TU CASSA CARVAJAL</option>
              <option value="T518">TU CASSA MALAMBO</option>
              <option value="099">ADMON MAXICASSA</option>
              <option value="P099">PEGOMAX</option>
              <option value="I099">INNOVAPACK</option>
      </select>
              <label for="centrodecosto"></label>
           <input type="text" name="centrodecosto" id="centrodecosto" size="50" value="<?php echo utf8_encode($cc); ?>"></td>
         </tr>
         <td height="27" colspan="4" align="left" valign="middle" class="encabezados"><strong>Hijos y edades</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"> <label for="hijos_edades"></label>
      <input name="hijos_edades" type="text" id="hijos_edades" size="100" value="<?php echo utf8_encode($rs_qry1->hijosyedades); ?>"></td>  
     </tr>
      <tr>
      <td height="26" colspan="4" align="left" valign="middle" bgcolor="#999999" class="encabezados"><strong>Educacion</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><label for="educacion"></label>
        <input name="educacion" type="text" id="educacion" size="100" value="<?php echo utf8_encode($rs_qry1->educacion); ?>"></td>
     </tr>
      <tr>
      <td height="32" colspan="4" align="left" valign="middle"  bgcolor="#999999" class="encabezados"><strong>Que lo motiva</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><input name="q_lo_motiva" type="text" id="q_lo_motiva" size="100" value="<?php echo utf8_encode($rs_qry1->motivacion); ?>"></td>
     </tr>

      <tr>
      <td height="26" colspan="4" align="left" valign="middle" class="encabezados"><strong>Proyecciones</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><label for="proyecciones"></label>
       
        <input type="text" name="proyecciones" id="proyecciones" size="100" value="<?php echo utf8_encode($rs_qry1->proyeccion); ?>"></td> 
     </tr>
      <tr>
      <td height="73" colspan="4" align="left" valign="middle" class="encabezados"><strong>Ayudas reciibidas por la empresa</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><label for="ayudas"></label>
      
        <input type="text" name="ayudas" id="ayudas" size="100" value="<?php echo utf8_encode($rs_qry1->ayudas); ?>"></td> 
  </tr>
     
     
        <tr>
        <td height="28" colspan="4" align="left" valign="middle" class="header">&nbsp;</td>
        <td class="header" colspan="6" align="center" valign="middle"><input align="right" name="guardar" type="button" class="botones" onclick= "guardardpersonal(<?php echo($cedulanueva); ?>,  $('#sala').val(),  $('#hijos_edades').val(), $('#educacion').val(), $('#q_lo_motiva').val(), $('#proyecciones').val(), $('#ayudas').val());" id="guardar" value="GUARDAR" /></td>
  </tr>
</table>

    </p>
  </div>
</div>
                
<footer style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold">

 </footer>
 
 

