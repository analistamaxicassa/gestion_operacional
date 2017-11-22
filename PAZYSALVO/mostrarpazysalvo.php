<?php


//funcion fechas
require_once("FuncionFechas.php");

//recojo variables
$certificado=$_POST['certificado'];
$cedula=$_POST['cedula'];
$fretiro=$_POST['fretiro'];
$mretiro=$_POST['mretiro'];
$flimite=$_POST['flimite'];
$correo=$_POST['correo'];
$correo2=$_POST['correo2'];
$pego=$_POST['pego'];
$hoy=date("d/m/y");



//$fsolicitud = $hoy;


//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}

		

require_once('conexion_ares.php'); 
$link=Conectarse();
//$ced=$_POST['ced']; 
		

//switcheo que certificado es el que voy a generar
switch($certificado)
{
	case 'P1':
	
	
	$sql="SELECT fsolicitud FROM personal_pazysalvo WHERE cedula='$cedula'";
	$qry_sql=$link->query($sql);
	$rs_qry=$qry_sql->fetch_object();  ///consultar 
	
	 //conexion queryx
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		$query = "SELECT  EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 					                   NOMBRE FROM EMPLEADO EM WHERE EM.EMP_CODIGO = '$cedula'";
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row_n = $stmt->fetch();		
		$row_n['NOMBRE'];
			
	do{
	if (@$rs_qry->fsolicitud=="")
	{
		echo "SOLICITUD DE PAZ Y SALVO EN PROCESO<br>";
		
		

		//envio correo
		
		require_once('PHPMailer-master/class.phpmailer.php'); 
		require_once('PHPMailer-master/class.smtp.php');
		require_once('PHPMailer-master/PHPMailerAutoload.php');
		$cuerpo='
		<center>
		Gestion humana le informa que tiene paz y salvos por autorizar. <br>	
		Por favor dirijase a la plataforma de ares para realizar su respectiva autorizacion http://10.1.0.22/ares 							        <br>	
		GRACIAS<br>
		</center>';
		
		echo $row_n['NOMBRE'];
			
			$mail = new PHPMailer(); //Crea un objecte/instancia.
			$mail->IsSMTP(); // enviament per protocol SMTP
			$mail->IsHTML(true);
			//$mail->SMTPDebug  = 2; //Habilita el SMTPDebug per test.
			$mail->Host = "smtp.live.com"; //Estableix GMAIL com el servidor SMTP.
			$mail->SMTPAuth= true; //Habilita la autenticaciÃ³ SMPT.
			$mail->SMTPSecure="tls"; //Estableix el prefix del servidor.
			$mail->Port = 587 ; //Estableix el port SMTP.
			$mail->Username="plataforma_ares@hotmail.com"; //Username de la conte de correo que s'utilitza com a servei d'enviament.
			$mail->Password="maxicassa2016"; //contrasenya del compte.
		 
		 
			//Parametros del Remitente
			$mail->SetFrom('plataforma_ares@hotmail.com', 'Depto de Gestion Humana');	
			$mail->Subject ="Recordatorio de Autorizacion de Paz y salvo";
			$mail->AltBody ="Depto de Gestion Humana - Maxicassa S.A.S";//Messatge d'advertencia pels usuaris que no utilitzan un client HTML.
		 
			// Construccio del Body i assignacio a variable (body).
			/////$body=$cuerpo, $row_n['NOMBRE'] ;//Plantilla HTML creat. Document root+ruta "absoluta".
			$body= $cuerpo.$row_n['NOMBRE'] ;//Plantilla HTML creat. Document root+ruta "absoluta".
		
			//Utilitzacio de la funcio MsgHTML i utilitzacio de la variable body creada avanÃ§s per compondre el cos del missatge.
			$mail->MsgHTML($body);
			//S'indica adressa electronica on s'envia el mail i el nom.
//			$mail->AddAddress('pazysalvo@ceramigres.com','PAZ_Y_SALVO_ARES');
			$mail->AddAddress('lrodriguez@ceramigres.com','PAZ_Y_SALVO_ARES');
			$mail->AddAddress($correo2,'correo2');
			echo 			$mail->AddBCC($correo, "Inscripcion realizada");
			$mail->Send();


	}else{
		
	$fsolicitud = $rs_qry->fsolicitud;
	}
	}
	while($rs_qry=$qry_sql->fetch_object());	
	
	
	if (empty($fsolicitud))
		{
			$sql="INSERT INTO `personal`.`personal_pazysalvo` (`cedula`, `fsolicitud`, `fretiro`, `motivo`, `flimite`, `correo`, `pego`) values 				('$cedula','$hoy','$fretiro','$mretiro', '$flimite', '$correo','$pego')";
		$qry_sql=$link->query($sql);
		
         }
	else {
	echo "Este empleado ya fue solicitado.";
	     } 
	  
	exit();
				
	case 'P2':
	
	  //conexion queryx
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		$query = "SELECT SO.NOMBRE_SOCIEDAD SOCIEDAD,  EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 					                   NOMBRE , EM.EMP_CODIGO, CA.CARGO_NOMBRE,
        CC.CENCOS_NOMBRE CC,EM.EMP_FECHA_INI_CONTRATO
        FROM EMPLEADO EM, CARGO CA,  sociedad SO, CENTRO_COSTO CC
        WHERE EM.EMP_CARGO = CA.CARGO_CODIGO  AND EM.EMP_CC_CONTABLE = CC.CENCOS_CODIGO
        AND EM.EMP_SOCIEDAD = SO.COD_SOCIEDAD
        AND EM.EMP_CODIGO = '$cedula'";
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
	
		
	//conexion sql
	
	$sql="SELECT * FROM personal_pazysalvo WHERE cedula='$cedula' ORDER BY `ID` DESC LIMIT 1 ";
	$qry_sql=$link->query($sql);
	$rs_qry=$qry_sql->fetch_object();  ///consultar 
	do{
	//$rs_qry->cedula;	
	$fpedido = $rs_qry->fsolicitud;
	$fretiro = $rs_qry->fretiro;
	$mretiro = $rs_qry->motivo;
	$vb_contabilidad = $rs_qry->vb_contabilidad;
	$obs_vb_contabilidad = $rs_qry->obs_vb_contabilidad;
	$usu_vb_contabilidad = $rs_qry->usu_vb_contabilidad;
	$vb_cartera = $rs_qry->vb_cartera;
	$obs_vb_cartera = $rs_qry->obs_vb_cartera;
	$usu_vb_cartera = $rs_qry->usu_vb_cartera;
	$vb_sistemas = $rs_qry->vb_sistemas;
	$obs_vb_sistemas = $rs_qry->obs_vb_sistemas;
	$usu_vb_sistemas = $rs_qry->usu_vb_sistemas;
	$vb_infraestructura = $rs_qry->vb_infraestructura;
	$obs_vb_infraestructura = $rs_qry->obs_vb_infraestructura;
	$usu_vb_infraestructura = $rs_qry->usu_vb_infraestructura;
	$vb_auditoria = $rs_qry->vb_auditoria;
	$obs_vb_auditoria = $rs_qry->obs_vb_auditoria;
	$usu_vb_auditoria = $rs_qry->usu_vb_auditoria;
	$vb_ghumana = $rs_qry->vb_ghumana;
	$obs_vb_ghumana = $rs_qry->obs_vb_ghumana;
	$usu_vb_ghumana = $rs_qry->usu_vb_ghumana;
	$vb_femcrecer = $rs_qry->vb_femcrecer;
	$obs_vb_femcrecer = $rs_qry->obs_vb_femcrecer;
	$usu_vb_femcrecer = $rs_qry->usu_vb_femcrecer;
	$vb_nomina = $rs_qry->vb_nomina;
	$obs_vb_nomina = $rs_qry->obs_vb_nomina;
	$usu_vb_nomina = $rs_qry->usu_vb_nomina;
	$vb_sala = $rs_qry->vb_sala;
	$obs_vb_sala = $rs_qry->obs_vb_sala;
	$usu_vb_sala= $rs_qry->usu_vb_sala;
	$vb_contapego = $rs_qry->vb_contapego;
	$obs_vb_contapego = $rs_qry->obs_vb_contapego;
	$usu_vb_contapego= $rs_qry->usu_vb_contapego;
	$vb_containno = $rs_qry->vb_containno;
	$obs_vb_containno = $rs_qry->obs_vb_containno;
	$usu_vb_containno= $rs_qry->usu_vb_containno;
	$vb_produccion = $rs_qry->vb_produccion;
	$obs_vb_produccion = $rs_qry->obs_vb_produccion;
	$usu_vb_produccion= $rs_qry->usu_vb_produccion;
	$vb_despachos = $rs_qry->vb_despachos;
	$obs_vb_despachos = $rs_qry->obs_vb_despachos;
	$usu_vb_despachos= $rs_qry->usu_vb_despachos;
	$vb_adminpego = $rs_qry->vb_adminpego;
	$obs_vb_adminpego = $rs_qry->obs_vb_adminpego;
	$usu_vb_adminpego= $rs_qry->usu_vb_adminpego;
	$vb_gcomercialpego = $rs_qry->vb_gcomercialpego;
	$obs_vb_gcomercialpego = $rs_qry->obs_vb_gcomercialpego;
	$usu_vb_gcomercialpego= $rs_qry->usu_vb_gcomercialpego;
	
	}while($rs_qry=$qry_sql->fetch_object());	
	


//********************************

 	
	break;

}
?>	
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<body>
<form method="post" action="web_contacto.php">
<label></label>
  <table width="830" border="3" align="left">
    <tr>
      <td colspan="7" align="center" valign="middle" bgcolor="#99FFFF"><label><strong>PAZ Y SALVO</strong></label></td>
    </tr>
    <tr>
      <td width="97">Identificacion</td>
      <td colspan="3"><label for="cedula"></label><?php echo $cedula; ?></td>
      <td width="54">Nombre</td>
      <td colspan="2"><?php echo $row_n['NOMBRE']; ?></td>
    </tr>
    <tr>
      <td rowspan="2">Empresa</td>
      <td colspan="3" rowspan="2"><?php echo $row_n['SOCIEDAD']; ?>&nbsp;</td>
      <td rowspan="2">Fecha Ingreso</td>
      <td width="268" rowspan="2"> <?php echo fechaletra($fingreso) ?>&nbsp;</td>
      <td width="332">Motivo retiro: <?php echo $mretiro; ?></td>
    </tr>
    <tr>
      <td>Cargo: <?php echo $row_n['CARGO_NOMBRE']; ?></td>
    </tr>
    <tr>
      <td>F. Solicitud</td>
      <td colspan="3"><?php echo $fpedido; ?></td>
      <td>Fecha Retiro</td>
      <td bgcolor="#FFFFFF"><?php echo $fretiro ?>&nbsp;</td>
      <td width="332">Centro de Costos:<?php echo $row_n['CC']; ?></td>
    </tr>
    <tr>
      <td colspan="7" align="center" bgcolor="#CCCCCC"><em><strong>1. CONCEPTO CONTABILIDAD</strong></em></td>
    </tr>
    <tr>
      <td colspan="3">F. Respuesta</td>
      <td width="108"><?php echo $vb_contabilidad; ?>&nbsp;</td>
      <td colspan="4" align="left">Vb. <?php echo $usu_vb_contabilidad; ?></td>
    </tr>
    <tr>
      <td>Observaciones: </td>
      <td colspan="6"><label for="obs1"></label>
      <textarea name="obs1" cols="130" id="obs1"><?php echo $obs_vb_contabilidad; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="7" align="center" bgcolor="#CCCCCC"><em><strong>2. CONCEPTO CARTERA</strong></em></td>
    </tr>
    <tr>
      <td colspan="3">F. Respuesta</td>
      <td><?php echo $vb_cartera; ?>&nbsp;</td>
      <td colspan="3">Vb. <?php echo $usu_vb_cartera; ?></td>
    </tr>
    <tr>
      <td>Observaciones:</td>
      <td colspan="6"><label for="obs2"></label>
      <textarea name="obs2" cols="130" id="obs2"><?php echo $obs_vb_cartera; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="7" align="center" bgcolor="#CCCCCC"><em><strong>3. CONCEPTO INFRAESTRUCTURA TECNOLOGIA Y SISTEMAS</strong></em></td>
      </tr>
    <tr>
      <td colspan="3">F. Respuesta</td>
      <td><?php echo $vb_sistemas; ?>&nbsp;</td>
      <td colspan="3">Vb. <?php echo $usu_vb_sistemas; ?></td>
    </tr>
    <tr>
      <td colspan="3">Observaciones</td>
      <td colspan="4"><label for="obs3"></label>
      <textarea name="obs3" cols="130" id="obs3"><?php echo $obs_vb_sistemas; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="7" align="center" bgcolor="#CCCCCC"><em><strong>4. CONCEPTO COMUNICACIONES</strong></em></td>
    </tr>
    <tr>
      <td colspan="3">F. Respuesta</td>
      <td><?php echo $vb_infraestructura; ?>&nbsp;</td>
      <td colspan="3">Vb. <?php echo $usu_vb_infraestructura; ?></td>
    </tr>
    <tr>
      <td colspan="3">Observaciones </td>
      <td colspan="4"><label for="obs4"></label>
      <textarea name="obs4" cols="130" id="obs4"><?php echo $obs_vb_infraestructura; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="7" align="center" bgcolor="#CCCCCC"><em><strong>5. CONCEPTO DE AUDITORIA</strong></em></td>
    </tr>
    <tr>
      <td colspan="3">F. Respuesta</td>
      <td><?php echo $vb_auditoria; ?>&nbsp;</td>
      <td colspan="3">Vb.<?php echo $usu_vb_auditoria; ?></td>
    </tr>
    <tr>
      <td colspan="3">Observaciones</td>
      <td colspan="4"><label for="obs5"></label>
      <textarea name="obs5" cols="130" id="obs5"><?php echo $obs_vb_auditoria; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="7" align="center" bgcolor="#CCCCCC"><em><strong>6. CONCEPTO GESTION HUMANA</strong></em></td>
    </tr>
    <tr>
      <td colspan="3">F. Respuesta</td>
      <td><?php echo $vb_ghumana; ?>&nbsp;</td>
      <td colspan="3">Vb.<?php echo $usu_vb_ghumana; ?></td>
    </tr>
    <tr>
      <td colspan="3">Observaciones</td>
      <td colspan="4"><label for="obs6"></label>
      <textarea name="obs6" cols="130" id="obs6"><?php echo $obs_vb_ghumana; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="7" align="center" bgcolor="#CCCCCC"><em><strong>7. CONCEPTO FONDO DE EMPLEADO</strong></em></td>
    </tr>
    <tr>
      <td colspan="3">F. Respuesta</td>
      <td><?php echo $vb_femcrecer; ?>&nbsp;</td>
      <td colspan="3">Vb.<?php echo $usu_vb_femcrecer; ?></td>
    </tr>
    <tr>
      <td colspan="3">Observaciones</td>
      <td colspan="4"><label for="obs7"></label>
      <textarea name="obs7" cols="130" id="obs7"><?php echo $obs_vb_femcrecer; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="7" align="center" bgcolor="#CCCCCC"><em><strong>8. CONCEPTO NOMINA</strong></em></td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#FFFFFF">F. Respuesta</td>
      <td bgcolor="#FFFFFF"><?php echo $vb_nomina; ?></td>
      <td colspan="3" bgcolor="#FFFFFF">Vb.<?php echo $usu_vb_nomina; ?></td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#FFFFFF">Observaciones</td>
      <td colspan="4" bgcolor="#FFFFFF"><textarea name="obs8" cols="130" id="obs8"><?php echo $obs_vb_nomina; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="7" align="center" bgcolor="#CCCCCC"><em><strong>9. CONCEPTO ADMINISTRADOR SALA</strong></em></td>
    </tr>
    <tr>
      <td colspan="3">F. Respuesta</td>
      <td><?php echo $vb_sala; ?></td>
      <td colspan="3">Vb.<?php echo $usu_vb_sala; ?></td>
    </tr>
    <tr>
      <td height="25" colspan="3">Observaciones</td>
      <td colspan="4"><label for="obs9"></label>
        <?php echo $obs_vb_sala; ?>
      <textarea name="obs9" cols="130" id="obs9"></textarea><label for="obs8"></label></td>
    </tr>
    
     <tr>
      <td colspan="7" align="center" bgcolor="#CCCCCC"><em><strong>10. CONCEPTO SEGURIDAD Y SALUD EN EL TRABAJO</strong></em></td>
    </tr>
    <tr>
      <td colspan="3">F. Respuesta</td>
      <td><?php echo $vb_socupacional; ?></td>
      <td colspan="3">Vb.<?php echo $usu_vb_socupacional; ?></td>
    </tr>
    <tr>
      <td height="25" colspan="3">Observaciones</td>
      <td colspan="4"><label for="obs9"></label>
        <?php echo $obs_vb_socupacional; ?>
      <textarea name="obs10" cols="130" id="obs10"></textarea><label for="obs10"></label></td>
    </tr>
    
     <tr>
      <td colspan="7" align="center" bgcolor="#CCCCCC"><em><strong>11. CONCEPTO SUMINISTROS</strong></em></td>
    </tr>
    <tr>
      <td colspan="3">F. Respuesta</td>
      <td><?php echo $vb_suministros; ?></td>
      <td colspan="3">Vb.<?php echo $usu_vb_suministros; ?></td>
    </tr>
    
    <tr>
      <td height="25" colspan="3">Observaciones</td>
      <td colspan="4"><label for="obs9"></label>
        <?php echo $obs_vb_suministros; ?>
      <textarea name="obs11" cols="130" id="obs11"></textarea><label for="obs11"></label></td>
    </tr>
    
    <tr bgcolor="#CCCCCC">
      <td height="25" colspan="7" align="center"><em><strong>12. CONCEPTO CONTABILIDAD INNOVAPACK</strong></em></td>
    </tr>
    <tr>
      <td height="25" colspan="3">F. Respuesta</td>
      <td><?php echo $vb_containno; ?></td>
      <td colspan="3">Vb.<?php echo $usu_vb_containno; ?></td>
    </tr>
    <tr>
      <td height="25" colspan="3">Observaciones</td>
      <td colspan="4"><label for="obs10"></label>
      <textarea name="obs12" cols="130" id="obs12"></textarea></td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <td height="25" colspan="7" align="center"><em><strong>13. CONCEPTO CONTABILIDAD PEGOMAX</strong></em></td>
    </tr>
    <tr>
      <td height="25" colspan="3">F. Respuesta</td>
      <td><?php echo $vb_contapego; ?></td>
      <td colspan="3">Vb.<?php echo $usu_vb_contapego; ?></td>
    </tr>
    <tr>
      <td height="25" colspan="3">Observaciones</td>
      <td colspan="4"><label for="obs13"></label>
      <textarea name="obs13" cols="130" id="obs13"><?php echo $obs_vb_contapego; ?></textarea></td>
    </tr>
    <tr>
      <td height="25" colspan="7" align="center" bgcolor="#CCCCCC"><em><strong>14. CONCEPTO PRODUCCION</strong></em></td>
    </tr>
    <tr>
      <td height="25" colspan="3">F. Respuesta</td>
      <td><?php echo $vb_produccion; ?></td>
      <td colspan="3">Vb.<?php echo $usu_vb_produccion; ?></td>
    </tr>
    <tr>
      <td height="25" colspan="3">Observaciones</td>
      <td colspan="4"><label for="obs14"></label>
      <textarea name="obs14" cols="130" id="obs14"><?php echo $obs_vb_produccion; ?></textarea></td>
    </tr>
    <tr>
      <td height="25" colspan="7" align="center" bgcolor="#CCCCCC"><em><strong>15. CONCEPTO DESPACHOS</strong></em></td>
    </tr>
    <tr>
      <td height="25" colspan="3">F. Respuesta</td>
      <td><?php echo $vb_despachos; ?></td>
      <td colspan="3">Vb.<?php echo $usu_vb_despachos; ?></td>
    </tr>
    <tr>
      <td height="25" colspan="3">Observaciones</td>
      <td colspan="4"><label for="obs15"></label>
      <textarea name="obs15" cols="130" id="obs15"><?php echo $obs_vb_despachos; ?></textarea></td>
    </tr>
    <tr>
      <td height="25" colspan="7" align="center" bgcolor="#CCCCCC"><em><strong>16. CONCEPTO ADMIN PEGOMAX</strong></em></td>
    </tr>
    <tr>
      <td height="25" colspan="3">F. Respuesta</td>
      <td><?php echo $vb_adminpego; ?></td>
      <td colspan="3">Vb.<?php echo $usu_vb_adminpego; ?></td>
    </tr>
    <tr>
      <td height="25" colspan="3">Observaciones</td>
      <td colspan="4"><label for="obs16"></label>
      <textarea name="obs16" cols="130" id="obs16"><?php echo $obs_vb_adminpego; ?></textarea></td>
    </tr>
    <tr>
      <td height="25" colspan="7" align="center" bgcolor="#CCCCCC"><em><strong>17. CONCEPTO GERENCIA COMERCIAL PEGOMAX</strong></em></td>
    </tr>
    <tr>
      <td height="25" colspan="3">F. Respuesta</td>
      <td><?php echo $vb_gcomercialpego; ?></td>
      <td colspan="3">Vb.<?php echo $usu_vb_gcomercialpego; ?></td>
    </tr>
    <tr>
      <td height="25" colspan="3">Observaciones</td>
      <td colspan="4"><label for="obs17"></label>
      <textarea name="obs17" cols="130" id="obs17"><?php echo $obs_vb_gcomercialpego; ?></textarea></td>
    </tr>

  </table>
  <p>&nbsp;</p>
  <label ></label>
  <p>&nbsp;</p>
  <label></label>
  <p>&nbsp;</p>
  <label></label>
  <p>&nbsp;</p>
  <label></label>
  <br/>
  <p>&nbsp;</p>
  <label style="margin-left:100px;width:210px;"></label> 
</form>
</body>
</html>
