
<link rel="stylesheet" type="text/css" href="../estilos.css"/>
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
 

<?php

//error_reporting(0);
//$sala = '511';
$cedula = $_POST['cedula'];
$sala= $_POST['sala'];
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
  

session_start();
if($_SESSION['us'] == '2') {
	
	?>
	
<script>
		alert( "USTED NO TIENE PERMISOS PARA INGRESAR A ESTA SECCION")
	location.href="selecciona_sala.php"
	
	  </script>
 <!DOCTYPE html>
 
<html lang="es">
 
<head>

</head>
<body>
      <?php
	exit();
	}

////consulta de concepto de sala

$sql2="SELECT id, evaluador, fecha_evaluacion, evaluacion, fortalezas, debilidades, recomendaciones, ap_conocimientos, ap_estudios, ap_presentacion, ac_horarios, ac_colaboracion, proyeccion_laboral, observacion  FROM `evaluacion_empleado` WHERE cedula = '$cedula' order by id desc ";
			$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
				
		
	if (empty($rs_qry2)) {
    echo 'No existen registros';
	exit();
	}

	else {
	$evaluador = $rs_qry2->evaluador;
	$fecha_evaluacion = $rs_qry2->fecha_evaluacion;
	$evaluacion = $rs_qry2->evaluacion;
	$fortalezas = $rs_qry2->fortalezas;
	$debilidades = $rs_qry2->debilidades;
	$recomendaciones = $rs_qry2->recomendaciones;
	$ap_conocimientos = $rs_qry2->ap_conocimientos;
	$ap_estudios = $rs_qry2->ap_estudios;
	$ap_presentacion = $rs_qry2->ap_presentacion;
	$ac_horarios = $rs_qry2->ac_horarios;
	$ac_colaboracion = $rs_qry2->ac_colaboracion;
	$proyeccion_laboral = $rs_qry2->proyeccion_laboral;
	$observacion = $rs_qry2->observacion;
			}
			

do{
	?>
    <A href="informe_sala.php?sala=<?php echo $sala;?>">REGRESAR</A>
<?php 
?>   
    
<script src="//code.jquery.com/jquery-1.10.2.js"></script>


<table width="830" border="1" align="center" class="formulario" style="border-collapse:collapse">
    <tr>
      <td height="2" colspan="2" align="left" valign="middle" bgcolor="#003399" ><span class="header"></span></td>
      <td colspan="2"  align="justify" bgcolor="#003399" class="header" >&nbsp;</td>
  </tr>
    <tr>
      <td  class="subtitulos" colspan="2" align="left" valign="middle"><strong>Fecha de evaluacion</strong></td> 
      <td class="header" colspan="2"  align="justify" ><span class="subtitulos"><h3><?php echo $rs_qry2->fecha_evaluacion; ?></h3></span></td>      </tr> 
    <tr>
      <td class="header" colspan="2" align="left" valign="middle"><strong>Evaluador</strong></td> 
      <td  class="subtitulos" colspan="2" align="justify" valign="middle"><span class="header"><?php echo utf8_encode($rs_qry2->evaluador); ?></span></td> 
  </tr> 
 <tr>
      <td class="header" colspan="2" align="left" valign="middle"><strong>Nota de Evaluacion</strong></td> 
      <td width="455" align="justify" valign="middle" class="header">
	  <?php   echo $rs_qry2->evaluacion; ?></td>
    <td width="379" height="25" align="justify" valign="top" class="header"><p class="header">A: MUY BUENO</p>
      <p class="header">B: BUENO</p>
      <p class="header">C: MATRICULA CONDICIONAL</p></td>
 </tr>
      <tr>
      <td class="header" colspan="2" align="left" valign="middle"><strong>Fortalezas</strong></td> 
      <td class="header" colspan="2" align="justify"  valign="middle"><?php echo utf8_encode($rs_qry2->fortalezas); ?></td>
     </tr>
      <tr>
      <td class="header" colspan="2" align="left" valign="middle"><strong>Debilidades</strong></td> 
      <td class="header" colspan="2" align="justify"  valign="middle"><?php echo utf8_encode($rs_qry2->debilidades); ?></td>
     </tr>

      <tr>
      <td class="header" colspan="2" align="left" valign="middle"><strong>Recomendaciones</strong></td> 
      <td class="header" colspan="2" align="justify" valign="middle"><?php echo utf8_encode($rs_qry2->recomendaciones); ?></td> 
     </tr>
      <tr>
      <td rowspan="3" align="left" valign="middle" class="header"><strong>Aptitud</strong></td>
      <td width="84" colspan="-1" align="left" valign="middle" class="header">Conocimiento del Producto/Puesto</td> 
      <td colspan="2" align="justify" valign="middle" class="header"><?php echo $rs_qry2->ap_conocimientos; ?></td> 
     </tr>
      <tr>
        <td colspan="-1" align="left" valign="middle" class="header">Estudios</td>
        <td colspan="2" align="justify" valign="middle" class="header"><?php echo $rs_qry2->ap_estudios; ?></td>
      </tr>
      <tr>
        <td colspan="-1" align="left" valign="middle" class="header">Presentacion</td>
        <td colspan="2" align="justify" valign="middle" class="header"><?php echo $rs_qry2->ap_presentacion; ?></td>
      </tr>
      <tr>
      <td rowspan="2" align="left" valign="middle" class="header"><strong>Recomendaciones</strong></td>
      <td colspan="-1" align="left" valign="middle" class="header">Horarios</td> 
      <td colspan="2" align="justify" valign="middle" class="header"><?php echo $rs_qry2->ac_horarios; ?></td> 
     </tr>
      <tr>
        <td colspan="-1" align="left" valign="middle" class="header">Colaboracion</td>
        <td colspan="2" align="justify" valign="middle" class="header"><?php echo $rs_qry2->ac_colaboracion; ?></td>
      </tr>
    <tr>
      <td class="header" colspan="2" align="left" valign="middle"><strong>Proyeccion Laboral</strong></td> 
      <td class="header" colspan="2" align="justify" valign="middle"><?php echo utf8_encode($rs_qry2->proyeccion_laboral); ?></td> 
  </tr>
      <tr>
      <td class="header" colspan="2" align="left" valign="middle"><strong>Observaciones</strong></td> 
      <td class="header" colspan="2" align="justify" valign="middle"><?php echo utf8_encode($rs_qry2->observacion); ?></td> 
     </tr>
      <tr>
        <td height="50" colspan="2" align="left" valign="middle" class="header"><strong>Observacion General</strong>        </td>
        <td class="subtitulos" colspan="2" align="justify" valign="middle">
            <input name="observacion" type="text" id="observacion" value="" size="140" /></td>
    </tr>
     
</table>
<?php
}
while($rs_qry2=$qry_sql2->fetch_object());	
//}
?>	

</body>
</html>
<br>
