<?php 

error_reporting(0);

//recojo variables
$sala=$_REQUEST['sala'];
//$sala='555';
$hoy=date("d/m/Y");


//funcion fechas

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

 $sql2="SELECT ss.cedula cedula, `descripcion_elemento`, observacion, `cantidad`,`ubicacion`,  nombre, `condicion`
FROM suministros_sala ss inner join suministros_elementos se on ss.elemento = se.id
 inner join act_man2.`usuarios_queryx` ec on ss.cedula = ec.cedula
WHERE sala = '$sala' order by ubicacion";
			$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
			
 $sql3="SELECT nombre FROM salas WHERE cc = '$sala'";
			$qry_sql3=$link->query($sql3);
			$rs_qry3=$qry_sql3->fetch_object();  ///consultar 
			
			
			
	
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
  

		<script type="text/javascript">
function imprSelec(validador){
	var ficha=document.getElementById(validador);
    var ventimp=window.open(' ','popimpr');
	ventimp.document.write(ficha.innerHTML);
	ventimp.document.close();
	ventimp.print();
	ventimp.close();
}
</script>
</head>
<body>

<p>

<form>
<div id="validador"> 


  <table width="90%" border="1" align="center"  style="border-collapse:collapse">
   
    <tr>
      <td colspan="8" align="left" valign="middle"><h2 class="encabezados">INVENTARIO DE SUMINISTROS  <?php echo $hoy;?> </h2></td>
    </tr>

    <tr>
      <td width="76" align="left" valign="middle" style="background-color:#999"><strong>Ubicación</strong></td>
      <td colspan="7"  align="justify" ><?php echo utf8_encode($rs_qry3->nombre);?></td>
    </tr>
    
   
    
    
    <tr>
      <td colspan="3" align="left" valign="middle" class="subtitulos"><strong>Descripción</strong></td>
      <td width="138" align="center" valign="middle" class="subtitulos"><strong>Cantidad</strong></td>
      <td width="126" align="left" valign="middle" class="subtitulos">Ubicación</td>
      <td width="175" align="left" valign="middle" class="subtitulos">Responsable Directo    Cedula-Nombre</td>
      <td width="124" align="left" valign="middle" class="subtitulos">Estado</td>
      <td width="124" align="left" valign="middle" class="subtitulos">Observación</td>
    </tr>

    <?php 
  do{
  ?>   
    
    <tr>
      <td style="font-size:12px" colspan="3" align="left" valign="middle"><?php echo utf8_encode($rs_qry2->descripcion_elemento);?></td>
      <td align="center" valign="middle"><?php echo $rs_qry2->cantidad;?></td>
      <td align="left" valign="middle"><?php echo $rs_qry2->ubicacion;?></td>
      <td align="left" valign="middle"><?php echo $rs_qry2->cedula." - ".$rs_qry2->nombre;?></td>
      <td align="left" valign="middle"><?php echo $rs_qry2->condicion;?></td>
      <td align="left" valign="middle"><?php echo $rs_qry2->observacion;?></td>
    </tr>
      <?php 
  }while($rs_qry2=$qry_sql2->fetch_object());
  ?>  
  </table>
  
  <table align="center" width="80%" border="0">
  <tr>
    <th width="70%"   align="justify"  scope="col">Declaro que he recibido los elementos antes descritos en perfecto estado de funcionamiento y que apartir de ahora me hago responsable de su custodia y cuidado</th>
  </tr>
  <tr>
    <td><p ><strong>Igualmente autorizo a MAXICASSA, PEGOMAX, TU CASSA E INNOVAPACK a descontar de mi salario mensual o prestacines sociales en caso de perdida </strong></p></td>
  </tr>
</table>

  <table width="70%" border="1" align="center">
    <tr>
      <th colspan="3">&nbsp;</th>
      </tr>
    <tr>
      <th width="37%">En constancia Firma:</th>
      <th width="34%" scope="col">&nbsp;</th>
      <th width="29%" scope="col">Fecha:<?php echo $hoy;?>  </th>
    </tr>
    <tr>
      <th height="48" scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
    </tr>
    <tr>
      <td>Responsable Directos </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
 <input type="button" name="imprimir" id="prn" value="imprimir" onClick="imprSelec('validador');" >
</div></form>
 <p>