<?php

echo "llegue aqui";
//recojo variables
$cedula=$_POST['cedula'];
$ecivil= $_POST['txtecivil'];
$hyedades=$_POST['hyedades'];
$educacion= $_POST['educacion'];
$qlomotiva=$_POST['qlomotiva'];
$proyecciones= $_POST['proyecciones'];
$sala= $_POST['sala'];
$tipo_sala=$_POST['tipo_sala'];
$salario= $_POST['salario'];
$ayudas=$_POST['ayudas'];
$evaluador= $_POST['evaluador'];
$fevaluacion=$_POST['fevaluacion'];
$nota= $_POST['nota'];
$fortalezas=$_POST['fortalezas'];
$debilidades= $_POST['debilidades'];
$recomendacion=$_POST['recomendacion'];
$ap_conocimiento= $_POST['ap_conocimiento'];
$ap_estudios=$_POST['ap_estudios'];
$ap_presentacion= $_POST['ap_presentacion'];
$horarios=$_POST['horarios'];
$colaboracion= $_POST['colaboracion'];
$proylaboral=$_POST['proylaboral'];
$observ= $_POST['observ'];


include "../PAZYSALVO/conexion_ares.php";
$link=Conectarse();

$hoy=date("d/m/y");

	
echo $sql="UPDATE `cliente_interno` SET `sala`='$sala',`tipo_sala`='$tipo_sala',`educacion`='$educacion',`hijosyedades`='$hyedades',`motivacion`='$qlomotiva',`proyeccion`='$proyecciones',`ayudas`='$ayudas',`evaluador`='$evaluador',`fecha_evaluacion`='$fevaluacion',`evaluacion`='$nota',`fortalezas`='$fortalezas',`debilidades`='$debilidades',`recomendaciones`='$recomendacion',`ap_conocimientos`='$ap_conocimiento',`ap_estudios`='$ap_estudios',`ap_presentacion`='$ap_presentacion',`ac_horarios`='$horarios',`ac_colaboracion`='$colaboracion',`proyeccion_laboral`='$proylaboral',`observacion`='$observ' WHERE `cedula`='$cedula'
 ";

$qry_sql=$link->query($sql);
?>
<script>
alert("P R O C E S A D O")
</script>

