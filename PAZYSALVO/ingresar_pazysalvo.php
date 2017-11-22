<?php
require_once('Z:\conec.php');
$ced=$_POST['ced'];
$fsolicitud=$_POST['fsolicitud'];
$fretiro=$_POST['fretiro'];
$mretiro=$_POST['mretiro'];

mysql_select_db($database_conec, $conec);
$sql="INSERT INTO personal_pazysalvo (cedula,fsolicitud,fretiro, motivo) values ('$ced','fsolicitud','fretiro', 'mretiro') ";
echo $sql;
$qry=mysql_query($sql,$conec);


?>