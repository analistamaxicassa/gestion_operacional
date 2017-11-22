<?php


//recojo variables
$id = $_POST['id'];
$tipo=$_POST['tipo'];
$serie=$_POST['serie'];
$marca=$_POST['marca'];
echo $observacion=$_POST['observacion'];

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

	
			
	
	echo  $sql3="UPDATE `personal`.`suministros_sala` set tipo = '$tipo', serie = '$serie', marca = '$marca',  observacion = '$observacion'  where id = '$id';";
			$qry_sql3=$link->query($sql3);
			//$rs_qry1=$qry_sql1->fetch_object();  ///consultar 
			
		

	echo "SE REALIZO LA MODIFICACION  AL ITEM SELECCIONADO <br>"; 

?>