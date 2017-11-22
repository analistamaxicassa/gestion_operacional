<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<?php

error_reporting(0);
require_once("../FuncionFechas.php");

//recojo variables
$cedula=$_POST['aval'];


$hoy=date("d/m/y");



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
	$sql="SELECT `ID`,`CEDULA`,`JEFE`,`PERIODO`,`DIAS`,`SALIDA`,`ENTRADA`,`REEMPLAZO`,`F_EMPALME`,`EMAIL_PERSONAL` FROM `VACACIONES`
WHERE CEDULA  = '$cedula' and aut_jefe = '1' and impreso is null limit 1";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 

			if (empty($rs_qry)) {
   						 echo '<br> <br> No existen registros autorizados';
							//$datelimite = 0;
							exit;
								}

		do{
	$id = 	$rs_qry->ID;
	$cedula = $rs_qry->CEDULA;
	$jefe = $rs_qry->JEFE;
	$periodo  = $rs_qry->PERIODO;
	$dias = $rs_qry->DIAS;
	$salida = $rs_qry->SALIDA;
	$entrada = $rs_qry->ENTRADA;
	$reemplazo = $rs_qry->REEMPLAZO;
	$f_empalme = $rs_qry->F_EMPALME;
	$email_personal = $rs_qry->EMAIL_PERSONAL;
	
	
	
	
	
//	consulta en queryx

	 $query = "SELECT SO.NOMBRE_SOCIEDAD SOCIEDAD,  EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , CA.CARGO_NOMBRE,  CC.CENCOS_NOMBRE CC, CC.CENCOS_TIPO_CODIGO, LO.NOMBRE_LOCALIDAD, EM.EMP_CC_CONTABLE
        FROM EMPLEADO EM, CARGO CA,  sociedad SO, CENTRO_COSTO CC, LOCALIDAD LO
        WHERE EM.EMP_CARGO = CA.CARGO_CODIGO  AND EM.EMP_CC_CONTABLE = CC.CENCOS_CODIGO
        AND EM.EMP_SOCIEDAD = SO.COD_SOCIEDAD AND EM.EMP_LOCALIDAD = LO.COD_LOCALIDAD
        AND EM.EMP_CODIGO = '$cedula'";
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row_n = $stmt->fetch();
		
		$row_n['NOMBRE'];
		$row_n ['SOCIEDAD'];
		$row_n ['CC'];
		$cargo=utf8_encode($row_n['CARGO_NOMBRE']);
		$tipo = $row_n ['CENCOS_TIPO_CODIGO'];
				$row_n ['NOMBRE_LOCALIDAD'];
		$codcc = substr($row_n ['EMP_CC_CONTABLE'], 0, -7);	
		
		if($codcc =='10-099'||$codcc =='70-099'||$codcc == '20-099')
				 {
						 $correo2 = " ";
					}
			else
				{
					  		
			$sql1="SELECT email emailpunto FROM email_permisos where cc = '$codcc'";
			$qry_sql1=$link->query($sql1);
			$rs_qry1=$qry_sql1->fetch_object();  ///consultar 
			$correo2 =$rs_qry1->emailpunto;
				}	
	
	
	 $codcc = trim(substr($row_n ['EMP_CC_CONTABLE'], 0, -7));

	
	
	 $queryjefe = " select EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBREJEFE, CA.CARGO_NOMBRE  CARGOJEFE
        FROM EMPLEADO EM, cargo CA
        WHERE EM.EMP_CODIGO = '$jefe' AND EM.EMP_CARGO = CA.CARGO_CODIGO";
		$stmt1 = $dbh->prepare($queryjefe);
		$stmt1->execute();
		$row_n1 = $stmt1->fetch();
		$row_n1['NOMBREJEFE'];
		$row_n1['CARGOJEFE'];
		
		$proceso = explode("-", $row_n ['CC']);
		
	//	$sql="UPDATE `vacaciones` SET `impreso`='1' WHERE `id` = '$id' ";
	//	$qry_sql=$link->query($sql);
		
	
?> 

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



			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Autorizacion de Vacaciones</title>
</head>
<div id="validador"> 

<body style="font-family: Verdana, Geneva, sans-serif; font-weight: bold;">
<table width="100%" border="0" align="center">
  <tr>
    <td>
    <center style="font-size: 10px">
        <table width="100%" border="1">
        <tr>
          <th width="19%" rowspan="3" scope="row"><?php echo $row_n['SOCIEDAD']; ?>&nbsp;</th>
          <td width="62%" rowspan="3" align="center">SOLICITUD DE VACACIONES </td>
          <td width="19%">Codigo: FR-GH-15</td>
        </tr>
        <tr>
          <td>Version: 3</td>
        </tr>
        <tr>
          <td height="22">Pag 1 de 1</td>
        </tr>
      </table>
    </center>
    <p><?php $localidad = utf8_encode(str_replace("?","&Ntilde",$row_n['NOMBRE_LOCALIDAD']));
	 echo $localidad;  echo","; echo fechaletra($hoy); ?></p>
    <p>&nbsp;</p>
    <p>Señores:</p>
    <p>GESTION HUMANA</p>
    <p>Bogota D.C.</p>
    <p>&nbsp;</p>
    <p>Apreciados señores</p>
    <p style="text-align: justify">Por medio del presente solicito me sean autorizados <b> <?php echo $dias; ?></b> dias de vacaciones; correspondiente al periodo <b><?php echo substr("$periodo", 0, 19); ?></b>, para ser tomados desde el dia <b><?php echo $salida; ?></b> hasta el dia <b><?php echo $entrada; ?></b>  y en caso de no haber cumplido el tiempo necesario, autorizo que se me descuente de mi liquidacion final de prestaciones sociales, premios, bonificaciones, indemnizaciones y salarios el valor proporcional</p>
    <p>Agradezco la atencion prestada al presente</p>
    <table width="83%" border="0">
       <tr>
        <th width="35%" align="left" ><b><?php echo $row_n['NOMBRE']; ?></b>&nbsp;</th>
        <td width="65%" ><div id="validadorfinal">
          <p>
            <input type="image" name="aprobado" id="aprobado" src="http://190.144.42.83:9090/plantillas/vacaciones/aprobado con msj.jpg" />
            </p>
          <p>
            <label for="Autoriza">Autoriza: <?php echo $row_n1['NOMBREJEFE']; ?></label>
          </p>
          <p>Cargo: <?php echo $row_n1['CARGOJEFE'] ?></p>
        </div></td>
      </tr>
    </table>
     <span style="text-align: left"	scope="row"></span>
    <table width="100%" border="1" style="border-collapse: collapse; font-weight: bold; font-size: 10px;" bordercolor="#000000" >
      <tr>
        <th width="50%" align="left" bgcolor="#CCCCCC" scope="row"><span style="text-align: left"></span>Cedula</th>
        <td width="50%" bgcolor="#CCCCCC">Proceso</td>
      </tr>
      <tr>
        <th height="34" align="left" scope="row"><?php echo $cedula; ?>&nbsp;</th>
        <td><?php echo $proceso[2]; ?>&nbsp;</td>
      </tr>
      <tr>
        <th align="left" bgcolor="#CCCCCC" scope="row">Cargo</th>
        <td bgcolor="#CCCCCC">Almacen</td>
      </tr>
      <tr>
        <th height="30" align="left" scope="row"><?php echo $row_n['CARGO_NOMBRE']; ?>&nbsp;</th>
        <td><?php echo $proceso[1]; ?>&nbsp;</td>
      </tr>
      <tr>
        <th align="left" bgcolor="#CCCCCC" scope="row">Quien reemplaza</th>
        <td bgcolor="#CCCCCC">Fecha de Empalme</td>
      </tr>
      <tr>
        <th height="35" align="left" scope="row"><?php echo $rs_qry->REEMPLAZO; ?>
          <label for="reemplazajp"></label></th>"
        <td><?php echo $rs_qry->F_EMPALME; ?>
          <label for="empalmejp"></label></td>
      </tr>
     
    </table></td>
    
  </tr>
  <tr>
    <td></td>
  </tr>
</table>
 

</div>
   </p>
 </div> 
<input name="imprimir" type="submit" class="botones" id="prn" onclick="imprSelec('validador');" value="imprimir" />
</body>
<?php
  }
while($rs_qry=$qry_sql->fetch_object());
  
?>
</html>
