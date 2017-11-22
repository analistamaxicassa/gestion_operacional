
 
<?php
//error_reporting(0);

//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		} 
		
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

//session_start();
$area=$_POST['area'];
$concepto=$_POST['concepto'];
$cedula=$_POST['cedula'];
$id=$_POST['id'];

   //inserta concepto por empleado
	 
$sql5="UPDATE `personal`.`eval_desempeno` SET `$area` = '$concepto' WHERE `eval_desempeno`.`ced_evaluado` = '$cedula' and `eval_desempeno`.`id` = '$id' ;"; 
		$qry_sql5=$link->query($sql5);
		
	

?>

<h3 align="center">&nbsp;</h3>
<h3 align="center">El concepto  ha sido guardado
</h3>
<h3>&nbsp;</h3>
<p align="center">&nbsp;</p>
<div id="validador"></div>

