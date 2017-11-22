<?php


//recojo variables
$id =($_POST['id']);
$saladestino=$_POST['saladestino'];
echo $ubicacion=$_POST['ubicacion'];
$cantidaddestino=$_POST['cantidaddestino'];
$responsablenew=$_POST['responsablenew'];
$cedulaingreso=$_POST['cedulaingreso'];
$opcion=$_POST['opcion'];

$hoy=date("d/m/y");

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

if ($opcion == 'true')

{
	echo "SE REALIZO UNA REASIGNACION DEL ELEMENTO <br>";
	
	$sql1a="SELECT cedula FROM `suministros_sala` WHERE id = '$id';";
			$qry_sql1a=$link->query($sql1a);
			$rs_qry1a=$qry_sql1a->fetch_object();  ///consultar 
			
			$cedulaactual = $rs_qry1a->cedula;
	
	
	 $sql1="UPDATE `personal`.`suministros_sala` set sala = '$saladestino', ubicacion = '$ubicacion', cedula = '$responsablenew' where id = '$id';";
			$qry_sql1=$link->query($sql1);
			//$rs_qry1=$qry_sql1->fetch_object();  ///consultar 
			
 $sql5="INSERT INTO `personal`.`suministros_inactiva` (`id`, `accion`,`item`, `fecha`, `cedula`) VALUES (NULL, 'Reasignar',
  '$id-$cedulaactual-$responsablenew', '$hoy', '$cedulaingreso');";
		$qry_sql5=$link->query($sql5);
		


			
}

if ($opcion == 'false')
{
		$sql2="select *  from  `personal`.`suministros_sala` where id = '$id';";
			$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
	
			$cantoriginal = $rs_qry2->cantidad;
			
	 	$cantidadfinal =  $cantoriginal - $cantidaddestino;
			$cedulaactual = $rs_qry2->cedula;
			
	$sql3="UPDATE `personal`.`suministros_sala` set cantidad = '$cantidadfinal' where id = '$id';";
			$qry_sql3=$link->query($sql3);
			//$rs_qry1=$qry_sql1->fetch_object();  ///consultar 
			
	$sql4="INSERT INTO `personal`.`suministros_sala` (`id`, `sala`, `elemento`, `observacion`, `cantidad`, `ubicacion`, `cedula`, `condicion`, `entrega`, `fecha`, `estado`) VALUES (NULL, '$saladestino', '$rs_qry2->elemento', 'distribuido', '$cantidaddestino', '$ubicacion', '$responsablenew', 'traslado', '$rs_qry2->cedula', '$hoy', '1');";
			$qry_sql4=$link->query($sql4);
			//$rs_qry1=$qry_sql1->fetch_object();  ///consultar 
	
	$sql6="SELECT max(id) id FROM `suministros_sala` ORDER BY id";
			$qry_sql6=$link->query($sql6);
			$rs_qry6=$qry_sql6->fetch_object();  ///consultar 		

	echo "SE REALIZO UNA DISTRIBUCION DEL ELEMENTO <br>, 
	Utilice la opcion de Reimprimir Acta con el Item No. ".$rs_qry6->id."  para que el empleado la firme";





 $sql5="INSERT INTO `personal`.`suministros_inactiva` (`id`, `accion`,`item`, `fecha`, `cedula`) VALUES (NULL, 'distribuir', '$id-$cedulaactual-$responsablenew', '$hoy', '$cedulaingreso');";
		$qry_sql5=$link->query($sql5);
		
}	

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

</head>
<body>

<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>










<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
</body>
</html>