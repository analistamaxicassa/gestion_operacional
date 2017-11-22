<?php

//recojo variables
$cedula=$_POST['cedula'];
$anio=$_POST['anio'];
$mes=$_POST['mes'];

//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}

//conexion tabla de retencion
		require_once('conecrete.php');
		
		
		//objeto para manipulacion de datos
		$link = Conectarse();

			
		$uvt = 28279;
		$anioant = $anio - 1 ;
		
		$query = "SELECT EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE, EM.EMP_PORC_RET
		FROM EMPLEADO EM
		WHERE EM.EMP_CODIGO = '$cedula'";
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row_n = $stmt->fetch();
		

		$row_n['EMP_PORC_RET'];
		
		
		$query_salario = "select  SUM(AC.NOMI_VALOR_LOCAL) NOMI_VALOR_LOCAL  from trh_nomina ac  
						where AC.NOMI_ANO = '$anio' and AC.NOMI_MES = '$mes' AND AC.CON_CODIGO in ('1','2','3','145') and 											                          AC.EMP_CODIGO = '$cedula'";
		$stmt = $dbh->prepare($query_salario);
		$stmt->execute();
		$row = $stmt->fetch();
		
		$row['NOMI_VALOR_LOCAL'];
	
	    $query_bonos = "select  AC.NOMI_VALOR_LOCAL BONOS from trh_nomina ac, CON_GRUPO GR, EMPLEADO EM 
						where AC.CON_CODIGO = GR.CON_CODIGO AND EM.EMP_CODIGO = AC.EMP_CODIGO AND 																				                        EM.EMP_TIPO_NOMINA = GR.CON_TIPO_EMP AND
                        AC.NOMI_ANO = '$anio' and AC.NOMI_MES = '$mes' and ac.EMP_CODIGO = '$cedula' AND 			                         GR.CON_GRUPO  = '208' UNION
                         select  AC.NOMI_VALOR_LOCAL bonos from trh_nomina ac  
                         where AC.NOMI_ANO = '$anio' and AC.NOMI_MES = '$mes' and ac.EMP_CODIGO = '$cedula' AND                         AC.CON_CODIGO = '502'";

			$stmt = $dbh->prepare($query_bonos);
			$row_bono = $stmt->fetch();
		
		if ($stmt->execute()) 
			{
				$suma=0;
			   		 while ($row_bono = $stmt->fetch()) 
					 {
					      	$suma=$suma + $row_bono['BONOS'];
		   			 }
			} 
		
		
		   $query_bonosAC = "select  AC.ACUM_VALOR_LOCAL BONOS from trh_acumulado ac, CON_GRUPO GR, EMPLEADO EM 
						where AC.CON_CODIGO = GR.CON_CODIGO AND EM.EMP_CODIGO = AC.EMP_CODIGO AND 																				                        EM.EMP_TIPO_NOMINA = GR.CON_TIPO_EMP AND
                        AC.ACUM_ANO = '$anio' and AC.ACUM_MES = '$mes' and ac.EMP_CODIGO = '$cedula' AND 			                         GR.CON_GRUPO  = '208' UNION
                         select  AC.ACUM_VALOR_LOCAL bonos from trh_acumulado ac  
                         where AC.ACUM_ANO = '$anio' and AC.ACUM_MES = '$mes' and ac.EMP_CODIGO = '$cedula' AND                         AC.CON_CODIGO = '502'";

			$stmtAC = $dbh->prepare($query_bonosAC);
			$row_bonoAC = $stmtAC->fetch();
		
		if ($stmtAC->execute()) 
			{
				$sumaAC=0;
			   		 while ($row_bonoAC = $stmtAC->fetch()) 
					 {
					      	$sumaAC=$sumaAC + $row_bonoAC['BONOS'];
		   			 }
			} 
		
		
		
		
		$query_auxroda = "select  AC.ACUM_VALOR_LOCAL RODAMIENTO  from trh_acumulado ac  
                         where AC.ACUM_ANO = '$anio' and AC.ACUM_MES = '$mes' and AC.EMP_CODIGO = '$cedula' AND                         AC.CON_CODIGO = '508'";
		$stmt = $dbh->prepare($query_auxroda);
		$stmt->execute();
		$row_roda = $stmt->fetch();
		$row_roda['RODAMIENTO'];
		
		
		
	
 	    $query_2014 = "Select MVR_VALOR_CERTIFICADO from (select * from MENOR_VALOR_RETENCION MVR WHERE                       MVR.MVR_EMP_CODIGO = '$cedula' and MVR.MVR_TIPO = '2' order by MVR.MVR_FECHA_DESDE  desc ) where  rownum = 1"; 
		$stmt = $dbh->prepare($query_2014);
		$stmt->execute();
		$row_2014 = $stmt->fetch();
		$row_2014['MVR_VALOR_CERTIFICADO'];
		
		$query_depend = "Select MVR_VALOR_CERTIFICADO from (select * from MENOR_VALOR_RETENCION MVR WHERE                       MVR.MVR_EMP_CODIGO = '$cedula'  and MVR.MVR_TIPO = '5' order by MVR.MVR_FECHA_DESDE  desc )                      where  rownum = 1"; 
		$stmt = $dbh->prepare($query_depend);
		$stmt->execute();
		$row_depend = $stmt->fetch();
		$row_depend['MVR_VALOR_CERTIFICADO'];
		
		
		
		
	   $query_prom2014 = "select  (sum(AC.ACUM_VALOR_LOCAL)/12)  PROMEDIO2014 from trh_acumulado ac 
                          where AC.ACUM_ANO = '$anioant'  and AC.EMP_CODIGO = '$cedula' AND AC.CON_CODIGO = '3010'  ";
		$stmt = $dbh->prepare($query_prom2014);
		$stmt->execute();
		$row_pr2014 = $stmt->fetch();
		$row_pr2014 ['PROMEDIO2014'];
		
		
		$query_rentaex = "select  SUM(AC.NOMI_VALOR_LOCAL) RENTA from trh_nomina ac 
                          where AC.NOMI_ANO = '$anio' and AC.NOMI_MES = '$mes' and AC.CON_CODIGO IN                         ('3020','3023','3027') AND AC.EMP_CODIGO = '$cedula'";
		$stmt = $dbh->prepare($query_rentaex);
		$stmt->execute();
		$row_rentaex = $stmt->fetch();
		$row_rentaex['RENTA'];

		$query_aportes = "select  SUM(AC.NOMI_VALOR_LOCAL) APORTES from trh_nomina ac 
                       where AC.NOMI_ANO = '$anio' and AC.NOMI_MES = '$mes' and AC.CON_CODIGO IN                        ('3010','3020','3023') AND AC.EMP_CODIGO = '$cedula'";
		$stmt = $dbh->prepare($query_aportes);
		$stmt->execute();
		$row_aportes = $stmt->fetch();
		$row_aportes['APORTES'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="mediaprint.css" media="print"/>

</head>
<body>
<table width="95%" border="1" align="center" style="border-collapse:collapse; border: 1px solid #999; font-family:Arial, Helvetica, sans-serif; font-size:10px">
  <tr>
    <th colspan="4" align="left" scope="row">NOMBRE: <?php echo $row_n['NOMBRE']; ?> - CEDULA: <?php echo $cedula; ?> - AÑO:  <?php echo $anio; ?>   - MES:  <?php echo $mes; ?> </th>
  </tr>
  <tr>
    <th width="74%" bgcolor="#003300" style="font-family: Arial, Helvetica, sans-serif; color: #FFF;" scope="row">Detalle de pagos y depuraciones Aplicables</th>
    <td width="9%" bgcolor="#003300" style="color: #FFF">(*.*) al final</td>
    <td width="9%" align="center" bgcolor="#003300" style="color: #FFF">Parciales</td>
    <td width="8%" align="center" bgcolor="#003300" style="color: #FFF">Totales</td>
  </tr>
  <tr>
    <th align="left" bgcolor="#D5FFD5"  scope="row">1. Cálculos de la retención básica del mes</th>
    <td bgcolor="#D5FFD5">&nbsp;</td>
    <td bgcolor="#D5FFD5">&nbsp;</td>
    <td bgcolor="#D5FFD5">&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row">Pagos brutos laborales efectuados al trabajador durante el respectivo mes :</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left"  scope="row"> Salarios</th>
    <td>&nbsp;</td>
    <td> <?php echo number_format($row['NOMI_VALOR_LOCAL'],0,",",".") ; ?>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left"  scope="row"> Otros pagos laborales (auxilios, subsidios, bonificaciones, aportes que le haga la empresa)</th>
    <td>&nbsp;</td>
    <td> <?php 
		$sumatotal = $suma + $sumaAC;
		echo  number_format($sumatotal,0,",",".") ; ?>&nbsp;</td>
    <td> <?php
	$totalbasico= $sumatotal + $row['NOMI_VALOR_LOCAL'];
	 echo number_format($totalbasico,0,",",".")  ; ?>&nbsp;</td>
  </tr>
  <tr>
    <th align="left"  scope="row"> por cuenta de ella a los fondos de pensiones, intereses de cesantías, cesantías, etc.)</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row">&nbsp;</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row">Menos : Ingresos del mes que se consideran &quot;no gravables&quot; para el trabajador</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row">&nbsp;</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row"> - La parte recibida en &quot;alimentación&quot; (salario en especie)</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row"> - Medios de transporte distintos del subsidio de transporte (Concepto DIAN 18381 julio 30 de 1990)</th>
    <td>&nbsp;</td>
    <td><?php echo number_format($row_roda['RODAMIENTO']*-1,0,",","."); ?>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row"> -Viáticos ocasionales para manutención y alojamiento, tanto para empleados oficiales como de empresas</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row"> privadas (ver artículo 10 Decreto 537 de 1987, y artículo 8 Decreto 823 de 1987)</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php 
	$ingnogravable = $row_roda['RODAMIENTO']*-1;
	echo number_format($ingnogravable,0,",","."); ?>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row">&nbsp;</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row">Menos:  &quot;deducciones&quot; (artículo 387 del ET, y Decreto 2271 del 2009)</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row"> <p>1) Intereses en préstamos para adquisición de vivienda del trabajador (o el costo financiero en un                      contrato de leasing para adquirir vivienda del trabajador) pagados en el año anterior (2014) y                      divididos por los meses a que correspondieron  (este valor no puede exceder de 100 UVT, o sea,                     100 x $28.279= 2.828.000; ver artículo 5 Decreto 4713 diciembre 2005; es el item 95 en la tabla del artículo 867-1 del ET)</p></th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row"> 2) Pagos durante el año anterior (2014) a medicina prepagada del trabajador, la esposa                      y hasta dos hijos, y divididos por los meses a que correspondieron (este valor no pude exceder de                       16 UVT, o sea, 16 x $28.279 = $452.000)</th>
    <td>&nbsp;</td>
    <td> <?php $mycertificado = round($row_2014['MVR_VALOR_CERTIFICADO']*-1,-3);
				echo number_format($mycertificado,0,",",".") ; ?>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row"> <p>3) Deducción por concepto de &quot;personas a cargo&quot; (10% de los ingresos brutos sin exceder de 32 UVT;                       o sea, sin exceder de 32 x 28.279= $905.000)</p></th>
    <td>&nbsp;</td>
    <td><?php $mvcertificado = round($row_depend['MVR_VALOR_CERTIFICADO']*-1,-3);
			echo number_format($mvcertificado,0,",",".") ; ?>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row"> <p>4) aporte mensual promedio que hizo  durante el año gravable anterior (2014) por aportes obligatorios                     a salud (ver Concepto DIAN 81294 ootubre del 2009; y Decreto 2271 de junio del 2009 )</p></th>
    <td>&nbsp;</td>
    <td> <?php  $prom2014 = round ($row_pr2014 ['PROMEDIO2014']*-1,-3);
			echo number_format($prom2014,0,",","."); ?>&nbsp;</td>
    <td> <?php 
	$totaldeducciones = round(($row_pr2014 ['PROMEDIO2014'] + $row_2014['MVR_VALOR_CERTIFICADO'] + $row_depend['MVR_VALOR_CERTIFICADO'])*-1,-3);
	echo number_format($totaldeducciones ,0,",",".")
	 ; ?>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row">&nbsp;</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row">Menos: Renta exentas (artículo 126-1, 126-4 y artículo 206 numerales 1 al 9 del ET)</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row"> Aportes  obligatorios y volunarios a los fondos de pensiones y a las cuentas AFC</th>
    <td>&nbsp;</td>
    <td><?php echo number_format($row_rentaex['RENTA']*-1,0,",","."); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row"> Rentas exentas de las mencionadas en los numerales 1 al 9 del atículo 206. Por ejemplo:</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row"> <p>- Indemnizaciones por accidente de trabajo (numeral 1 del artículo 206)</p></th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row"> - Lo recibido por intereses de cesantías (numeral 4 del artículo 206)</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php 
	$excenta = $row_rentaex['RENTA']*-1;
	echo number_format($excenta,0,",","."); ?>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row">Subtotal 1</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php 
	$subtotal1 =  ($totalbasico + $ingnogravable + $totaldeducciones + $excenta);
	echo number_format($subtotal1,0,",","."); ?>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row">&nbsp;</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row"> - El 25% del subtotal 1, sin que exceda de 240 UVTs (es decir, 240 x $28.279 = $6.787.000 )</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php 
	$porcsubtotal =  round((($subtotal1  * 25 )/100),-3)*-1;
	 echo number_format( $porcsubtotal,0,",",".")
	 ?>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row">&nbsp;</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row">Subtotal 2</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php $subtotal2 = $subtotal1  + $porcsubtotal; 
			 echo number_format( $subtotal2,0,",","."); ?>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row">Valor de la Retención básica  con procedimiento 2 (al subtotal 2 se aplica el porcentaje definido en junio del 2015)</th>
    <td><?php echo $row_n['EMP_PORC_RET'] ?>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php 
		
			      $porcrete = $row_n['EMP_PORC_RET'];
				  $porc= str_replace (",",".",$porcrete);
				  $retebasica = ($subtotal2 * $porc)/100;
				 echo number_format(round($retebasica, -3),0,",",".");

				 ?> &nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row">&nbsp;</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" bgcolor="#D5FFD5" scope="row">2. Retención mínima del artículo 384 del ET (forma de realizar el cálculo según Decreto 1070)</th>
    <td bgcolor="#D5FFD5">&nbsp;</td>
    <td bgcolor="#D5FFD5">&nbsp;</td>
    <td bgcolor="#D5FFD5"><?php echo  number_format(($sumatotal + $row['NOMI_VALOR_LOCAL']),0,",",".") ; ?>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row"> Total pagos laborales del mes</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row"> Menos: aportes obligatorios a salud y pensiones del asalariado en este mismo mes</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php echo  number_format($row_aportes['APORTES'],0,",","."); ?>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row"> Menos: valor recibido para gastos de representación en los términos del numeral 7 del artículo 206 del ET.</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row"> Menos: valor recibido en exceso del salario básico para el caso de los oficiales y suboficilaes de las fuerzas militares y la policía nacional.</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row"> Menos: lo recibido en el mes por concepto de licencia de maternidad</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row">Base gravable </th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php $basegravable = ($sumatotal + $row['NOMI_VALOR_LOCAL']) - $row_aportes['APORTES'];
	echo   number_format($basegravable,0,",","."); ?> </td>
  </tr>
  <tr>
    <th align="left" scope="row">&nbsp;</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row">Valor de la retención mínima (la base gravable se busca en la tabla del artículo 384 del ET)</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td> <?php $reteminima =  $basegravable / $uvt;
	        
			if ($reteminima <= 1136.92){
		//determinamos el rango del presupuesto
				$rangor="SELECT hasta, uvt FROM retefuente WHERE  hasta >= '$reteminima'";
				$qry_6=$link->query($rangor);
				$row_rangor=$qry_6->fetch_object();
    			$cont=0;
				
				do{ 
					if($reteminima >= $row_rangor->hasta)
					{
						$cont=1+$cont;
						
					}else{	
						$porcentajeuvt=$row_rangor->uvt."<br />";
						$valorreteminima = ($uvt * 	$porcentajeuvt);
						break;
					}
				}while($row_rangor=$qry_6->fetch_object());
				echo   number_format(round($valorreteminima, -3),0,",",".");
				
			}
								
			if ($reteminima > 1136.92){
					$var1=($reteminima*27)/100;
					$valorx= 135.17;
			        $porcentajeuvt = ($valorx-$var1);
			
					$valorreteminima = ($uvt * 	$porcentajeuvt);

			
					echo   number_format($valorreteminima,0,",",".");	

			}
					
	?>
    &nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row">&nbsp;</th>
    <td>&nbsp; </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row">Valor de la retención final del mes (el mayor entre la retención básica y la retención mínima)</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php $mayor = max($retebasica,$valorreteminima);
			echo  number_format(round($mayor, -3),0,",",".");?> &nbsp;</td>
  </tr>
</table>
</body>
</html>


