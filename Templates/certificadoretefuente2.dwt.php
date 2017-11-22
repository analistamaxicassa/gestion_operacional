<?php

//recojo variables
//$cedula=$_POST['cedula'];

//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}

			
		$cedula='63332960';
		
		$query = "SELECT EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE
		FROM EMPLEADO EM
		WHERE EM.EMP_CODIGO = '$cedula'";
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row_n = $stmt->fetch();
		
	    $nombre_per=$row_n['NOMBRE'];
		

		
		/*$query_salario = "select  AC.ACUM_VALOR_LOCAL  from trh_acumulado ac  
						where AC.ACUM_ANO = '2015' and AC.ACUM_MES = '9' AND AC.CON_CODIGO in ('1','2','3') and 						EM.EMP_CODIGO = '$cedula'";
		$stmt = $dbh->prepare($query_salario);
		$row = $stmt->fetch();
		
		$row['ACUM_VALOR_LOCAL'];
	
	$query_bonos = "select  AC.ACUM_VALOR_LOCAL BONOS from trh_acumulado ac, CON_GRUPO GR, EMPLEADO EM 
where AC.CON_CODIGO = GR.CON_CODIGO AND EM.EMP_CODIGO = AC.EMP_CODIGO AND EM.EMP_TIPO_NOMINA = GR.CON_TIPO_EMP AND
AC.ACUM_ANO = '2015' and AC.ACUM_MES = '9' and ac.EMP_CODIGO = '$cedula' AND GR.CON_GRUPO = '208' 
UNION
select  AC.ACUM_VALOR_LOCAL bonos from trh_acumulado ac  
where AC.ACUM_ANO = '2015' and AC.ACUM_MES = '9' and ac.EMP_CODIGO = '$cedula' AND AC.CON_CODIGO = '502' 						";
		$stmt = $dbh->prepare($query_salario);
		
		if ($stmt->execute()) 
		{
	
	$suma=0;
	
    while ($row = $stmt->fetch()) {
       	$suma=$suma + $row['BONOS'];
		   }
		} 
		
		$query_auxroda = "select  AC.ACUM_VALOR_LOCAL RODAMIENTO  from trh_acumulado ac  
where AC.ACUM_ANO = '2015' and AC.ACUM_MES = '9' and AC.EMP_CODIGO = '$cedula' AND AC.CON_CODIGO = '508'";
		$stmt = $dbh->prepare($query_auxroda);
		$row = $stmt->fetch();
		$row['RODAMIENTO'];
		
		
		
	
	$query_2014 = "Select MVR_VALOR_CERTIFICADO from (select * from MENOR_VALOR_RETENCION MVR WHERE MVR.MVR_EMP_CODIGO = '$cedula'
order by MVR.MVR_FECHA_DESDE  desc )
where  rownum = 1"; 
		$stmt = $dbh->prepare($query_2014);
		$row = $stmt->fetch();
		
		$row['MVR_VALOR_CERTIFICADO'];
		
		$query_prom2014 = "select AVG(AC.ACUM_VALOR_LOCAL) PROMEDIO2014 from trh_acumulado ac 
where AC.ACUM_ANO = '2014'  and AC.EMP_CODIGO = '$cedula' AND AC.CON_CODIGO = '3010'  ";
		$stmt = $dbh->prepare($query_prom2014);
		$row = $stmt->fetch();
		$row['PROMEDIO2014'];
		
		
		$query_rentaex = "select  SUM(AC.ACUM_VALOR_LOCAL) RENTA from trh_acumulado ac 
where AC.ACUM_ANO = '2015' and AC.ACUM_MES = '9' and AC.CON_CODIGO IN ('3020','3023','3027') AND AC.EMP_CODIGO = '$cedula'";
		$stmt = $dbh->prepare($query_rentaex);
		$row = $stmt->fetch();
		$row['RENTA'];*/

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- TemplateBeginEditable name="doctitle" -->
<title>Documento sin título</title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
</head>
<body align="left"; style="font-family: Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold;">
<table width="90%" border="1">
  <tr>
    <th width="57%" align="left" scope="row">NOMBRE: <?php echo $nombre_per; ?></th>
    <td width="9%">CEDULA</td>
    <td width="17%" align="center"><label for="idcedula"></label>
    <input name="idcedula" type="text" id="idcedula" /></td>
    <td width="17%" align="center">&nbsp;</td>
  </tr>
  <tr>
    <th scope="row">&nbsp;</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th scope="row">Detalle de pagos y depuraciones Aplicables</th>
    <td>(*.*) al final</td>
    <td align="center">Parciales</td>
    <td align="center">Totales</td>
  </tr>
  <tr>
    <th scope="row">&nbsp;</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left"  scope="row">1. Cálculos de la retención básica del mes</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
    <td> <?php echo $row['ACUM_VALOR_LOCAL']; ?>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left"  scope="row"> Otros pagos laborales (auxilios, subsidios, bonificaciones, aportes que le haga la empresa)</th>
    <td>&nbsp;</td>
    <td> <?php echo $row['$suma']; ?>&nbsp;</td>
    <td>&nbsp;</td>
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
    <td><?php echo $row['RODAMIENTO']; ?>&nbsp;</td>
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row">&nbsp;</th>
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
    <td> <?php echo $row['MVR_VALOR_CERTIFICADO']; ?>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row"> <p>3) Deducción por concepto de &quot;personas a cargo&quot; (10% de los ingresos brutos sin exceder de 32 UVT;                       o sea, sin exceder de 32 x 28.279= $905.000)</p></th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row"> <p>4) aporte mensual promedio que hizo  durante el año gravable anterior (2014) por aportes obligatorios                     a salud (ver Concepto DIAN 81294 ootubre del 2009; y Decreto 2271 de junio del 2009 )</p></th>
    <td>&nbsp;</td>
    <td> <?php echo $row['PROMEDIO2014']; ?>&nbsp;</td>
    <td>&nbsp;</td>
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
    <td><?php echo $row['PROMEDIO2014']; ?>&nbsp;</td>
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row">Subtotal 1</th>
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
    <th align="left" scope="row"> - El 25% del subtotal 1, sin que exceda de 240 UVTs (es decir, 240 x $28.279 = $6.787.000 )</th>
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
    <th align="left" scope="row">Subtotal 2</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row">Valor de la Retención básica  con procedimiento 2 (al subtotal 2 se aplica el porcentaje definido en junio del 2015)</th>
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
    <th align="left" scope="row">2. Retención mínima del artículo 384 del ET (forma de realizar el cálculo según Decreto 1070)</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
    <td>&nbsp;</td>
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
    <td>&nbsp;</td>
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row">&nbsp;</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th align="left" scope="row">Valor de la retención final del mes (el mayor entre la retención básica y la retención mínima)</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th scope="row">&nbsp;</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>


