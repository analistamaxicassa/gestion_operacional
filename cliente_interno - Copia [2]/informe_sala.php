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
                url: 'http://190.144.42.83:9090/plantillas/cliente_interno/informe_hist_sala2.php',
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
                url: 'http://190.144.42.83:9090/plantillas/cliente_interno/actualizar_concepto_sala.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta1").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta1").html(response);
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

	session_start();
	$usuingreso= $_SESSION['ced'];


require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();


$sqlpre="SELECT `id` FROM `acceso_cixsala` WHERE `sala` = '$sala' and cedula = '$usuingreso' ";
			$qry_sqlpre=$link->query($sqlpre);
			$rs_qrypre=$qry_sqlpre->fetch_object();  ///consultar 
				
		
	if (empty($rs_qrypre)) {
    echo 'Esta sala no esta habilitada para su consulta';
	exit();
	}
	else {
		?>	
	<?php	
  
  
//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		
//conexion sql


$sql="SELECT nombre, tipo_sala, presupuesto, jefeoperacion, localidad FROM salas where cc = '$sala' and activo = '1'";
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
	$localidad = $rs_qry->localidad;
		
		
		
		
		}

////consulta de concepto de sala
$sql2="SELECT id, fecha, avg(calificacion) concepto, autor FROM `concepto_sala` WHERE cc = '$sala' group by fecha order by id DESC LIMIT 1 ";
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

// cantidad de empleados
 $query1a = "SELECT count (EMP.EMP_CODIGO) CANTIDAD FROM EMPLEADO EMP
  WHERE (EMP.EMP_CC_CONTABLE LIKE '10-$sala-%' OR EMP.EMP_CC_CONTABLE LIKE '70-$sala-%') AND EMP.EMP_ESTADO <> 'R'";
		$stmt1a = $dbh->prepare($query1a);
		$stmt1a->execute();
		$row_n1a = $stmt1a->fetch();	
		$row_n1a['CANTIDAD'];	

// cantidad de asesores
$query1c = "SELECT count (EMP.EMP_CARGO) CANTIDADASESORES FROM EMPLEADO EMP, cargo ca
  WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO and
   (EMP.EMP_CC_CONTABLE LIKE '10-$sala-%' OR EMP.EMP_CC_CONTABLE LIKE '70-$sala-%') AND EMP.EMP_ESTADO <> 'R' and EMP.EMP_CARGO in ('113','114','115')";
		$stmt1c = $dbh->prepare($query1c);
		$stmt1c->execute();
		$row_n1c = $stmt1c->fetch();	
		$cantasesores = $row_n1c['CANTIDADASESORES'];
		


// cantidad de empleados en capacitacion 
 $query1d = " SELECT count (EMP.EMP_CODIGO) CANTIDADCAPACI
 FROM EMPLEADO EMP 
 WHERE (EMP.EMP_CC_CONTABLE LIKE '10-099-%' OR EMP.EMP_CC_CONTABLE LIKE '70-099-%') and EMP.EMP_NRO_CONTRATO = '$sala' and EMP.EMP_ESTADO <> 'R'";
		$stmt1d = $dbh->prepare($query1d);
		$stmt1d->execute();
		$row_n1d = $stmt1d->fetch();	
		$row_n1d['CANTIDADCAPACI'];
		

// cantidad de empleados en capacitacion detallando cargo
 $query1e = " SELECT count (EMP.EMP_CODIGO) CANTIDADCAPACI, EMP.EMP_CARGO CODCARGO
 FROM EMPLEADO EMP 
 WHERE (EMP.EMP_CC_CONTABLE LIKE '10-099-%' OR EMP.EMP_CC_CONTABLE LIKE '70-099-%') and EMP.EMP_NRO_CONTRATO = '$sala' and EMP.EMP_ESTADO <> 'R'  group by  EMP.EMP_CARGO";
		$stmt1e = $dbh->prepare($query1e);
		$stmt1e->execute();
		$row_n1e = $stmt1e->fetch();	
		$row_n1e['CANTIDADCAPACI'];
		$row_n1e['CODCARGO'];
 
	$cantidadtotal = $row_n1a['CANTIDAD'] + $row_n1e['CANTIDADCAPACI'];


	
 //MUESTRA LOS EMPLEADOS EN CAPACITACION 
	
	 $queryc = "SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_CODIGO CODCARGO,  CA.CARGO_NOMBRE
FROM EMPLEADO EMP, CARGO CA, CENTRO_COSTO CC
 WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO AND EMP.EMP_CC_CONTABLE = CC.CENCOS_CODIGO 
 and EMP.EMP_NRO_CONTRATO = '$sala' AND CC.CENCOS_NOMBRE NOT LIKE '%ROTATIVO%' AND EMP.EMP_ESTADO <> 'R'
  ORDER BY EMP.EMP_CARGO ";
		$stmtc = $dbh->prepare($queryc);
		$stmtc->execute();
		$row_c = $stmtc->fetch();	
		$row_c['CEDULA'];	
		$row_c['NOMBRE'];
		$row_c ['CODCARGO'];
		$row_c ['CARGO_NOMBRE'];
		
		if ($row_c['CODCARGO'] == '113' || $row_c['CODCARGO'] == '114' || $row_c['CODCARGO'] == '115' )
			{ 
				 $cantasesores =  $cantasesores + $row_n1e['CANTIDADCAPACI'];
			}		
	
					
		
			
			


	?>
    
<!DOCTYPE html>
 
<html lang="es">
 
<head>


<title>Help Desk</title>
<meta charset="utf-8" />

<link rel="stylesheet" type="text/css" href="../estilos1.css">    
    
<script src="//code.jquery.com/jquery-1.10.2.js"></script>

</head>

<body>



    <header>
       <h4>

       <table width="70%" border="10" cellpadding="0" cellspacing="0">
       <tr style="background-color:transparent">
         <td width="26%" height="46"><img src="../gh/img/logo-gh.png" width="185" height="46"></td>
         <td width="50%" align="center" valign="middle"><div style="font-family:Verdana, Geneva, sans-serif; font-size:12px; width:600px; height:60px; text-align:center" class="intro_tk">
     <br>
     <b style="color:#333">CLIENTE INTERNO</b></div>
    </td>
         <td align="right">
         <img src="../gh/img/maxicassa.png" width="279" height="44">
         </td>
       </tr>
       </table>
	 </h4>
     </header>

 
<br> <br> <br> <br> <br> <br>

<br>
<table width="60%" border="0" align="center" style="border-collapse:collapse; font-family:Verdana, Geneva, sans-serif; font-size:14px ">
    <tr>
      <td  border="0" colspan="3" align="left" valign="middle"><strong><a href="http://190.144.42.83:9090/plantillas/cliente_interno/selecciona_sala.php">CONSULTAR OTRA SALA</a></strong></td>
      <td  border="0" align="left" valign="middle"><strong><a href="http://190.144.42.83:9090/plantillas/cliente_interno/actualizar_dsalas.php?sala=<?php echo $sala;?>">MODIFICAR DATOS DE SALA</a></strong></td>
     
    </tr>
</table>
<br>

<table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:12px " width="59%" align="center">
    <tr>
      <td colspan="4" align="left" valign="middle"><strong>Nombre de Sala <?php echo $sala;?></strong></td>
      <td colspan="6"  align="justify" ><h2><?php echo utf8_encode($rs_qry->nombre); ?></h2></td>
    </tr>
    <tr>
      <td colspan="4" align="left" valign="middle"><strong>Tipo de sala</strong></td>
      <td colspan="6"  align="justify" ><?php echo utf8_encode($tiposala); ?></td>
    </tr>
    <tr>
      <td colspan="4" align="left" valign="middle"><strong>Presupuesto</strong></td> 
      <td width="303" colspan="6"  align="justify" >$<?php echo number_format($presupuesto, 0, ",", "."); ?></td>      </tr> 
    <tr>
      <td colspan="4" align="left" valign="middle"><strong>Jefe de operacion</strong></td>
      <td colspan="6" align="justify" valign="middle"><?php echo utf8_encode($jefeoperacion); ?></td>
    </tr>
    <tr>
      <td colspan="4" align="left" valign="middle"><strong>Numero de empleados </strong></td>
      <td colspan="6" align="justify" valign="middle"><?php echo ($cantidadtotal); ?></td>
    </tr>
    <tr>
      <td colspan="4" align="left" valign="middle"><strong>Presupuesto de ventas  por empleado</strong></td>
      <td colspan="6" align="justify" valign="middle">$<?php echo number_format($presupuesto/$cantidadtotal, 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td colspan="4" align="left" valign="middle"><strong>Presupuesto de ventas  por Asesor</strong></td>
      <td colspan="6" align="justify" valign="middle">$<?php echo number_format($presupuesto/$cantasesores, 0, ",", "."); ?></td>
    </tr>
    <tr>
      <td colspan="4" align="left" valign="middle"><strong>Ultima visita realiza por <?php echo utf8_encode($autor); ?></strong></td>
      <td colspan="6" align="justify" valign="middle"><?php echo utf8_encode($fecha); ?></td>
    </tr>
    <tr>
      <td colspan="4" align="left" valign="middle"><strong>Evaluacion  General</strong></td> 
      <td width="303" colspan="6" align="justify" valign="middle"><?php echo number_format($concepto,2); ?></td> 
  </tr> 
</table>
<br>
<table border="0" style="border-collapse:collapse;  font-family:Verdana, Geneva, sans-serif; font-size:10px " width="80%" align="center">
    <tr>
      <td  border="0" colspan="4" align="left" valign="middle" ><strong><input type="submit" name="hist_sala" id="hist_sala" onclick= "consultarhist_sala (<?php echo ($sala); ?>);" value="Nuevo reporte e historial" class="botones" /></strong></td>
     
    </tr>
</table>
<br>

<table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="30%" align="center">
  <tr class="intro_tk">
    <td class="header" colspan="10" align="center" valign="middle"><strong>ESTRUCTURA DE LA SALA</strong></td>
  </tr>
  <tr>
    <?php
	
		
// cantidad de empleados x cargo 

 $query1b = "SELECT CA.CARGO_NOMBRE NOMBRECARGO,  count (EMP.EMP_CARGO) CANTIDADCARGO FROM EMPLEADO EMP, cargo ca
  WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO and
   (EMP.EMP_CC_CONTABLE LIKE '10-$sala-%' OR EMP.EMP_CC_CONTABLE LIKE '70-$sala-%') AND EMP.EMP_ESTADO <> 'R' group by CA.CARGO_NOMBRE,  EMP.EMP_CARGO";
		$stmt1b = $dbh->prepare($query1b);
		$stmt1b->execute();
		$row_n1b = $stmt1b->fetch();	
		$row_n1b['NOMBRECARGO'];
		$row_n1b['CANTIDADCARGO'];

	
			
		do{
			
			?>
  </tr>
  <tr>
    <td class="header" colspan="4" align="left" valign="middle"><?php echo utf8_encode($row_n1b['NOMBRECARGO']); ?></td>
    <td width="134" colspan="4" align="center" valign="middle" class="header"><?php echo utf8_encode($row_n1b['CANTIDADCARGO']); ?></td>
  </tr>
  <?php
}
while($row_n1b = $stmt1b->fetch());
	
//}
?>
 
</table>



<table border="2" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="60%" align="center">
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
      <td  colspan="4" align="left" valign="middle"><?php echo utf8_encode($row_n['CARGO_NOMBRE']); ?></td> 
     <td width="111"><A href="informe_cliente_interno2.php?cedula=<?php echo utf8_encode($row_n['CEDULA']);?>&sala=<?php echo utf8_encode($sala);?>"> <?php echo utf8_encode($row_n['NOMBRE']); ?></A></td>
</tr>
<?php
}
while($row_n = $stmt->fetch());	
//}
?>	
<tr>
<td width="50" style="font-size:14px" >&nbsp;</td>
</tr>     
</table>
<br>



<table border="0" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="60%" align="center">
  <tr>
    <td class="header" colspan="4" align="left" valign="middle"><strong>EN CAPACITACION</strong></td>
    <td width="260" class="header" colspan="6" align="justify" valign="middle">&nbsp;</td>
  </tr>
  <tr>
<?php
do{
?>
  </tr>
  <tr>
    <td class="header" colspan="4" align="left" valign="middle"><?php echo utf8_encode($row_c['CARGO_NOMBRE']); ?></td>
    <td width="111"><a href="informe_cliente_interno2.php?cedula=<?php echo utf8_encode($row_c['CEDULA']);?>&amp;sala=<?php echo utf8_encode($sala);?>"> <?php echo utf8_encode($row_c['NOMBRE']); ?></a></td>
  </tr>
  <?php
}
while($row_c = $stmtc->fetch());
	
//}
?>
  <tr>
    <td width="50">&nbsp;</td>
  </tr>
</table>

<table border="0" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="60%" align="center">
  <tr>
    <td class="header" colspan="4" align="left" valign="middle"><strong>ROTATIVOS</strong></td>
    <td width="260" class="header" colspan="6" align="justify" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <?php
	
//do{
	
	$queryr = "SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_NOMBRE, LO.COD_LOCALIDAD 
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
		$row_r ['COD_LOCALIDAD'];
	
	
					
		do{		

if ($localidad == $row_r ['COD_LOCALIDAD'])
	{
			?>
  </tr>
  <tr>
    <td class="header" colspan="4" align="left" valign="middle"><?php echo utf8_encode($row_r['CARGO_NOMBRE']); ?></td>
    <td width="111"><a href="informe_cliente_interno2.php?cedula=<?php echo utf8_encode($row_r['CEDULA']);?>&amp;sala=<?php echo utf8_encode($sala);?>"> <?php echo utf8_encode($row_r['NOMBRE']); ?></a></td>
  </tr>
  <?php
}}
while($row_r = $stmtr->fetch());
	
//}
?>
  <tr>
    <td width="50">&nbsp;</td>
  </tr>
</table>


	
	<?php	
  		} 
	?>

    <footer>
    
    </footer>
</body>
</html>
