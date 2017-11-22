<?php
require_once("FuncionFechas.php");

try {
    $dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
} catch (PDOException $e) {
    echo "Error: ". $e->getMessage();
    exit;
}
$query = "SELECT EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , EM.EMP_CODIGO, EM.EMP_FECHA_RETIRO, CC.CCOS_VAL_ALF1, 
CA.CARGO_NOMBRE, sysdate as HOY
FROM EMPLEADO EM, CARGO CA, CENTRO_COSTO CC
WHERE EM.EMP_CARGO = CA.CARGO_CODIGO AND EM.EMP_CC_CONTABLE = CC.CENCOS_CODIGO
AND EM.EMP_CODIGO = '10096222'";

$stmt = $dbh->prepare($query);

if ($stmt->execute()) {
    while ($row = $stmt->fetch()) {
        $row['NOMBRE']."<br />";
		$row['EMP_CODIGO']."<br />";
		$row['CARGO_NOMBRE']."<br />";
		$fretiro = $row['EMP_FECHA_RETIRO']."<br />";
		$row['CCOS_VAL_ALF1']."<br />";
		$hoy=$row['HOY'];
		
  ?>
  <body  style="font-family:Verdana, Geneva, sans-serif">
<table width="60%" border="0" align="center">
  <tr>
    <td>
  
<p>Bogotá   <?php echo fechaletra($hoy); ?><br /></p>
<p>&nbsp;</p>
<p>Señores:<br />
  <strong>IPS  SALUD OCUPACIONAL REGIONAL S.A.S</strong><br />
  <strong>SORE  S.A.S</strong><br />
  AV.  Ferrocarril No. 41 -46 <br />
  Tel:  2647277- 2701394<br />
  Ciudad.-</p>
<p>&nbsp;</p>
<p>Estimados señores:</p>
<p>&nbsp;</p>
<p style="text-align: justify">Comedidamente  solicitamos se practique el examen de la referencia para la persona indicada a 
continuación, dentro de los cinco (5) días siguientes a la fecha de entrega de  esta orden:</p>
<p>&nbsp;</p>
<p>NOMBRE:               <strong><b><?php echo $row['NOMBRE']; ?></b></strong><br />
  C.C.                           <?php echo number_format($row['EMP_CODIGO'],0,",","."); ?><br />
  CARGO:                         <?php echo $row['CARGO_NOMBRE']; ?><br />
  UBICACIÓN:                     <?php echo $row['CCOS_VAL_ALF1']; ?><br />
  FECHA DE RETIRO:               <?php echo fechaletra($fretiro); ?></p>
<p>&nbsp;</p>
<p style="text-align: justify">El costo  de los exámenes practicados al trabajador, serán cancelados por nuestra  empresa, de conformidad con el convenio existente.</p>
<p>&nbsp;</p>
<p>Agradecemos  enviar los resultados al correo <a href="mailto:contratación@ceramigres.com">contratación@ceramigres.com</a></p>
<p>Atentamente,</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><strong>FAIZULI  LEON BERMUDEZ</strong><br />
  Jefe de Gestión Humana</p>
  </td>
  </tr>
</table>
</body>
 <?php
  }
}  
?>
