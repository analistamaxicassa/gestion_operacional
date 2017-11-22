
<?php

//recojo variables
$sala=$_POST['sala'];
$nombre= $_POST['nombre'];
$tipo= $_POST['tipo'];
$serie= $_POST['serie'];
$marca= $_POST['marca'];
$cantidad= $_POST['cantidad'];
$ubicacion=$_POST['ubicacion'];
$cedula= $_POST['cedula'];
$observacion= $_POST['observacion'];
$condicion= $_POST['condicion'];

include "../PAZYSALVO/conexion_ares.php";

$link=Conectarse();

$hoy=date("d/m/y");

////consulta de elementos
$sql2="SELECT `area`, responsable, responsableind FROM `suministros_elementos` where id = $nombre";
			$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
			
						
		
	if (empty($rs_qry2)) {
    echo 'No existen registros';
	exit();
	}

	else {
		 
		  $rs_qry2->area;	
		   $rs_qry2->responsable;
		  $rs_qry2->responsableind;	
			}

  $sql3="SELECT  id FROM `suministros_sala` where sala = '$sala' and elemento = '$nombre' and cedula = '$cedula'";
			$qry_sql3=$link->query($sql3);
			$rs_qry3=$qry_sql3->fetch_object();  ///consultar 
		
	if (empty($rs_qry3)) 
	{
	 $sql4="INSERT INTO `personal`.`suministros_sala` (`id`, `sala`, `elemento`, `tipo`, `serie`, `marca`, `observacion`, `cantidad`, `ubicacion`, `cedula`, `condicion`, `entrega`, `fecha`, `estado`) VALUES (NULL, '$sala', '$nombre', '$tipo','$serie','$marca','$observacion', '$cantidad', '$ubicacion', '$cedula', 'Nuevo', '$entrega', '$hoy', '1')";
$qry_sql4=$link->query($sql4);

	exit();
	}

	else {
		
	 $sql5="UPDATE `suministros_sala` SET `cantidad` = $cantidad WHERE `sala` = $sala and `elemento` = $nombre";
		 $qry_sql5=$link->query($sql5);
			}

/*
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
			$mail->Host = "smtp.live.com"; //Estableix GMAIL com el servidor SMTP.
			$mail->SMTPAuth= true; //Habilita la autenticaciÃ³ SMPT.
			$mail->SMTPSecure="tls"; //Estableix el prefix del servidor.
			$mail->Port = 587 ; //Estableix el port SMTP.
			$mail->Username="plataforma_ares@hotmail.com"; //Username de la conte de correo que s'utilitza com a servei d'enviament.
			$mail->Password="maxicassa2016"; //contrasenya del compte.
		 
		 
			//Parametros del Remitente
			$mail->SetFrom('plataforma_ares@hotmail.com', 'CLIENTE INTERNO');	
			$mail->Subject ="Concepto de visita a sala -  Cliente Interno";
			$mail->AltBody ="Aplicacion CLIENTE INTERNO - Maxicassa S.A.S";//Messatge d'advertencia pels usuaris que no utilitzan un client HTML.
		 
			// Construccio del Body i assignacio a variable (body).
			/////$body=$cuerpo, $row_n['NOMBRE'] ;//Plantilla HTML creat. Document root+ruta "absoluta".
			$body= $cuerpo.$impfecha.$rs_qry2->fecha.$impsala.$rs_qry2->nombre.$impconcepto.$rs_qry2->promedio.$impautor.$rs_qry2->autor;//Plantilla HTML creat. Document root+ruta "absoluta".
		
			
//			$body= $cuerpo.$rs_qry2['fecha'].$sdlinea.$rs_qry2['NOMBRE'] .$sdlinea.$rs_qry2['CONCEPTO'] //.$sdlinea.$rs_qry2['AUTOR'] ;//Plantilla HTML creat. Document root+ruta "absoluta".
		
			//Utilitzacio de la funcio MsgHTML i utilitzacio de la variable body creada avanÃ§s per compondre el cos del missatge.
			$mail->MsgHTML($body);
			//S'indica adressa electronica on s'envia el mail i el nom.
			$mail->AddAddress('lrodriguez@ceramigres.com','CLIENTE INTERNO');
//			$mail->AddAddress('lrodriguez@ceramigres.com','PAZ_Y_SALVO_ARES');
			//echo "$correo";
			//$mail->AddAddress();
		    $mail->AddBCC('','');
			$mail->Send();


*/
?>

