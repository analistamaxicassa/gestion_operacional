<?php

//error_reporting(0);
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
$usuario = $_POST['usuario'];


	
	//consulta USUARIO
	$sql1="SELECT password, correo FROM `autentica_ci` WHERE cedula = '$usuario'";
			$qry_sql1=$link->query($sql1);
			$rs_qry1=$qry_sql1->fetch_object();  ///consultar 
			
		
		
if (empty($rs_qry1)) {
    echo 'La cedula digitada no esta registrada en la plataforma, verifique';
	exit();
				}
$correo = $rs_qry1->correo;
	//envio correo
		require_once('PHPMailer-master/class.phpmailer.php'); 
		require_once('PHPMailer-master/class.smtp.php');
		require_once('PHPMailer-master/PHPMailerAutoload.php');
		
		
	
		$cuerpo='
		<center>
		
		Est&atildes recibiendo esta notificaci&otilden porque olvidaste tu contrase&ntildea de la herramienta CLIENTE INTERNO
		 <br>
		 Si no realizaste esta solicitud por favor comunicate con el Area de Sistemas
		 <br>
		 Tu contrase&ntildea es :		 
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
			$mail->SetFrom('plataforma_ares@hotmail.com', 'CLIENTE INTERNO');	
			$mail->Subject ="Recuperacion de Clave -  Cliente Interno";
			$mail->AltBody ="Aplicacion CLIENTE INTERNO - Maxicassa S.A.S";//Messatge d'advertencia pels usuaris que no utilitzan un client HTML.
		 
			// Construccio del Body i assignacio a variable (body).
			/////$body=$cuerpo, $row_n['NOMBRE'] ;//Plantilla HTML creat. Document root+ruta "absoluta".
			utf8_encode ($body= $cuerpo.$rs_qry1->password);//Plantilla HTML creat. Document root+ruta "absoluta".
		
			
//			$body= $cuerpo.$rs_qry2['fecha'].$sdlinea.$rs_qry2['NOMBRE'] .$sdlinea.$rs_qry2['CONCEPTO'] //.$sdlinea.$rs_qry2['AUTOR'] ;//Plantilla HTML creat. Document root+ruta "absoluta".
		
			//Utilitzacio de la funcio MsgHTML i utilitzacio de la variable body creada avanÃ§s per compondre el cos del missatge.
			$mail->MsgHTML($body);
			//S'indica adressa electronica on s'envia el mail i el nom.
			$mail->AddAddress($correo,'CLIENTE INTERNO');
			//$mail->AddAddress();
		    $mail->AddBCC('','');
			$mail->Send();



?>
<script>
alert("SU CLAVE HA SIDO ENVIADA A SU CORREO EMPRESARIAL, POR FAVOR VERIFIQUE")
</script>
	

	
