<?php

echo "ingreso";

//recojo variables
echo $cedula=$_POST['cedula'];
$hora=$_POST['hora'];
$fecha=$_POST['fecha'];
$inicio=$_POST['inicio'];
$final=$_POST['final'];
$horario = $inicio." a ".$final;


/*//conexion QUERYS
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}*/

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();


$sql1="INSERT INTO `personal`.`permisos_rephoras` (`id`, `cedula`, `fecha`, `cantidad`, `horario`, `confirmacion`) VALUES (NULL, '$cedula', '$fecha', '$hora', '$horario', '0');";
		$qry_sql1=$link->query($sql1);
		
		 
?>
			
