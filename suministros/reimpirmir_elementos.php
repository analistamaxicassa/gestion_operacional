<?php

//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");

//recojo variables
$id=$_POST['iditem'];



require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
		
$sql3="SELECT s.nombre sala, se.descripcion_elemento, tipo, serie, marca, ss.observacion, ss.cantidad, ss.ubicacion, uq.nombre nombreemp, ss.entrega, ss.fecha FROM `suministros_sala` ss INNER JOIN SUMINISTROS_ELEMENTOS se on ss.elemento = se.id
inner join act_man2.usuarios_queryx uq on ss.cedula = uq.cedula inner join salas s on ss.sala = s.cc
WHERE ss.id = '$id'";
		$qry_sql3=$link->query($sql3);		
			$rs_qry3=$qry_sql3->fetch_object();  ///consultar 		
		
		
		
		
		 
?>
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>RELACION DE SUMINISTROS</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="../estilos.css">
 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
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
<div id="validador" align="center">


<p>&nbsp;</p>
<h5  align="center"><strong><em>ACUSO DE RECIBIDO Y AUTORIZACIÓN DE DESCUENTO</em></strong></h5>
<p  align="center">&nbsp;</p>
<table  align="center" width="60%" border="1">
  <tr>
    <td >Sala - Oficina
    - Planta<td ><?PHP echo $rs_qry3->sala;?>        
  </tr>
  <tr>
    <td width="31%" >Descripcion Elemento</th>
    <td width="69%" ><?PHP echo  utf8_encode($rs_qry3->descripcion_elemento);?></th>
  </tr>
  <tr>
    <td >Tipo    
    <td ><?PHP echo  utf8_encode($rs_qry3->tipo);?>        
  </tr>
  <tr>
    <td >Serie    
    <td ><?PHP echo  utf8_encode($rs_qry3->serie);?>        
  </tr>
  <tr>
    <td >Marca
    <td ><?PHP echo  utf8_encode($rs_qry3->marca);?>        
  </tr>
  <tr>
    <td >Observacion
    <td ><?PHP echo  utf8_encode($rs_qry3->observacion);?>        
  </tr>
  <tr>
    <td>Cantidad</td>
    <td><?PHP echo $rs_qry3->cantidad;?></td>
  </tr>
  <tr>
    <td>Ubicación</td>
    <td><?PHP echo $rs_qry3->ubicacion;?></td>
  </tr>
  <tr>
    <td>Responsable</td>
    <td><?PHP echo $rs_qry3->nombreemp;?></td>
  </tr>
  <tr>
    <td>Entregó</td>
    <td><?PHP echo $rs_qry3->entrega;?></td>
  </tr>
  <tr>
    <td>Fecha de entrega</td>
    <td><?PHP echo $rs_qry3->fecha;?></td>
  </tr>
</table>
<p>&nbsp;</p>
<table align="center" width="60%" border="0">
  <tr>
    <th colspan="2"   align="justify"  scope="col">Declaro que he recibido los elementos antes descritos en perfecto estado de funcionamiento y que apartir de ahora me hago responsable de su custodia y cuidado</th>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><p ><strong>Igualmente autorizo a MAXICASSA, PEGOMAX, TU CASSA E INNOVAPACK a descontar de mi salario mensual o prestacines sociales en caso de perdida </strong></p></td>
  </tr>
  <tr>
    <td height="40" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="53%"><p>__________________</p></td>
    <td width="47%">_____________</td>
  </tr>
  <tr>
    <td>Firma Entrega</td>
    <td>Firma responsable</td>
  </tr>
</table>

<p >&nbsp;</p>
<p >&nbsp;</p>
</div>
</body>
</html>
