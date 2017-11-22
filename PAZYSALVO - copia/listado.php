<?php

//recojo variables
$arealis=$_POST['area'];
//funcion fechas
require_once("FuncionFechas.php");
require_once('conexion_ares.php'); 
$link=Conectarse();
$hoy=date("Y-m-d");
$antes = date('Y-m-d', strtotime('-15 day')) ;

?>	

<link rel="stylesheet" type="text/css" href="../estilos.css"/>
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<body>
<form method="post" action="web_contacto.php">
<table width="982" border="3" align="left">
    <tr>
      <td class="encabezados" colspan="9" align="center" valign="middle"><strong>PAZ Y SALVO</strong>
      </td>
    </tr> 
    <tr>
       <td width="111">      Identificacion</td>
      <td colspan="3"><label for="cedula">Empresa</label></td>
      <td width="186" bgcolor="#B6BCC3">Nombre</td>
      <td width="126">Cargo:</td>
      <td width="142">Centro de Costos:</td>
      <td width="126">Motivo retiro: </td>
      <td width="120">Fecha Retiro</td>
    </tr>
    </table>

<?php
	//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
	//conexion sql	
	
		if (($arealis == "vb_gcomercialpego") or($arealis == "vb_produccion")
		or($arealis == "vb_adminpego")or($arealis == "vb_despachos"))
		{
			$sql="SELECT * FROM personal_pazysalvo where $arealis is null and `pego` is not null and flimite > '$antes'";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 
			}	
		else
			{				
			$sql="SELECT * FROM personal_pazysalvo where $arealis is null and flimite > '$antes' ";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 
			}	
	
	if (empty($rs_qry)) {
    echo 'No existen registros';
	$datelimite = 0;
	}
	else {
		do{
		
	$cedula = $rs_qry->cedula;
	$fpedido = $rs_qry->fsolicitud;
	$fretiro = $rs_qry->fretiro;
	$mretiro = $rs_qry->motivo;
	$flimite = $rs_qry->flimite;
	$mensaje = "";
	$mensaje1 = "";

		$difer = strtotime($hoy) - strtotime($flimite);
		if ($difer > 0)	
		{
		$mensaje= "*** EL PAZ Y SALVO CADUCO, COMUNIQUESE CON LA JEFE DE GESTION HUMANA***";
		}
		if ($difer == 0)	
		{
		$mensaje1= "HASTA HOY ESTA DISPONIBLE EL PAZ Y SALVO PARA SU ENTREGA";
		}
		
	
		$query = "SELECT SO.NOMBRE_SOCIEDAD SOCIEDAD,  EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 					                   NOMBRE , EM.EMP_CODIGO, CA.CARGO_NOMBRE,
        CC.CENCOS_NOMBRE CC,EM.EMP_FECHA_INI_CONTRATO
        FROM EMPLEADO EM, CARGO CA,  sociedad SO, CENTRO_COSTO CC
        WHERE EM.EMP_CARGO = CA.CARGO_CODIGO  AND EM.EMP_CC_CONTABLE = CC.CENCOS_CODIGO
        AND EM.EMP_SOCIEDAD = SO.COD_SOCIEDAD and EM.EMP_CODIGO = '$cedula'";
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row_n = $stmt->fetch();		
		$row_n['NOMBRE'];
		$row_n ['SOCIEDAD'];
		$row_n['NOMBRE'];
		$row_n['EMP_CODIGO'];
		$cargo=utf8_encode($row_n['CARGO_NOMBRE']);
		$row_n ['CC'];
		$row_n['EMP_FECHA_INI_CONTRATO'];
		$fingreso=$row_n['EMP_FECHA_INI_CONTRATO'];
?>
<br>
  <table width="982" border="3" align="left" style="font-size: 14px;"  >
    <tr>
      <td class="subtitulos" colspan="9">Fecha limite: <?php echo $flimite; ?></td>
     </tr>
     <tr>
       <td class="encabezados" colspan="9" > <?php echo $mensaje; ?></td>
    </tr>
     <tr>
       <td class="encabezados" colspan="9"> <?php echo $mensaje1; ?></td>
    </tr>
    <tr>
      <td width="111"><A href="pazysalvomostrar.php?cedula=<?php echo $cedula;?>"> <?php echo $cedula; ?></A></td>
      <td colspan="3"><?php echo $row_n['SOCIEDAD']; ?>&nbsp;</td>
      <td width="182"><?php echo $row_n['NOMBRE']; ?></td>
      <td width="156"><?php echo $row_n['CARGO_NOMBRE']; ?></td>
      <td width="112"><?php echo $row_n['CC']; ?></td>
      <td width="128"><?php echo $mretiro; ?></td>
      <td width="118"><?php echo $fretiro ?></td>
    </tr>
  </table>
  </p>
  <p>&nbsp;</p>
</form>
</body>
</html>
<?php
}
while($rs_qry=$qry_sql->fetch_object());	
}
?>	
