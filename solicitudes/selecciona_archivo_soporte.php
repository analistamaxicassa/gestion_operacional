<link rel="stylesheet" type="text/css" href="../estilos.css"/>

<?php



error_reporting(0);
//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

//recojo variables
$id=$_POST['id'];
$cedula=$_POST['cedula'];
$codausentismo=$_POST['codausentismo'];
$numero_inc=$_POST['numero_inc'];
$f_inicial=$_POST['f_inicial'];
$f_final=$_POST['f_final'];
$ndias=$_POST['ndias'];
$motivo=$_POST['motivo'];
$entidad=$_POST['entidad'];
$observacion=$_POST['observacion'];
$referencia=$_POST['referencia'];
$correo=$_POST['correo'];



//conexion
try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		
	 $query = "SELECT SO.NOMBRE_SOCIEDAD SOCIEDAD,  EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , CA.CARGO_NOMBRE,  CC.CENCOS_NOMBRE CC 
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
		$cargo=utf8_encode($row_n['CARGO_NOMBRE']);


//$ced=$_POST['ced']; 

if ($id == 'NO')
	{
	$sql="INSERT INTO `personal`.`incapacidades` (`cedula`, `tipo_incapacidad`, `numero_incapacidad`, `finicial`, `ffinal`, `ndias`, `diagnostico`, `entidad`, `adjunto`, `observacion`, `referencia` ) VALUES ('$cedula', '$codausentismo', '$numero_inc', '$f_inicial',  '$f_final', '$ndias', '$motivo','$entidad', '', '$observacion', '$referencia')";
		$qry_sql=$link->query($sql);
		
		
	}
	
else {
	$sq2="UPDATE `personal`.`incapacidades` SET `tipo_incapacidad` = '$codausentismo', `numero_incapacidad` = '$numero_inc', `finicial` = '$f_inicial', `ffinal` = '$f_final', `ndias` = '$ndias', `diagnostico` = '$motivo', `entidad` = '$entidad', `observacion` = '$observacion' WHERE `incapacidades`.`id` = '$id'";
		$qry_sql2=$link->query($sq2);
	
	
	
	}
	echo  "<font color='blue'; font-size:35px;><br><br><br>EL REPORTE SE HA REALIZADO A GESTION HUMANA, POR FAVOR ADJUNTE LA DOCUMENTACION REQUERIDA PARA VALIDAR LA INCAPACIDAD</font>";	
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
		
		$sdlinea='<br>';
	    $iempleado='<br><b>EMPLEADO:</b> ';
   	    $isala='<br><b>UBICACION:</b> ';
		$icargo='<br><b>CARGO: </b>';
		$imotivo='<br><b>MOTIVO: </b>';
		$ifinicial='<br><b>FECHA INICIAL: </b>';
		$idias='<br><b>DIAS: </b>';
	
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
		
			$body= $cuerpo.$iempleado.$nombre.$isala.$cc.$icargo.$cargo.$sdlinea.$empresa.$ifinicial.$f_inicial.$idias.$ndias;//Plantilla HTML creat. Document root+ruta "absoluta".
			//Utilitzacio de la funcio MsgHTML i utilitzacio de la variable body creada avanÃ§s per compondre el cos del missatge.
			$mail->MsgHTML($body);
			//S'indica adressa electronica on s'envia el mail i el nom.
			$mail->AddAddress('personal@ceramigres.com','correo');
			$mail->AddAddress('auxpersonal@ceramigres.com','correo');
			$mail->AddAddress($correo,'correo');
			$mail->Send();

        
	//exit();
	
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
         <td width="25%" align="right"><img src="../gh/img/maxicassa.png" width="316" height="98" class="formulario"></td>
       </tr>
       
</table>
  <br>
    <br>
  <table width="961" border="1" align="left" >
    <tr align="center" class="encabezados">
      <td width="225" height="30"><i>ENFERMEDAD GENERAL - ACCIDENTE DE TRABAJO </td>
      <td width="250" height="30">ACCIDENTE DE TRANSITO: </td>
      <td width="239" ><i>LICENCIA DE MATERNIDAD: </td>
      <td width="219" >LICENCIA DE PATERNIDAD: </td>
    </tr>
    <tr align="center">
      <td height="30" align="left"><ol>
        <li>
          <h5 class="formulario">Incapacidad</h5>
        </li>
        <li>
          <h5 class="formulario">Epicrisis (Historia Clinica de la incapacidad)</h5>
        </li>
      </ol>      <p align="center">&nbsp;</p></td>
      <td height="30"  align="left"><div>
        <ol>
          <li>
            <h5 class="formulario">Incapacidad</h5>
          </li>
          <li>
            <h5 class="formulario">Epicrisis (Historia Clinica de la incapacidad)</h5>
          </li>
          <li>
            <h5 class="formulario">Informe de transito</h5>
          </li>
          <li>
            <h5 class="formulario">Copia del SOAT</h5>
          </li>
        </ol>
      </div></td>
      <td  align="left"><ol>
        <li>
          <h5 class="formulario">Incapacidad</h5>
        </li>
        <li>
          <h5 class="formulario">Epicrisis (Historia Clinica de la incapacidad)</h5>
        </li>
        <li>
          <h5 class="formulario">Registro civil</h5>
        </li>
        <li>
          <h5 class="formulario">Fotocopia de la cédula de la madre</h5>
        </li>
      </ol>      </td>
      <td  align="left"><ol>
        <li>
          <h5 class="formulario">Incapacidad </h5>
        </li>
        <li>
          <h5 class="formulario">Epicrisis (Historia clínica incacidad de la madre)</h5>
        </li>
        <li>
          <h5 class="formulario">Registro civil </h5>
        </li>
        <li>
          <h5 class="formulario">Fotocopia Cédula  del padre y de la madre</h5>
        </li>
      </ol>      </td>
    </tr>
    <tr align="center">
      <td height="30" colspan="4">&nbsp;</td>
    </tr>

  <tr class="formulario">
    <td height="22" colspan="4" class="encabezados"><b>ADJUNTE LA DOCUMENTACION SEGUN EL CASO</b></td>
  </tr>
  <tr class="formulario">
    <td height="22" colspan="4"><p><b>El nombre del archivo debe ser asignado asi: (No. Cedula)-(Nombre del Documento) </b></p>
      <p><b>EJ: 79852258-Incapacidad</b></p>
        
      <form action="guardar_archivoinc.php" method="post" enctype="multipart/form-data">
Seleccione el archivo:
  <input name="archivo" type="file" class="textbox" id="archivo" />
  <input type="submit" class="botones" value="Guardar" />
  <br>
<br>
     </form>
   
      <br />
      <br /></td>
  </tr>
</table>
</body>
</html>
