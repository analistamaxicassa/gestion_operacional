<?php



//recojo variables
$cedula=$_POST['cedula'];
$compromiso=$_POST['compromiso'];
$f_revision=$_POST['f_revision'];
$hoy = date('Y-m-d') ;

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();


$sql1="INSERT INTO `personal`.`form_compromiso_emp` (`id`, `cedula`, `desc_compromiso`, `f_compromiso`, `desc_seguimiento`, `f_seguimiento`, `estado`) VALUES (NULL, '$cedula', '$compromiso', '$hoy', NULL, '$f_revision', '1');";
		$qry_sql1=$link->query($sql1);
//echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";		
		 
?>
			
