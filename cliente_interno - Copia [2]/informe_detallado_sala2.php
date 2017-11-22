
<link rel="stylesheet" type="text/css" href="../estilos.css"/>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

<?php

//error_reporting(0);


$sala=$_POST['sala'];
$autor=$_POST['autor'];
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



////consulta de informe detallado de sala

$sql2="SELECT `cc`, `autor`,`concepto_esp`, `calificacion`, `hallazgo`, `tarea`, `responsable`, `fecha_control` FROM `concepto_sala` WHERE `fecha` = '$fechainf' ";
			$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
				
		
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

            <table align="center" border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="60%">
    <tr class="subtitulos">
      <td width="132" height="26" align="left" valign="middle"><span>Sala: </span></td>
      <td width="352" align="left" valign="middle"><?php echo $sala ?></td>
    
      </tr>
    <tr class="subtitulos">
      <td align="left" valign="middle"><span>Realizado por:  </span></td>
      <td align="left" valign="middle"><span class="encabezados"><?php echo $autor ?></span></td>
    
      </tr>
    <tr>
      <td align="left" valign="middle"><span class="encabezados">Fecha:</span></td>
      <td align="left" valign="middle"><span class="encabezados"><?php echo $fechainf ?></span></td>
    
      </tr>
    <tr>
      <td colspan="3" align="left" valign="middle">&nbsp;</td>
      </tr>
      
      <?php
do{
	?>
    
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <tr>
      <td align="left" valign="middle" class="subtitulos">CONCEPTO A EVALUAR</td>
      <td colspan="2" align="left" valign="middle" class="encabezados"><?php echo ($rs_qry2->concepto_esp); ?></td>
      </tr>
    <tr>
      <td align="left" valign="middle" class="subtitulos">CAL 1-5</td>
      <td colspan="2" align="left" valign="middle"><?php echo utf8_encode($rs_qry2->calificacion); ?></td>
      </tr>
   





    <tr>
      <td align="left" valign="middle" class="subtitulos">HALLAZGO</td>
      <td colspan="2" align="left" valign="middle"><?php echo utf8_encode($rs_qry2->hallazgo); ?></td>
      </tr>
    <tr>
      <td align="left" valign="middle" class="subtitulos">TAREAS</td>
      <td colspan="2" align="left" valign="middle"><?php echo utf8_encode($rs_qry2->tarea); ?></td>
      </tr>
    <tr>
      <td align="left" valign="middle" class="subtitulos">RESPONSABLE</td>
      <td colspan="2" align="left" valign="middle"><?php echo utf8_encode($rs_qry2->responsable); ?></td>
      </tr>
    <tr>
      <td align="justify" class="subtitulos" >FECHA DE CONTROL</td>
      <td colspan="2" align="left" valign="middle"><?php echo utf8_encode($rs_qry2->fecha_control); ?></td>
    </tr>
    <tr>
      <td colspan="3" align="justify" >&nbsp;</td>
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

