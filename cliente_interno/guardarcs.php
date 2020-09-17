<?php
	require_once('../conexionesDB/conexion.php');
	require "../vendor/autoload.php";

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
	$link = Conectarse_personal();

	$sala=$_POST['sala'];
	$concepto_det = $_POST['concepto_det'];
	$calificacion = $_POST['nota'];
	$hallazgo = $_POST['hallazgo'];
	$tarea = $_POST['tarea'];
	$responsable = $_POST['responsable'];
	$fcontrol = $_POST['fcontrol'];
	$autor = $_POST['evaluador'];
	$f_visita = $_POST['fecha_visita'];
	$hoy = date("d/m/y");
	$fecha = new DateTime('NOW');
	$fechaActual = $fecha->format('Y-m-d');

	$sql="INSERT INTO personal.concepto_sala ( cc, fecha, concepto_esp, calificacion, hallazgo, tarea, responsable, fecha_control, autor, estado) VALUES ('$sala', '$f_visita', '$concepto_det', '$calificacion', '$hallazgo', '$tarea', '$responsable', '$fcontrol', '$autor', 'PENDIENTE');";
	$qry_sql=$link->query($sql);

	//consulta de email de sala
	$sqla="SELECT email, nombre FROM email_permisos where cc = '10-$sala'";
	$qry_sqla=$link->query($sqla);
	$rs_qrya=$qry_sqla->fetch_object();  ///consultar

	$rs_qrya->email;
if(true)
{
	$mailer = new PHPMailer(true);

  try {
    $cuerpo='<center style="color:#002F87;">Se ha realizado una solicitud a su área.<br></center>';
		$sdlinea='<br>';
	  $impfecha='<br><b>FECHA: </b> ';
		$impsala='<br><b>SALA: </b>';
		$impconcepto='<br><b>SOLICITUD: </b>';
		$impautor='<br><b>AUTOR: </b>';
		$espacio=' : ';

		$body= $cuerpo.$impfecha.$fechaActual.$impsala.$rs_qrya->nombre.$impconcepto.$concepto_det.$espacio.$tarea.$impautor.$autor;

    $mailer->isSMTP();

    $mailer->SMTPOptions = [
      'ssl'=> [
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
      ]
    ];

    $mailer->Host = 'smtp.gmail.com';
    $mailer->SMTPAuth = true;
    $mailer->Username = 'ares@ceramigres.com';
    $mailer->Password = 'M41l3rD43m0n+';
    $mailer->SMTPSecure = 'tls';
    $mailer->Port = 587;

    $mailer->CharSet = 'UTF-8';
    $mailer->setFrom('ares@ceramigres.com', 'Plataforma del Grupo Empresarial Maxicassa');
    /*if ($es_pegomax == "1") {
      $mailer->addAddress('pazysalvo@pegoperfecto.com', 'PEGOMAX');
    }*/
    $mailer->addAddress($responsable);

    $mailer->isHTML(true);
    $mailer->Subject = 'Concepto de visita a sala -  Auditoria Operacional';
    $mailer->Body = $body;

    $mailer->send();
    $mailer->ClearAllRecipients();
    echo "Mensaje enviado";

  } catch (Exception $e) {
    echo "Falla en el envío del mensaje. INFO: " . $mailer->ErrorInfo;
  }

	header("Location: informe_sala.php?sala=$sala");
}

?>
