<?php 
//error_reporting(0);

//recojo variables
$cedulae=$_POST['cedula'];
$resultado_total = 0;

require_once('../PAZYSALVO/conexion_ares.php');
require_once("../PAZYSALVO/FuncionFechas.php"); 
$link=Conectarse();

	//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}

$sql1="select MAX(fecha) fecha FROM `eval_desem_detallado` where cedula = '$cedulae' ";
			$qry_sql1=$link->query($sql1);
			$rs_qry1=$qry_sql1->fetch_object();  ///consultar 
		
		$ultimafecha = $rs_qry1->fecha;

 $sql2="SELECT `ced_evaluador`,`periodo`,`empresa`,`cc`,`cargo`,`mejoras`,`obs_evaluador`,
`concepto_gh`,`concepto_auditoria`,`Contrataxempresa`,`condiciones`,`capacitacion` FROM `eval_desempeno` WHERE `ced_evaluado` = '$cedulae' and `fecha_evaluacion` = '$rs_qry1->fecha'";
			$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
			
$query1 = "SELECT EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE,  EMP.EMP_FECHA_INI_CONTRATO,  SO.NOMBRE_SOCIEDAD, ROUND (MONTHS_BETWEEN(SYSDATE,EMP.EMP_FECHA_INI_CONTRATO),0) MESES
FROM EMPLEADO EMP, sociedad so
WHERE EMP.EMP_SOCIEDAD = SO.COD_SOCIEDAD   
and EMP.EMP_CODIGO = '$cedulae'";

		$stmt1 = $dbh->prepare($query1);
		$stmt1->execute();
		$row1 = $stmt1->fetch();	
		$nombre=$row1['NOMBRE'];
		$fingreso=$row1['EMP_FECHA_INI_CONTRATO'];
		$sociedad=$row1['NOMBRE_SOCIEDAD'];
		
		//$cc = explode("-",$row1['CCQ']);
 		//	$nombrecc = $cc[3];

$query2 = "SELECT  E.EMP_NOMBRE||' '||E.EMP_APELLIDO1||' '||e.EMP_APELLIDO2 NOMBREENTREVISTA, CA.CARGO_NOMBRE CARGOENTREVISTA from empleado e, cargo ca where E.EMP_CARGO = CA.CARGO_CODIGO AND E.EMP_CODIGO = '$rs_qry2->ced_evaluador'" ;

		$stmt2 = $dbh->prepare($query2);
		$stmt2->execute();
		$row2 = $stmt2->fetch();	
		
	
 ?>



<!doctype html>
<html lang="en">
<head>



<style type='text/css'>
tr:nth-child(odd) {
    background-color:#f2f2f2;
}
tr:nth-child(even) {
	background-color: #fbfbfb;
	font-size: 14;	
	
}

</style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Evaluacion de Desempeño</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="../estilos.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript">
function imprSelec(validador){
	var ficha=document.getElementById(validador);
    var ventimp=window.open(' ','popimpr');
	ventimp.document.write(ficha.innerHTML);
	ventimp.document.close();
	ventimp.print();
	ventimp.close();
}
</script>



<script type="text/javascript">

function confirmar_contrata(condiciones, nombre)
   {   
			   var respuesta=confirm("¿Esta seguro?");
     			if(respuesta==true){
				var parametros = {
				"condiciones": condiciones,
				"nombre": nombre,
               	};
				$.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/eval_desempeno/enviocorreo_contrat.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validadores").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#validadores").html(response);
											
                    }
        
        });
			}
			else
         return 0;
        }



</script>
  


</head>
<body>
<p>
<form>
<div id="validador">  
  
    <table width="97%" border="1" align="center" style="font-size:12px">
    <tr>
        
      </tr>
      <tr>
        <th colspan="5" rowspan="3" scope="col">EVALUACION DE DESEMPEÑO</th>
        <th width="22%" scope="col">Código: FRH-06        </th>
      </tr>
      <tr>
        <th width="22%" scope="col">Versión: 3 (actualizado agosto / 12)</th>
      </tr>
      <tr>
        <th width="22%" scope="col">Página: 1 de 1</th>
      </tr>
      <tr>
        <th width="15%" scope="col">Evaluado</th>
        <th width="33%" colspan="1" scope="col"><?php echo $row1['NOMBRE']; ?></th>
        <th width="20%" scope="col">Cargo del Evaluado</th>
        <th colspan="3" align="left" scope="col"><p>
         <?php echo $rs_qry2->cargo; ?>
      </th>
      </tr>
      <tr>
        <th scope="col">Fecha Ingreso </th>
        <th colspan="-1" scope="col"><?php echo fechaletra($row1['EMP_FECHA_INI_CONTRATO']); ?></th>
        <th scope="col">Tiempo de Vinculación</th>
        <th colspan="3" scope="col"  align="left"><?php echo $row1['MESES']." MESES"; ?>
       </th>
      </tr>
      <tr>
        <th scope="col">Evaluador
      </th>
        <th colspan="-1" scope="col"><?php echo utf8_encode($row2['NOMBREENTREVISTA']); ?></th>
        <th scope="col">Cargo del evaluador</th>
        <th colspan="3" scope="col" align="left"><?php echo utf8_encode($row2['CARGOENTREVISTA']); ?></th>
      </tr>
      <tr>
        <th scope="col">Empleador</th>
        <th colspan="-1" scope="col"><?php echo utf8_encode($row1['NOMBRE_SOCIEDAD']); ?></th>
        <th scope="col">Fecha de Evaluación</th>
        <th colspan="3" scope="col" align="left"><?php echo $rs_qry1->fecha; ?></th>
      </tr>
      <tr>
        <th scope="col">Centro de trabajo</th>
        <th colspan="-1" scope="col"><?php echo $rs_qry2->cc; ?></th>
        <th scope="col">Periodo</th>
        <th colspan="3" scope="col" align="left"><?php echo $rs_qry2->periodo; ?>
        </label></th>
      </tr>
   
      
</table>
  <table width="97%" border="1" align="center" style="font-size:12px">
      <tr>
                    <td width="332"  class="encabezados">ASPECTOS </td>
                    <td colspan="2" class="encabezados">DEFINICIONES</td>
      </tr>
                  <tr>
             <?php
			

$sql="SELECT id, aspecto, definicion FROM `ed_def_aspectos` order by id";


			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 
				
			
			do{	
		
			 $Qaspecto = $rs_qry->id;
			
//Cuenta la cantidad de operaciones por aspecto y genera el porcentaje para cada operacion
	  $sql6="SELECT COUNT(`aspecto`) NUMASPECTO FROM `eval_desem_detallado` WHERE `aspecto` = '$Qaspecto' and cedula = '$cedulae' and fecha = '$ultimafecha' "; 		
			$qry_sql6=$link->query($sql6);
			$rs6=$qry_sql6->fetch_object();
 
		  $numaspecto = $rs6->NUMASPECTO; 
		
		 $porcentaje = 1 / $numaspecto;
		
	
// genera el peso dependiendo del aspecto		
	  $sql7="SELECT valor FROM `ed_def_aspectos` where id = '$Qaspecto'"; 		
			$qry_sql7=$link->query($sql7);
			$rs7=$qry_sql7->fetch_object();
		
			$pesoxaspecto = $rs7->valor; 
 		
// realiza formula para calcular la calificacion por aspecto
				
	 $sql8="SELECT  sum(valoracion * $porcentaje)* $pesoxaspecto valoraspecto  FROM `eval_desem_detallado`  WHERE cedula ='$cedulae' and aspecto = '$Qaspecto'"; 		
			$qry_sql8=$link->query($sql8);
			$rs8=$qry_sql8->fetch_object();
 
		
		 $valoraspecto = $rs8->valoraspecto; 
		 		//echo "<br>";
				
				$resultado_total = $resultado_total + $valoraspecto;
			
			
			
			
			// termina calculos
			?>  
                   
                    <td class="subtitulos"><?php echo ($rs_qry->aspecto); ?></td>
                    <td width="621" class="subtitulos"><?php echo utf8_encode($rs_qry->definicion); ?></td>
                    <td width="106" class="subtitulos"><?php echo number_format($valoraspecto,1); ?></td>
                  </tr>
                 
     
             <?php

			
			$sqla="SELECT  operacion, valoracion, resaltarop, mejorarop FROM `eval_desem_detallado` edll inner join ed_def_aspectos ed on edll.aspecto = ed.id WHERE cedula = '$cedulae' and fecha = '$rs_qry1->fecha' and edll.aspecto ='$rs_qry->id'";
			$qry_sqla=$link->query($sqla);
			$rs_qrya=$qry_sqla->fetch_object();  ///consultar 
			
	 
		do{
			 
			
	?>
   
 
  <?php
		}
		while($rs_qrya=$qry_sqla->fetch_object());
		
		
//}
		}
		while($rs_qry=$qry_sql->fetch_object());
			
?>
 <tr>
                    <td>&nbsp;</td>
                    <td class="subtitulos">TOTAL GENERAL</td>
                    <td class="subtitulos"><?php echo number_format($resultado_total,1); ?></td>
    </tr>
  <tr>
      <td colspan="3"><strong>Concepto de Gestion Humana:</strong></td>
    <tr>
      <td colspan="3">
      <?php echo $rs_qry2->concepto_gh; ?>
		
      </td>
    <tr>
      <td colspan="3"><strong>Concepto de Auditoría:</strong></td>
    <tr>
      <td colspan="3">
     <?php echo $rs_qry2->concepto_auditoria; ?>
     </td>
    <tr>
      <td colspan="3">
       
        <strong>Se contrata por la empresa?</strong>
<?php   if ($rs_qry2->Contrataxempresa == '0')
		   {
				echo trim('NO');	
			   }
			else {echo trim('SI');}
		   ?>
<strong>Nuevas condiciones laborales 
<label>
  <input type="text" name="condicioneslab" id="condicioneslab" value="<?php echo utf8_encode($rs_qry2->condiciones); ?>">
</label>
</strong>
    
      
      <strong>CONFIRMAR CONTRATACION 
      <input type="submit" name="confirmar" id="confirmar" value="SI" onClick="confirmar_contrata($('#condicioneslab').val(),'<?php echo  $row1['NOMBRE']; ?>')">														
      </strong></td>
    <tr>
      <td colspan="3"><strong>Necesidades de Capacitación</strong> <?php echo $rs_qry2->capacitacion; ?></td>
    <tr>
      <td colspan="3"><strong>Compromiso Evaluado:<?php echo $rs_qry2->mejoras; ?></strong></td>
    <tr>
      <td colspan="3"><strong>Observacion de Evaluado:<?php echo $rs_qry2->obs_evaluador; ?></strong></td>
    <tr>
      <td height="42" colspan="3"><strong>Firma Gestion Humana: </strong></td>
    </table>
    </div>
   

 <input  name="imprimir" type="button" class="botones" id="prn" onClick="imprSelec('validador');" value="imprimir" />
</form>
  
