<?php

//recojo variables
$sala = $_REQUEST['sala'];
//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
//$hoy=date("Y-m-d");

?>	

<link rel="stylesheet" type="text/css" href="../estilos.css"/>
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<body>
<?php
	//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
	//conexion sql	
	
	$sql="SELECT cedula, tipo_sala, ayudas  FROM cliente_interno where sala = $sala";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 
	
	if (empty($rs_qry)) {
    echo 'No existen registros';
	exit();
	}
	else {
		//do{
	$cedula = $rs_qry->cedula;	
	$tipo_sala = $rs_qry->tipo_sala;
	$ayudas = $rs_qry->ayudas;

	
	 $query = "SELECT CA.CARGO_NOMBRE, TO_CHAR((SYSDATE - EMP_FECHA_INGRESO)/30,9999)/12 ANTIGUEDAD, EMP.EMP_TIPO_CONTRATO TIPO_CONTRATO
, (SUM(AC.ACUM_VALOR_LOCAL))/3 PROMEDIO
FROM EMPLEADO EMP
,TRH_ACUMULADO AC,CARGO CA, CONCEPTOS CO
WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO  AND EMP.EMP_CODIGO = AC.EMP_CODIGO  AND
AC.ACUM_FECHA_PAGO > SYSDATE - 90  AND AC.CON_CODIGO = CO.CON_CODIGO AND
CO.CON_NATU = 'DEV' AND EMP.EMP_ESTADO <> 'R'  AND EMP.EMP_CODIGO = '$cedula' AND AC.CON_CODIGO <> '130'
GROUP BY CA.CARGO_NOMBRE, TO_CHAR((SYSDATE - EMP_FECHA_INGRESO)/30,9999)/12, EMP.EMP_TIPO_CONTRATO";
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch();	
		
		$cargo=$row['CARGO_NOMBRE'];
		$antiguedad=substr($row['ANTIGUEDAD'],0,2);
		$tipo_contrato=$row['TIPO_CONTRATO'];
		$promedio=number_format($row['PROMEDIO'], 0, ',', '.');
		}
?>


<form method="post" action="../cliente_interno/selecciona_sala.php">
<table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="100%">
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Cargo</strong></td> 
      <td width="612" class="header" colspan="6"  align="justify" ><?php echo utf8_encode($cargo); ?></td>      </tr> 
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Antiguedad</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" valign="middle"><?php echo  $antiguedad; ?> Años</td> 
     </tr> 
 <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Contrato</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" valign="middle">
	  <?php if ($tipo_contrato == 1)
	  		  $contrato = "Termino indefinido"; 
		  if ($tipo_contrato == 2)
		    $contrato = "Termino fijo";
		  if ($tipo_contrato == 4) 
		   $contrato = "Aprendiz";
	  
	  echo utf8_encode($contrato); ?></td>      </tr>
      <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Tipo de sala</strong></td> 
      <td width="612" class="header" colspan="6" align="justify"  valign="middle"><?php echo $tipo_sala; ?></td>
     </tr>
      <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Salario Promedio</strong></td> 
      <td width="612" class="header" colspan="6" align="justify"  valign="middle"><?php echo "$".$promedio; ?></td>
     </tr>

      <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Ayudas recibidad por la empresa</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" valign="middle"><?php echo utf8_encode($ayudas); ?></td> 
     </tr>
   
    </table>

<br>
  </p>
  <p>&nbsp;</p>
</form>
</body>
</html>
<br>
