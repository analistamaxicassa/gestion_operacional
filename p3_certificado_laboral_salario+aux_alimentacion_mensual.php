<?php
require_once("FuncionFechas.php");

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
AND EM.EMP_CODIGO = CF.EMP_CODIGO AND EM.EMP_CODIGO = NF.EMP_CODIGO AND NF.CON_CODIGO = '506'
AND EM.EMP_CODIGO = '1047383207'";

$stmt = $dbh->prepare($query);


if ($stmt->execute()) {
    while ($row = $stmt->fetch()) {
        $row['NOMBRE']."<br />";
		$row['EMP_CODIGO']."<br />";
		$row['CARGO_NOMBRE']."<br />";
		$fingreso=$row['EMP_FECHA_INI_CONTRATO'];
		$row['TCO_NOMBRE']."<br />";
		$row['NOVF_VALOR']."<br />";
		$hoy=$row['HOY'];
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
  
  <p style="text-align: justify">Que el(a) señor(a) <b><?php echo utf8_encode($row['NOMBRE']); ?></b> identificado(a) con cedula de 
  
  ciudadanía No. <b><?php echo number_format($row['EMP_CODIGO'],0,",","."); ?></b>, labora para la empresa con contrato a <b><?php echo $row['TCO_NOMBRE']; ?></b>
  desde el día <b><?php echo fechaletra($fingreso); ?></b> desempeña el cargo <b><?php echo $row['CARGO_NOMBRE']; ?></b>, devenga un salario mensual 
  por valor de $<b><?php echo number_format($row['COF_VALOR'],0,",","."); ?></b> y recibe un auxilio de Alimentación mensual no constitutivo de salario ni factor prestacional 
  de $<b><?php echo number_format($row['NOVF_VALOR'],0,",","."); ?></b>.</span></p>
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
  }
}  
?>
