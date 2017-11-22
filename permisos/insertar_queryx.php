
<?php

echo "si ingresa";
require_once('../PAZYSALVO/conexion_ares.php'); 
//require_once('conexion_ares.php'); 
$link=Conectarse();

//recojo variables
$EMP_CODIGO=$_POST['cedula'];
$AUS_FECHA_LIQ=$_POST['f_solicitud'];
$AUS_OBSERVACION=$_POST['jefe']." ".$_POST['observacion']."  salida: ".$_POST['salidafor'];
$AUS_OBSERVACION1 = (utf8_encode($AUS_OBSERVACION));
$AUS_FECHA_INICIAL=$_POST['f_permiso'];
$AUS_FECHA_INICIAL2=date("m/d/Y",strtotime($AUS_FECHA_INICIAL));
$TAUS_CODIGO=$_POST['motivo'];
$UNIDADES=$_POST['unidades'];
$correoemp=$_POST['correoemp'];
$tipo=$_POST['tipo'];
$codcc=trim($_POST['codcc']);
$id=trim($_POST['id']);
$hoy=date("m/d/y");
$hoy2=date("m/d/Y",strtotime($hoy));




//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		
	 $queryx = " Select AUS_CONSECUTIVO from (select * from TRH_AUSENTISMO order by  AUS_CONSECUTIVO desc )
where rownum = 1";
		$stmt = $dbh->prepare($queryx);
		$stmt->execute();
		$row_n1 = $stmt->fetch();
		
		$AUS_CONSECUTIVO = $row_n1['AUS_CONSECUTIVO']+1;
		
		
		 $query1 = "SELECT SO.NOMBRE_SOCIEDAD SOCIEDAD,  EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , CA.CARGO_NOMBRE,  CC.CENCOS_NOMBRE CC, CC.CENCOS_TIPO_CODIGO
        FROM EMPLEADO EM, CARGO CA,  sociedad SO, CENTRO_COSTO CC
        WHERE EM.EMP_CARGO = CA.CARGO_CODIGO  AND EM.EMP_CC_CONTABLE = CC.CENCOS_CODIGO
        AND EM.EMP_SOCIEDAD = SO.COD_SOCIEDAD
        AND EM.EMP_CODIGO = '$EMP_CODIGO'";
		$stmt1 = $dbh->prepare($query1);
		$stmt1->execute();
		$row_n1 = $stmt1->fetch();
		
		$nombre = $row_n1['NOMBRE']; 
		$empresa = $row_n1 ['SOCIEDAD'];
		$cc = $row_n1 ['CC'];
		$cargo1=utf8_encode($row_n1['CARGO_NOMBRE']);
		
	
	 $sql="Insert into TRH_AUSENTISMO
   (AUS_CONSECUTIVO, EMP_CODIGO, EN1_CODIGO, TNOM_CODIGO, TAUS_CODIGO, 
    AUS_FECHA_INICIAL, AUS_FECHA_FINAL, AUS_UNIDADES, AUS_FECHA_LIQ, AUS_ESTADO, 
    AUS_CONSECUTIVO_REFER, AUS_DOCUMENTO, AUS_INCAPACIDAD, AUS_DOC_AUT_DESC_INCAP, AUS_OBSERVACION, 
    DIAG_CODIGO, CABUPZ_CODIGO, USERNAME, AUS_FECHA_SISTEMA, AUS_CONSEC_GENERO, 
    VERSION)
 Values
   ($AUS_CONSECUTIVO, '$EMP_CODIGO', 1, 1,'$TAUS_CODIGO', 
    TO_DATE('$AUS_FECHA_INICIAL2', 'MM/DD/YYYY HH24:MI:SS'), TO_DATE('$AUS_FECHA_INICIAL2', 'MM/DD/YYYY HH24:MI:SS'), $UNIDADES,TO_DATE('$AUS_FECHA_INICIAL2', 'MM/DD/YYYY HH24:MI:SS'), 'ACT', 
    NULL, NULL,  NULL, NULL, '$AUS_OBSERVACION1', NULL, NULL,'SRHCATERIN',TO_DATE('$hoy2', 'MM/DD/YYYY HH24:MI:SS'), NULL, 
    0)";
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		
		
			if($codcc =='10-099'||$codcc =='70-099'||$codcc == '20-099')
				 {
				echo "El empleado es administrativo<br>";	 
				 $correo2 = " ";
					}
			else
				{
					echo "El empleado es comercial<br>";	  		
			$sql1="SELECT email emailpunto FROM email_permisos where cc = '$codcc'";
			$qry_sql1=$link->query($sql1);
			$rs_qry1=$qry_sql1->fetch_object();  ///consultar 
			$correo2 =$rs_qry1->emailpunto;
				}
		
			


//conexion sql	para ACTUALIZAR el registro EN SQL
	
	
			$sql="UPDATE `permisos` SET CONFIRMADO = '1' WHERE `cedula` = '$EMP_CODIGO' and id = '$id'";
			$qry_sql=$link->query($sql);
	
	//envio correo
			
	require_once('../PAZYSALVO/PHPMailer-master/class.phpmailer.php'); 
		require_once('../PAZYSALVO/PHPMailer-master/class.smtp.php');
		require_once('../PAZYSALVO/PHPMailer-master/PHPMailerAutoload.php');
		$cuerpo='
		<center>
		Se le informa que su solicitud de permiso ha sido aceptada
		Sr(a):  
		<br>
		</center>';
		
		$espacio= "<br>";
		  
	
			$mail = new PHPMailer(); //Crea un objecte/instancia.
			$mail->IsSMTP(); // enviament per protocol SMTP
			$mail->IsHTML(true);
			//$mail->SMTPDebug  = 2; //Habilita el SMTPDebug per test.
			$mail->Host = "smtp.gmail.com"; //Estableix GMAIL com el servidor SMTP.
			$mail->SMTPAuth= true; //Habilita la autenticaciÃ³ SMPT.
			//$mail->SMTPSecure="tls"; //Estableix el prefix del servidor.
			$mail->Port = 25 ; //Estableix el port SMTP.
			$mail->Username="ares@ceramigres.com"; //Username de la conte de correo que s'utilitza com a servei d'enviament.
			$mail->Password="T3mp0r4l123"; //contrasenya del compte.
		 
		 
			//Parametros del Remitente
			$mail->SetFrom('ares@ceramigres.com', 'AUTORIZACION DE PERMISOS');	
			$mail->Subject ="Respuesta de Solicitud de Permisos";
			$mail->AltBody ="AUTORIZACION DE PERMISOS - Maxicassa S.A.S";//Messatge d'advertencia pels usuaris que no utilitzan un client HTML.
		 
			// Construccio del Body i assignacio a variable (body).
			$body= $cuerpo.$nombre.$espacio.$empresa.$espacio.$cc.$espacio.$cargo1 ;//Plantilla HTML creat. Document root+ruta "absoluta".
			
		
			//Utilitzacio de la funcio MsgHTML i utilitzacio de la variable body creada avanÃ§s per compondre el cos del missatge.
			$mail->MsgHTML($body);
			//S'indica adressa electronica on s'envia el mail i el nom.
			$mail->AddAddress($correoemp,'correo');
			$mail->AddAddress($correo2,'correo2');
			$mail->Send();

	//conexion sql	para eliminar el registro OPCION BLOQUEADA POR CONTROL DE INSERCION*****
	
		//	$sql="DELETE FROM `permisos` WHERE `cedula` = '$EMP_CODIGO'";
		//	$qry_sql=$link->query($sql);
	
if (isset($AUS_CONSECUTIVO)) {
    echo "<font color='blue'; font-size:35px;>Se ha realizado la autorizacion del permiso y se ha enviado correo al usuario</font>";
}
else 
	echo "<font color='blue'; font-size:35px;>No se guardo el registro de novedad en el sistema de nomina, por favor informe a lrodriguez@ceramigres.com</font>"
?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
</body>
</html>