<?php
//funcion fechas
require_once("FuncionFechas.php");

//recojo variables
$certificado=$_POST['certificado'];
$cedula=$_POST['cedula'];
$sucesion=$_POST['sucesion'];  //liliana
echo $sucesion;

//genero el encabezado
$encabezado='<center><span style="font-size:24px;; font-weight:bold"><br><br><br><br><br><br>LA JEFE DE GESTION HUMANA<br><br><br>
C E R T I F I C A:<br><br><br></span></center>';

//genero el pie de firma del certificado

$hoy=date("d/m/y");
$footer='<p>&nbsp;</p><p>&nbsp;</p>
<p align="left"  >La presente constancia se expide a solicitud del interesado el '.fechaletra($hoy).'</p>
<p>&nbsp;</p>
<p align="left">Cordialmente,  </p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p align="left"><b>FAIZULI LEON BERMUDEZ<br>  
Jefe de Gestión Humana</b></p>';



//switcheo que certificado es el que voy a generar
switch($certificado)
{
	case 'P1':
	    //conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		$query = "SELECT EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , EM.EMP_CODIGO, TC.TCO_NOMBRE,  
		EM.EMP_FECHA_INI_CONTRATO, EM.EMP_FECHA_RETIRO,   CA.CARGO_NOMBRE, sysdate as hoy
		FROM EMPLEADO EM, CARGO CA, TRH_TIPO_CONTRATO TC
		WHERE EM.EMP_CARGO = CA.CARGO_CODIGO AND EM.EMP_TIPO_CONTRATO = TC.TCO_CODIGO
		AND EM.EMP_CODIGO = '$cedula'";
		$stmt = $dbh->prepare($query);


		if ($stmt->execute()) {
			while ($row = $stmt->fetch()) {
				$row ['NOMBRE'];
				$row['EMP_CODIGO'];
				$cargo=utf8_encode($row['CARGO_NOMBRE']);
				$row['EMP_FECHA_INI_CONTRATO'];
				$fingreso=$row['EMP_FECHA_INI_CONTRATO'];
				$fretiro=$row['EMP_FECHA_RETIRO'];
				$row['TCO_NOMBRE'];
				//$hoy=$row['HOY'];
                //$hoy="21/09/2015";   		     
			
		if (empty($fretiro)) {
    			echo 'EL EMPLEADO AUN SE ENCUENTRA ACTIVO<br /> <br />'; 
				break;
			}
			 echo $encabezado;
			 echo '<p style="text-align: justify">Que el(a) señor(a)  <b>'.utf8_encode($row['NOMBRE']).' </b> identificado(a) con cedula de ciudadanía No. <b>'. number_format($row['EMP_CODIGO'],0,",",".").'</b>, labora para la empresa con contrato a   <b>'.$row['TCO_NOMBRE'].'</b> desde el día <b>'.fechaletra($fingreso).' </b> hasta el
  <b>'.fechaletra($fretiro).'</b> desempeñando el cargo <b>'.$cargo.'</b>.</p>';
  echo '<p style="text-align: justify"> La sociedad CERAMIGRES S.A.S. fue absorbida por fusion el 14 de Diciembre de 2015 por la sociedad MAXICASSA S.A.S.</p>'; 
			 echo $footer;
	      }
	   }
	break;
	
	case 'P2':
	//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		$query = "SELECT EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , EM.EMP_CODIGO,  TC.TCO_NOMBRE, EM.EMP_FECHA_INI_CONTRATO, CA.CARGO_NOMBRE,  
CF.COF_VALOR, (AC.ACUM_VALOR_LOCAL), to_number(MONTHS_BETWEEN(SYSDATE, EM.EMP_FECHA_INI_CONTRATO)) AS MES, sysdate as HOY
FROM EMPLEADO EM, CARGO CA, TRH_TIPO_CONTRATO TC, CONCEPTOS_FIJOS CF, TRH_ACUMULADO AC
WHERE EM.EMP_CARGO = CA.CARGO_CODIGO AND EM.EMP_TIPO_CONTRATO = TC.TCO_CODIGO
AND EM.EMP_CODIGO = CF.EMP_CODIGO 
AND EM.EMP_CODIGO = AC.EMP_CODIGO AND AC.CON_CODIGO = '506'
AND EM.EMP_CODIGO = '$cedula' and AC.ACUM_FECHA_PAGO > (sysdate - 365)";
$stmt = $dbh->prepare($query);


if ($stmt->execute()) {
	$suma=0;
	
    while ($row = $stmt->fetch()) {
		$nombre=$row['NOMBRE'];
		$codigo=$row['EMP_CODIGO'];
		$contrato=$row['TCO_NOMBRE'];	
		$fingreso=$row['EMP_FECHA_INI_CONTRATO'];
		$cargo=utf8_encode($row['CARGO_NOMBRE']);
		$salario=$row['COF_VALOR'];
		$divisor=$row['MES'];
		$suma=$suma + $row['ACUM_VALOR_LOCAL'];
		//$hoy=$row['HOY'];
   		 }
			if ($divisor<12) 
			{
			$total = $suma/$divisor;	
			}	
			else{$total = $suma/12;	
				}
			 echo $encabezado;
			   
			/*  if (empty($sucesion)) {
    			$fsesion = $fingreso;
				$fingreso = '01/01/16' ;
					}	*/
			 echo '<p style="text-align: justify">Que el(a) señor(a) <b>'.utf8_encode($nombre).'</b> identificado(a) con cedula de  ciudadanía No. <b>'.number_format($codigo,0,",",".").'</b>, laboró para la empresa con contrato a <b>'.$contrato.'</b>  desde el día  <b>'.fechaletra($fingreso).'</b>  desempeña el cargo <b>'.$cargo.'</b>,  devenga un salario mensual   por valor de $<b>'.number_format($salario,0,",",".").'</b> , recibe un auxilio de alimentacion promedio no constitutivo al  salario ni factor prestacional de $<b>'.number_format($total,0,",",".").'</b></p>';
			 
			 if (empty($sucesion)) {

    		echo '<p style="text-align: justify"> La sociedad CERAMIGRES S.A.S. fue absorbida por fusion el 14 de Diciembre de 2015 por la sociedad MAXICASSA S.A.S.</p>'; 
					}
   			 echo $footer;
	      
	   }
	break;
	case 'P3':
	    //conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		$query = "SELECT EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , EM.EMP_CODIGO, TC.TCO_NOMBRE, EM.EMP_FECHA_INI_CONTRATO,   CA.CARGO_NOMBRE, 
CF.COF_VALOR, NF.NOVF_VALOR, sysdate as HOY
FROM EMPLEADO EM, CARGO CA, TRH_TIPO_CONTRATO TC, CONCEPTOS_FIJOS CF, TRH_NOV_FIJAS NF
WHERE EM.EMP_CARGO = CA.CARGO_CODIGO AND EM.EMP_TIPO_CONTRATO = TC.TCO_CODIGO
AND EM.EMP_CODIGO = CF.EMP_CODIGO AND EM.EMP_CODIGO = NF.EMP_CODIGO AND NF.CON_CODIGO = '506' AND EM.EMP_CODIGO = '$cedula'";

$stmt = $dbh->prepare($query);


if ($stmt->execute()) {
    while ($row = $stmt->fetch()) {
        $row['NOMBRE']."<br />";
		$row['EMP_CODIGO']."<br />";
		$row['TCO_NOMBRE']."<br />";
		$fingreso=$row['EMP_FECHA_INI_CONTRATO'];
		$cargo=utf8_encode($row['CARGO_NOMBRE']);		
		$row['COF_VALOR']."<br />";			
		$row['NOVF_VALOR']."<br />";
		$hoy=$row['HOY']; 
			 
			 echo $encabezado;
			 
			/* if (empty($sucesion)) {
    			$fsesion = $fingreso;
				$fingreso = '01/01/16' ;
					}	*/
		 
		 echo '<p style="text-align: justify">Que el(a) señor(a) <b>'.utf8_encode(str_replace("?","&Ntilde",$row['NOMBRE'])).'</b> identificado(a) con 								cedula de ciudadanía No. <b>'.number_format($row['EMP_CODIGO'],0,",",".").'</b>, labora para la empresa con contrato a <b>'.$row['TCO_NOMBRE'].'</b>  desde el día <b>'.fechaletra($fingreso).'</b> desempeña el cargo <b>'.$cargo.'</b>, devenga un salario mensual por valor de $<b>'.number_format($row['COF_VALOR'],0,",",".").'</b> y recibe un auxilio de Alimentación mensual no constitutivo de salario ni factor prestacional 
		de $<b>'.number_format($row['NOVF_VALOR'],0,",",".").'</b>.</span></p>';

		if (empty($sucesion)) {
    		
    		echo '<p style="text-align: justify"> La sociedad CERAMIGRES S.A.S. fue absorbida por fusion el 14 de Diciembre de 2015 por la sociedad MAXICASSA S.A.S.</p>'; 
					}	
   			 echo $footer;			 
			 
	     }
	   }
	break;
	case 'P4':
	    //conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		$query = "SELECT EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , EM.EMP_CODIGO,  TC.TCO_NOMBRE, EM.EMP_FECHA_INI_CONTRATO, 
CA.CARGO_NOMBRE,   CF.COF_VALOR, AC.ACUM_FECHA_PAGO,
CO.CON_NOMBRE, (AC.ACUM_VALOR_LOCAL), to_number(MONTHS_BETWEEN(SYSDATE, EM.EMP_FECHA_INI_CONTRATO)) AS MES,
(select AC.ACUM_VALOR_LOCAL 
from  TRH_ACUMULADO AC
where AC.CON_CODIGO = '508' and AC.EMP_CODIGO =  EM.EMP_CODIGO and acum_consecutivo = (select max(acum_consecutivo) from  TRH_ACUMULADO AC
where AC.CON_CODIGO = '508' and AC.EMP_CODIGO =  EM.EMP_CODIGO ))  as roda, sysdate as HOY
FROM EMPLEADO EM, CARGO CA, TRH_TIPO_CONTRATO TC,  TRH_ACUMULADO AC, CONCEPTOS CO, CONCEPTOS_FIJOS CF
WHERE EM.EMP_CARGO = CA.CARGO_CODIGO AND EM.EMP_TIPO_CONTRATO = TC.TCO_CODIGO AND AC.CON_CODIGO = CO.CON_CODIGO
AND EM.EMP_CODIGO = CF.EMP_CODIGO
AND EM.EMP_CODIGO = AC.EMP_CODIGO AND CO.CON_NOMBRE LIKE '%COMIS%' 
AND EM.EMP_CODIGO = '$cedula' and AC.ACUM_FECHA_PAGO > (sysdate - 365)
ORDER BY AC.ACUM_FECHA_PAGO";

$stmt = $dbh->prepare($query);


if ($stmt->execute()) {
	
	$suma=0;
	
    while ($row = $stmt->fetch()) {
        $nombre=$row['NOMBRE'];
		$codigo=$row['EMP_CODIGO'];
		$contrato=$row['TCO_NOMBRE'];
		$fingreso=$row['EMP_FECHA_INI_CONTRATO'];
		$cargo=utf8_encode($row['CARGO_NOMBRE']);
		$salario=$row['COF_VALOR'];
		$divisor=$row['MES'];
		$suma=$suma + $row['ACUM_VALOR_LOCAL'];
		$rodamiento=$row['RODA'];
		$hoy=$row['HOY'];
   			}
			
			 $encabezado;
			
  if (empty($divisor)) {
    			echo 'EL EMPLEADO NO RECIBE COMISION <br /> <br />'; 
				break;
			}

		
			if ($divisor<12) 			
			{
			//echo $suma; echo $divisor;
			$total = $suma/$divisor;
			}
			else{$total = $suma/12;	
			}
		 echo $encabezado;
	
			/* if (empty($sucesion)) {
    			$fsesion = $fingreso;
			//	$fingreso = '01/01/16' ;
					}	 */

		 echo '<p style="text-align: justify">Que el(a) señor(a) <b>'.utf8_encode($nombre).'</b> identificado(a) con cedula de 
   ciudadanía No. <b>'.number_format($codigo,0,",",".").'</b> , labora para la empresa con contrato a <b>'.$contrato.'</b> desde el día  <b>'.fechaletra($fingreso).'</b>,  desempeña el cargo <b>'.$cargo.'</b>,  devenga un salario mensual  por valor de $<b>'.number_format($salario,0,",",".").'</b>,  recibe una comision promedio mensual de $
  <b>'.number_format($total,0,",",".").'</b> y un auxilio de rodamiento por $<b>'.number_format($rodamiento,0,",",".").'</b>.</p>';
  
  	 if (empty($sucesion)) {
    		
    		echo '<p style="text-align: justify"> La sociedad CERAMIGRES S.A.S. fue absorbida por fusion el 14 de Diciembre de 2015 por la sociedad MAXICASSA S.A.S.</p>'; 
					}
   			 echo $footer;
	      
	}	  
	 break;
	
	case 'P5':
	    //conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		$query = "SELECT EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , EM.EMP_CODIGO,  TC.TCO_NOMBRE, EM.EMP_FECHA_INI_CONTRATO, 
CA.CARGO_NOMBRE,   CF.COF_VALOR, AC.ACUM_FECHA_PAGO,
CO.CON_NOMBRE, (AC.ACUM_VALOR_LOCAL), to_number(MONTHS_BETWEEN(SYSDATE, EM.EMP_FECHA_INI_CONTRATO)) AS MES, sysdate as HOY
FROM EMPLEADO EM, CARGO CA, TRH_TIPO_CONTRATO TC,  TRH_ACUMULADO AC, CONCEPTOS CO, CONCEPTOS_FIJOS CF
WHERE EM.EMP_CARGO = CA.CARGO_CODIGO AND EM.EMP_TIPO_CONTRATO = TC.TCO_CODIGO AND AC.CON_CODIGO = CO.CON_CODIGO
AND EM.EMP_CODIGO = CF.EMP_CODIGO
AND EM.EMP_CODIGO = AC.EMP_CODIGO AND CO.CON_NOMBRE LIKE '%COMIS%' 
AND EM.EMP_CODIGO = '$cedula' and AC.ACUM_FECHA_PAGO > (sysdate - 365)
ORDER BY AC.ACUM_FECHA_PAGO";

$stmt = $dbh->prepare($query);


if ($stmt->execute()) {
	
	$suma=0;
	
    while ($row = $stmt->fetch()) {
        $nombre=$row['NOMBRE'];
		$codigo=$row['EMP_CODIGO'];
		$contrato=$row['TCO_NOMBRE'];
		$fingreso=$row['EMP_FECHA_INI_CONTRATO'];
		$cargo=utf8_encode($row['CARGO_NOMBRE']);
		$salario=$row['COF_VALOR'];
		$divisor=$row['MES'];
		$suma=$suma + $row['ACUM_VALOR_LOCAL'];
		$hoy=$row['HOY'];
			}
			 if (empty($divisor)) {
    			echo 'EL EMPLEADO NO RECIBE COMISION <br /> <br />'; 
				break;
				}
		
		
			if ($divisor<12) 
			{
				$total = $suma/$divisor;	
			}	
			else{$total = $suma/12;	
				}	
	
			 
			 echo $encabezado;
			 
			 /*	 if (empty($sucesion)) {
    			$fsesion = $fingreso;
				$fingreso = '01/01/16' ;
					}	 	 */
			 
			 
		 echo '<p style="text-align: justify">Que el(a) señor(a) <b>'.utf8_encode($nombre).'</b> identificado(a) con cedula de 
   ciudadanía No. <b>'.number_format($codigo,0,",",".").'</b> , labora para la empresa con contrato a <b>'.$contrato.'</b> desde el día <b>'.fechaletra($fingreso).'</b>,  desempeña el cargo <b>'.$cargo.'</b>,  devenga un salario mensual 
  por valor de $<b>'.number_format($salario,0,",",".").'</b>,  recibe una comision promedio mensual de
  $<b>'.number_format($total,0,",",".").'</b>.</p>';
   
  //LETRERO SI ES SUCESION
  if (empty($sucesion)) {
    		
    		echo '<p style="text-align: justify"> La sociedad CERAMIGRES S.A.S. fue absorbida por fusion el 14 de Diciembre de 2015 por la sociedad MAXICASSA S.A.S.</p>'; 
					}	
   			 echo $footer;
		 
	 }   
	break;
	case 'P6':
	    //conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		$query = "SELECT EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , EM.EMP_CODIGO, EM.EMP_FECHA_RETIRO, CC.CCOS_VAL_ALF1, 
CA.CARGO_NOMBRE, sysdate as HOY, trim(LO.NOMBRE_LOCALIDAD) as LOCALIDAD
FROM EMPLEADO EM, CARGO CA, CENTRO_COSTO CC, LOCALIDAD LO
WHERE EM.EMP_CARGO = CA.CARGO_CODIGO AND EM.EMP_CC_CONTABLE = CC.CENCOS_CODIGO AND EM.EMP_LOCALIDAD = LO.COD_LOCALIDAD
AND EM.EMP_CODIGO = '$cedula'";

$stmt = $dbh->prepare($query);

if ($stmt->execute()) {
    while ($row = $stmt->fetch()) {
        $row['NOMBRE'];
		$row['EMP_CODIGO'];
		$cargo=utf8_encode($row['CARGO_NOMBRE']);
	    $fretiro = $row['EMP_FECHA_RETIRO'];
		$row['CCOS_VAL_ALF1'];;
		$hoy=$row['HOY'];
		$ciudad=$row['LOCALIDAD'];

		
			 echo '<p align="left">'.$ciudad.','.fechaletra($hoy).'<br />
			<br />
			<br />
			Señores:<br />
			<strong>UNIMSALUD</strong><br />
			  Ciudad.
			<br />
			<br />
		  Estimados señores:<br /></p>
		  <p style="text-align: justify">Comedidamente  solicitamos se practique el examen de la
		  referencia para la persona indicada a continuación, dentro de los cinco (5) días siguientes a la fecha de            entrega de  esta orden:</p>
			<br />
			<p align="left">
			  NOMBRE:<b>      '.utf8_encode($row['NOMBRE']).'</b><br />
			  C.C.            '.number_format($row['EMP_CODIGO'],0,",",".").'<br />
			  CARGO:          '.$cargo.'<br />;
			  UBICACIÓN:      '.$row['CCOS_VAL_ALF1'].'<br />
			  FECHA DE RETIRO:'.fechaletra($fretiro).'</p>';
		}
 	}     
	break;
	case 'P7':
	    //conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		$query = "SELECT EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , EM.EMP_CODIGO, EM.EMP_FECHA_RETIRO, sysdate as HOY,
 ES.ENT_NOMBRE_ASOCIADO, trim(LO.NOMBRE_LOCALIDAD) as LOCALIDAD
FROM EMPLEADO EM, CARGO CA, CENTRO_COSTO CC, COBXEMP CE, ENTIDADES_SERV ES, LOCALIDAD LO
WHERE EM.EMP_CARGO = CA.CARGO_CODIGO AND EM.EMP_CC_CONTABLE = CC.CENCOS_CODIGO AND EM.EMP_CODIGO = CE.EMP_CODIGO AND CE.ENT_CODIGO = ES.ENT_CODIGO
AND CE.TENT_CODIGO = 'FCES' AND EM.EMP_CODIGO = '$cedula' AND EM.EMP_LOCALIDAD = LO.COD_LOCALIDAD";

$stmt = $dbh->prepare($query);

if ($stmt->execute()) {
    while ($row = $stmt->fetch()) {
        $row['NOMBRE'];
		$row['EMP_CODIGO'];
		$row['ENT_NOMBRE_ASOCIADO'];
		$hoy=$row['HOY'];
		$ciudad=$row['LOCALIDAD'];	
				 
		// echo $encabezado;
	 echo '<p align="left">'.$ciudad.', '.fechaletra($hoy).'<br />
			<br />
			<br />
			Señores:<br />
	  FONDO  DE PENSIONES Y CESANTIAS<br />
      <b>'.$row['ENT_NOMBRE_ASOCIADO'].'</b><br />
      Ciudad.</p>
      <br />
	  <br />
      <p align="left"><b>REF. AUTORIZACION PAGO PARCIAL DE CESANTIAS</b></p>
      <br />
	  <br />
      <p style="text-align: justify">
	  Respetados señores:
      <br />
	  <br />
	  De conformidad con lo establecido en el artículo 21 de la Ley 1429 de 2.010, el cual 
	  modifico el numeral 3 del artículo 265 del codigo Sustantivo del Trabajo, solicito a la entidad 
	  que usted representa el pago del retiro de cesantias del trabajador</p>
	  
	  <p align="left">
			  NOMBRE EMPLEADO:<b>         '.utf8_encode($row['NOMBRE']).'</b><br />
			  IDENTIFICACION:<b>             '.number_format($row['EMP_CODIGO'],0,",",".").'</b><br />
			  VALOR CESANTIAS SOLICITADO:<b> '.$valorcesantias=$_POST['val'].'</b><br />
			  INVERION o DESTINO:<b>         '.$destinocesantias=$_POST['des'].'</b><br />  <br />
 	<p style="text-align: justify">La empresa se compromete a verificar y vigilar, la correcta destinación de las cesantias en cumplimiento de la obligación prevista en la Ley</p>
		<br />
      <p align="left">Cordialmente,
      <br />
	   <br />
	   <br />
       <br />
      <strong>FAIZULI LEON BERMUDEZ </strong><br />
		C.C. No. 52.243.78 <br />
    Jefe de Gestión Humana</p>';
		}
    }
	break;
	
	case 'P8':
	    //conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		$query = "SELECT EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , EM.EMP_CODIGO, EM.EMP_FECHA_RETIRO,  
 sysdate as HOY, ES.ENT_NOMBRE_ASOCIADO, LO.NOMBRE_LOCALIDAD
FROM EMPLEADO EM,  COBXEMP CE, ENTIDADES_SERV ES, LOCALIDAD LO
WHERE EM.EMP_CODIGO = CE.EMP_CODIGO AND CE.ENT_CODIGO = ES.ENT_CODIGO
AND CE.TENT_CODIGO = 'FCES' AND EM.EMP_CODIGO = '$cedula' AND EM.EMP_LOCALIDAD = LO.COD_LOCALIDAD";

$stmt = $dbh->prepare($query);

if ($stmt->execute()) {
    while ($row = $stmt->fetch()) {
        $row['NOMBRE']."<br />";
		$row['EMP_CODIGO']."<br />";
		$fretiro=$row['EMP_FECHA_RETIRO']."<br />";
		$row['ENT_NOMBRE_ASOCIADO']."<br />";
		$hoy=$row['HOY'];
		$ciudad=$row['NOMBRE_LOCALIDAD'];
		
		
	if (empty($fretiro)) {
    			echo 'EL EMPLEADO AUN SE ENCUENTRA ACTIVO<br /> <br />'; 
				break;
			}				

			// echo $encabezado;
	 echo '<p align="left">'.$ciudad.','.fechaletra($hoy).'<br />
			<br />
			<br />
			<br />
			Señores:<br />
	  FONDO  DE PENSIONES Y CESANTIAS<br />
      <b>'.$row['ENT_NOMBRE_ASOCIADO'].'</b><br />
      Ciudad.</p>
		<br />
		<br />
      <p align="right"><b>REF. RETIRO DEFINITIVO DE CESANTIAS</b></p>
      <p style="text-align: justify">La  presente con el fin de autorizar el retiro de las cesantías definitivas consignadas en ese fondo del (la) señor (a) <b>'.utf8_encode($row['NOMBRE']).'</b> identificado(a) con cédula de ciudadanía número  <b>'.number_format($row['EMP_CODIGO'],0,",",".").'</b> quien laboró hasta el día
	  <b>'.fechaletra($fretiro).'</b> </b></p>
      <br />
      <p align="left">Atentamente,
      <br />
	  <br />
	  <br />
	  <br />
      <strong>FAIZULI LEON BERMUDEZ </strong><br />
    Jefe de Gestión Humana</p>';
		}
 	}
	break;
	case 'P9':
	    //conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		$query = "SELECT EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , EM.EMP_CODIGO,  TC.TCO_NOMBRE, EM.EMP_FECHA_INI_CONTRATO, 
CA.CARGO_NOMBRE,  
 CF.COF_VALOR, NF.NOVF_VALOR, AC.ACUM_FECHA_PAGO,
CO.CON_NOMBRE, (AC.ACUM_VALOR_LOCAL), to_number(MONTHS_BETWEEN(SYSDATE, EM.EMP_FECHA_INI_CONTRATO)) AS MES, sysdate as HOY
FROM EMPLEADO EM, CARGO CA, TRH_TIPO_CONTRATO TC,  TRH_ACUMULADO AC, CONCEPTOS CO, CONCEPTOS_FIJOS CF, TRH_NOV_FIJAS NF
WHERE EM.EMP_CARGO = CA.CARGO_CODIGO AND EM.EMP_TIPO_CONTRATO = TC.TCO_CODIGO AND AC.CON_CODIGO = CO.CON_CODIGO
AND EM.EMP_CODIGO = CF.EMP_CODIGO
AND EM.EMP_CODIGO = AC.EMP_CODIGO AND CO.CON_NOMBRE LIKE '%COMIS%' 
AND EM.EMP_CODIGO = NF.EMP_CODIGO AND NF.CON_CODIGO = '506'
AND EM.EMP_CODIGO = '$cedula' and AC.ACUM_FECHA_PAGO > (sysdate - 365)
ORDER BY AC.ACUM_FECHA_PAGO";

$stmt = $dbh->prepare($query);


if ($stmt->execute()) {
	
	$suma=0;
	
    while ($row = $stmt->fetch()) {
        $nombre=$row['NOMBRE'];
		$codigo=$row['EMP_CODIGO'];
		$contrato=$row['TCO_NOMBRE'];
		$fingreso=$row['EMP_FECHA_INI_CONTRATO'];
		$cargo=utf8_encode($row['CARGO_NOMBRE']);
		$salario=$row['COF_VALOR'];
		$auxalimentacion=$row['NOVF_VALOR'];
		$divisor=$row['MES'];
		$suma=$suma + $row['ACUM_VALOR_LOCAL'];
		$hoy=$row['HOY'];
			}
			 if (empty($divisor)) {
    			echo 'EL EMPLEADO NO RECIBE COMISION <br /> <br />'; 
				break;
				}
		
		
			if ($divisor<12) 
			{
				$total = $suma/$divisor;	
			}	
			else{$total = $suma/12;	
				}	
	
			 
			 echo $encabezado;
			 
			 /*	 if (empty($sucesion)) {
    			$fsesion = $fingreso;
				$fingreso = '01/01/16' ;
					}	 	 */
			 
			 
		 echo '<p style="text-align: justify">Que el(a) señor(a) <b>'.utf8_encode($nombre).'</b> identificado(a) con cedula de 
   ciudadanía No. <b>'.number_format($codigo,0,",",".").'</b> , labora para la empresa con contrato a <b>'.$contrato.'</b> desde el día <b>'.fechaletra($fingreso).'</b>,  desempeña el cargo <b>'.$cargo.'</b>,  devenga un salario mensual por valor de $<b>'.number_format($salario,0,",",".").'</b> y  una comision promedio mensual de  $<b>'.number_format($total,0,",",".").'</b>  y  un auxilio de alimentacion mensual de  $<b>'.number_format($auxalimentacion,0,",",".").'</b></p>';
   
   //, un auxilio de alimentacion mensual por valor de $<b>'.number_format($auxalimentacion,0,",",".").'</b>
   // y  una comision promedio mensual de  $<b>'.number_format($total,0,",",".").'</b>.
  //LETRERO SI ES SUCESION
  if (empty($sucesion)) {
    		
    		echo '<p style="text-align: justify"> La sociedad CERAMIGRES S.A.S. fue absorbida por fusion el 14 de Diciembre de 2015 por la sociedad MAXICASSA S.A.S.</p>'; 
					}	
   			 echo $footer;
		 
	 }   
	break;
case 'P10':
	    //conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		
		
			$query5 = "SELECT  NF.NOVF_VALOR
FROM EMPLEADO EM, CONCEPTOS_FIJOS CF, TRH_NOV_FIJAS NF
WHERE EM.EMP_CODIGO = CF.EMP_CODIGO AND EM.EMP_CODIGO = NF.EMP_CODIGO AND NF.CON_CODIGO = '508' AND EM.EMP_CODIGO = '$cedula'";
		$stmt5 = $dbh->prepare($query5);
		$stmt5->execute();
		$row_n = $stmt5->fetch();
			
		
		$query = "SELECT EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , EM.EMP_CODIGO, TC.TCO_NOMBRE, EM.EMP_FECHA_INI_CONTRATO,   CA.CARGO_NOMBRE, 
 NF.CON_CODIGO, CF.COF_VALOR, NF.NOVF_VALOR, sysdate as HOY
FROM EMPLEADO EM, CARGO CA, TRH_TIPO_CONTRATO TC, CONCEPTOS_FIJOS CF, TRH_NOV_FIJAS NF
WHERE EM.EMP_CARGO = CA.CARGO_CODIGO AND EM.EMP_TIPO_CONTRATO = TC.TCO_CODIGO
AND EM.EMP_CODIGO = CF.EMP_CODIGO AND EM.EMP_CODIGO = NF.EMP_CODIGO AND NF.CON_CODIGO = '506' AND EM.EMP_CODIGO = '$cedula'"; 

$stmt = $dbh->prepare($query);
if ($stmt->execute()) {
    while ($row = $stmt->fetch()) {
		
        $row['NOMBRE']."<br />";
		$row['EMP_CODIGO']."<br />";
		$row['TCO_NOMBRE']."<br />";
		$fingreso=$row['EMP_FECHA_INI_CONTRATO'];
		$cargo=utf8_encode($row['CARGO_NOMBRE']);		
		$row['COF_VALOR']."<br />";			
		$row['NOVF_VALOR']."<br />";
		$hoy=$row['HOY']; 
	
			 
			 echo $encabezado;
			 
			/* if (empty($sucesion)) {
    			$fsesion = $fingreso;
				$fingreso = '01/01/16' ;
					}	*/
		 
		 echo '<p style="text-align: justify">Que el(a) señor(a) <b>'.utf8_encode(str_replace("?","&Ntilde",$row['NOMBRE'])).'</b> identificado(a) con 								cedula de ciudadanía No. <b>'.number_format($row['EMP_CODIGO'],0,",",".").'</b>, labora para la empresa con contrato a <b>'.$row['TCO_NOMBRE'].'</b>  desde el día <b>'.fechaletra($fingreso).'</b> desempeña el cargo <b>'.$cargo.'</b>, devenga un salario mensual por valor de $<b>'.number_format($row['COF_VALOR'],0,",",".").'</b> y recibe un auxilio de Alimentación por valor de $<b>'.number_format($row['NOVF_VALOR'],0,",",".").'</b> mensual y un auxilio de Rodamiento por valor de $<b>'.number_format($row_n['NOVF_VALOR'],0,",",".").'</b> mensual los cuales no son constitutivo de salario ni factor prestacional.</span></p>';

		if (empty($sucesion)) {
    		
    		echo '<p style="text-align: justify"> La sociedad CERAMIGRES S.A.S. fue absorbida por fusion el 14 de Diciembre de 2015 por la sociedad MAXICASSA S.A.S.</p>'; 
					}	
   			 echo $footer;			 
			 
	     }
		 
	   }
	break;
}


?>

