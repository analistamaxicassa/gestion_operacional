<?php

//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");

//recojo variables
$descripcion =utf8_decode($_POST['descripcion']);
$ubicacion=$_POST['ubicacion'];
$area=$_POST['area'];


require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

if (($descripcion && $ubicacion && $area) <> "")
{

echo $sql1="INSERT INTO `personal`.`suministros_elementos` (`id`, `descripcion_elemento`, `posible_ubicacion`, `area`) VALUES (NULL, '$descripcion', '$ubicacion', '$area');";
		$qry_sql1=$link->query($sql1);
		
		echo  "ELEMENTO AGREGADO AL LISTADO";
}
else
	echo "No se han llenado todos los campos, VERIFIQUE";
?>
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>RELACION DE SUMINISTROS</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="../estilos.css">
 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

</head>
<body>

<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
