<link rel="stylesheet" type="text/css" href="../estilos.css"/>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<style type="text/css">
.text {font-family:Verdana, Geneva, sans-serif;
	   font-size:11px;
}
.text1 {font-family:Verdana, Geneva, sans-serif;
	   font-size:11px;
}
.text1 {font-family:Verdana, Geneva, sans-serif;
	   font-size:11px;
}
</style>

<?php

//session_start();


//recojo variables
//$cedula=$_POST['aval'];
$hoy=date("d/m/Y");
$fecha = date('d/m/Y',strtotime('+20 day'));  
echo $fecha;


//conexion

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

	echo $sql1="SELECT cc FROM `concepto_sala` WHERE `fecha_control` = '$fecha' group by cc";
			$qry_sql1=$link->query($sql1);
			$rs_qry1=$qry_sql1->fetch_object();  ///consultar 
			 
	echo '<br>';
	do{
		echo $codcc =$rs_qry1->cc;	
		echo '<br>';
			//consulta el email de la sala
		 echo $sql2="SELECT email emailpunto FROM email_permisos where cc like '%$codcc%'";
			$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
			$correo2 =$rs_qry2->emailpunto;	 
			 if (empty($correo2)) 
				{
				$correo2 = "liroal@hotmail.com";
				
				}
			 $correo1 = "lrodriguez@ceramigres.com";
			
			
			//consulta informacion de tarea
	echo $sql3="SELECT tarea FROM `concepto_sala` WHERE `fecha_control` = '$fecha' and cc = $codcc";
			$qry_sql3=$link->query($sql3);
			$rs_qry3=$qry_sql3->fetch_object();  ///consultar 
			//$codcc =$rs_qry1->cc;	
			
			//guarda tareas en un arreglo
			$tareas_pend = '';
			
			do	{
			echo '<br>';
			$espacio = '<br>';		
			$tareas_pend = $tareas_pend.$espacio.utf8_encode($rs_qry3->tarea);
			echo $tareas_pend;
				}
				while($rs_qry3=$qry_sql3->fetch_object());
			
				
				
			
			//envio correo
		
		require_once('../PAZYSALVO/PHPMailer-master/class.phpmailer.php'); 
		require_once('../PAZYSALVO/PHPMailer-master/class.smtp.php');
		require_once('../PAZYSALVO/PHPMailer-master/PHPMailerAutoload.php');
		$cuerpo='
		<br>
		<br>
		Le informamos que seg&#250n la &#250ltima visita realizada a su sala, usted se compromet&#237o con las siguientes tareas para el pr&#243ximo ';
		$final='
		<br>
		<br>
		Recuerde revisarlas antes de la fecha estipulada<br><br>ESTE ES UN MENSAJE AUTOMATICO POR FAVOR NO RESPONDA A ESTE CORREO
		';
		
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
			$mail->SetFrom('plataforma_ares@hotmail.com', 'EVALUACION PUNTOS DE VENTA');	
			$mail->Subject = "Evaluacion de puntos de venta - RECORDATORIO";
			$mail->AltBody ="Seguimiento de compromisos - Maxicassa S.A.S";//Messatge d'advertencia pels usuaris que no utilitzan un client HTML.
		 
			// Construccio del Body i assignacio a variable (body).
			/////$body=$cuerpo, $row_n['NOMBRE'] ;//Plantilla HTML creat. Document root+ruta "absoluta".
			$body= $cuerpo.$fecha.$espacio.$tareas_pend.$final;//Plantilla HTML creat. Document root+ruta "absoluta".
		
			//Utilitzacio de la funcio MsgHTML i utilitzacio de la variable body creada avanÃ§s per compondre el cos del missatge.
			$mail->MsgHTML($body);
			//S'indica adressa electronica on s'envia el mail i el nom.
			$mail->AddAddress('lrodriguez@ceramigres.com','correo');
			$mail->Send();

   			    // echo "ok enviado".$correo2;
			//return;  		
	


	}while($rs_qry1=$qry_sql1->fetch_object())
	
?>	



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CORREO DE TAREAS PENDIENTES</title>
</head>
<body>

</body>
</html>
