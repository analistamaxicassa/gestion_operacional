<link rel="stylesheet" type="text/css" href="../estilos.css"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
  <script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
  <script src="../SpryAssets/SpryValidationRadio.js" type="text/javascript"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">


<?php

//recojo variables
echo $condiciones=$_POST['condiciones'];
//$condiciones="condicioness";
echo $nombre=$_POST['nombre'];
//$nombre="Liliana";

	//envio correo
		
		require_once('../PAZYSALVO/PHPMailer-master/class.phpmailer.php'); 
		require_once('../PAZYSALVO/PHPMailer-master/class.smtp.php');
		require_once('../PAZYSALVO/PHPMailer-master/PHPMailerAutoload.php');
		$cuerpo='
		<br>
		<br>
		Se le informa que el empleado(a)  ';	

		$cuerpo2= '( continuara laborando en la empresa, por lo cual es necesario realizar el proceso de contratacion, Teniendo en cuenta que las condiciones )';

	
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
			$mail->SetFrom('plataforma_ares@hotmail.com', 'AUTORIZACION DE CONTRATACION');	
			$mail->Subject = "Evaluacion de desempeno";
			$mail->AltBody ="AUTORIZACION DE CONTRATACION";//Messatge d'advertencia pels usuaris que no utilitzan un client HTML.
		 
			// Construccio del Body i assignacio a variable (body).
			/////$body=$cuerpo, $row_n['NOMBRE'] ;//Plantilla HTML creat. Document root+ruta "absoluta".
			$body= $cuerpo.$nombre.$cuerpo2.$condiciones ;//Plantilla HTML creat. Document root+ruta "absoluta".
		
			//Utilitzacio de la funcio MsgHTML i utilitzacio de la variable body creada avanÃ§s per compondre el cos del missatge.
			$mail->MsgHTML($body);
			//S'indica adressa electronica on s'envia el mail i el nom.
			//$mail->AddAddress('liroal@hotmail.com','correo');
			//$mail->AddAddress('contratacion@ceramigres.com');
			$mail->AddAddress('contratacion@ceramigres.com');
			$mail->Send();

       // echo "ok enviado".$correo2;

?>	
Correo enviado