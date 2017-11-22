<?php


//recojo variables
$cedulaingreso=$_POST['cedulaingreso'];
$actual =($_POST['actual']);
$nuevo=$_POST['nuevo'];
$tmp = $nuevo."temp";

$hoy=date("d/m/y");

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
$sql1="UPDATE `personal`.`suministros_sala` set cedula = '$tmp' where cedula = '$actual';";
			$qry_sql1=$link->query($sql1);
			//$rs_qry1=$qry_sql1->fetch_object();  ///consultar 
		
$sql2="UPDATE `personal`.`suministros_sala` set cedula = '$actual' where cedula = '$nuevo';";
			$qry_sql2=$link->query($sql2);
			
$sql3="UPDATE `personal`.`suministros_sala` set cedula = '$nuevo' where cedula = '$tmp';";
			$qry_sql3=$link->query($sql3);			
			
 $sql5="INSERT INTO `personal`.`suministros_inactiva` (`id`, `accion`,`item`, `fecha`, `cedula`) VALUES (NULL, 'intercambiar', '$actual-$nuevo', '$hoy', '$cedulaingreso');";
		$qry_sql5=$link->query($sql5);
					
					
		echo  "INFORMACION ACTUALIZADA<br>Utilice la opcion de reimpimir por cedula para hacer firmar los documentos";

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










<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
</body>
</html>