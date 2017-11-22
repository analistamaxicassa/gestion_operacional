<?php
//recojo variables
$cedula=$_POST['cedula'];
$observasamudio= $_POST['observasamudio'];
$pagina= $_POST['pagina'];

include "../PAZYSALVO/conexion_ares.php";
$link=Conectarse();

$hoy=date("d/m/y");

	
$sql="UPDATE `cliente_interno` SET `obfsamudio`='$observasamudio', `fechafsamudio`='$hoy'  WHERE `cedula`='$cedula' ";
$qry_sql=$link->query($sql);

?>
<script>
alert("P R O C E S A D O")
document.location.href="http://190.144.42.83:9090/plantillas/cliente_interno/informe_cliente_interno.php?pagina=<?php
		  echo $pagina+1 ?>"
</script>

