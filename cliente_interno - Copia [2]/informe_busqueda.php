  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

<?php

$empleado = $_POST['empleado'];
//$empleado = "SANDRA";
$empresa = $_POST['empresa'];
//$empresa = "10";

//	session_start();
//	$usuingreso= $_SESSION['ced'];


require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();


/*$sqlpre="SELECT `id` FROM `acceso_cixsala` WHERE `sala` = '$sala' and cedula = '$usuingreso' ";
			$qry_sqlpre=$link->query($sqlpre);
			$rs_qrypre=$qry_sqlpre->fetch_object();  ///consultar 
				
		
	if (empty($rs_qrypre)) {
    echo 'Esta sala no esta habilitada para su consulta';
	exit();
	}
	else {*/
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

/*
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
		
		
		
		
		}*/


	
 //MUESTRA LOS EMPLEADOS 
	
$queryc = "SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_NOMBRE, CC.CENCOS_NOMBRE, SUBSTR(EMP.EMP_CC_CONTABLE,4,3) UBICACION
FROM EMPLEADO EMP, CARGO CA, CENTRO_COSTO CC
 WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO AND EMP.EMP_CC_CONTABLE = CC.CENCOS_CODIGO AND (EMP.EMP_NOMBRE LIKE '%$empleado%'  or EMP.EMP_APELLIDO1 LIKE '%$empleado%' or EMP.EMP_APELLIDO2 LIKE '%$empleado%' ) AND EMP.EMP_SOCIEDAD = '$empresa' AND  EMP.EMP_ESTADO <> 'R'";
		$stmtc = $dbh->prepare($queryc);
		$stmtc->execute();
		$row_c = $stmtc->fetch();	
		$row_c['CEDULA'];	
		$row_c['NOMBRE'];
		$row_c ['CARGO_NOMBRE'];
		$row_c ['CENCOS_NOMBRE'];
		
	
			if (empty($row_c)) {
   						 echo 'No existen registros';
						exit;
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
   
</header>

 
<br> <br> <br> <br> <br> <br>



<table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:12px " width="80%" align="center"> 
</table>
<br>
<?php
do{	
?>
<table border="0" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="50%" align="center">
     
     
     <td width="250"><A href="informe_cliente_interno2.php?cedula=<?php echo utf8_encode($row_c['CEDULA']);?>&sala=<?php echo utf8_encode($row_c ['UBICACION']);?>"> <?php echo utf8_encode($row_c['NOMBRE']); ?></A></td>
      
       <td  colspan="4" align="left" valign="middle"><?php echo utf8_encode($row_c['CENCOS_NOMBRE']); ?></td> 
        
</tr>   
</table>
<?php
}
while($row_c = $stmtc->fetch());	
//}
?>	

    <footer>
    
    </footer>
</body>
</html>
