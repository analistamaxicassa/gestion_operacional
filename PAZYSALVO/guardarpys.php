<?php
session_start();


include "conexion_ares.php";
$link=Conectarse();
$areas=$_POST['area'];
$obs= $_POST['obs'];
$cedula= $_POST['cedula'];
$nomaval2=  $_SESSION['AVALADOR'];



$hoy=date("d/m/y");

	
$sql="UPDATE `personal_pazysalvo` SET `obs_$areas`='$obs', $areas= '$hoy', `usu_$areas`='$nomaval2'  WHERE `cedula`='$cedula' ";
$qry_sql=$link->query($sql);
?>
<script>
alert("P R O C E S A D O")
</script>

