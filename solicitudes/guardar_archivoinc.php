<?php

include "../permisos/conexion_ares.php";
$link=Conectarse();

@$archivo=$_POST['archivo'];
//@$archivo=$_POST['190.144.42.83:9090/GGHH/INCAPACIDADES'];
@$titulo=$_POST['titulo'];
//datos del arhivo   
$uploaddir = 'archivoinc/';
$uploadfile = $uploaddir . basename($_FILES['archivo']['name']);

if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
	@$sql="UPDATE `personal`.`incapacidades` SET `adjunto` = '$uploadfile' WHERE `incapacidades`.`cedula` = $cedula";
	$guardar=$link->query($sql);
?>
  <script language="Javascript"> 
	alert(" Archivo guardado correctamente. Adjunto el siguiente archivo de ser necesario !!!") ;
	window.location.href = "http://190.144.42.83:9090/plantillas/solicitudes/selecciona_archivo2.php";
	
	</script>
  
<?php
}
?>