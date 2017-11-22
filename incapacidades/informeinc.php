<?php 

error_reporting(0);


//funcion fechas

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();



$sql2="SELECT `cedula`,`finicial`, `ndias`, observacion FROM `incapacidades` WHERE `tipo_incapacidad` = ' '";
			$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
			
			


//conexion
try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		
	
 ?>



<!doctype html>
<html lang="en">
<head>


<style type='text/css'>
tr:nth-child(odd) {
    background-color:#f2f2f2;
}
tr:nth-child(even) {
	background-color: #fbfbfb;
	text-align: left;	
	
}

</style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Listado de empleados</title>
  
  <link rel="stylesheet" type="text/css" href="../estilos.css"/>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
</head>
<body>

<p>

<form>
<div id="validador"> 


  <table width="90%" border="1" align="center"  style="border-collapse:collapse">
   
    <tr>
      <td colspan="7" align="left" valign="middle"><h2 class="encabezados">INCAPACIDADES SIN LEGALIZAR</h2></td>
    </tr>
    
  
 
    <tr>
      <td align="left" valign="middle" class="subtitulos">SALA</td>
      <td align="left" valign="middle" class="subtitulos"><strong>CEDULA</strong></td>
      <td width="163" colspan="-1" align="center" valign="middle" class="subtitulos"><strong>NOMBRE</strong></td>
      <td width="209" align="center" valign="middle" class="subtitulos">CARGO</td>
      <td width="210" align="center" valign="middle" class="subtitulos">DETALLES</td>
      <td width="98" align="center" valign="middle" class="subtitulos">DIAS</td>
      <td width="150" colspan="-1" align="left" valign="middle" class="subtitulos"><strong>FECHA</strong></td>
      </tr>

  
    <?php 
  do{
	   $query = "SELECT SO.NOMBRE_SOCIEDAD SOCIEDAD,  EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , CA.CARGO_NOMBRE,  CC.CENCOS_NOMBRE CC 
        FROM EMPLEADO EM, CARGO CA,  sociedad SO, CENTRO_COSTO CC
        WHERE EM.EMP_CARGO = CA.CARGO_CODIGO  AND EM.EMP_CC_CONTABLE = CC.CENCOS_CODIGO
        AND EM.EMP_SOCIEDAD = SO.COD_SOCIEDAD
        AND EM.EMP_CODIGO = '$rs_qry2->cedula'";
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row_n = $stmt->fetch();
		
		$row_n['NOMBRE'];
		$row_n ['SOCIEDAD'];
		$row_n ['CC'];
		$cargo=utf8_encode($row_n['CARGO_NOMBRE']);
		
		
		
  ?>   
    
    <tr>

      <td width="59" align="left" valign="middle" style="font-size:12px"><?php echo $row_n ['CC']; ?></td>
      <td width="87" align="left" valign="middle" style="font-size:12px"><?php echo $rs_qry2->cedula; ?></td>
      <td align="left" valign="middle"><?php echo utf8_encode($row_n ['NOMBRE']);?></td>
      <td align="left" valign="middle"><?php echo utf8_encode($row_n ['CARGO_NOMBRE']);?></td>
      <td align="left" valign="middle"><?php echo $rs_qry2->observacion; ?></td>
      <td align="left" valign="middle"><span style="font-size:12px"><?php echo $rs_qry2->ndias; ?></span></td>
      <td colspan="-1" align="left" valign="middle"><?php echo $rs_qry2->finicial;?></td>
      </tr>
      <?php 
  }while($rs_qry2=$qry_sql2->fetch_object());
  ?>  
  </table>
  
  
  <table width="90%" border="1" align="center"  style="border-collapse:collapse">
   
    <tr>
      <td colspan="6" align="left" valign="middle"><h2 class="encabezados">INCAPACIDADES PENDIENTES EN QUERYX</h2></td>
    </tr>
    
   
    
    
    <tr>
      <td align="left" valign="middle" class="subtitulos">SALA</td>
      <td align="left" valign="middle" class="subtitulos"><strong>CEDULA</strong></td>
      <td width="309" colspan="-1" align="center" valign="middle" class="subtitulos"><strong>NOMBRE</strong></td>
      <td width="306" align="center" valign="middle" class="subtitulos">CARGO</td>
      <td width="67" align="center" valign="middle" class="subtitulos">DIAS</td>
      <td width="150" colspan="-1" align="left" valign="middle" class="subtitulos"><strong>FECHA</strong></td>
      </tr>

    <?php 
 
  			
$sql3="SELECT * FROM `incapacidades` WHERE `queryx` = '0' AND TIPO_INCAPACIDAD <> ''";
			$qry_sql3=$link->query($sql3);
			$rs_qry3=$qry_sql3->fetch_object();  ///consultar 
 
  do{
	
	 $query = "SELECT SO.NOMBRE_SOCIEDAD SOCIEDAD,  EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , CA.CARGO_NOMBRE,  CC.CENCOS_NOMBRE CC 
        FROM EMPLEADO EM, CARGO CA,  sociedad SO, CENTRO_COSTO CC
        WHERE EM.EMP_CARGO = CA.CARGO_CODIGO  AND EM.EMP_CC_CONTABLE = CC.CENCOS_CODIGO
        AND EM.EMP_SOCIEDAD = SO.COD_SOCIEDAD
        AND EM.EMP_CODIGO = '$rs_qry3->cedula'";
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row_n = $stmt->fetch();
		
		$row_n['NOMBRE'];
		$row_n ['SOCIEDAD'];
		$row_n ['CC'];
		$cargo=utf8_encode($row_n['CARGO_NOMBRE']);
		
		
		
  ?>   
    
    <tr>

      <td width="59" align="left" valign="middle" style="font-size:12px"><?php echo $row_n ['CC']; ?></td>
      <td width="87" align="left" valign="middle" style="font-size:12px"><?php echo $rs_qry3->cedula; ?></td>
      <td align="left" valign="middle"><?php echo utf8_encode($row_n ['NOMBRE']);?></td>
      <td align="left" valign="middle"><?php echo utf8_encode($row_n ['CARGO_NOMBRE']);?></td>
      <td align="left" valign="middle"><span style="font-size:12px"><?php echo $rs_qry3->ndias; ?></span></td>
      <td colspan="-1" align="left" valign="middle"><?php echo $rs_qry3->finicial;?></td>
      </tr>
      <?php 
  }while($rs_qry3=$qry_sql3->fetch_object());
  ?>  
  </table>
  <p><span class="encabezados">
  <input type="submit" style="background:#0F0" name="cerrar" id="cerrar"  onClick="window.close();"value="CERRAR" >
  </span></p>
</div></form>
 <p>