<?php

//recojo variables
$EMP_CODIGO=$_POST['cedula'];
$correoemp=$_POST['correoemp'];
$codcc=trim($_POST['codcc']);




//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");


require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();


				
		echo  "<font color='blue'; font-size:35px;>LA SOLICITUD HA SIDO RECHAZADA</font>";
		
		$sql="UPDATE `permisos` SET CONFIRMADO = '2' WHERE `cedula` = '$EMP_CODIGO'";
			$qry_sql=$link->query($sql);
		
		
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
			
		
		
		//envio correo
		
		require_once('../PAZYSALVO/PHPMailer-master/class.phpmailer.php'); 
		require_once('../PAZYSALVO/PHPMailer-master/class.smtp.php');
		require_once('../PAZYSALVO/PHPMailer-master/PHPMailerAutoload.php');
		$cuerpo='
		<center>
		Se le informa que su solicitud de permiso ha sido NEGADA<br>
		GRACIAS<br>
		</center>';
	
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
			$mail->SetFrom('plataforma_ares@hotmail.com', 'AUTORIZACION DE PERMISOS');	
			$mail->Subject ="Respuesta de Solicitud de Permisos";
			$mail->AltBody ="AUTORIZACION DE PERMISOS - Maxicassa S.A.S";//Messatge d'advertencia pels usuaris que no utilitzan un client HTML.
		 
			// Construccio del Body i assignacio a variable (body).
			/////$body=$cuerpo, $row_n['NOMBRE'] ;//Plantilla HTML creat. Document root+ruta "absoluta".
			$body= $cuerpo ;//Plantilla HTML creat. Document root+ruta "absoluta".
		
			//Utilitzacio de la funcio MsgHTML i utilitzacio de la variable body creada avanÃ§s per compondre el cos del missatge.
			$mail->MsgHTML($body);
			//S'indica adressa electronica on s'envia el mail i el nom.
			$mail->AddAddress($correoemp,'correo');
			$mail->AddAddress($correo2,'correo2');
			$mail->Send();

        
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
