<?php



//recojo variables
$cedula=$_POST['cedula'];
$evaluador= $_POST['evaluador'];
$nota= $_POST['nota'];
$fortalezas=$_POST['fortalezas'];
$debilidades= $_POST['debilidades'];
$recomendacion=$_POST['recomendacion'];
$ap_conocimiento= $_POST['ap_conocimiento'];
$ap_estudios= $_POST['ap_estudios'];
$ap_presentacion=$_POST['ap_presentacion'];
$horarios= $_POST['horarios'];
$colaboracion=$_POST['colaboracion'];
$proylaboral= $_POST['proylaboral'];
$observ= $_POST['observ'];

include "../PAZYSALVO/conexion_ares.php";
$link=Conectarse();

$hoy=date("d/m/y");

$sql="INSERT INTO `personal`.`evaluacion_empleado` (`ID`, `cedula`, `evaluador`, `fecha_evaluacion`, `evaluacion`, `fortalezas`, `debilidades`, `recomendaciones`, `ap_conocimientos`, `ap_estudios`, `ap_presentacion`, `ac_horarios`, `ac_colaboracion`, `proyeccion_laboral`, `observacion`) VALUES (NULL, '$cedula', '$evaluador', '$hoy', '$nota', '$fortalezas', '$debilidades', '$recomendacion', '$ap_conocimiento', '$ap_estudios', '$ap_presentacion', '$horarios', '$colaboracion', '$proylaboral', '$observ')";
 

$qry_sql=$link->query($sql);
?>
<script>
alert("P R O C E S A D O")
</script>

