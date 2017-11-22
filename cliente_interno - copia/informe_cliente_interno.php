
<?php 
error_reporting(0);
$sala = $_REQUEST['sala'];
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();


//llenar la tabla temporal


  
	//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}


	//consulta tabla cliente interno
	$sql1="SELECT cedula FROM `cliente_interno` where sala = '$sala' ";
			$qry_sql1=$link->query($sql1);
			$rs_qry1=$qry_sql1->fetch_object();  ///consultar 
	
	
// consulta en queryx y llenado en mysql tabla cliente interno queryx
		do
		{
		$cedula = $rs_qry1->cedula;	
$query = "SELECT EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE
,EMP.EMP_ESTADO_CIVIL ECIVIL, CA.CARGO_NOMBRE, TO_CHAR((SYSDATE - EMP_FECHA_INGRESO)/30,9999)/12 ANTIGUEDAD, EMP.EMP_TIPO_CONTRATO TIPO_CONTRATO
, CASE WHEN TO_CHAR((SYSDATE - EMP_FECHA_INGRESO)/30,9999)/12 < 2 THEN CF.COF_VALOR ELSE (SUM(AC.ACUM_VALOR_LOCAL))/2 END AS PROMEDIO, CC.CENCOS_NOMBRE CC
FROM EMPLEADO EMP,TRH_ACUMULADO AC,CARGO CA, CONCEPTOS CO, conceptos_fijos cf, centro_costo cc
WHERE EMP.EMP_ESTADO <> 'R'  AND EMP.EMP_CODIGO = '$cedula' and EMP.EMP_CARGO = CA.CARGO_CODIGO  AND EMP.EMP_CODIGO = AC.EMP_CODIGO  AND
AC.ACUM_FECHA_PAGO > SYSDATE - 60  AND AC.CON_CODIGO = CO.CON_CODIGO AND
CO.CON_NATU = 'DEV' AND EMP.EMP_ESTADO <> 'R'  AND EMP.EMP_CODIGO = '$cedula' AND AC.CON_CODIGO <> '130'
and CF.EMP_CODIGO = EMP.EMP_CODIGO and CC.CENCOS_CODIGO = EMP.EMP_CC_CONTABLE
GROUP BY EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2, EMP.EMP_ESTADO_CIVIL,  CA.CARGO_NOMBRE, TO_CHAR((SYSDATE - EMP_FECHA_INGRESO)/30,9999)/12, EMP.EMP_TIPO_CONTRATO,  CF.COF_VALOR, CC.CENCOS_NOMBRE" ;

		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch();	
		
		$nombreemp=$row['NOMBRE'];
		$ecivil=$row['ECIVIL'];
		$cargonombre=$row['CARGO_NOMBRE'];
		$ant=$row['ANTIGUEDAD'];
		$tcontrato=$row['TIPO_CONTRATO'];
		$promediosalario=$row['PROMEDIO'];
		$centrocostos=$row['CC'];
		
$sql3="INSERT INTO `personal`.`cliente_interno_queryx` (`cedulaq`, `nombreq`, `estado_civil`, `cargo`, `antiguedad`, `tipo_contrato`, `promedio`, `ccq`) VALUES ('$cedula', '$nombreemp', '$ecivil', '$cargonombre', '$ant', '$tcontrato', '$promediosalario', '$centrocostos');";
$qry_sql3=$link->query($sql3);

		}
		while($rs_qry1=$qry_sql1->fetch_object());
		
		
//hacer consulta generando  inner join entre la temporal y la tabla mysql

$tam=1;			
		
$reg="SELECT cedulaq, nombreq, estado_civil, tipo_sala, cargo, antiguedad, tipo_contrato, promedio, ccq, educacion, hijosyedades, motivacion, proyeccion, ayudas, evaluador, fecha_evaluacion, evaluacion, fortalezas, debilidades, recomendaciones, ap_conocimientos,  ap_estudios, ap_presentacion, ac_horarios, ac_colaboracion, proyeccion_laboral, observacion, obfsamudio FROM cliente_interno ci inner join cliente_interno_queryx ciq on ci.cedula = ciq.cedulaq"; //esta
$qreg=$link->query($reg);
$rsreg=$qreg->fetch_object();
$num_total_registros=$qreg->num_rows; // numero de registros

$TAMANO_PAGINA = $tam;
$pagina = false;

if (isset($_GET["pagina"]))
		$pagina = $_GET["pagina"];
	
if (!$pagina) {
	$inicio = 0;
	$pagina = 1;
}
else {
	$inicio = ($pagina - 1) * $TAMANO_PAGINA;
}

//calculo el total de paginas
$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);

$sql="SELECT cedulaq, nombreq, estado_civil, tipo_sala, cargo, antiguedad, tipo_contrato, promedio, ccq, educacion, hijosyedades, motivacion, proyeccion, ayudas, evaluador, fecha_evaluacion, evaluacion,  fortalezas, debilidades, recomendaciones, ap_conocimientos,  ap_estudios, ap_presentacion, ac_horarios, ac_colaboracion, proyeccion_laboral, observacion, obfsamudio FROM cliente_interno ci inner join cliente_interno_queryx ciq on ci.cedula = ciq.cedulaq LIMIT ".$inicio.",".$TAMANO_PAGINA.""; //seleccionan los campos
$qry=$link->query($sql);
$rs=$qry->fetch_object();
$total_registros=$qry->num_rows;


?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CLIENTE INTERNO</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="../estilos.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#accordion" ).accordion();
  } );
  
   function guardarci(cedula, observasamudio, pagina)
        {	alert("se actualizara la informacion")
				var parametros = {
				"cedula": cedula,
				"observasamudio": observasamudio,
				"pagina": pagina,
				};
                $.ajax({
                data: parametros,
                url: 'guardarci.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
						 // document.getElementById('consultar').disabled=false;
						 // document.getElementById('sala').disabled=false;
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta").html(response);
									
						
                    }
        
        });
        }
		  </script>
            <script>
		
		 function consultarsala()
        {	alert("si")
             location.href="http://190.144.42.83:9090/plantillas/cliente_interno/selecciona_sala.php"
        }
  </script>
</head>
<body>

<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>
         <td width="16%" height="46" class="encabezados" align="center"><img src="../gh/img/logo-gh.png" width="260" height="92"></td>
    <td width="100" align="center" class="encabezados">PROCESO DE GESTION HUMANA</td>
         <td width="25%" align="right"><img src="../gh/img/maxicassa.png" width="268" height="98" class="formulario"></td>
       </tr>
       </table>
  <form action="http://190.144.42.83:9090/plantillas/cliente_interno/selecciona_sala.php" method="post">
 
    <input type="submit"  name="nueva_consulta" id="nueva_consulta"   value="CONSULTAR NUEVA SALA">	
   
</form>

 
<div id="accordion">
  <h3>Datos personales</h3>
  <div>
    <p>
    <table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="100%">
    <input type="hidden" id="cedula_pan" value="<?php echo utf8_encode($rs->cedulaq); ?>">
     <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>NOMBRE</strong></td>
      <td class="header" colspan="6"  align="justify" ><?php echo utf8_encode($rs->nombreq); ?></td>
    </tr>
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Estado Civil</strong></td> 
      <td width="612" class="header" colspan="6"  align="justify" ><?php if ($rs->estado_civil == 'SOL')
	  		  $rs->estado_civil = "SOLTERO"; 
		  if ($rs->estado_civil == 'CAS')
		    $rs->estado_civil = "CASADO";
		  if ($rs->estado_civil == 'DIV')
		    $rs->estado_civil = "DIVERCIADO";
		  if ($rs->estado_civil == 'SEP')
		    $rs->estado_civil = "SEPARADO";
		  if ($rs->estado_civil == 'ND')
		    $rs->estado_civil = "NO DEFINIDO";
		  if ($rs->estado_civil == 'UNI') 
		   $rs->estado_civil = "UNION LIBRE";
	  echo utf8_encode($rs->estado_civil); ?></td>      </tr> 
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Hijos y Edades</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" valign="middle"><?php echo utf8_encode($rs->hijosyedades); ?></td> 
     </tr> 
 <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Educacion</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" valign="middle"><?php echo utf8_encode($rs->educacion); ?></td>      </tr>
      <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Que lo motiva</strong></td> 
      <td width="612" class="header" colspan="6" align="justify"  valign="middle"><?php echo utf8_encode($rs->motivacion); ?></td>
     </tr>
      <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Proyecciones</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" valign="middle"><?php echo utf8_encode($rs->proyeccion); ?></td> 
     </tr>
      
    </table>

    </p>
  </div>
  <h3>Datos labores</h3>
  <div>
    <p>
   <table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="100%">
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Cargo</strong></td> 
      <td width="612" class="header" colspan="6"  align="justify" ><?php echo utf8_encode($rs->cargo); ?></td>      </tr> 
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Antiguedad</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" valign="middle"><?php echo substr($rs->antiguedad,0,2); ?> Años</td> 
     </tr> 
 <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Contrato</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" valign="middle">
	  <?php if ($rs->tipo_contrato == 1)
	  		  $rs->contrato = "Termino indefinido"; 
		  if ($rs->tipo_contrato == 2)
		    $rs->contrato = "Termino fijo";
		  if ($rs->tipo_contrato == 4) 
		   $rs->contrato = "Aprendiz";
	  
	  echo utf8_encode($rs->contrato); ?></td>      </tr>
      <tr>
        <td class="header" colspan="4" align="left" valign="middle"><strong>Ubicacion</strong></td>
        <td class="header" colspan="6" align="justify"  valign="middle"><?php echo utf8_encode($rs->ccq); ?></td>
      </tr>
      <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Tipo de sala</strong></td> 
      <td width="612" class="header" colspan="6" align="justify"  valign="middle"><?php echo $rs->tipo_sala; ?></td>
     </tr>
      <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Salario Promedio (2 meses)</strong></td> 
      <td width="612" class="header" colspan="6" align="justify"  valign="middle"><?php echo "$".number_format($rs->promedio, 0, ',', '.'); ?></td>
     </tr>

      <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Ayudas recibidad por la empresa</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" valign="middle"><?php echo utf8_encode($rs->ayudas); ?></td> 
     </tr>
   
    </table>

    </p>
  </div>
  <h3>Calificacion</h3>
  <div>
    <p>
   <table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="100%" height="82%">
    <tr>
      <td  class="subtitulos" colspan="4" align="left" valign="middle"><strong>Evaluador</strong></td> 
      <td class="header" colspan="2"  align="justify" ><?php echo utf8_encode($rs->evaluador); ?></td>      </tr> 
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Fecha de evaluacion</strong></td> 
      <td class="header" colspan="2" align="justify" valign="middle"><?php echo $rs->fecha_evaluacion; ?></td> 
  </tr> 
 <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Nota de Evaluacion</strong></td> 
      <td width="467" align="justify" valign="middle" class="header">
        <?php   echo $rs->evaluacion; ?></td>
      <td width="367" align="justify" valign="middle" bgcolor="#CCCCCC" class="header"><p>A: MUY BUENO</p>
        <p>B: BUENO</p>
        <p>C: MATRICULA CONDICIONAL</p></td>
 </tr>
      <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Fortalezas</strong></td> 
      <td class="header" colspan="2" align="justify"  valign="middle"><?php echo utf8_encode($rs->fortalezas); ?></td>
     </tr>
      <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Debilidades</strong></td> 
      <td class="header" colspan="2" align="justify"  valign="middle"><?php echo utf8_encode($rs->debilidades); ?></td>
     </tr>

      <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Recomendaciones</strong></td> 
      <td class="header" colspan="2" align="justify" valign="middle"><?php echo utf8_encode($rs->recomendaciones); ?></td> 
     </tr>
      <tr>
      <td colspan="3" rowspan="3" align="left" valign="middle" class="header"><strong>Aptitud</strong></td>
      <td width="84" align="left" valign="middle" class="header">Conocimiento del Producto/Puesto</td> 
      <td colspan="2" align="justify" valign="middle" class="header"><?php echo $rs->ap_conocimientos; ?></td> 
     </tr>
      <tr>
        <td class="header" align="left" valign="middle">Estudios</td>
        <td colspan="2" align="justify" valign="middle" class="header"><?php echo $rs->ap_estudios; ?></td>
      </tr>
      <tr>
        <td class="header" align="left" valign="middle">Presentacion</td>
        <td colspan="2" align="justify" valign="middle" class="header"><?php echo $rs->ap_presentacion; ?></td>
      </tr>
      <tr>
      <td colspan="3" rowspan="2" align="left" valign="middle" class="header"><strong>Actitud</strong></td>
      <td class="header" align="left" valign="middle">Horarios</td> 
      <td colspan="2" align="justify" valign="middle" class="header"><?php echo $rs->ac_horarios; ?></td> 
     </tr>
      <tr>
        <td class="header" align="left" valign="middle">Colaboracion</td>
        <td colspan="2" align="justify" valign="middle" class="header"><?php echo $rs->ac_colaboracion; ?></td>
      </tr>
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Proyeccion Laboral</strong></td> 
      <td class="header" colspan="2" align="justify" valign="middle"><?php echo utf8_encode($rs->proyeccion_laboral); ?></td> 
  </tr>
      <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Observaciones</strong></td> 
      <td class="header" colspan="2" align="justify" valign="middle"><?php echo utf8_encode($rs->observacion); ?></td> 
     </tr>
      <tr>
        <td height="50" colspan="4" align="left" valign="middle" class="header"><strong>Observacion General</strong>        </td>
        <td class="subtitulos" colspan="2" align="justify" valign="middle"><span class="header">
          <label for="observasamudio"></label>
          
          <input name="observasamudio" type="text" id="observasamudio" value="<?php echo utf8_encode($rs->obfsamudio); ?>" size="80">
        </span></td>
    </tr>
      <tr>
         
        <td height="28" colspan="4" align="left" valign="middle" class="header">&nbsp;</td>
        <td class="header" colspan="2" align="center" valign="middle"><input align="right" name="guardar" type="button" class="botones" onclick= "guardarci($('#cedula_pan').val(), $('#observasamudio').val(),'<?php
		  echo $pagina ?>');" id="guardar" value="GUARDAR" /></td>
  </tr>
</table>
    </p>
  </div>
</div>
                
<footer style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold">

 <?php
 


echo '<p>';
$url="informe_cliente_interno.php";
if ($total_paginas > 1) {
    if ($pagina != 1)
        echo '<a href="'.$url.'?pagina='.($pagina-1).'"><img src="img/izq.png" width="24" height="24"> </a>';
    for ($i=1;$i<=$total_paginas;$i++) {
        if ($pagina == $i)
            //si muestro el indice de la pagina actual, no coloco enlace
            echo $pagina;
        else
            //si el indice no corresponde con la pagina mostrada actualmente,
            //coloco el enlace para ir a esa pagina
            echo '  <a href="'.$url.'?pagina='.$i.'">'.$i.'</a>  ';
    }
    if ($pagina != $total_paginas)
        echo '<a href="'.$url.'?pagina='.($pagina+1).'"><img src="img/der.png" width="24" height="24"> </a>';
}
echo '</p>';


 ?>   
 </footer>
 
 

