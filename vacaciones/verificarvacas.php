<?php

error_reporting(0);
//recojo variables
$periodov=$_POST['periodov'];
$diasseleccionado = intval(substr($periodov, -2));   
$cedulae=$_POST['cedulae'];

//$diasp=$_POST['diasp'];*/

//conexion

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

//$consultaBusqueda = $_POST['valorBusqueda'];

//Variable vacía (para evitar los E_NOTICE)

$sql1="SELECT sum(dias) dias FROM `vacaciones` WHERE `cedula` = '$cedulae'  and periodo = '$periodov'";
			$qry_sql1=$link->query($sql1);
			$rs_qry1=$qry_sql1->fetch_object();  ///consultar 
			
			if ($rs_qry1== NULL) {
				echo "0";
				//exit();
			}
			else
			{
			echo $diastomados = $rs_qry1->dias;	
			}
?>




