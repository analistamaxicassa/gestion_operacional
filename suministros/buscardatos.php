
<?php 	




//error_reporting(0);
$cedulares=$_POST['cedulares'];
//$cedulares="52522883";


require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

$sql1 = "SELECT nombre, cargo, email FROM act_man2.`usuarios_queryx` WHERE `cedula` = '$cedulares'";
$qry_sql1=$link->query($sql1);
$rs_qry1=$qry_sql1->fetch_object();  ///consultar 


		if (empty($rs_qry1->nombre)) 
		{
			echo $dato = "NO EXISTE EMPLEADO";
		
		exit();
		}

	$dato = $rs_qry1->nombre." / ".$rs_qry1->cargo." / ".$rs_qry1->email;		
		
		
		echo $dato;
		
		
		?>
		
