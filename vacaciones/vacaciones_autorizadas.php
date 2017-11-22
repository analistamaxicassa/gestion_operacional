<link rel="stylesheet" type="text/css" href="../estilos.css"/>

<style type="text/css">
.text {font-family:Verdana, Geneva, sans-serif;
	   font-size:11px;
}
</style>


<?PHP

require_once('../PAZYSALVO/FuncionFechas.php');
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

//conexion
try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		

//PENDIENTE QUE MUESTRE EL NOMBRE*****
	
		//conexion sql	
			$sql="SELECT  MONTH(CURRENT_DATE) MES, `CEDULA`,`PERIODO`,`DIAS`,`SALIDA`,`ENTRADA` FROM `VACACIONES`
WHERE AUT_JEFE = '1' and MONTH(salida) = MONTH(CURRENT_DATE) order by salida";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 

			if (empty($rs_qry)) {
   						 echo 'No existen registros';
							//$datelimite = 0;
							exit;
								}

	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>VACACIONES AUTORIZADAS</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table  align="center" width="60%" border="1">
    <tr class="encabezados">
      <th colspan="6" scope="row">VACACIONES AUTORIZADAS</th>
    </tr>
    <tr>
      <th colspan="6" scope="row">Mes de <?php echo $meses[$rs_qry->MES-1] ?></th>
    </tr>
    <tr>
      <th scope="row">CEDULA</th>
      <th scope="row">NOMBRE</th>
      <th scope="row">PERIODO</th>
      <th scope="row">DIAS</th>
      <th scope="row">PRIMER  DIA</th>
      <th scope="row">ULTIMO DIA</th>
    </tr>
    
  <?php
do{
?>
    <tr>
      <th><?php echo $rs_qry->CEDULA ?></th>
      <?php 
	  $query1 = "SELECT EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE FROM EMPLEADO EM WHERE EM.EMP_CODIGO = '$rs_qry->CEDULA' ";
	  $stmt1 = $dbh->prepare($query1);
		$stmt1->execute();
		$row_n1 = $stmt1->fetch();
		
		$nombre = $row_n1['NOMBRE'];
	   ?>
      
      <th><?php echo $nombre  ?></th>
      <th><?php echo $rs_qry->PERIODO ?></th>
      <td><?php echo $rs_qry->DIAS ?></td>
      <td><?php echo $rs_qry->ENTRADA?></td>
      <td><?php echo $rs_qry->SALIDA ?></td>
    </tr>
 

<?php
  }
while($rs_qry=$qry_sql->fetch_object());
  
?>
 </table>
</form>
</body>
</html>