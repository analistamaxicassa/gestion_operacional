<?php 

//error_reporting(0);


//funcion fechas

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

$sql2="SELECT cedula, nombre, cargo
FROM act_man2.usuarios_queryx
order by nombre ";
			$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
$sala = "099";			
		
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
  
 <script> 					
function gsalaemp(cedula, sala)
{  

window.open("http://190.144.42.83:9090/plantillas/suministros/inventario_emp_pys.php?sala="+sala+"&&empleado="+cedula+"", "Inv Asociado", "width=800, height=500")
//	location.href="http://190.144.42.83:9090/plantillas/suministros/inventario_emp_pys.php?sala="+sala+"&&empleado="+cedula+""
	
	}
  
</script>
	
</head>
<body>

<p>

<form>
<div id="validador"> 


  <table width="90%" border="1" align="center"  style="border-collapse:collapse">
   
    <tr>
      <td colspan="4" align="left" valign="middle"><h2 class="encabezados">LISTADO DE EMPLEADOS</h2></td>
      <td width="39" align="left" valign="middle"><img src="../PAZYSALVO/img/informe.png" alt="reasignar elementos" name="myImage1"  width="39" height="28" id="myImage2" onClick="gsalae( <?php echo $cedula; ?>, <?php echo $row_n['CODCC']; ?> )" /></td>
      <td width="39" align="left" valign="middle"><img src="../PAZYSALVO/img/entregar.png" alt="reasignar elementos" name="myImage3"  width="39" height="28" id="myImage3" onClick="gsalae( <?php echo $cedula; ?>, <?php echo $row_n['CODCC']; ?> )" /></td>
      <td width="39" align="left" valign="middle"><img src="../PAZYSALVO/img/intercambiar.png" alt="reasignar elementos" name="myImage3"  width="39" height="28" id="myImage4" onClick="gsalae( <?php echo $cedula; ?>, <?php echo $row_n['CODCC']; ?> )" /></td>
      <td width="109" align="left" valign="middle">&nbsp;</td>
    </tr>
  </table>
  
  <table  width="90%" border="1" align="center"  style="border-collapse:collapse">
   
    
    
    <tr>
      <td colspan="2" align="left" valign="middle" class="subtitulos"><strong>CEDULA</strong></td>
      <td width="271" colspan="-1" align="center" valign="middle" class="subtitulos"><strong>NOMBRE</strong></td>
      <td align="left" valign="middle" class="subtitulos"><strong>CARGO</strong></td>
      <td align="left" valign="middle" class="subtitulos">&nbsp;</td>
      <td align="left" valign="middle" class="subtitulos">&nbsp;</td>
      <td align="left" valign="middle" class="subtitulos">&nbsp;</td>
      <td align="left" valign="middle" class="subtitulos">&nbsp;</td>
      </tr>

    <?php 
  do{
  ?>   
    
    <tr>

      <td width="40" align="left" valign="middle" style="font-size:12px"><img src="../PAZYSALVO/img/utiles.png" alt="Herramientas Asignadas" name="myImage"  width="37" height="23" id="myImage" onclick="gsalaemp('<?php echo $rs_qry2->cedula; ?>','<?php echo $sala; ?>')" /></td>
      <td width="53" align="left" valign="middle" style="font-size:12px"><?php echo $rs_qry2->cedula; ?></td>
      <td colspan="-1" align="left" valign="middle"><?php echo utf8_encode($rs_qry2->nombre);?></td>
      <td align="left" valign="middle"><?php echo utf8_encode($rs_qry2->cargo);?></td>
      <td align="left" valign="middle"><input type="radio" name="radio" id="opcion" value="opcion"></td>
      <td align="left" valign="middle">&nbsp;</td>
      <td align="left" valign="middle">&nbsp;</td>
      <td align="left" valign="middle">&nbsp;</td>
      </tr>
      <?php 
  }while($rs_qry2=$qry_sql2->fetch_object());
  ?>  
  </table>
  <p>&nbsp;</p>
  <p><span class="encabezados">
    <input type="submit" style="background:#0F0" name="cerrar" id="cerrar"  onClick="window.close();"value="CERRAR" >
</span></p>
</div></form>
 <p>