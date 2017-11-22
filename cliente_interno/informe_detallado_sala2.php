
<link rel="stylesheet" type="text/css" href="../estilos.css"/>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

<?php

error_reporting(0);


$sala=$_POST['sala'];
//$autor=$_POST['autor'];
$fechainf=$_POST['fechainf'];

$hoy=date("d/m/y");

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

session_start();  
$cedingreso = $_SESSION['ced'];

if($_SESSION['us'] == '2') {
	
	?>
	
	  <script>
		alert( "USTED NO TIENE PERMISOS PARA INGRESAR A ESTA SECCION")
		
	location.href="selecciona_sala.php?sala=<?php echo $sala ?>"
	
	  </script>
      
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CLIENTE INTERNO</title>


</head>

<body>
 
     
      
      <p>
              <?php
	exit();
	}
	
////consulta nombre de sala

$sql3="SELECT nombre FROM `salas` WHERE `cc` LIKE '$sala' ";
			$qry_sql3=$link->query($sql3);
			$rs_qry3=$qry_sql3->fetch_object();  ///consultar 
			
			$nombre = $rs_qry3->nombre;		



////consulta de informe detallado de sala

 $sql2="SELECT id, `cc`, `autor`,`concepto_esp`, `calificacion`, `hallazgo`, `tarea`, `responsable`, `fecha_control` FROM `concepto_sala` WHERE `fecha` = '$fechainf' and cc = '$sala' ";
			$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
			
			
			$autor = $rs_qry2->autor;	
		
	if (empty($rs_qry2)) {
    echo 'No existen registros';
	exit();
	}



	else {
		 $rs_qry2->cc;	
		 $rs_qry2->autor;
		 $rs_qry2->concepto_esp;
		 $rs_qry2->calificacion;	
		 $rs_qry2->hallazgo;
		 $rs_qry2->tarea;
		 $rs_qry2->responsable;	
		 $rs_qry2->fecha_control;
			}
			?>
</p>
<div id="validador">  
<p>&nbsp; </p>

            <table   align="center" border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="67%">
    <tr class="subtitulos">
      <td height="26" colspan="7" align="left" valign="middle" class="encabezados">INFORME DE VISITA A SALA DE VENTAS</td>
      </tr>
    <tr class="subtitulos">
      <td height="26" colspan="3" align="left" valign="middle">Fecha Visita</td>
      <td width="150" align="left" valign="middle"><span class="encabezados"><?php echo $fechainf ?></span></td>
      <td width="210" align="left" valign="middle">Almacen</td>
      <td colspan="2" align="left" valign="middle"><?php echo $nombre ?></td>
    </tr>
    <tr class="subtitulos">
      <td height="26" colspan="3" align="left" valign="middle">Realizado por: </td>
      <td align="left" valign="middle"><span class="encabezados"><?php echo $autor ?></span></td>
      <td align="left" valign="middle">Administrador</td>
      <td colspan="2" align="left" valign="middle">&nbsp;</td>
    </tr>
      
    
    
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <tr class="encabezados">
      <td width="22" align="left" valign="middle"><strong>ID</strong></td>
      <td width="190" align="left" valign="middle"><strong>CONCEPTO</strong></td>
      <td width="35" align="left" valign="middle"><strong>CALIF</strong></td>
      <td align="left" valign="middle"><strong>HALLAZGO</strong></td>
      <td align="left" valign="middle"><strong>TAREAS</strong></td>
      <td width="84" align="left" valign="middle"><strong>RESPONSABLE</strong></td>
      <td width="94" align="left" valign="middle"><strong>CONTROL</strong></td>
      </tr>
      
        <?php
do{
	?>
    <tr>
      <td align="left" valign="middle" class="subtitulos"><?php echo ($rs_qry2->id); ?></td>
      <td align="left" valign="middle" class="subtitulos"><?php echo ($rs_qry2->concepto_esp); ?></td>
      <td align="left" valign="middle"><?php echo utf8_encode($rs_qry2->calificacion); ?></td>
      <td align="left" valign="middle"><?php echo utf8_encode ($rs_qry2->hallazgo); ?></td>
      <td align="left" valign="middle"><?php echo utf8_encode ($rs_qry2->tarea); ?></td>
      <td align="left" valign="middle"><?php echo utf8_encode($rs_qry2->responsable); ?></td>
      <td align="left" valign="middle"><?php echo utf8_encode($rs_qry2->fecha_control); ?></td>
    </tr>  
 
  <?php
}
while($rs_qry2=$qry_sql2->fetch_object());	
//}
?>  
  
</table>

	


</div>
  
   </p>



</body>
</html>

