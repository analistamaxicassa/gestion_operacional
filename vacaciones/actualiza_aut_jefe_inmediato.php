<?php



//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

//recojo variables
$id=$_POST['id'];
$email_personal=$_POST['ema'];
$jefe=$_POST['jefe'];
$correo2=$_POST['correo2'];
$reemplazajp=$_POST['reemplazajp'];
$empalmejp=$_POST['empalmejp'];


//conexion sql	
			$sql="SELECT  `ID`,`CEDULA`,`JEFE`,`PERIODO`,`DIAS`,`SALIDA`,`ENTRADA`,`REEMPLAZO`,`F_EMPALME`,`EMAIL_PERSONAL` FROM `VACACIONES`
WHERE ID = '$id'";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 

			if (empty($rs_qry)) {
   						 echo 'No existen registros por autorizar';
							//$datelimite = 0;
							exit;
								}

		do{
	$id = 	$rs_qry->ID;
	$cedula = $rs_qry->CEDULA;
	$periodo  = $rs_qry->PERIODO;
	$dias = $rs_qry->DIAS;
	$salida = $rs_qry->SALIDA;
	$entrada = $rs_qry->ENTRADA;
	$reemplazo = $rs_qry->REEMPLAZO;
	$f_empalme = $rs_qry->F_EMPALME;
	$email_personal = $rs_qry->EMAIL_PERSONAL;
	
	 }
		while($rs_qry=$qry_sql->fetch_object());
		
		//conexion queryx
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		
		$query1 = "SELECT SO.NOMBRE_SOCIEDAD SOCIEDAD,  EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , CA.CARGO_NOMBRE,  CC.CENCOS_NOMBRE CC, CC.CENCOS_TIPO_CODIGO
        FROM EMPLEADO EM, CARGO CA,  sociedad SO, CENTRO_COSTO CC
        WHERE EM.EMP_CARGO = CA.CARGO_CODIGO  AND EM.EMP_CC_CONTABLE = CC.CENCOS_CODIGO
        AND EM.EMP_SOCIEDAD = SO.COD_SOCIEDAD
        AND EM.EMP_CODIGO = '$cedula'";
		$stmt1 = $dbh->prepare($query1);
		$stmt1->execute();
		$row_n1 = $stmt1->fetch();
		
		$nombre = $row_n1['NOMBRE']; 
		$empresa = $row_n1 ['SOCIEDAD'];
		$cc = $row_n1 ['CC'];
		$cargo1=utf8_encode($row_n1['CARGO_NOMBRE']);
		
		$query2 = "SELECT EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , CA.CARGO_NOMBRE  FROM EMPLEADO EM, CARGO CA
        WHERE EM.EMP_CARGO = CA.CARGO_CODIGO 
        AND EM.EMP_CODIGO = '$jefe'";
		$stmt2 = $dbh->prepare($query2);
		$stmt2->execute();
		$row_n2 = $stmt2->fetch();
		
		$nombrejefe = $row_n2['NOMBRE']; 
		$cargojefe=utf8_encode($row_n2['CARGO_NOMBRE']);
	
		$sql="UPDATE `vacaciones` SET `aut_jefe`='1', reemplazo = '$reemplazajp', f_empalme = '$empalmejp' WHERE `id` = '$id' ";
		$qry_sql=$link->query($sql);
		
		
		?>
		
		 <input type="image" name="sello_aprobado" id="sello_aprobado" src="aprobado con msj.jpg" />
              		
<?php
		echo  "<br>Autoriza:".$row_n2['NOMBRE'].'<br>';
		echo  "Cargo:".utf8_encode($row_n2['CARGO_NOMBRE']).'<br>'.'<br>';
			
		
		//envio correo
		
		require_once('../PAZYSALVO/PHPMailer-master/class.phpmailer.php'); 
		require_once('../PAZYSALVO/PHPMailer-master/class.smtp.php');
		require_once('../PAZYSALVO/PHPMailer-master/PHPMailerAutoload.php');
		$precuerpo = 'Sr(a)'.$nombre.'<br>';
		$cuerpo='
		<center>
		Se informa que sus vacaciones han sido aprobadas segun su solicitud<br><br>
		
		No olvide enviar al departamento de Gestion Humana la carta de autorizacion firmada para terminar el tramite de autorizacion.
		
		
		</center>';
		
		
		$cuerpo2='Salida a vacaciones:  '.$salida.'<br> Ultimo dia de vacaciones:  '.$entrada.'<br>Periodo.  '.$periodo.'<br> Empresa:  '.$empresa.'<br> Centro de costos:  '.$cc.'<br> Cargo:  '.$cargo1.'<br>Con copia a:' ;
	
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
			$mail->Subject ="RESPUESTA DE SOLICITUD DE VACACIONES";
			$mail->AltBody ="AUTORIZACION DE VACACIONES - Maxicassa S.A.S";//Messatge d'advertencia pels usuaris que no utilitzan un client HTML.
		 
			// Construccio del Body i assignacio a variable (body).
			/////$body=$cuerpo, $row_n['NOMBRE'] ;//Plantilla HTML creat. Document root+ruta "absoluta".
			$body= $precuerpo.$cuerpo.$cuerpo2.$correo2 ;//Plantilla HTML creat. Document root+ruta "absoluta".
		
			//Utilitzacio de la funcio MsgHTML i utilitzacio de la variable body creada avanÃ§s per compondre el cos del missatge.
			$mail->MsgHTML($body);
			//S'indica adressa electronica on s'envia el mail i el nom.
			$mail->AddAddress($email_personal,'correo');
			$mail->AddBCC($correo2,'correo2');
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
<title>Documento sin título</title>
</head>
<body>

</body>
</html>
