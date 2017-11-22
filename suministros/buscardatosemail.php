
<?php 	




//error_reporting(0);
$cedulares=trim($_POST['cedulares']);
//$cedulares="52522883";


require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

$sql1 = "SELECT  email FROM act_man2.`usuarios_queryx` WHERE `cedula` like '%$cedulares%'";
$qry_sql1=$link->query($sql1);
$rs_qry1=$qry_sql1->fetch_object();  ///consultar 


		if (empty($rs_qry1->email)) 
		{
		echo "No se encontro cedula, verifique que el empleado no esta retirado";
		exit();
		}

	$dato = $rs_qry1->email;		
		
		
		echo $dato;
		
		
		?>
		
