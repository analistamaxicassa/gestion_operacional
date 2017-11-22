<?php

//recojo variables

$cedula=$_POST['cedula'];
$correo=$_POST['correo'];
$llegada=$_POST['llegada'];
$hll=$_POST['hll'];
$mll=$_POST['mll'];


//conexion

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

$sql="SELECT nombre FROM act_man2.`usuarios_queryx` WHERE cedula = $cedula";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 		
	
		$nombre= $rs_qry->nombre;
				
		//envio correo
		
		require_once('../PAZYSALVO/PHPMailer-master/class.phpmailer.php'); 
		require_once('../PAZYSALVO/PHPMailer-master/class.smtp.php');
		require_once('../PAZYSALVO/PHPMailer-master/PHPMailerAutoload.php');
		$cuerpo='Le informo que ha reportado su llegada de permiso el senor(a)
		<br>';
		$cuerpo2='<br>La hora del final del permiso era: ';
		$cuerpo3='<br>El reporte de llegada es:  ';
		$cuerpo4=' : ';
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
			$mail->SetFrom('plataforma_ares@hotmail.com', 'SOPORTE DE PERMISO');	
			$mail->Subject ="Ares";
			$mail->AltBody ="REPORTE DE LLEGADA DE PERMISO - Maxicassa S.A.S";//Messatge d'advertencia pels usuaris que no utilitzan un client HTML.
		 
			// Construccio del Body i assignacio a variable (body).
			/////$body=$cuerpo, $row_n['NOMBRE'] ;//Plantilla HTML creat. Document root+ruta "absoluta".
			$body= $cuerpo.$nombre.$cuerpo2.$llegada.$cuerpo3.$hll.$cuerpo4.$mll;//Plantilla HTML creat. Document root+ruta "absoluta".
		
			//Utilitzacio de la funcio MsgHTML i utilitzacio de la variable body creada avanÃ§s per compondre el cos del missatge.
			$mail->MsgHTML($body);
			//S'indica adressa electronica on s'envia el mail i el nom.
			$mail->AddAddress('lrodriguez@ceramigres.com');
//			$mail->AddAddress('lrodriguez@ceramigres.com','correo');
			$mail->Send();
		
        
	//exit();
	
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