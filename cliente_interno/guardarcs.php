<?php
	require_once('../conexionesDB/conexion.php');

	$link=Conectarse_personal();
	//echo $link->character_set_name();
	//recojo variables
	$sala=$_POST['sala'];
	$concepto_det= $_POST['concepto_det'];
	$calificacion= $_POST['nota'];
	$hallazgo= $_POST['hallazgo'];
	$tarea= $_POST['tarea'];
	$responsable= $_POST['responsable'];
	$fcontrol=$_POST['fcontrol'];
	$autor= $_POST['evaluador'];
	$f_visita= $_POST['fecha_visita'];
	$hoy=date("d/m/y");
	$fecha = new DateTime('NOW');
	$fechaActual = $fecha->format('Y-m-d');

	$sql="INSERT INTO personal.concepto_sala ( cc, fecha, concepto_esp, calificacion, hallazgo, tarea, responsable, fecha_control, autor, estado) VALUES ('$sala', '$f_visita', '$concepto_det', '$calificacion', '$hallazgo', '$tarea', '$responsable', '$fcontrol', '$autor', 'PENDIENTE');";
	//echo "<br>".$sql;
	$qry_sql=$link->query($sql);

	//consulta de email de sala
	$sqla="SELECT email, nombre FROM email_permisos where cc = '10-$sala'";
	$qry_sqla=$link->query($sqla);
	$rs_qrya=$qry_sqla->fetch_object();  ///consultar

	$rs_qrya->email;
if(true)
{
	require_once '../vendor/autoload.php';

	// Create the Transport
	$transport = (new Swift_SmtpTransport('aspmx.l.google.com', 25))
	->setUsername('ares@ceramigres.com')
	->setPassword('T3mp0r4l123')
	;

	// Create the Mailer using your created Transport
	$mailer = new Swift_Mailer($transport);

	$asunto = "Concepto de visita a sala -  Auditoria Operacional";

	$cuerpo='
	<center>
	Se ha realizado una solicitud a su area. <br>
	</center>';

	$sdlinea='<br>';
  $impfecha='<br><b>FECHA:</b> ';
	$impsala='<br><b>SALA: </b>';
	$impconcepto='<br><b>SOLICITUD: </b>';
	$impautor='<br><b>AUTOR: </b>';
	$espacio=' : ';

	$body= $cuerpo.$impfecha.$fechaActual.$impsala.$rs_qrya->nombre.$impconcepto.$concepto_det.$espacio.$tarea.$impautor.$autor;

	// Create a message
	$message = (new Swift_Message($asunto))
	->setFrom(['ares@ceramigres.com' => 'Plataforma del Grupo Empresarial Maxicassa'])
	->setTo([$responsable => 'Sala'])
	->setBody($body, 'text/html')
	;

	// Send the message
	$result = $mailer->send($message);
	header("Location: selecciona_sala.php");
}

?>
