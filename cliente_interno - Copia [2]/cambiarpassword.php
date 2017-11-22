<?php
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
$usuario = $_POST['usuario'];
$anterior = $_POST['anterior'];
$nueva = $_POST['nueva'];

	
	//consulta USUARIO
	$sql1="SELECT password FROM `autentica_ci` WHERE cedula = '$usuario'";
			$qry_sql1=$link->query($sql1);
			$rs_qry1=$qry_sql1->fetch_object();  ///consultar 


if ($rs_qry1->password <> $anterior) {
    echo 'La clave anterior digitada no coincide, intente de nuevo';
	exit();
				}
	
	$sql2="UPDATE `autentica_ci` SET `password`= '$nueva' where `cedula` = '$usuario' ";
			$qry_sql2=$link->query($sql2);
			//$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
	
	echo "SU CLAVE HA SIDO MODIFICADA, INGRESE DE NUEVO";		
	
	 ?>

