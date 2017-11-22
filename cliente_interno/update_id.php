<?php

echo "ingreso";
//recojo variables
echo $id = $_POST['id'];
echo $calificacion=$_POST['calificacion'];
echo $hallazgo=$_POST['hallazgo'];
echo $tarea=$_POST['tarea'];
echo $fcontrol=$_POST['fcontrol'];

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

	
			
	
	echo  $sql3="UPDATE `personal`.`concepto_sala` SET `tarea` = '$tarea', calificacion = $calificacion, hallazgo = $hallazgo, fecha_control = $fcontrol WHERE `concepto_sala`.`id` = '$id';";
			$qry_sql3=$link->query($sql3);
			//$rs_qry1=$qry_sql1->fetch_object();  ///consultar 
			
		

	echo "SE REALIZO LA MODIFICACION  AL ITEM SELECCIONADO <br>"; 

?>