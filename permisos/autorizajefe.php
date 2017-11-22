<?php
error_reporting(0);

//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");


//recojo variables
$cedula=$_POST['cedula'];
$f_solicitud=$_POST['f_solicitud'];
$jefe=str_replace(" ","",$_POST['jefe']);
$f_permiso=$_POST['f_permiso'];
$salida=$_POST['salida'];
$llegada=$_POST['llegada'];
$motivo=$_POST['motivo'];
$observacion=$_POST['observacion'];
$correo=$_POST['correo'];
$correoemp=$_POST['correoemp'];
$nombre=$_POST['nombreemp'];
$codcc=trim($_POST['codcc']);
$correo2=$_POST['correo2'];



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


		if($codcc =='10-099'||$codcc =='70-099'||$codcc == '20-099')
			 {
				 $emailsala = " ";
				$sala = "ADMINISTRACION ";
			}
			else
			{   
			$sql="SELECT email emailpunto FROM email_permisos where cc = '$codcc'";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 
				
				$emailsala = $rs_qry->emailpunto;
				$sala= substr($emailsala, 0, -15); 
				
				
			}
		
	if  ($f_permiso >= $f_solicitud && $llegada >= $salida)
		{ 
			$unidades = $llegada - $salida;
			$sql="INSERT INTO `personal`.`permisos` (`cedula`, `tausentismo`, `f_final`, `f_liquidacion`,  `salida`, `llegada`,`unidades`, `autoriza`, `observacion`, `correo`, `correoemp`) VALUES ('$cedula', '$motivo', '$f_permiso', '$f_solicitud', '$salida', '$llegada','$unidades', '$jefe', '$observacion', '$correo', '$correoemp')";
		$qry_sql=$link->query($sql);
		
		echo  "<font color='blue'; font-size:35px;>SOLICITUD REALIZADA A JEFE DIRECTO</font>";
		
		
		//envio correo
		
		require_once('../PAZYSALVO/PHPMailer-master/class.phpmailer.php'); 
		require_once('../PAZYSALVO/PHPMailer-master/class.smtp.php');
		require_once('../PAZYSALVO/PHPMailer-master/PHPMailerAutoload.php');
		$cuerpo='
		<center>
		Se le informa que existe una solicitud de permiso <br>
		Plataforma de ares http://10.1.0.22/ares o  http://190.144.42.83/ares/		        <br>	
		GRACIAS<br>
		</center>';
		
		$sdlinea='<br>';
	    $iempleado='<br><b>EMPLEADO:</b> ';
   	    $isala='<br><b>UBICACION:</b> ';
		$ifpermiso='<br><b>FECHA DE PERMISO: </b>';
		$isalida='<br><b>LA HORA DE SALIDA ES: </b>';
		$illegada='<br><b>LA HORA DE LLEGADA ES: </b>';
		$iobservacion='<br><b>DETALLES DEL PERMISO: </b>';
			
			$mail = new PHPMailer(); //Crea un objecte/instancia.
			$mail->IsSMTP(); // enviament per protocol SMTP
			$mail->IsHTML(true);
			//$mail->SMTPDebug  = 2; //Habilita el SMTPDebug per test.
			$mail->Host = "smtp.gmail.com"; //Estableix GMAIL com el servidor SMTP.
			$mail->SMTPAuth= true; //Habilita la autenticaciÃ³ SMPT.
			//$mail->SMTPSecure="tls"; //Estableix el prefix del servidor.
			$mail->Port = 25 ; //Estableix el port SMTP.
			$mail->Username="ares@ceramigres.com"; //Username de la conte  de correo que s'utilitza com a servei d'enviament.
			$mail->Password="T3mp0r4l123"; //contrasenya del compte.
		 
		 
			//Parametros del Remitente
			$mail->SetFrom('ares@ceramigres.com', 'AUTORIZACION DE PERMISOS');	
			$mail->Subject ="Solicitud de Permisos";
			$mail->AltBody ="AUTORIZACION DE PERMISOS - Maxicassa S.A.S";//Messatge d'advertencia pels usuaris que no utilitzan un client HTML.
		 
			// Construccio del Body i assignacio a variable (body).
			/////$body=$cuerpo, $row_n['NOMBRE'] ;//Plantilla HTML creat. Document root+ruta "absoluta".
			$body= $cuerpo ;//Plantilla HTML creat. Document root+ruta "absoluta".
			
			$body= $cuerpo.$iempleado.$nombre.$isala.$sala.$ifpermiso.$f_permiso.$isalida.$salida.$illegada.$llegada.$iobservacion.$observacion;//Plantilla HTML creat. Document root+ruta "absoluta".
		
		
			//Utilitzacio de la funcio MsgHTML i utilitzacio de la variable body creada avanÃ§s per compondre el cos del missatge.
			$mail->MsgHTML($body);
			//S'indica adressa electronica on s'envia el mail i el nom.
			$mail->AddAddress($correo,'Solicitud de permisos');
			$mail->AddBCC($emailsala,'Solicitud de permisos');
			$mail->AddAddress($correo2,'Solicitud de permisos');
			
			$mail->Send();

         }
	else {
	echo "Los horarios o fechas no estan correctos, Verifique que la fecha del permiso sea mayor a la fecha de solicitud o que la hora de llegada sera mayor a la hora de salida.";
	     } 
	  
	exit();
?>	
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Autorización Jefe</title>
</head>
<body>

</body>
</html>
