<?php

//error_reporting(0);

require_once('../permisos/conexion_ares.php'); 
$link=Conectarse();

//recojo variables
$ID=$_POST['id'];

	
			$sql="UPDATE `incapacidades` SET queryx = '3' WHERE `id` = '$ID'";
			$qry_sql=$link->query($sql);
	
?>	
