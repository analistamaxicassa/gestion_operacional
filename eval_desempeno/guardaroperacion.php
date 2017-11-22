<?php

//recojo variables
$cargo=$_POST['cargo'];
$aspecto= $_POST['aspecto'];
$operacion= $_POST['operacion'];
$perfil= $_POST['perfil'];
echo $opcion= $_POST['opcion'];

include "../PAZYSALVO/conexion_ares.php";
$link=Conectarse();


if ($opcion == '1')
{	
 $sql="INSERT INTO `personal`.`ed_aspectos` (`id`, `cargo`, `aspecto`, `rol`, `operacion`) VALUES (NULL, '$cargo', '2', '', '$operacion');";

$qry_sql=$link->query($sql);
}

if ($opcion == '2')
{	
echo $sql="INSERT INTO `personal`.`ed_aspectos` (`id`, `cargo`, `aspecto`, `rol`, `operacion`) VALUES (NULL, '', '$aspecto', '$perfil', '$operacion');";

$qry_sql=$link->query($sql);
}

if ($opcion == '3')
{	
$sql="INSERT INTO `personal`.`ed_aspectos` (`id`, `cargo`, `aspecto`, `rol`, `operacion`) VALUES (NULL, '999', '1', '999', '$operacion');";

$qry_sql=$link->query($sql);
}



?>
<script>
alert("P R O C E S A D O")
</script>

