

<?php

//recojo variables
$sala = $_REQUEST['sala'];
//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
//$hoy=date("Y-m-d");

?>	

			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link rel="stylesheet" type="text/css" href="../estilos.css"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

   <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>

 function guardarci(cedula, observacion)
        {	
				var parametros = {
				"cedula": cedula,
				"observacion": observacion,
				};
                $.ajax({
                data: parametros,
                url: 'guardarci.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta").html(response);
						document.getElementById('guardar').disabled=true;
									
						
                    }
        
        });
        }
</script>

<title>Documento sin título</title>


</head>
<body>
<?php
	//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
	//conexion sql	
	
	$sql="SELECT cedula, evaluador, fecha_evaluacion, evaluacion, fortalezas, debilidades, recomendaciones, ap_conocimientos, ap_estudios, ap_presentacion, ac_horarios, ac_colaboracion, proyeccion_laboral, observacion FROM cliente_interno where sala = $sala";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 
	
	if (empty($rs_qry)) {
    echo 'No existen registros';
	exit();
	}
	else {
		//do{
	$cedula = $rs_qry->cedula;
	$evaluador = $rs_qry->evaluador;
	$fecha_evaluacion = $rs_qry->fecha_evaluacion;
	$evaluacion = $rs_qry->evaluacion;
	$fortalezas = $rs_qry->fortalezas;
	$debilidades = $rs_qry->debilidades;
	$recomendaciones = $rs_qry->recomendaciones;
	$ap_conocimientos = $rs_qry->ap_conocimientos;
	$ap_estudios = $rs_qry->ap_estudios;
	$ap_presentacion = $rs_qry->ap_presentacion;
	$ac_horarios = $rs_qry->ac_horarios;
	$ac_colaboracion = $rs_qry->ac_colaboracion;
	$proyeccion_laboral = $rs_qry->proyeccion_laboral;
	$observacion = $rs_qry->observacion;
	}
?>



<table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="100%" height="82%">
    <tr>
      <td  class="subtitulos" colspan="4" align="left" valign="middle"><strong>Evaluador</strong></td> 
      <td class="header" colspan="2"  align="justify" ><?php echo utf8_encode($evaluador); ?></td>      </tr> 
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Fecha de evaluacion</strong></td> 
      <td class="header" colspan="2" align="justify" valign="middle"><?php echo $fecha_evaluacion; ?></td> 
  </tr> 
 <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Nota de Evaluacion</strong></td> 
      <td width="455" align="justify" valign="middle" class="header">
	  <?php   echo $evaluacion; ?></td>
    <td width="379" height="25" align="justify" valign="top" class="header"><p class="header">A: MUY BUENO</p>
      <p class="header">B: BUENO</p>
      <p class="header">C: MATRICULA CONDICIONAL</p></td>
 </tr>
      <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Fortalezas</strong></td> 
      <td class="header" colspan="2" align="justify"  valign="middle"><?php echo utf8_encode($fortalezas); ?></td>
     </tr>
      <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Debilidades</strong></td> 
      <td class="header" colspan="2" align="justify"  valign="middle"><?php echo utf8_encode($debilidades); ?></td>
     </tr>

      <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Recomendaciones</strong></td> 
      <td class="header" colspan="2" align="justify" valign="middle"><?php echo utf8_encode($recomendaciones); ?></td> 
     </tr>
      <tr>
      <td colspan="3" rowspan="3" align="left" valign="middle" class="header"><strong>Aptitud</strong></td>
      <td width="84" align="left" valign="middle" class="header">Conocimiento del Producto/Puesto</td> 
      <td colspan="2" align="justify" valign="middle" class="header"><?php echo $ap_conocimientos; ?></td> 
     </tr>
      <tr>
        <td class="header" align="left" valign="middle">Estudios</td>
        <td colspan="2" align="justify" valign="middle" class="header"><?php echo $ap_estudios; ?></td>
      </tr>
      <tr>
        <td class="header" align="left" valign="middle">Presentacion</td>
        <td colspan="2" align="justify" valign="middle" class="header"><?php echo $ap_presentacion; ?></td>
      </tr>
      <tr>
      <td colspan="3" rowspan="2" align="left" valign="middle" class="header"><strong>Recomendaciones</strong></td>
      <td class="header" align="left" valign="middle">Horarios</td> 
      <td colspan="2" align="justify" valign="middle" class="header"><?php echo $ac_horarios; ?></td> 
     </tr>
      <tr>
        <td class="header" align="left" valign="middle">Colaboracion</td>
        <td colspan="2" align="justify" valign="middle" class="header"><?php echo $ac_colaboracion; ?></td>
      </tr>
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Proyeccion Laboral</strong></td> 
      <td class="header" colspan="2" align="justify" valign="middle"><?php echo utf8_encode($proyeccion_laboral); ?></td> 
  </tr>
      <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Observaciones</strong></td> 
      <td class="header" colspan="2" align="justify" valign="middle"><?php echo utf8_encode($observacion); ?></td> 
     </tr>
      <tr>
        <td height="50" colspan="4" align="left" valign="middle" class="header"><strong>Observacion General</strong>        </td>
        <td class="subtitulos" colspan="2" align="justify" valign="middle">
            <input name="observacion" type="text" id="observacion" value="" size="140" /></td>
    </tr>
      <tr>
           
        <td height="28" colspan="4" align="left" valign="middle" class="header">&nbsp;</td>
        <td class="header" colspan="2" align="center" valign="middle"><input align="right" name="guardar" type="button" class="botones" onclick= "guardarci('<?php echo ($cedula); ?>', $('#observacion').val());" id="guardar" value="GUARDAR" /></td>
  </tr>
</table>

<br>
  </p>
  <p>&nbsp;</p>

</body>
</html>
<br>
