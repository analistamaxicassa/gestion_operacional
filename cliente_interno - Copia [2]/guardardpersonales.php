<?php

//recojo variables
$cedula=$_POST['cedula'];
$cc= $_POST['cc'];
$hijos_edades= $_POST['hijos_edades'];
$educacion=$_POST['educacion'];
$q_lo_motiva= $_POST['q_lo_motiva'];
$proyecciones=$_POST['proyecciones'];
$ayudas=$_POST['ayudas'];

include "../PAZYSALVO/conexion_ares.php";
$link=Conectarse();

	
 $sql="UPDATE `cliente_interno` SET `sala`= '$cc',`educacion`= '$educacion',`hijosyedades`= '$hijos_edades',`motivacion`= '$q_lo_motiva',`proyeccion`= '$proyecciones',`ayudas`= '$ayudas' WHERE cedula = '$cedula'";

$qry_sql=$link->query($sql);
?>
<script>
alert("P R O C E S A D O")
</script>

