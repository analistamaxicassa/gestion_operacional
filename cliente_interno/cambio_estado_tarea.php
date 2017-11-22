<?php 
//error_reporting(0);
echo "Se dara por cumplida esta tarea";

//recojo variables
$estado=$_POST['estado'];
$fnueva=$_POST['fnueva'];
$id=$_POST['id'];
$sala=$_POST['sala'];

$hoy = date('d-m-Y') ;


//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();


if($estado== 'CUMPLIDO')
{
	echo "ingreso a cunmplido";
$sql3="UPDATE `personal`.`concepto_sala` SET `fecha_control` = '$hoy', estado = 'CUMPLIDO' WHERE `concepto_sala`.`id` = '$id';";
$qry_sql3=$link->query($sql3);
}
if($estado== 'APLAZADO')
{
echo $sql3="UPDATE `personal`.`concepto_sala` SET `fecha_control` = '$fnueva', estado = 'APLAZADO' WHERE `concepto_sala`.`id` = '$id';";
$qry_sql3=$link->query($sql3);
}

header('Location: http://190.144.42.83:9090/plantillas/cliente_interno/informe_seguimiento.php');
		
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>

</body>
</html>