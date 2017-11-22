<?php
require_once("FuncionFechas.php");
 
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
AND EM.EMP_CODIGO = '1065562910'";

$stmt = $dbh->prepare($query);


if ($stmt->execute()) {
    while ($row = $stmt->fetch()) {
        $row['NOMBRE'];
		$row['EMP_CODIGO'];
		$row['CARGO_NOMBRE'];
		$row['EMP_FECHA_INI_CONTRATO'];
		$fingreso=$row['EMP_FECHA_INI_CONTRATO'];
		$fretiro=$row['EMP_FECHA_RETIRO'];
		$row['TCO_NOMBRE'];
		//$hoy=$row['HOY'];

$hoy="21/09/2015";		
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
<p style="text-align: justify">Que el(a) señor(a)  <b><?php echo $row['NOMBRE']; ?></b> identificado(a) con cedula de   
  ciudadanía No. <b><?php echo number_format($row['EMP_CODIGO'],0,",","."); ?></b>, labora para la empresa con contrato a 
  <b><?php echo $row['TCO_NOMBRE']; ?></b> desde el día <b><?php echo fechaletra($fingreso); ?> </b> hasta el
  <b><?php echo fechaletra($fretiro); ?></b> desempeña el cargo <b><?php echo $row['CARGO_NOMBRE']; ?></b>.</p>
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
