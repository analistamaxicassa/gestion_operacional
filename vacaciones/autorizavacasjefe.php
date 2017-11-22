<?php

//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");


//recojo variables
$cedula=$_POST['cedula'];
$correo=$_POST['correo'];
$jefe=str_replace(" ","",$_POST['jefe']);
$periodo=$_POST['periodo'];
$dias=$_POST['dias'];
$salida=$_POST['salida'];
$llegada=$_POST['llegada'];
$reemplazo=$_POST['reemplazo'];
$entrena=$_POST['entrena'];
$email_personal=$_POST['email_personal'];
$nombre=$_POST['nombre'];
$cc=$_POST['cc'];
$emergencia=$_POST['emergencia'];

$hoy=date("y/m/d");



/*//conexion QUERYS
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}*/


require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
//$ced=$_POST['ced']; 

		
	//if  ($llegada <= $salida)
		//{ 
			$sql="INSERT INTO `personal`.`vacaciones` (`cedula`, `correo`, `jefe`, `periodo`, `dias`, `salida`, `entrada`, `reemplazo`, `f_empalme`, `email_personal`, `emergencia`) VALUES ('$cedula', '$correo', '$jefe', '$periodo', '$dias', '$salida', '$llegada','$reemplazo', '$entrena', '$email_personal', '$emergencia')";
		$qry_sql=$link->query($sql);
		
		echo  "<font color='blue'; font-size:35px;>SOLICITUD REALIZADA A JEFE DIRECTO</font>";
		
		
		//envio correo
		require_once('../PAZYSALVO/PHPMailer-master/class.phpmailer.php'); 
		require_once('../PAZYSALVO/PHPMailer-master/class.smtp.php');
		require_once('../PAZYSALVO/PHPMailer-master/PHPMailerAutoload.php');
		$cuerpo='
		<center>
		Se ha generado una solicitud de vacaciones<br> http://10.1.0.22/ares o  http://190.144.42.83/ares/		        <br>	
		GRACIAS<br>
		
		**Por favor no responda a este correo, es un medio de generacion de mensajes**
		</center>';
		
		$sdlinea='<br>';
	    $iempleado='<br><b>EMPLEADO:</b> ';
   	    $isala='<br><b>UBICACION:</b> ';
		$isalida='<br><b>DIA DE SALIDA ES: </b>';
		$illegada='<br><b>ULTIMO DIA DE VACACIONES ES: </b>';
	
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
			$mail->Subject ="SOLICITUD DE GESTION HUMANA - VACACIONES";
			$mail->AltBody ="AUTORIZACION DE VACACIONES - Maxicassa S.A.S";//Messatge d'advertencia pels usuaris que no utilitzan un client HTML.
		 
			// Construccio del Body i assignacio a variable (body).
			/////$body=$cuerpo, $row_n['NOMBRE'] ;//Plantilla HTML creat. Document root+ruta "absoluta".
			$body= $cuerpo ;//Plantilla HTML creat. Document root+ruta "absoluta".
		
		$body= $cuerpo.$iempleado.$nombre.$isala.$cc.$isalida.$salida.$illegada.$llegada;
		
			//Utilitzacio de la funcio MsgHTML i utilitzacio de la variable body creada avanÃ§s per compondre el cos del missatge.
			$mail->MsgHTML($body);
			//S'indica adressa electronica on s'envia el mail i el nom.
			$mail->AddAddress($correo,'correo');
			$mail->AddAddress($email_personal,'COPIA_SOLICITANTE');
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
<title>Solicitud de vacaciones</title>
</head>
<body>

</body>
</html>
