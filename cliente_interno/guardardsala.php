<?php

//recojo variables
$sala=$_POST['sala'];
$nombre=$_POST['nombre'];
$tipo_sala= $_POST['tipo_sala'];
$localidad= $_POST['localidad'];
$presupuesto=$_POST['presupuesto'];
$jefe_operacion= $_POST['jefe_operacion'];
$activo=$_POST['activo'];

include "../PAZYSALVO/conexion_ares.php";
$link=Conectarse();

	
 $sql="UPDATE `salas` SET `nombre`='$nombre',`tipo_sala`='$nombre',`localidad`='$localidad',`presupuesto`='$presupuesto',`jefeoperacion`='$jefe_operacion',`activo`='$activo' WHERE cc = '$sala'";
$qry_sql=$link->query($sql);
?>
<script>
alert("P R O C E S A D O")
</script>

