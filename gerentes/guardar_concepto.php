<?php
	require_once('../conexionesDB/conexion.php');
	require "../vendor/autoload.php";
	session_start();

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
	$link = Conectarse_personal();
	$link_caronte=Conectarse_caronte();
	$mensaje = "";

	if (isset($_POST['sala'],$_POST['cod_tema'])) {

			$sala = $_POST['sala'];
			$cod_sociedad = $_SESSION['cod_sociedad'];

			$cod_variable = $_POST['cod_variable'];
			$cod_concepto = $_POST['cod_concepto'];
			$cod_tema = $_POST['cod_tema'];
			$calificacion = $_POST['calificacion'];


			if (isset($_POST['calificacion_ant'],$_POST['codigo_sol_califica']) && !empty($_POST['calificacion_ant'])) {

				$calificacion_ant = $_POST['calificacion_ant'];
				$codigo_sol_califica = $_POST['codigo_sol_califica'];

				$calificacion = $_POST['calificacion_ant'];

				// $sql_actualiza_calificacion = "UPDATE gestion_salas SET calificacion=$calificacion_ant WHERE codigo_gestion='$codigo_sol_califica'";

				$sql_actualiza_calificacion = "UPDATE gestion_salas SET calificacion=$calificacion_ant
																			 WHERE centro_costo='$sala' and cod_variable=$cod_variable
																			 and cod_concepto=$cod_concepto and estado_gestion<>98";
				// $mensaje .= $sql_actualiza_calificacion."<br>";
				$query_actualiza_calificacion = $link->query($sql_actualiza_calificacion);

			}

			$hallazgo = $_POST['hallazgo'];
			$acciones = $_POST['acciones'];
			$fecha_control = $_POST['fecha_control'];

			$autor = $_POST['evaluador'];
			$hoy = date("d/m/y");
			$fecha = new DateTime('now');
			$fechaActual = $fecha->format('Y-m-d');
			$observacion = $_POST['observacion'];


			//busqueda de solicitud hermes para asociar
			$sql_hermes = "SELECT max(solicitud_id) as cod_solicitud FROM solicitud  WHERE cod_origen=2 and solicitante='$autor' and DATE(fecha_inicial)='$fechaActual'";
			$query = $link_caronte->query($sql_hermes);
			$resul = $query->fetch_object();
			$cod_sol_hermes = $resul->cod_solicitud;

			// $sql="INSERT INTO personal.concepto_sala (cc, fecha, concepto_esp, calificacion, hallazgo, tarea, responsable, fecha_control,observacion_conf,autor, estado)
			// 		VALUES ('$sala', '$f_visita', '$concepto_det', '$calificacion', '$hallazgo', '$tarea', '$responsable', '$fcontrol','$observacion_conf', '$autor', 'PENDIENTE');";
			$sql = "INSERT INTO gestion_salas(sociedad_ID, centro_costo, fecha, hora, cod_variable, cod_concepto, cod_tema, calificacion, hallazgo, acciones,
				 			cod_sol_hermes,fecha_control, estado_gestion, observacion, usuario_radica) VALUES ('$cod_sociedad','$sala',CURDATE(),CURTIME(),'$cod_variable','$cod_concepto','$cod_tema',
							'$calificacion','$hallazgo','$acciones','$cod_sol_hermes','$fecha_control',97,'$observacion','$autor')";
			// $mensaje .=  $sql;
			// exit($mensaje);
			$qry_sql = $link->query($sql);

			if ($qry_sql == true) {
				$mensaje .= "Se ha creado la gestión con éxito";
				echo $mensaje;
			}else {
				$mensaje .= "No se pudo crear su solicitud, se presentaron errores al crear el registro, intenter de nuevo en un momento.";
				echo $mensaje;
			}

}else {
	$mensaje .= "No hay suficientes datos para crear un registro";
	echo $mensaje;
}

	// $sql_concepto="SELECT Descripcion from parametros where id_parametro='$concepto_det' and Tipo_ID=1";
	// $query_concepto=$link->query($sql_concepto);
	// $resul_concepto= $query_concepto->fetch_object();

		//consulta de email de sala
	// $sqla="SELECT email, nombre FROM email_permisos where cc = '10-$sala'";
	// $qry_sqla=$link->query($sqla);
	// $rs_qrya=$qry_sqla->fetch_object();  ///consultar

// 	$rs_qrya->email;
// if(true)
// {
// 	$mailer = new PHPMailer(true);
//
//   try {
// 		$correo .= '<div style="width:95%; border:6px solid #f6bc1c; padding:6px;">';
// 		$correo .= '<div style="width:97%; border:4px ridge #002F87;padding:6px;">';
// 		$correo .= '<h3>Hola buen día,</h3>';
// 		$correo .= '<ul>';
// 		$correo .='Se ha realizado una solicitud a su área desde la herramienta de auditoria operacional, con los siguentes datos básicos: <br>';
// 		$correo .= '<br><b>FECHA: </b> '.$fechaActual;
// 		$correo .= '<br><b>SALA: </b>'.$rs_qrya->nombre;
// 		$correo .= '<br><b>SOLICITUD: </b>'.$resul_concepto->Descripcion.": ".$tarea;
// 		$correo .= '<br><b>AUTOR: </b>'.$autor;
// 		// $correo .= '<br>Para gestionar esta solicitud ingrese al siguiente <a href="http://10.1.0.48:81/auditoria_operacional/gerentes/index.php">enlace</a>.';
// 		$correo .= '</ul>';
// 		$correo .= '<ul><br>Gracias por su atención.</ul>';
// 		$correo .= '</div></div>';
//
//     $mailer->isSMTP();
//
//     $mailer->SMTPOptions = [
//       'ssl'=> [
//           'verify_peer' => false,
//           'verify_peer_name' => false,
//           'allow_self_signed' => true
//       ]
//     ];
//
//     $mailer->Host = 'smtp.gmail.com';
//     $mailer->SMTPAuth = true;
//     $mailer->Username = 'ares@ceramigres.com';
//     $mailer->Password = 'M41l3rD43m0n+';
//     $mailer->SMTPSecure = 'tls';
//     $mailer->Port = 587;
//
//     $mailer->CharSet = 'UTF-8';
//     $mailer->setFrom('ares@ceramigres.com', 'Plataforma del Grupo Empresarial Maxicassa');
//
//     $mailer->addAddress($responsable);
// 		// $mailer->addAddress('desarrollador@ceramigres.com');
//
//     $mailer->isHTML(true);
//     $mailer->Subject = 'Concepto de visita a sala -  Auditoria Operacional';
//     $mailer->Body = $correo;
//
//     $mailer->send();
//     $mailer->ClearAllRecipients();
//     echo "Mensaje enviado";
//
//   } catch (Exception $e) {
//     echo "Falla en el envío del mensaje. INFO: " . $mailer->ErrorInfo;
//   }
//


?>
