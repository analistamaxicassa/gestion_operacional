<?php
echo "hola";

//funcion fechas
require_once("FuncionFechas.php");

//recojo variables

$cedula=$_POST['cedula'];
$hoy = date("Y-m-d"); 

//$hoy=date("d/m/y");

require_once('conexion_ares.php'); 
$link=Conectarse();

echo $sql="UPDATE `personal`.`personal_pazysalvo` SET `flimite` = '$hoy' WHERE `personal_pazysalvo`.`cedula` = $cedula;";
		$qry_sql=$link->query($sql);
		
	  
	exit();
				
?>	