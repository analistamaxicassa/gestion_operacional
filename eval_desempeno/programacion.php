<?php 

//error_reporting(0);


$cargo=$_REQUEST['cargo'];
//$cargo = '101';
$cedulaevalua=$_REQUEST['cedulaevalua'];
$f_limite=$_REQUEST['f_seguimiento'];
$email=$_REQUEST['correo'];


//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

	//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		
 $query1 = "select EMP_CODIGO, E.EMP_NOMBRE||' '||E.EMP_APELLIDO1||' '||e.EMP_APELLIDO2 NOMBRE from empleado E where e.emp_cargo = '$cargo' and e.emp_estado <> 'R' order by E.EMP_CC_CONTABLE ";

		$stmt1 = $dbh->prepare($query1);
		$stmt1->execute();
		$row1 = $stmt1->fetch();	
		
//		 $row1['NOMBRE']?>;

		




<!doctype html>
<html lang="en">
<head>


<style type='text/css'>
tr:nth-child(odd) {
    background-color:#f2f2f2;
}
tr:nth-child(even) {
	background-color: #fbfbfb;
	
	
}

</style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Entrevista de Retiro</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="../estilos.css">
 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
</head>
<body>
<p>
<div align="center"></div>


	

  <form method="post" action=  "http://190.144.42.83:9090/plantillas/eval_desempeno/guardar_programacion.php"
    enctype="multipart/form-data"  id="formulario">
  <table width="501" border="1" align="center">
            <tr>
              <td align="center"><label>
                <input name="evaluador" type="text" style="visibility:hidden" id="evaluador" value="<?php  echo $cedulaevalua; ?>" readonly >
              </label></td>
              <td align="center"><label>
                <input type="text" name="correo" id="correo">
                <input name="fecha_limite" type="text" style="visibility:hidden" id="fecha_limite" value="<?php  echo $f_limite;?>" readonly >
              </label></td>
            </tr>
            <tr>
              <td colspan="2" align="center">NOMBRES</td>
            </tr>
            <tr>
              <td colspan="2">
         <br>
        <?php 
         do  
		    {?>
                 <input style="font-size:6px" type="checkbox" name="colores[<?php  echo $row1['EMP_CODIGO'];?>]" value="<?php  echo $row1['EMP_CODIGO']."-".$row1['NOMBRE'];?>" /><?php  echo $row1['NOMBRE'];?> 
       <br>
       <?PHP
       }   while ($row1 = $stmt1->fetch())
  		?>
        <input type="submit" value="Programar" name="btn_colores" />
    </td>
            </tr>
          </table>
  </p>
  </p>
  
  
</form>
 <?PHP
//envio correo
		
		require_once('../PAZYSALVO/PHPMailer-master/class.phpmailer.php'); 
		require_once('../PAZYSALVO/PHPMailer-master/class.smtp.php');
		require_once('../PAZYSALVO/PHPMailer-master/PHPMailerAutoload.php');
		$cuerpo='
		<br>
		<br>
		Se ha realizado una programacion de Evaluaciones de Desempeño a su nombre. <br>
		Por favor ingrese a la plataforma ares.ceramigres.com ';	

	
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
			$mail->SetFrom('plataforma_ares@hotmail.com', 'PROGRAMACION DE EVALUACIONES DE DESEMPEÑO');	
			$mail->Subject = "Programacion de Evaluaciones de desempeno";
			$mail->AltBody ="PROGRAMACION DE EVALUACIONES DE DESEMPEÑO";//Messatge d'advertencia pels usuaris que no utilitzan un client HTML.
		 
			// Construccio del Body i assignacio a variable (body).
			/////$body=$cuerpo, $row_n['NOMBRE'] ;//Plantilla HTML creat. Document root+ruta "absoluta".
			$body= $cuerpo;//Plantilla HTML creat. Document root+ruta "absoluta".
		
			//Utilitzacio de la funcio MsgHTML i utilitzacio de la variable body creada avanÃ§s per compondre el cos del missatge.
			$mail->MsgHTML($body);
			//S'indica adressa electronica on s'envia el mail i el nom.
			//$mail->AddAddress('liroal@hotmail.com','correo');
			//$mail->AddAddress('contratacion@ceramigres.com');
			$mail->AddAddress($email);
			$mail->Send();

       // echo "ok enviado".$correo2;

?>	



 <p>


