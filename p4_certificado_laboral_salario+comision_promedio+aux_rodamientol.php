<?php
require_once("FuncionFechas.php");

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
AND EM.EMP_CODIGO = '10776380' and AC.ACUM_FECHA_PAGO > (sysdate - 365)
ORDER BY AC.ACUM_FECHA_PAGO";

$stmt = $dbh->prepare($query);


if ($stmt->execute()) {
	
	$suma=0;
	
    while ($row = $stmt->fetch()) {
        $nombre=$row['NOMBRE'];
		$codigo=$row['EMP_CODIGO'];
		$contrato=$row['TCO_NOMBRE'];
		$fingreso=$row['EMP_FECHA_INI_CONTRATO'];
		$cargo=$row['CARGO_NOMBRE'];
		$salario=$row['COF_VALOR'];
		$divisor=$row['MES'];
		$suma=$suma + $row['ACUM_VALOR_LOCAL'];
		$rodamiento=$row['RODA'];
		$hoy=$row['HOY'];
    }
			if ($divisor<12) 
			{
				$total = $suma/$divisor;	
			}	
			else{$total = $suma/12;	
			}	
	} 
	
  ?>
<body style="font-family:Verdana, Geneva, sans-serif">
<table width="60%" border="0" align="center">
  <tr>
    <td>
    <center><span style="font-size:24px;; font-weight:bold">LA JEFE DE GESTIÓN HUMANA</span></center>
    <br><br><br>

<center><span style="font-size:24px; font-weight:bold">C E R T I F I C A:</span></center>
<br>
  <br><br>
  
  <p style="text-align: justify">Que el(a) señor(a) <b><?php echo $nombre; ?> </b>identificado(a) con cedula de 
   ciudadanía No. <b><?php echo number_format($codigo,0,",","."); ?></b> , labora para la empresa con contrato a <b><?php echo $contrato; ?></b> 
   desde el día  <b><?php echo fechaletra($fingreso); ?> </b>,  desempeña el cargo <b><?php echo $cargo; ?></b>,  devenga un salario mensual 
  por valor de $<b><?php echo number_format($salario,0,",","."); ?></b>,  recibe una comision promedio mensual de $
  <b><?php echo number_format($total,0,",","."); ?></b> y un auxilio de rodamiento por 
  $<b><?php echo number_format($rodamiento,0,",","."); ?></b>.</p>
<p>&nbsp;</p>
<p>La presente constancia se expide a solicitud del interesado el <?php echo fechaletra($hoy);?></p>
<p>&nbsp;</p>
<p>Cordialmente,  </p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>FAIZULI LEON BERMUDEZ<br>  
Jefe  de Gestión Humana</p></td>
  </tr>
</table>
</body>
<?php
 
?>
