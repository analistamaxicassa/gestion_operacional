<?php

include "../permisos/conexion_ares.php";
$link=Conectarse();

@$archivo=$_POST['archivo'];
@$titulo=$_POST['titulo'];
//datos del arhivo   
$uploaddir = 'archivo/';
$uploadfile = $uploaddir . basename($_FILES['archivo']['name']);

if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
	@$sql="UPDATE `personal`.`personal_pazysalvo` SET `adjunto` = '$uploadfile' WHERE `personal_pazysalvo`.`cedula` = $cedula";
	//$guardar=$link->query($sql);
?>
  <script language="Javascript"> 
	alert(" archivo guardado correctamente!!!") ;
	window.location.href = "pazysalvoVB.php";
	
	</script>
  
<?php
}
?>