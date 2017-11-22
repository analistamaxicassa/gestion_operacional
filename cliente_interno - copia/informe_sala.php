
<link rel="stylesheet" type="text/css" href="../estilos.css"/>

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script>
		 function consultarhist_sala(sala)
        {	
				var parametros = {
				"sala": sala,
				};
                $.ajax({
                data: parametros,
                url: 'informe_hist_sala.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta").html(response);
						 {
						
					    // document.getElementById('consultar').disabled=true;
		                $("#validador").html(response);

                    }
						
                    }
        
        });
        }
		</script>
		<script>
		
		 function actualizar_concepto_sala(sala)
        {	
				var parametros = {
				"sala": sala,
				};
                $.ajax({
                data: parametros,
                url: 'actualizar_concepto_sala.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta").html(response);
						 {
						
					    // document.getElementById('consultar').disabled=true;
		                $("#validador").html(response);

                    }
						
                    }
        
        });
        }
		
		
        </script>

<?php

//error_reporting(0);
//$sala = '552';
$sala = $_REQUEST['sala'];
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
  
  
  
//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		
//conexion sql

$sql="SELECT tipo_sala, presupuesto, jefeoperacion FROM salas where cc = '$sala' and activo = '1'";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 
				
		
	if (empty($rs_qry)) {
    echo 'Esta sala no esta habilitada';
	exit();
	}
	else {
		
	$tiposala = $rs_qry->tipo_sala;	
	$presupuesto = $rs_qry->presupuesto;
	$jefeoperacion = $rs_qry->jefeoperacion;
		
		
		
		
		}

////consulta de concepto de sala
 $sql2="SELECT fecha, concepto, autor FROM `concepto_sala` WHERE cc = '$sala' order by id desc limit 1";
			$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
				
		
	if (empty($rs_qry2)) {
    echo 'No existen ningun concepto acerca de esta sala';
	exit();
	}
	else {
		$fecha = $rs_qry2->fecha;	
		$concepto = $rs_qry2->concepto;
		$autor = $rs_qry2->autor;
			}

	?>
    
<script src="//code.jquery.com/jquery-1.10.2.js"></script>

<br>
<br>

<table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="80%"><tr>
         <td width="16%" height="46" class="encabezados" align="center"><img src="../gh/img/logo-gh.png" width="260" height="92"></td>
    <td width="100" align="center" class="encabezados">PROCESO DE GESTION HUMANA</td>
         <td width="25%" align="right"><img src="../gh/img/maxicassa.png" width="268" height="98" class="formulario"></td>
       </tr>
</table>
<span class="header"> </span><a href="http://190.144.42.83:9090/plantillas/cliente_interno/selecciona_sala.php">CONSULTAR OTRA SALA</a>
<table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="80%">
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Tipo de sala</strong></td>
      <td class="header" colspan="6"  align="justify" ><?php echo utf8_encode($tiposala); ?></td>
    </tr>
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Presupuesto</strong></td> 
      <td width="260" class="header" colspan="6"  align="justify" ><?php echo utf8_encode($presupuesto); ?></td>      </tr> 
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Jefe de operacion</strong></td>
      <td class="header" colspan="6" align="justify" valign="middle"><?php echo utf8_encode($jefeoperacion); ?></td>
    </tr>
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Ultima visita realiza por <?php echo utf8_encode($autor); ?></strong></td>
      <td class="header" colspan="6" align="justify" valign="middle"><?php echo utf8_encode($fecha); ?></td>
    </tr>
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Concepto</strong></td> 
      <td width="260" class="header" colspan="6" align="justify" valign="middle"><?php echo utf8_encode($concepto); ?></td> 
     </tr> 
</table>
<span class="header">
<input type="submit" name="hist_sala" id="hist_sala" onclick= "consultarhist_sala($('#sala').val());" value="Conceptos Anteriores" />
<input type="submit" name="actualizar_concepto_sala" id="actualizar_concepto_sala" onclick= "actualizar_concepto_sala($('#sala').val());" value="Nuevo registro de visita" />
</span><br>

<table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="80%"> <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>ESTRUCTURA</strong></td> 
      <td width="260" class="header" colspan="6" align="justify" valign="middle">&nbsp;</td>      </tr>
      <tr>
      
<?php
	
//do{
	$findme   = 'T';
	$pos = strpos($sala, $findme);
	
	if ($pos === false)
	{
			$findme   = 'P';
			$pos = strpos($sala, $findme);
	
			if ($pos === false)
			{ 
					$findme   = 'I';
					$pos = strpos($sala, $findme);
			
					if ($pos === false)
					{
					 $query = "SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_NOMBRE
 FROM EMPLEADO EMP, CARGO CA
  WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO
  AND (EMP.EMP_CC_CONTABLE LIKE '10-$sala-%' OR EMP.EMP_CC_CONTABLE LIKE '70-$sala-%') AND EMP.EMP_ESTADO <> 'R'
   ORDER BY EMP.EMP_CARGO";
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row_n = $stmt->fetch();	
		$cedula=$row_n['CEDULA'];	
		$nombre=$row_n['NOMBRE'];
		$cargo=$row_n ['CARGO_NOMBRE'];
						
						
						
						}	
					else
					{
					 $sala = substr($sala, -3);
			 
						$query = "SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' 			'||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_NOMBRE FROM EMPLEADO EMP, CARGO CA  WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO
		  AND EMP.EMP_CC_CONTABLE LIKE '40-%' AND EMP.EMP_ESTADO <> 'R'
		   ORDER BY EMP.EMP_CARGO";
					$stmt = $dbh->prepare($query);
					$stmt->execute();
					$row_n = $stmt->fetch();	
					$cedula=$row_n['CEDULA'];	
					$nombre=$row_n['NOMBRE'];
					$cargo=$row_n ['CARGO_NOMBRE'];
					}	
				}	
			else
			{
			 $sala = substr($sala, -3);
	 
				 $query = "SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' 			'||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_NOMBRE FROM EMPLEADO EMP, CARGO CA  WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO
  AND EMP.EMP_CC_CONTABLE LIKE '60-%' AND EMP.EMP_ESTADO <> 'R'
   ORDER BY EMP.EMP_CARGO";
			$stmt = $dbh->prepare($query);
			$stmt->execute();
			$row_n = $stmt->fetch();	
			$cedula=$row_n['CEDULA'];	
			$nombre=$row_n['NOMBRE'];
			$cargo=$row_n ['CARGO_NOMBRE'];
			}	
	
	}	
	else
	{
	 $sala = substr($sala, -3);
	 
	$query = "SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_NOMBRE
 FROM EMPLEADO EMP, CARGO CA
  WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO
  AND EMP.EMP_CC_CONTABLE LIKE '20-$sala-%' AND EMP.EMP_ESTADO <> 'R'
   ORDER BY EMP.EMP_CARGO";
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row_n = $stmt->fetch();	
		$cedula=$row_n['CEDULA'];	
		$nombre=$row_n['NOMBRE'];
		$cargo=$row_n ['CARGO_NOMBRE'];
	}	


do{		

	?>
 <tr>
      <td class="header" colspan="4" align="left" valign="middle"><?php echo utf8_encode($row_n['CARGO_NOMBRE']); ?></td> 
     <td width="111"><A href="informe_cliente_interno2.php?cedula=<?php echo utf8_encode($row_n['CEDULA']);?>&sala=<?php echo utf8_encode($sala);?>"> <?php echo utf8_encode($row_n['NOMBRE']); ?></A></td>
</tr>
<?php
}
while($row_n = $stmt->fetch());	
//}
?>	
<tr>
<td width="50">&nbsp;</td>
</tr>     
</table>
<table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="80%">
  <tr>
    <td class="header" colspan="4" align="left" valign="middle"><strong>ROTATIVOS</strong></td>
    <td width="260" class="header" colspan="6" align="justify" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <?php
	
//do{
	
	echo $queryr = "   SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_NOMBRE,substr('T736',-3), LO.NOMBRE_LOCALIDAD 
 FROM EMPLEADO EMP, CARGO CA, CENTRO_COSTO CC, LOCALIDAD LO
  WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO AND EMP.EMP_CC_CONTABLE = CC.CENCOS_CODIGO AND EMP.EMP_LOCALIDAD = LO.COD_LOCALIDAD
  AND CC.CENCOS_NOMBRE LIKE '%ROTATIVO%'  AND EMP.EMP_ESTADO <> 'R'
   ORDER BY LO.NOMBRE_LOCALIDAD, EMP.EMP_CARGO";
		$stmtr = $dbh->prepare($queryr);
		$stmtr->execute();
		$row_r = $stmtr->fetch();	
		$row_r['CEDULA'];	
		$row_r['NOMBRE'];
		$row_r ['CARGO_NOMBRE'];
						
						
					
do{		

	?>
  </tr>
  <tr>
    <td class="header" colspan="4" align="left" valign="middle"><?php echo utf8_encode($row_r['CARGO_NOMBRE']); ?></td>
    <td width="111"><a href="informe_cliente_interno2.php?cedula=<?php echo utf8_encode($row_r['CEDULA']);?>&amp;sala=<?php echo utf8_encode($sala);?>"> <?php echo utf8_encode($row_r['NOMBRE']); ?></a></td>
  </tr>
  <?php
}
while($row_n = $stmt->fetch());	
//}
?>
  <tr>
    <td width="50">&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p> 


