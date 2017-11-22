<?php

//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");


//recojo variables
$cedula=$_POST['cedula'];
$f_inicial=$_POST['f_inicial'];
$ndias=$_POST['ndias'];
$fe_final=$_POST['fe_final'];
$observacion=$_POST['observacion'];
$correo=$_POST['correo'];


//conexion
try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		
	 $query = "SELECT SO.NOMBRE_SOCIEDAD SOCIEDAD,  EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , CA.CARGO_NOMBRE,  CC.CENCOS_NOMBRE CC, SUBSTR(EM.EMP_CC_CONTABLE,1,9) CODIGO, SUBSTR(EM.EMP_CC_CONTABLE,1,3) CODSOCIEDAD
        FROM EMPLEADO EM, CARGO CA,  sociedad SO, CENTRO_COSTO CC
        WHERE EM.EMP_CARGO = CA.CARGO_CODIGO  AND EM.EMP_CC_CONTABLE = CC.CENCOS_CODIGO
        AND EM.EMP_SOCIEDAD = SO.COD_SOCIEDAD
        AND EM.EMP_CODIGO = '$cedula'";
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row_n = $stmt->fetch();
		
		$nombre=$row_n['NOMBRE'];
		$empresa=$row_n ['SOCIEDAD'];
		$cc=$row_n ['CC'];
		$codigo=$row_n ['CODIGO'];
		$codsociedad =$row_n ['CODSOCIEDAD'];
		$cargo=utf8_encode($row_n['CARGO_NOMBRE']);
		


require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

$sql="INSERT INTO `personal`.`incapacidades` (`cedula`, `tipo_incapacidad`, `numero_incapacidad`, `finicial`, `ffinal`, `ndias`, `diagnostico`, `entidad`, `adjunto`, `observacion`, `referencia` ) VALUES ('$cedula','', '', '$f_inicial',  '$fe_final', '$ndias', '','', '', '$observacion', '')";
		$qry_sql=$link->query($sql);
		
		echo  "<font color='blue'; font-size:35px;> <br> <br> <br>EL REPORTE SE HA REALIZADO A LA JEFE DE PERSONAL Y GESTION HUMANA, <br> POR FAVOR TRAMITAR LA INCAPACIDAD DEFINITIVA DE SER NECESARIO ANTES DE 2 DIAS CON SUS DOCUMENTOS ADJUNTOS</font>";
		
		
		//envio correo
		
		require_once('../PAZYSALVO/PHPMailer-master/class.phpmailer.php'); 
		require_once('../PAZYSALVO/PHPMailer-master/class.smtp.php');
		require_once('../PAZYSALVO/PHPMailer-master/PHPMailerAutoload.php');
		$cuerpo='
		<center>
		Se le informa que se ha realizado un reporte de Ausencia Temporal
		
		 <br>	
		
		</center>';
		
		$sdlinea='<br>';
	    $iempleado='<br><b>EMPLEADO:</b> ';
   	    $isala='<br><b>UBICACION:</b> ';
		$icargo='<br><b>CARGO: </b>';
		$idetalles='<br><b>DETALLES: </b>';
		
	
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
			$mail->SetFrom('plataforma_ares@hotmail.com', 'REPORTE DE AUSENCIA TEMPORAL');	
			$mail->Subject ="Ares";
			$mail->AltBody ="REPORTE DE AUSENCIA TEMPORAL - Maxicassa S.A.S";//Messatge d'advertencia pels usuaris que no utilitzan un client HTML.
		 
			// Construccio del Body i assignacio a variable (body).
			/////$body=$cuerpo, $row_n['NOMBRE'] ;//Plantilla HTML creat. Document root+ruta "absoluta".
			$body= $cuerpo ;//Plantilla HTML creat. Document root+ruta "absoluta".
		
			$body= $cuerpo.$iempleado.$nombre.$isala.$cc.$icargo.$cargo.$sdlinea.$empresa.$idetalles.$observacion;//Plantilla HTML creat. Document root+ruta "absoluta".
		
			//Utilitzacio de la funcio MsgHTML i utilitzacio de la variable body creada avanÃ§s per compondre el cos del missatge.
			$mail->MsgHTML($body);
			//S'indica adressa electronica on s'envia el mail i el nom.
		//	$mail->AddAddress('lrodriguez@ceramigres.com','correo');
			// echo $codigo;
			if ($codigo == '10-099-02'){
							//echo "ingreso a 10-099-02";
							$mail->AddAddress('personal@ceramigres.com','correo');
							$mail->AddAddress('$correo','correo');
							//exit();
									}
			if ($codigo =='10-099-01'){
							$mail->AddAddress('fleon@ceramigres.com','correo');
							$mail->AddAddress($correo,'correo');
							//echo "ingreso a 10-099-01";
							//exit();
									}
			if ($codigo == '70-099-02'){
							$mail->AddAddress('personal@ceramigres.com','correo');
							$mail->AddAddress($correo,'correo');
							//echo "ingreso a 70-099-02";
							//exit();
									}
			if ($codigo == '70-099-01'){
							$mail->AddAddress('fleon@ceramigres.com','correo');
							$mail->AddAddress($correo,'correo');
							//echo "ingreso a 70-099-01";
							//exit();
									}
			if ($codsociedad == '60-'){
							$mail->AddAddress('compras@pegoperfecto.com','correo');
							$mail->AddAddress($correo,'correo');
							//echo "ingreso a 40 o 60";
							//exit();
									}
			if ($codsociedad == '40-'){
							$mail->AddAddress('asisadministrativa@tucassa.com','correo');
							$mail->AddAddress($correo,'correo');
							//echo "ingreso a 40 o 60";
							//exit();
									}
			else {
					$mail->AddAddress('personal@ceramigres.com','correo');
					$mail->AddAddress($correo,'correo');
					//echo "no ingreso es de sala";
					//exit();
				}						
									
		//	$mail->AddAddress('fleon@ceramigres.com','correo');
			
		//	$mail->AddAddress('personal@ceramigres.com','correo');
			$mail->Send();

        
	//exit();
	
?>	
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
 <script> 					

  
</script>

</head>
 <link rel="stylesheet" type="text/css" href="../estilos.css"/>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

<body>
<form id="form1" name="form1" method="post" action="">
</form>
</body>
</html>
