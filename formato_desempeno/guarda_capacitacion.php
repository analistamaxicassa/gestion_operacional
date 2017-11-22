<?php

//recojo variables
$cedula=$_POST['cedula'];
//$cedula='52522883';
$hoy = date('Y-m-d') ;
$capacitacion = $_POST['capacitacion'];


require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();


if($_POST['checkbox'] != "")
{
	if(is_array($_POST['checkbox']))
	{
	
		while(list($key,$value) = each($_POST['checkbox']))
		{
			 $sql="INSERT INTO `personal`.`form_capacitacion` (`id`, `fecha`, `cedula`, `temas`) VALUES (NULL, '$hoy', '$cedula', '$value');";
			$qry_sql=$link->query($sql);
		}
		
		
		
		}


	
}
else {
	echo "Debe marcar alguna casilla";
	}
	

	
$sql1="INSERT INTO `personal`.`form_capacitacion` (`id`, `fecha`, `cedula`, `temas`) VALUES (NULL, '$hoy', '$cedula', '$capacitacion'); ";
$qry_sql1=$link->query($sql1);	
	
	
	if($sql)
	{
		echo "<h1>Los datos fueron almacenados</h1>";
		
		}

?>
			
