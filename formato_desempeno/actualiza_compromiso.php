<?php 

error_reporting(0);
//recojo variables

 $cedula=$_REQUEST['cedula'];


//funcion fechas

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();


$sql2="SELECT `id`,`desc_compromiso`, `f_compromiso`, f_seguimiento FROM `form_compromiso_emp` WHERE `cedula` = '$cedula' and estado = '1'";
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
	text-align: left;	
	
}

</style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Compromisos del empleado</title>
  
  <link rel="stylesheet" type="text/css" href="../estilos.css"/>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
</head>
<body>

<p>

<form>
<div id="validador"> 


  <table width="70%" border="1" align="center"  style="border-collapse:collapse">
   
    <tr>
      <td colspan="2" align="left" valign="middle"><h2 class="encabezados">COMPROMISO DE EMPLEADOS</h2></td>
    </tr>
    
  
 
    <tr>
      <td width="547" colspan="-1" align="center" valign="middle" class="subtitulos"><strong>COMPROMISO</strong></td>
      <td width="378" align="center" valign="middle" class="subtitulos">FECHA DE SEGUIMIENTO</td>
      </tr>

  
    <?php 
  do{
	  
	
		
  ?>   
    
    <tr>

      <td align="left" valign="middle">
        <label>
         <input name="fseguimiento" type="text" id="fseguimiento" value="<?php echo utf8_encode($rs_qry2->desc_compromiso);?>" size="90">
        </label></td>
      <td align="left" valign="middle">
        <label>
          <input type="text" name="fseguimiento" id="fseguimiento" value="<?php echo utf8_encode($rs_qry2->f_seguimiento);?>">
        </label></td>
      </tr>
      <?php 
  }while($rs_qry2=$qry_sql2->fetch_object());
  ?>  
  </table>
  <p><span class="encabezados">
    <input type="submit" style="background:#FFF" name="cerrar" id="cerrar"  onClick="window.close();"value="CERRAR" >
</span></p>
</div></form>
 <p>