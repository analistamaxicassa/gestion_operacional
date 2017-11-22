<?php

//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");


//recojo variables
$sala=$_POST['sala'];


/*//conexion QUERYS
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}*/

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
	$sql3="SELECT `nombre` FROM `salas` WHERE `cc` = '$sala' ";
		$qry_sql3=$link->query($sql3);
			$rs_qry3=$qry_sql3->fetch_object();  ///consultar 



$sql2="SELECT `elemento`,`descripcion_elemento`, ubicacion,`cantidad`, cedula,   ss.id FROM `suministros_sala` ss inner join suministros_elementos se on ss.elemento = se.id WHERE `sala` = '$sala' and estado = '1' order by descripcion_elemento";
		$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
			
			if (empty($rs_qry2)) {
   						 echo 'No existen registros';
						exit;
								}
	
		
		
		 
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ares::Actualizacion de información</title>
<link rel="stylesheet" type="text/css" href="../estilos.css">
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

	 <form>
    
       <p>&nbsp;</p>
       <table width="75%" border="1" align="center" style="font-size:10px">
         <tr>
          <th colspan="2" class="intro_tkg" scope="col"><span >Ubicacion:</span></th>
          
           <th colspan="6" class="textbox" scope="col"><?php echo utf8_encode($rs_qry3->nombre); ?></th>
         </tr>
         <tr>
           <th colspan="6" scope="col">&nbsp;</th>
         </tr>
         <tr class="encabezados">
           <th width="9%" scope="col">Id</th>
           <th width="30%" scope="col">Elemento</th>
           <th width="13%" scope="col">Ubicacion</th>
           <th width="9%" scope="col">Cantidad</th>
          	<th width="27%" scope="col">Cedula</th>
         </tr>
          <?php
     do{
		 
		/* $sql3="SELECT ubicacion FROM `suministros_elementos` WHERE `id` = '$rs_qry2->elemento' ";
		$qry_sql3=$link->query($sql3);		
			$rs_qry3=$qry_sql3->fetch_object();  ///consultar 		*/
			
			
			
	$sql4="SELECT nombre FROM act_man2.usuarios_queryx WHERE cedula = '$rs_qry2->cedula'";
		$qry_sql4=$link->query($sql4);
			$rs_qry4=$qry_sql4->fetch_object();  ///consultar 
			
	
 
     ?>
         <tr>
         <th scope="col"><?php echo $rs_qry2->id; ?></th>
           <th scope="col" align="left"><?php echo utf8_encode($rs_qry2->descripcion_elemento); ?></th>
           <th scope="col"><?php echo $rs_qry2->ubicacion; ?></th>
           <th scope="col"><?php echo $rs_qry2->cantidad; ?></th>
          <th scope="col"><?php echo $rs_qry2->cedula." - ".$rs_qry4->nombre; ?></th>
         </tr>
     
       <?php
		}
		while($rs_qry2=$qry_sql2->fetch_object());	
		?>
        
      </table>
       <table align="center" width="75%" border="0">
  <tr>
    <th width="75%"   align="justify"  scope="col"  style="font-size:10px">Declaro que he recibido los elementos antes descritos en perfecto estado de funcionamiento y que apartir de ahora me hago responsable de su custodia y cuidado</th>
  </tr>
  <tr>
    <td style="font-size:10px"><p><strong>Igualmente autorizo a MAXICASSA, PEGOMAX, TU CASSA E INNOVAPACK a descontar de mi salario mensual o prestacines sociales en caso de perdida </strong></p></td>
  </tr>
</table>
   <p>&nbsp;</p>
       <p>&nbsp;</p>
       <p>Entrega: _______________ Recibe:________________, ______________________ Fecha______
       <p>       
       <td width="10">&nbsp;</td>
        
       </p>
	 </form>
</body>
</html>
