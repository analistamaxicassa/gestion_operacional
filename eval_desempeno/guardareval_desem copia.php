<?php
error_reporting(0);


require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

session_start();


$hoy = date('Y-m-d') ;


$cedulae=$_POST['cedulae'];
 $cedulaent=$_POST['cedulaent'];
 $nombre=$_POST['nombre'];
$cargo=$_POST['cargo'];
$nombrecc=$_POST['nombrecc'];
$codcargo=$_POST['codcargo'];
echo $rol=$_POST['rol'];
$nombreent=$_POST['nombreent'];
$sociedad=$_POST['sociedad'];
$periodo=$_POST['periodo'];
$fevaluacion=$_POST['fevaluacion'];
$operacion1 = $_POST['operacion1'];
$valoracion1 = $_POST['valoracion1'];
$resaltar1 = $_POST['resaltar'];
$mejorar1 = $_POST['mejorar'];
$fortalezas = $_POST['fortalezas'];
$oportunidades = $_POST['oportunidades'];
$mejoras = $_POST['mejoras'];
echo $obs_evaluado = $_POST['obs_evaluado'];
$proceso_disciplinario = $_POST['proceso_disciplinario'];
$det_proc_disc = $_POST['det_proc_disc'];
$concepto_gh = $_POST['concepto_gh'];
$concepto_auditoria = $_POST['concepto_auditoria'];
$contrata_empresa = $_POST['contrata_empresa'];
$condiciones = $_POST['condiciones'];
$capacitacion = $_POST['capacitacion'];
$vb_gerencia = $_POST['vb_gerencia'];



 //echo "desde aqui";
 
// $sql2="SELECT count(id) total FROM `ed_aspectos` WHERE cargo = '$codcargo' "; 
 echo $sql2="select count(id) total FROM `ed_aspectos` WHERE rol in ('$rol','999') and cargo in ('$codcargo','','999')";
 		
			$qry_sql2=$link->query($sql2);
			$rs2=$qry_sql2->fetch_object();
 
		echo $ktotal = $rs2->total; 
			 echo "<br>";
		
		
//for($k=1;$k<=$ktotal;$k++){
	for($k=1;$k<=$ktotal;$k++){
	
	echo $operacionf= $_POST["operacion".$k];
	echo $valoracionf = $_POST["valoracion".$k];
	echo $resaltarf = $_POST["resaltar".$k];
	echo $mejorarf = $_POST["mejorar".$k];
	// echo "<br>";
	// echo $k;
	// echo "<br>";
	 	 
 $sql4="SELECT aspecto FROM `ed_aspectos` WHERE id = '$k'"; 		
			$qry_sql4=$link->query($sql4);
			$rs4=$qry_sql4->fetch_object();
		// echo "<br>";	
 $rs4->aspecto;
 	  $aspectoselec = $rs4->aspecto;
   $rs4->aspecto;
	 
  $sql3="INSERT INTO `personal`.`eval_desem_detallado` (`id`, `cedula`, `fecha`, `aspecto`, `operacion`, `valoracion`, `resaltarop`, `mejorarop`) VALUES (NULL, '$cedulae', '$hoy', '$aspectoselec', '$operacionf', '$valoracionf', '$resaltarf', '$mejorarf');"; 
		$qry_sql3=$link->query($sql3);
	 echo "<br>siguiente<br>";
	 }
	 
$sql5="INSERT INTO `personal`.`eval_desempeno` (`id`, `ced_evaluado`, `ced_evaluador`, `fecha_evaluacion`, `periodo`, `empresa`, `cc`,  `cargo`, `fortalezas`, `oportunidades`, `mejoras`, `obs_evaluador`, `procesos_disc`, `concepto_gh`, `concepto_auditoria`, `Contrataxempresa`, `condiciones`, `capacitacion`, `vb_gerencia`) VALUES (NULL, '$cedulae', '$cedulaent', '$hoy', '$periodo', '$sociedad', '$nombrecc', '$cargo', '$fortalezas', '$oportunidades', '$mejoras', '$obs_evaluado', '$proceso_disciplinario', '$concepto_gh', '$concepto_auditoria', '$contrata_empresa', '$condiciones', '$capacitacion', '');"; 
		$qry_sql5=$link->query($sql5);
		
// genera lacantidad de aspectos 		
	  
	 $sql9="SELECT id, aspecto FROM `ed_def_aspectos`"; 		
			$qry_sql9=$link->query($sql9);
			$rs9=$qry_sql9->fetch_object();
 
		echo $Qaspecto = $rs6->id;
		echo $defaspecto = $rs6->aspecto; 
	
	
/*		do{
//Cuenta la cantidad de operaciones por aspecto y genera el porcentaje para cada operacion
	 $sql6="SELECT COUNT(`aspecto`) NUMASPECTO FROM `eval_desem_detallado` WHERE `aspecto` = '$aspecto' "; 		
			$qry_sql6=$link->query($sql6);
			$rs6=$qry_sql6->fetch_object();
 
		 $numaspecto = $rs6->NUMASPECTO; 
		$porcentaje = 100 / $numaspecto;
	
// genera el peso dependiendo del aspecto		
	 $sql7="SELECT valor FROM `ed_def_aspectos` where id = '$aspecto'"; 		
			$qry_sql7=$link->query($sql7);
			$rs7=$qry_sql7->fetch_object();
			
			$pesoxaspecto = $rs7->valor; 
 
// realiza formula para calcular la calificacion por aspecto
				
	 $sql8="SELECT  sum(valoracion * 0.25)* $pesoxaspecto valoraspecto  FROM `eval_desem_detallado`  WHERE cedula ='$cedulae' and aspecto = '$aspecto'"; 		
			$qry_sql8=$link->query($sql8);
			$rs8=$qry_sql8->fetch_object();
 
		
		echo $valoraspecto = $rs6->valoraspecto; 
		
		}
		while($rs_qry9=$qry_sql9->fetch_object());
		
		
		*/
		
		
	
	
	
	
	 
	 ;


 /*$i=1;
 echo "<br>";
  echo $probar = $_POST['aspecto.$i'];
  /*
do{
echo $aspecto.$i = $_POST['aspecto.$i'];
echo $valoracion.$i = $_POST['valoracion.$i'];
echo $observacion.$i = $_POST['observacion.$i'];
$i = $i++;	
}
while($_POST);	
//}*/
?>  



