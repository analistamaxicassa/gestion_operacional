
<?php


//recojo variables
$sala=$_POST['sala'];


include "../PAZYSALVO/conexion_ares.php";
require_once('../PAZYSALVO/conexion_ares.php'); 

$link=Conectarse();

$hoy=date("d/m/y");



////consulta de concepto de sala
$sql2="SELECT sa.nombre nombre, `fecha`, avg(`calificacion`)  promedio  , `autor` FROM `concepto_sala` cs inner join salas sa on cs.cc = sa.cc  WHERE cs.cc = '$sala' and  `fecha` = '$hoy'";
			$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
			
						
		
	if (empty($rs_qry2)) {
    echo 'No existen registros';
	exit();
	}

	else {
		 $rs_qry2->nombre;
		  $rs_qry2->fecha;	
		 $rs_qry2->promedio;
		 $rs_qry2->autor;
			}


		//envio correo
		require_once('PHPMailer-master/class.phpmailer.php'); 
		require_once('PHPMailer-master/class.smtp.php');
		require_once('PHPMailer-master/PHPMailerAutoload.php');
		
		
	
		$cuerpo='
		<center>
		Le informamos que se ha generado una nueva visita que contiene la siguiente observacion. <br>	
		</center>';
		
		$sdlinea='<br>';
	    $impfecha='<br><b>FECHA:</b> ';
		$impsala='<br><b>SALA: </b>';
		$impconcepto='<br><b>PROMEDIO DE CALIFICACION: </b>';
		$impautor='<br><b>AUTOR: </b>';
		
			
			$mail = new PHPMailer(); //Crea un objecte/instancia.
			$mail->IsSMTP(); // enviament per protocol SMTP
			$mail->IsHTML(true);
			//$mail->SMTPDebug  = 2; //Habilita el SMTPDebug per test.
			$mail->Host = "smtp.gmail.com"; //Estableix GMAIL com el servidor SMTP.
			$mail->SMTPAuth= true; //Habilita la autenticaciÃ³ SMPT.
			//$mail->SMTPSecure="tls"; //Estableix el prefix del servidor.
			$mail->Port = 25 ; //Estableix el port SMTP.
			$mail->Username="ares@ceramigres.com"; //Username de la conte de correo que s'utilitza com a servei d'enviament.
			$mail->Password="M41l3rD43m0n+"; //contrasenya del compte.
		 
		 
			//Parametros del Remitente
			$mail->SetFrom('ares@ceramigres.com', 'AUDITORIA OPERACIONAL');	
			$mail->Subject ="Concepto de visita a sala -  Auditoria Operacional";
			$mail->AltBody ="Aplicacion AUDITORIA OPERACIONAL - Maxicassa S.A.S";//Messatge d'advertencia pels usuaris que no utilitzan un client HTML.
		 
			// Construccio del Body i assignacio a variable (body).
			/////$body=$cuerpo, $row_n['NOMBRE'] ;//Plantilla HTML creat. Document root+ruta "absoluta".
			$body= $cuerpo.$impfecha.$rs_qry2->fecha.$impsala.$rs_qry2->nombre.$impconcepto.$rs_qry2->promedio.$impautor.$rs_qry2->autor;//Plantilla HTML creat. Document root+ruta "absoluta".
		
			
//			$body= $cuerpo.$rs_qry2['fecha'].$sdlinea.$rs_qry2['NOMBRE'] .$sdlinea.$rs_qry2['CONCEPTO'] //.$sdlinea.$rs_qry2['AUTOR'] ;//Plantilla HTML creat. Document root+ruta "absoluta".
		
			//Utilitzacio de la funcio MsgHTML i utilitzacio de la variable body creada avanÃ§s per compondre el cos del missatge.
			$mail->MsgHTML($body);
			//S'indica adressa electronica on s'envia el mail i el nom.
			$mail->AddAddress('eprada@ceramigres.com','CLIENTE INTERNO');
			$mail->AddBCC('fleon@ceramigres.com','CLIENTE INTERNO');
			$mail->AddBCC('lrodriguez@ceramigres.com','CLIENTE INTERNO');
			$mail->AddBCC('asispresidencia@ceramigres.com','CLIENTE INTERNO');
			//$mail->AddAddress();
		    //$mail->AddBCC('','');
			$mail->Send();



?>
<script>
alert("INFORME ENVIADO")
</script>

