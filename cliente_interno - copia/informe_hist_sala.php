
<link rel="stylesheet" type="text/css" href="../estilos.css"/>

 
<table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="100%">
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>FECHA</strong></td>
      <td class="header" colspan="6"  align="justify" ><strong>AUTOR</strong></td>
      <td class="header"  align="justify" ><strong>CONCEPTO</strong></td>
    </tr>




<?php

//error_reporting(0);
//$sala = '511';
$sala = $_REQUEST['sala'];
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
  


////consulta de concepto de sala

			$sql2="SELECT fecha, concepto, autor FROM `concepto_sala` WHERE cc = '$sala'";
			$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
				
		
	if (empty($rs_qry2)) {
    echo 'No existen registros';
	exit();
	}

	else {
		 $rs_qry2->fecha;	
		 $rs_qry2->concepto;
		 $rs_qry2->autor;
			}
do{
	?>
    
<script src="//code.jquery.com/jquery-1.10.2.js"></script>

<form method="post" action="../cliente_interno/selecciona_sala.php">
   <tr>
      <td class="header" colspan="4" align="left" valign="middle"><?php echo utf8_encode($rs_qry2->fecha); ?></td> 
      <td class="header" colspan="6"  align="justify" ><?php echo utf8_encode($rs_qry2->autor); ?></td>
      <td width="281" class="header"  align="justify" ><?php echo utf8_encode($rs_qry2->concepto); ?></td>
    </tr> 
  
<?php
}
while($rs_qry2=$qry_sql2->fetch_object());	
//}
?>	


</table>
<br>
