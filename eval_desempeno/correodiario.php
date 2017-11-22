<link rel="stylesheet" type="text/css" href="../estilos.css"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
  <script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
  <script src="../SpryAssets/SpryValidationRadio.js" type="text/javascript"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">


<?php

require_once("enviocorreo.php");

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		
		
echo $query = "SELECT EMP.EMP_CODIGO CEDULA ,EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE,EMP.EMP_FECHA_INGRESO INGRESO, CC.CENCOS_NOMBRE CCNOMBRE,
 EMP.EMP_CC_CONTABLE CODCC ,TO_NUMBER(to_date (SYSDATE) - to_date (EMP.EMP_FECHA_INGRESO)) AS DIAS, EMP.EMP_CARGO CARGO FROM EMPLEADO EMP, CENTRO_COSTO CC
  WHERE EMP.EMP_CC_CONTABLE = CC.CENCOS_CODIGO AND EMP.EMP_ESTADO <> 'R' AND to_date (SYSDATE) - to_date (EMP.EMP_FECHA_INGRESO) in ('40','130','220',
  '310')  order by dias";
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row_n = $stmt->fetch();
		
	//	$correo1 = "personal@ceramigres.com";

		
		if (empty($row_n['CEDULA'])) 
		{
		echo "<br>no existen registros";
		exit();
		}

		 
		// NO SON TEMPORALES SOLO ENVIA A LOS 2 MESES
		do{
			echo $nombre = $row_n['NOMBRE'];
			echo $ccnombre = $row_n['CCNOMBRE'];
			echo "<br>";
		echo $empresa = trim((substr($row_n['CODCC'], 0, 2)));
			echo "<br>";
		if ($empresa <> '70' AND $row_n['DIAS'] == '40' )	
				{
					 switch($empresa)
					 {
						case '40':
						{	
						echo "ingreso x innova";		
						echo $correo1 = "contratacion@ceramigres.com";
						echo $correo2 = "";
						echo $correo3 = "";
						echo $correo4 = "";
						enviomensaje($nombre,$ccnombre,$correo1,$correo2,$correo3,$correo4);
						break;
						}
						case '60':
						{			
						echo "ingreso x pegomax";
						echo $correo1 = "contratacion@ceramigres.com";
						echo $correo2 = "compras@pegoperfecto.com";
						echo $correo3 = "";
						echo $correo4 = "";
						enviomensaje($nombre,$ccnombre,$correo1,$correo2,$correo3,$correo4);
						break;

						}
						case '20':
						{			
						echo "ingreso x tu cassa";
						echo $correo1 = "contratacion@ceramigres.com";
						echo $correo2 = "";
						echo $correo3 = "";
						echo $correo4 = "";
						enviomensaje($nombre,$ccnombre,$correo1,$correo2,$correo3,$correo4);
						break;
						}
						default;
						{
						echo $codcc = substr($row_n ['CODCC'], 3, -7);
							if ($row_n['CARGO']=='101') 
								{
								echo $correo3 = "goperacionesza@ceramigres.com";
								}
					
						echo $sql1="SELECT email emailpunto FROM email_permisos where cc like '%$codcc%'";
							$qry_sql1=$link->query($sql1);
							$rs_qry1=$qry_sql1->fetch_object();  ///consultar 
							$correo2 =$rs_qry1->emailpunto;	 
							
							if (empty($correo2)) 
								{
								$correo2 = "liroal@hotmail.com";
								
								}
						echo $correo1 = "personal@ceramigres.com";
						echo $correo4 = "bienestar@ceramigres.com";
						
								 
						enviomensaje($nombre,$ccnombre,$correo1,$correo2,$correo3,$correo4);
						
						}		
					  }
		}
		//}
		//while ($row_n = $stmt->fetch());
		
		
		//exit();		
			
		// SON TEMPORALES ENVIA CADA 3 MESES

		if ($empresa == '70')
		{
	//	do{ echo "ingreso como 70";
			 
			echo $codcc = substr($row_n ['CODCC'], 3, -7);
			
			if ($row_n['CARGO']=='101') 
				{
				echo $correo3 = "goperacionesza@ceramigres.com";
				}
				
		echo $sql1="SELECT email emailpunto FROM email_permisos where cc like '%$codcc%'";
			$qry_sql1=$link->query($sql1);
			$rs_qry1=$qry_sql1->fetch_object();  ///consultar 
			$correo2 =$rs_qry1->emailpunto;	 
			 if (empty($correo2)) 
				{
				$correo2 = "liroal@hotmail.com";
				
				}
			echo $correo1 = "personal@ceramigres.com";
			echo $correo4 = "bienestar@ceramigres.com"; 
			enviomensaje($nombre,$ccnombre,$correo1,$correo2,$correo3,$correo4); 
	/*	//envio correo
		
		require_once('../PAZYSALVO/PHPMailer-master/class.phpmailer.php'); 
		require_once('../PAZYSALVO/PHPMailer-master/class.smtp.php');
		require_once('../PAZYSALVO/PHPMailer-master/PHPMailerAutoload.php');
		$cuerpo='
		<br>
		<br>
		Se le informa que el empleado(a)  ';
		

		$cuerpo2='   esta en tiempo de realizar la evaluacion de desempeno<br><br>
		Ingrese al link https://drive.google.com/drive/folders/0B59RiutlMX4-ZnhNWmxjeW8yV1E para descargar el formato segun el cargo, diligencielo y envielo antes de 2 dias al correo personal@ceramigres.com<br>';
	
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
			$mail->Subject = "Evaluacion de desempeño";
			$mail->AltBody ="AUTORIZACION DE PERMISOS - Maxicassa S.A.S";//Messatge d'advertencia pels usuaris que no utilitzan un client HTML.
		 
			// Construccio del Body i assignacio a variable (body).
			/////$body=$cuerpo, $row_n['NOMBRE'] ;//Plantilla HTML creat. Document root+ruta "absoluta".
			$body= $cuerpo.$row_n['NOMBRE'].$cuerpo2.$row_n['CCNOMBRE'] ;//Plantilla HTML creat. Document root+ruta "absoluta".
		
			//Utilitzacio de la funcio MsgHTML i utilitzacio de la variable body creada avanÃ§s per compondre el cos del missatge.
			$mail->MsgHTML($body);
			//S'indica adressa electronica on s'envia el mail i el nom.
			$mail->AddAddress('personal@ceramigres.com','correo');
			$mail->AddAddress($correo2,'correo2');
			$mail->AddAddress($correo3,'correo3');
			$mail->Send();*/

        echo "paso el a otro";
				
		//}
		//while ($row_n = $stmt->fetch());
		//exit();
		}
		}
		while ($row_n = $stmt->fetch());
		
?>	
