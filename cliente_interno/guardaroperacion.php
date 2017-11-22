<?php

//recojo variables
$cargo=$_POST['cargo'];
$aspecto= $_POST['aspecto'];
$operacion= $_POST['operacion'];

include "../PAZYSALVO/conexion_ares.php";
$link=Conectarse();

	
$sql="INSERT INTO `personal`.`ed_aspectos` (`id`, `cargo`, `aspecto`, `operacion`) VALUES (NULL, '$cargo', '$aspecto', '$operacion');";

$qry_sql=$link->query($sql);
?>
<script>
alert("P R O C E S A D O")

</script>

