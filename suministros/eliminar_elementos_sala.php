<?php

//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();



//recojo variables
$id=$_POST['id'];
$cedulaingreso=$_POST['cedulaingreso'];

$hoy=date("d/m/y");


$sql2="SELECT ss.sala, descripcion_elemento, observacion,`cantidad`,`ubicacion`, nombre, `condicion`
FROM suministros_sala ss inner join suministros_elementos se on ss.elemento = se.id inner join act_man2.`usuarios_queryx` ec on ss.cedula = ec.cedula 
WHERE  ss.id = '$id'
order by ubicacion ";
			$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
			



$sql1="UPDATE `suministros_sala` SET `estado`='0' WHERE `id` = '$id'";
		$qry_sql1=$link->query($sql1);

$sql2="INSERT INTO `personal`.`suministros_inactiva` (`id`, `accion`,`item`, `fecha`, `cedula`) VALUES (NULL, 'inactiva', '$id', '$hoy', '$cedulaingreso');";
		$qry_sql2=$link->query($sql2);
		
		echo "Elemento inactivado";

	
?>
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
 <title>RELACION DE SUMINISTROS</title>
</head>
<body>
<div id="validador" align="center">


<p>&nbsp;</p>
<h5  align="center"><strong><em>DOCUMENTO PARA REEMPLZAR  UN ELEMENTO</em></strong></h5>
<p  align="center">&nbsp;</p>
<table  align="center" width="60%" border="1">
  <tr>
    <td >Sala - Oficina
    - Planta<td ><?PHP echo $rs_qry2->sala;?>        
  </tr>
  <tr>
    <td width="31%" >Descripcion Elemento</th>
    <td width="69%" ><?PHP echo  utf8_encode($rs_qry2->descripcion_elemento);?></th>
  </tr>
  <tr>
    <td >Observacion
    <td ><?PHP echo  utf8_encode($rs_qry2->observacion);?>        
  </tr>
  <tr>
    <td>Cantidad</td>
    <td><?PHP echo ($rs_qry2->cantidad);?></td>
  </tr>
  <tr>
    <td>Ubicación</td>
    <td><?PHP echo  utf8_encode($rs_qry2->ubicacion);?></td>
  </tr>
  <tr>
    <td>Responsable</td>
    <td><?PHP echo  utf8_encode($rs_qry2->nombre);?></td>
  </tr>
</table>
<p>&nbsp;</p>
<table align="center" width="60%" border="0">
  <tr>
    <th colspan="2"   align="justify"  scope="col"><p>Razones para reemplazar:</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></th>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="53%"><p>__________________</p></td>
    <td width="47%">_____________</td>
  </tr>
  <tr>
    <td>Firma de Realiza</td>
    <td>Firma de Aceptacion</td>
  </tr>
</table>

</div>

</body>
</html>
