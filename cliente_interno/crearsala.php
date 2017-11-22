<?php

//recojo variables
$ccnuevo=$_POST['ccnuevo'];
$nombre=$_POST['nombre'];
$tipo_sala= $_POST['tipo_sala'];
$localidad= $_POST['localidad'];
$presupuesto=$_POST['presupuesto'];
$jefe_operacion= $_POST['jefe_operacion'];

include "../PAZYSALVO/conexion_ares.php";
$link=Conectarse();

 
$sql="INSERT INTO `personal`.`salas` (`id`, `cc`, `nombre`, `tipo_sala`, `localidad`, `presupuesto`, `jefeoperacion`, `activo`) VALUES (NULL, '$ccnuevo', '$nombre', '$tipo_sala', '$localidad', '$presupuesto', '$jefe_operacion', '1')";
 

$qry_sql=$link->query($sql);

?>
<script>
alert("P R O C E S A D O")
</script>

