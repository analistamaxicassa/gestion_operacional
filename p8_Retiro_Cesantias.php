<?php
require_once("FuncionFechas.php");

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
AND CE.TENT_CODIGO = 'FCES' AND EM.EMP_CODIGO = '10096222' AND EM.EMP_LOCALIDAD = LO.COD_LOCALIDAD";

$stmt = $dbh->prepare($query);

if ($stmt->execute()) {
    while ($row = $stmt->fetch()) {
        $row['NOMBRE'];
		$row['EMP_CODIGO'];
		$row['EMP_FECHA_RETIRO'];
		$row['ENT_NOMBRE_ASOCIADO'];
		$hoy=$row['HOY'];
		$ciudad=$row['LOCALIDAD'];		
  ?>
  <body  style="font-family:Verdana, Geneva, sans-serif">
<table width="60%" border="0" align="center">
  <tr>
  <td>
      <p> <?php echo $row['LOCALIDAD'].", ".fechaletra($hoy); ?><br /></p>
      <p>&nbsp;</p>
      <p> Señores:<br />
	  FONDO  DE PENSIONES Y CESANTIAS<br />
      <b><?php echo $row['ENT_NOMBRE_ASOCIADO'];?></b><br />
      Ciudad.-</p>
      <p>&nbsp;</p>
      <p align="right"><b>REF. RETIRO DEFINITIVO DE CESANTIAS</b></p>
      <p style="text-align: justify">La  presente con el fin de autorizar el retiro de las cesantías definitivas consignadas 
	  en ese fondo del (la) señor (a) <b><?php echo $row['NOMBRE'];?></b> identificado(a) con cédula de ciudadanía 
	  número  <b> <?php echo number_format($row['EMP_CODIGO'],0,",","."); ?></b></p>
      <p>&nbsp;</p>
      <p>Atentamente,</p>
      <p>&nbsp;</p>
      <p align="justify"><strong>FAIZULI  LEON BERMUDEZ </strong><br />
    Jefe de Gestión Humana</p></th>
    <th width="10%" scope="row">&nbsp;</th>
	</td>
  </tr>
</table>

  </body>
 <?php
  }
}  
?>
