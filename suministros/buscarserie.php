<?php 

//error_reporting(0);

//recojo variables
$serie=$_REQUEST['serie'];
//$serie='1608B041';


//funcion fechas

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

 $sql2="SELECT ss.id, sa.nombre, ss.cedula, ec.nombre, ss.ubicacion, se.descripcion_elemento FROM `suministros_sala` ss inner join salas sa on ss.sala = sa.cc inner join suministros_elementos se on ss.elemento = se.id inner join act_man2.`usuarios_queryx` ec on ss.cedula = ec.cedula WHERE `serie` LIKE '%$serie%'";
			$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
			
			
	
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
	
	
}

</style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Actualizacion Datos</title>
  
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
      <td colspan="3" align="left" valign="middle" class="subtitulos"><strong>Descripción</strong></td>
      <td width="205" align="center" valign="middle" class="subtitulos"><strong>Ubicacion</strong></td>
      <td width="283" align="left" valign="middle" class="subtitulos">Cedula</td>
      <td width="175" align="left" valign="middle" class="subtitulos">Nombre</td>
    </tr>

    <?php 
  do{
  ?>   
    
    <tr>
      <td style="font-size:12px" colspan="3" align="left" valign="middle"><?php echo utf8_encode($rs_qry2->descripcion_elemento);?></td>
     
      <td align="left" valign="middle"><?php echo $rs_qry2->ubicacion;?></td>
      <td align="left" valign="middle"><?php echo $rs_qry2->cedula;?></td>
      <td align="left" valign="middle"><?php echo $rs_qry2->nombre;?></td>
      </tr>
      <?php 
  }while($rs_qry2=$qry_sql2->fetch_object());
  ?>  
  </table>
</div></form>
 <p>