<?php
require_once('PHPMailer-master/class.phpmailer.php'); 
require_once('PHPMailer-master/class.smtp.php');
require_once('PHPMailer-master/PHPMailerAutoload.php');

$cuerpo='
<center>
Gestion humana le informa que tiene paz y salvos por autorizar.
</center>';

    $mail = new PHPMailer(); //Crea un objecte/instancia.
	$mail->IsSMTP(); // enviament per protocol SMTP
	$mail->IsHTML(true);
	$mail->SMTPDebug  = 2; //Habilita el SMTPDebug per test.
	$mail->Host = "smtp.gmail.com"; //Estableix GMAIL com el servidor SMTP.
	$mail->SMTPAuth= true; //Habilita la autenticaciÃ³ SMPT.
	$mail->SMTPSecure="tls"; //Estableix el prefix del servidor.
	$mail->Port = 25 ; //Estableix el port SMTP.
	$mail->Username="ares@ceramigres.com"; //Username de la conte de correo que s'utilitza com a servei d'enviament.
	$mail->Password="T3mp0r4l123"; //contrasenya del compte.
 
 
    //Parametros del Remitente
	$mail->SetFrom('ares@ceramigres.com', 'Area Gestion Humana');	
	$mail->Subject ="Recordatorio";
	$mail->AltBody ="Depto. de Gestion Humana - Maxicassa S.A.S";//Messatge d'advertencia pels usuaris que no utilitzan un client HTML.
	//Utilitzacio de la funcio MsgHTML i utilitzacio de la variable body creada avanÃ§s per compondre el cos del missatge.
	$mail->MsgHTML($cuerpo);
	//S'indica adressa electronica on s'envia el mail i el nom.
	$mail->AddAddress('lrodriguez@ceramigres.com','PAZ_Y_SALVO_ARES');
	//$mail->AddBCC("lrodriguez@ceramigres.com","druiz@ceramigres.com");
    $mail->Send();

?>
