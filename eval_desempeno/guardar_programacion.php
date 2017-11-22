


<?php
$colores = $_POST['colores'];
 $cedulaevalua=$_POST['evaluador'];
 $fevaluacion=$_POST['fecha_limite'];
 
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();



foreach($colores as $color){
    $valor = "'".$color."'";
    $colores_aux[] = $valor;
}
$valores = implode(' , ', $colores_aux);
$sql_valores = '"'.($valores).'"';
 
$sql = "INSERT INTO `personal`.`evaldesep_programacion` (`id`, `evaluador`, `empleados`, `fecha_limite`) VALUES (NULL, '$cedulaevalua', $sql_valores, '$fevaluacion');";
	$qry_sql=$link->query($sql);



// . $sql_valores. ";";
//$sql_insert = "INSERT INTO TBL_COLORES (color) VALUES " . $sql_valores. ";";
 "<br>";
 $sql;
 
?>






<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<strong>PROGRAMACION REALIZADA </strong>
</body>
</html>