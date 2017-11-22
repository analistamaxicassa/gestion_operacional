<link rel="stylesheet" type="text/css" href="../estilos.css"/>
<?php
//error_reporting(0);

//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

//recojo variables
$cedula=$_POST['cedula'];
$codausentismo=$_POST['codausentismo'];
$numero_inc=$_POST['numero_inc'];
$f_inicial=$_POST['f_inicial'];
$f_final=$_POST['f_final'];
$ndias=$_POST['ndias'];
$motivo=$_POST['motivo'];
$entidad=$_POST['entidad'];
$observacion=$_POST['observacion'];



/*//conexion QUERYS
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}*/


//$ced=$_POST['ced']; 

			$sql="INSERT INTO `personal`.`incapacidades` (`cedula`, `tipo_incapacidad`, `numero_incapacidad`, `finicial`, `ffinal`, `ndias`, `diagnostico`, `entidad`, `adjunto`, `observacion`) VALUES ('$cedula', '$codausentismo', '$numero_inc', '$f_inicial',  '$f_final', '$ndias', '$motivo','$entidad', '', '$observacion')";
		$qry_sql=$link->query($sql);
		
		echo  "<font color='blue'; font-size:35px;>EL REPORTE SE HA REALIZADO A GESTION HUMANA, agregue los documentos de </font>";
		
		
		//envio correo
		
		require_once('../PAZYSALVO/PHPMailer-master/class.phpmailer.php'); 
		require_once('../PAZYSALVO/PHPMailer-master/class.smtp.php');
		require_once('../PAZYSALVO/PHPMailer-master/PHPMailerAutoload.php');
		$cuerpo='
		<center>
		Se le informa que se ha realizado un reporte de Incapacidad, por favor verifique en los datos del reporte vs el documento fisico. 
		por favor dirijase a la plataforma de ares http://10.1.0.22/ares o  http://190.144.42.83/ares/		        <br>	
		GRACIAS<br>
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
			$mail->SetFrom('plataforma_ares@hotmail.com', 'REPORTE DE INCAPACIDADES');	
			$mail->Subject ="Ares";
			$mail->AltBody ="REPORTE DE INCAPACIDADES - Maxicassa S.A.S";//Messatge d'advertencia pels usuaris que no utilitzan un client HTML.
		 
			// Construccio del Body i assignacio a variable (body).
			/////$body=$cuerpo, $row_n['NOMBRE'] ;//Plantilla HTML creat. Document root+ruta "absoluta".
			$body= $cuerpo ;//Plantilla HTML creat. Document root+ruta "absoluta".
		
			//Utilitzacio de la funcio MsgHTML i utilitzacio de la variable body creada avanÃ§s per compondre el cos del missatge.
			$mail->MsgHTML($body);
			//S'indica adressa electronica on s'envia el mail i el nom.
			$mail->AddAddress('lrodriguez@ceramigres.com','correo');
			$mail->Send();

        
	exit();
	
//guardar archivo 
//echo "estoy guardando archivo";
//include "../PAZYSALVO/conexion_ares.php";
//$link=Conectarse();

@$archivo=$_FILE['archivo'];
@$titulo=$_POST['titulo'];
//datos del arhivo   
$uploaddir = 'archivoinc/';
 $uploadfile = $uploaddir . basename($_FILES['archivo']['name']);
//exit();
if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
	@$sql="UPDATE `personal`.`incapacidades` SET `adjunto` = '$uploadfile' WHERE `incapacidades`.`cedula` = $cedula";
	$guardar=$link->query($sql);
?>
  <script language="Javascript"> 
	alert(" archivo guardado correctamente!!!") ;
	window.location.href = "http://http://190.144.42.83/ares/index.php";
	
	</script>

<?php
}
      //echo "termine de guardae el archivo";
?>
<?php

//fin de huardar archivo


?>	
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
.centrar {
	text-align: center;
}
.centrar {
	text-align: center;
}
</style>
	
</head>
<body>
<blockquote>

  <table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>
         <td width="16%" height="46" class="encabezados" align="center"><img src="../gh/img/logo-gh.png" width="257" height="108"></td>
    <td width="100" align="center" class="encabezados">SOLICITUDES DE GESTION HUMANA</td>
         <td width="25%" align="right"><img src="../gh/img/maxicassa.png" width="268" height="98" class="formulario"></td>
       </tr>
       </table>

  <table width="884" border="1" align="center" class="formulario" >
    <tr>
      <td height="30" colspan="2" align="center" class="encabezados" ><span class="encabezados">AUTORIZACION DE INCAPACIDADES</span></td>
    </tr>
    <tr>
      <td height="30" bgcolor="#CCCCCC" class="header" ><p>ENFERMEDAD GENERAL - ACCIDENTE DE TRABAJO - ACCIDENTE DE TRANSITO: </p>
        <p>Incapacidad - Historia clinica (aunque sea de 1 dia)</p></td>
      <td height="30" bgcolor="#CCCCCC" class="header"><p>LICENCIA DE MATERNIDAD: </p>
        <p>Incapacidad - Historia clinica - Registro de nacimiento - Copia de la cedula de la Mamá</p></td>
    </tr>
  </table>
</blockquote>
<table width="884" border="1" align="center" class="formulario" style="border-collapse: collapse; font-size: 12px; text-align: center;">
  <tr>
    <td span class="encabezados">ADJUNTE LA DOCUMENTACION SEGUN EL CASO</td>
  </tr>
  <tr>
    <td height="22" colspan="3" bgcolor="#CCCCCC" class="header"><p><b>El nombre del archivo debe ser asignado asi: (Cedula)-(nombre del  Documento) </b></p>
      <p><b>EJ: 79852258-incapacidad</b> -<b> 79852258-historiaclinica</b></p>
      Seleccione el archivo:
      <input name="archivo2" type="file" class="botones" id="archivo2" />
      <input type="submit" class="botones" value="Guardar" />
      <br />
      <br /></td>
  </tr>
</table>
</body>
</html>
