
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script>
	 
	 function paraimpimir(cedulae)
        {	//alert(cedulae);
				var parametros = {
				"cedulae": cedulae,				
				};
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/formato_desempeno/imprimir_evaluacion.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta").html(response);
						 {
						
					     document.getElementById('imprimir').disabled=true;
		                $("#validador").html(response);

                    }
						
                    }
        
        });
        }


</script>


<?php
error_reporting(0);

//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		} 
		
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

session_start();


$hoy = date('Y-m-d') ;
$cedulae=$_POST['cedulae'];
$cedulaent=$_POST['cedulaent'];
$nombre=$_POST['nombre'];
$cargo=$_POST['cargo'];
$nombrecc=$_POST['nombrecc'];
$codcargo=$_POST['codcargo'];
$nombreent=$_POST['nombreent'];
$sociedad=$_POST['sociedad'];
$periodo=$_POST['periodo'];
$fevaluacion=$_POST['fevaluacion'];
$operacion1 = $_POST['operacion1'];
$valoracion1 = $_POST['valoracion1'];
$resaltar1 = $_POST['resaltar'];
$mejorar1 = $_POST['mejorar'];
$mejoras = $_POST['mejoras'];
$fseguimiento = $_POST['fseguimiento'];
$obs_evaluado = $_POST['obs_evaluado'];
$contrata_empresa = $_POST['contrata_empresa'];
$condiciones = $_POST['condiciones'];


//evalua si ya existe un reporte de dia actual
 $sqlrv = "SELECT id  FROM `form_desempeno` WHERE `fecha_evaluacion` = '$hoy' and `ced_evaluado` = '$cedulae'" ;
			$qry_sqlrv=$link->query($sqlrv);
			$rs_qryrv=$qry_sqlrv->fetch_object();  ///consultar 	

if($rs_qryrv->id)
{
	echo "LA EVALUACION DEL EMPLEADO YA FUE GENERADA";
	exit();
	echo '<a href="http://190.144.42.83/ares/index.php">Vover</a>'; 

}



 //echo "desde aqui";
 
// $sql2="SELECT count(id) total FROM `ed_aspectos` WHERE cargo = '$codcargo' "; 
 $sql2="select count(id) total FROM `form_aspectos`";
 		
			$qry_sql2=$link->query($sql2);
			$rs2=$qry_sql2->fetch_object();
 
		 $ktotal = $rs2->total; 
			  "<br>";

// muestra los id de las operaciones dependiendo del cargo y rol definido 

	$sql2a="select id FROM `form_aspectos` WHERE cargo in ('$codcargo','999')";
 		
			$qry_sql2a=$link->query($sql2a);
			$rs2a=$qry_sql2a->fetch_object();
			
			
 	do
	{
	$k = $rs2a->id;	

	
	 $operacionf= $_POST["operacion".$k];
	 $valoracionf = $_POST["valoracion".$k];
	 $resaltarf = $_POST["resaltar".$k];
	 $mejorarf = $_POST["mejorar".$k];
	// echo "<br>";
	// echo $k;
	// echo "<br>";
	 	 
 $sql4="SELECT aspecto FROM `form_aspectos` WHERE id = '$k'"; 		
			$qry_sql4=$link->query($sql4);
			$rs4=$qry_sql4->fetch_object();
		// echo "<br>";	
 $rs4->aspecto;
 	  $aspectoselec = $rs4->aspecto;
   $rs4->aspecto;
   
   //inserta registros de calificaciones x operacion en tabla eval desempeño detallada
	 
  $sql3="INSERT INTO `personal`.`form_desem_detallado` (`id`, `cedula`, `fecha`, `aspecto`, `operacion`, `valoracion`, `resaltarop`, `mejorarop`) VALUES (NULL, '$cedulae', '$hoy', '$aspectoselec', '$operacionf', '$valoracionf', '$resaltarf', '$mejorarf');"; 
		$qry_sql3=$link->query($sql3);
	// echo "<br>siguiente<br>";
		
		}
		while($rs2a=$qry_sql2a->fetch_object());



   //inserta registros general en tabla eval desempeño
	 
 $sql5="INSERT INTO `personal`.`form_desempeno` (`id`, `ced_evaluado`, `ced_evaluador`, `fecha_evaluacion`, `periodo`, `empresa`, `cc`,  `cargo`, `mejoras`, `fseguimiento`, `obs_evaluador`,  `concepto_gh`, `concepto_auditoria`, `Contrataxempresa`, `condiciones`, `capacitacion`) VALUES (NULL, '$cedulae', '$cedulaent', '$hoy', '$periodo', '$sociedad', '$nombrecc', '$cargo',  '$mejoras', '$fseguimiento', '$obs_evaluado', '$concepto_gh', '$concepto_auditoria', '$contrata_empresa', '$condiciones', '$capacitacion');"; 
		$qry_sql5=$link->query($sql5);
		

			
$query1 = "SELECT EMP_EMAIL FROM EMPLEADO E
WHERE  E.EMP_CODIGO = (SELECT EMP_JEFE_CODIGO FROM EMPLEADO EMP
WHERE  EMP.EMP_CODIGO = '$cedulaent')";

		$stmt1 = $dbh->prepare($query1);
		$stmt1->execute();
		$row1 = $stmt1->fetch();	
		$correo2=$row1['EMP_EMAIL'];


		//ENVIO DE CORREO
		
		require_once('../PAZYSALVO/PHPMailer-master/class.phpmailer.php'); 
		require_once('../PAZYSALVO/PHPMailer-master/class.smtp.php');
		require_once('../PAZYSALVO/PHPMailer-master/PHPMailerAutoload.php');
		$cuerpo='
		<br>
		<br>
		Se le informa que al empleado(a)  ';
		

		$cuerpo2=  '   Se le realizo evaluacion de desempeño y es necesario su concepto para continuar el proceso <br><br>
		Ingrese a la plataforma de ares.ceramigres.com para ingresar su concepto <br> ';
	
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
			$mail->SetFrom('plataforma_ares@hotmail.com', 'EVALUACION DE DESEMPEÑO');	
			$mail->Subject = "Evaluacion de desempeño";
			$mail->AltBody ="EVALUACION DE DESEMPEÑO - Maxicassa S.A.S";//Messatge d'advertencia pels usuaris que no utilitzan un client HTML.
		 
			// Construccio del Body i assignacio a variable (body).
			/////$body=$cuerpo, $row_n['NOMBRE'] ;//Plantilla HTML creat. Document root+ruta "absoluta".
			$body= $cuerpo.$nombre.$cuerpo2.$nombrecc ;//Plantilla HTML creat. Document root+ruta "absoluta".
		
			//Utilitzacio de la funcio MsgHTML i utilitzacio de la variable body creada avanÃ§s per compondre el cos del missatge.
			$mail->MsgHTML($body);
			//S'indica adressa electronica on s'envia el mail i el nom.
			$mail->AddAddress('fleon@ceramigres.com','correo');
			$mail->AddAddress('lrodriguez@ceramigres.com','correo1');
			$mail->AddAddress('auditoria@ceramigres.com','correo2');
			//$mail->AddAddress($correo2,'correo3');
			//$mail->Send();


?>

<h3 align="center">Muchas gracias, </h3>
<h3 align="center">La evaluación ha sido guardada
</h3>
<h3>&nbsp;</h3>
<p align="center">
  <input type="button" name="imprimir" id="imprimir" value="Ver resultados" onclick="paraimpimir('<?php echo $cedulae; ?>')">
</p>
<div id="validador"></div>
