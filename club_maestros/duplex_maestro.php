<?php 	

//error_reporting(0);
$cedula=$_POST['cedula'];
//$cedula = '52522883';

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

$sql1 = "SELECT nombre from `personal`.`club_maestros`  WHERE `cedula` = '$cedula'";
$qry_sql1=$link->query($sql1);
$rs_qry1=$qry_sql1->fetch_object();  ///consultar 


		if (empty($rs_qry1->nombre)) 
		{
			$dato= '1';
			echo $dato;
		exit();
		}

		$dato = $rs_qry1->nombre;		
		echo $dato;
		
		
		?>
		
