<?php

//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

//recojo variables
$id=$_POST['id'];
$email_personal=$_POST['ema'];
$obsrechazo=$_POST['obsrechazo'];
$correo2=$_POST['correo2'];


		$sql="UPDATE `vacaciones` SET `aut_jefe`='2' WHERE `id` = '$id' ";
		$qry_sql=$link->query($sql);
		
		echo  "<font color='blue'; font-size:35px;>VACACIONES NEGADAS, Se enviara un correo al solicitante </font>";
		
			
		//envio correo
		
		require_once('../PAZYSALVO/PHPMailer-master/class.phpmailer.php'); 
		require_once('../PAZYSALVO/PHPMailer-master/class.smtp.php');
		require_once('../PAZYSALVO/PHPMailer-master/PHPMailerAutoload.php');
		//$precuerpo = '<br>Sr(a)'.$nombre.'<br>';
		$cuerpo='
		<center>
		Se le informa que sus vacaciones han sido NEGADAS
		<br><br>
		
		</center>';
		$postcuerpo = '<br>Observacion: '.$obsrechazo.'<br>'.'Mensaje enviado con copia a:';
		
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
			$mail->SetFrom('plataforma_ares@hotmail.com', 'AUTORIZACION DE VACACIONES');	
			$mail->Subject ="Ares";
			$mail->AltBody ="AUTORIZACION DE VACACIONES - Maxicassa S.A.S";//Messatge d'advertencia pels usuaris que no utilitzan un client HTML.
		 
			// Construccio del Body i assignacio a variable (body).
			/////$body=$cuerpo, $row_n['NOMBRE'] ;//Plantilla HTML creat. Document root+ruta "absoluta".
			$body= $cuerpo.$postcuerpo.$correo2;//Plantilla HTML creat. Document root+ruta "absoluta".
		
			//Utilitzacio de la funcio MsgHTML i utilitzacio de la variable body creada avanÃ§s per compondre el cos del missatge.
			$mail->MsgHTML($body);
			//S'indica adressa electronica on s'envia el mail i el nom.
			$mail->AddAddress($email_personal,'correo');
			$mail->AddBCC ($correo2,'correo2');
			$mail->Send();

 /*        }
	else {
	echo "Las fechas de salida es mayor a la fecha de entrada de vacaciones, Verifique.";
	     } */
	  
	exit();
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
