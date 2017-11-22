<?php

include "../permisos/conexion_ares.php";
$link=Conectarse();

@$archivo=$_POST['archivo'];
//@$archivo=$_POST['190.144.42.83:9090/GGHH/INCAPACIDADES'];
@$titulo=$_POST['titulo'];
//datos del arhivo   
$uploaddir = 'archivopermiso/';
$uploadfile = $uploaddir . basename($_FILES['archivo']['name']);

if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
	@$sql="UPDATE `personal`.`permisos` SET `adjunto` = '$uploadfile' WHERE `permisos`.`id` = $id";
	$guardar=$link->query($sql);
?>
  <script language="Javascript"> 
	alert ("El archivo ha sido guardado correctamente");
	window.location.href = "http://190.144.42.83:9090/plantillas/solicitudes/index.php";
	
	</script>
<?php
}
?>