<?php
	require_once('../conexionesDB/conexion.php');
	require "../vendor/autoload.php";
	session_start();

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
	$link = Conectarse_personal();
	$link_caronte=Conectarse_caronte();
	$mensaje = "";
	$valida = "";

	if (isset($_POST['sala'],$_POST['cod_concepto'],$_POST['cod_seguimiento']) && !empty($_POST['cod_seguimiento']) && !empty($_POST['cod_concepto'])) {

			$cod_seguimiento = $_POST['cod_seguimiento'];
			$fecha_visita = $_POST['fecha_visita'];
			$sala = $_POST['sala'];
			$cod_sociedad = $_SESSION['cod_sociedad'];

			$cod_variable = $_POST['cod_variable'];
			$cod_concepto = $_POST['cod_concepto'];
			// $cod_tema = $_POST['cod_tema'];
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
			if ($query ==  false) {
				$cod_sol_hermes = 0;
			}
			$resul = $query->fetch_object();
			if (empty($resul)) {
				$cod_sol_hermes = 0;
			}else {
				$cod_sol_hermes = $resul->cod_solicitud;
			}

			if (empty($cod_sol_hermes)) {

				if (isset($_POST['cod_hermes']) && $_POST['cod_hermes']) {
					$cod_sol_hermes = $_POST['cod_hermes'];
				}else {
					$cod_sol_hermes = 0;
				}
			}

			//VALIDACIONES DE NUMERO DE CONCEPTOS EN SEGUIMIENTOS

			$sql_conceptos = "SELECT cod_seguimiento,cod_concepto as concepto FROM gestion_salas WHERE cod_seguimiento='$cod_seguimiento'
			AND cod_concepto='$cod_concepto'";
			$query_conceptos = $link->query($sql_conceptos);
			$resul_conceptos = $query_conceptos->fetch_object();
			if (empty($resul_conceptos)) {

				$sql_update_segui = "UPDATE seguimiento_salas set num_conceptos = num_conceptos+1 WHERE cod_seguimiento='$cod_seguimiento'";
				$query_update_segui = $link->query($sql_update_segui);

			}


			$sql = "INSERT INTO gestion_salas(sociedad_ID, cod_seguimiento, centro_costo, fecha, hora, fecha_inspeccion, cod_variable, cod_concepto,  calificacion, hallazgo, acciones,
				 			cod_sol_hermes,fecha_control, estado_gestion, observacion, usuario_radica) VALUES ('$cod_sociedad','$cod_seguimiento','$sala',CURDATE(),CURTIME(), '$fecha_visita', '$cod_variable','$cod_concepto',
							'$calificacion','$hallazgo','$acciones','$cod_sol_hermes','$fecha_control',97,'$observacion','$autor')";
			// $mensaje .=  $sql;
			// exit($mensaje);
			$qry_sql = $link->query($sql);

			if ($qry_sql == true) {
				$mensaje .= "Se ha creado la gestión con éxito.<br\> ";
			}else {
				$mensaje .= "No se pudo crear su solicitud, se presentaron errores al crear el registro, intenter de nuevo en un momento.<br\>";
				// echo $mensaje;
			}

			//busqueda de código de gestión para asociar
			$sql_gestion = "SELECT max(codigo_gestion) AS cod_gestion FROM gestion_salas";
			$query_gestion = $link->query($sql_gestion);
			if ($query_gestion ==  false) {
				$cod_gestion = 0;
			}
			$resul_gestion = $query_gestion->fetch_object();
			if (empty($resul_gestion)) {
				$cod_gestion = 0;
			}else {
				$cod_gestion = $resul_gestion->cod_gestion;
			}

			if (isset($_POST['temas']) && !empty($_POST['temas'])) {
				  	$arreglo = array();
						$arreglo = json_decode($_POST['temas']);

						if (isset($_POST['auditoria']) && !empty($_POST['auditoria'])) {
							$val_auditoria = $_POST['auditoria'];
						}else {
							$val_auditoria= 0;
						}

						// var_dump($arreglo)."<br>";
						// echo count($arreglo);
						// exit();

						$cadena = '';
						  for ($i=0 ; $i< count($arreglo) ; $i++) {
								// echo $arreglo[$i]."<br>";

							if ($arreglo[$i] <> 0 OR !empty($arreglo[$i]))  {

								$cadena .= "( $cod_gestion, $arreglo[$i],$val_auditoria),";
							}
						}
						$sql_insert = "INSERT INTO temas_gestion(codigo_gestion, codigo_tema,valor)
													VALUES ".trim($cadena,',');
						// exit($sql_insert);

						$query_insert = $link->query($sql_insert);
						if ($qry_sql == true) {

							$mensaje .= "Se han asociado los temas a la gestión con éxito";
						}else {

							$mensaje .= "No se logro asociar los temas a la gestión, se presentaron errores al crear el registro.";
							// echo $mensaje;
						}
			}


			//CARGUE DE DOCUMENTOS
				 if (!empty($_FILES['file_adjunto']["name"])) {

							 $adjunto = $_FILES['file_adjunto'];
							 $contadoradjunto = 1;
							 $valida .= validar_archivo($adjunto, $sala, $cod_gestion, $link,$contadoradjunto);
							 // echo $valida;

					 }

					 if (!empty($_FILES['file_adjunto_1']["name"])) {

								 $adjunto1 = $_FILES['file_adjunto_1'];
								 $contadoradjunto += 1;
								 $valida .= validar_archivo($adjunto1, $sala, $cod_gestion, $link,$contadoradjunto);
								 // echo $valida;
						 }
						 if (!empty($_FILES['file_adjunto_2']["name"])) {

									 $adjunto1 = $_FILES['file_adjunto_2'];
									 $contadoradjunto += 1;
									 $valida .= validar_archivo($adjunto1, $sala, $cod_gestion, $link,$contadoradjunto);
									 // echo $valida;
							 }

			echo $mensaje;
			echo $valida;

}elseif (isset($_POST['codigo_gestion'],$_POST['cod_hermes']) && !empty($_POST['codigo_gestion']) && !empty($_POST['cod_hermes'])) {

	$codigo_gestion = $_POST['codigo_gestion'];
	$codigo_hermes = $_POST['cod_hermes'];

	$sql_update = "UPDATE  gestion_salas SET cod_sol_hermes=$codigo_hermes WHERE codigo_gestion=$codigo_gestion";
	// exit($sql_update);
	$query_update = $link->query($sql_update);
	if ($query_update == true) {
		$mensaje .= "Se guardo el código de solicitud de hermes a la gestión";
	}else {
		$mensaje .= "Se pressentaron errores al intentar actualizar la solicitud de hermes a la gestión";
	}

echo $mensaje;

}elseif (isset($_POST['codigo_gestion'],$_POST['centro_costo']) && !empty($_POST['codigo_gestion']) && !empty($_POST['centro_costo'])) {


	$codigo_gestion = $_POST['codigo_gestion'];
	$centro_costo = $_POST['centro_costo'];

	if (!empty($_FILES['file_adjunto']["name"])) {

				$adjunto = $_FILES['file_adjunto'];
				$contadoradjunto = 1;
				$valida .= validar_archivo($adjunto, $centro_costo, $codigo_gestion, $link,$contadoradjunto);
				// echo $valida;

		}

		if (!empty($_FILES['file_adjunto_1']["name"])) {

					$adjunto1 = $_FILES['file_adjunto_1'];
					$contadoradjunto += 1;
					$valida .= validar_archivo($adjunto1, $centro_costo, $codigo_gestion, $link,$contadoradjunto);
					// echo $valida;
			}

			echo $valida;

}else {
	$mensaje .= "No hay suficientes datos para crear/actualizar el registro";
	echo $mensaje;
	echo $valida;
}



function validar_archivo($adjunto, $centro_costo, $ultimo_registro, $link,$contadorad){
		$contador = $contadorad;

	 if (empty($adjunto["name"])) {
		 // $respuesta = var_dump($adjunto["file_adjunto"]["name"]);
		$tipo_error = "0";
		$archivo_adjunto = "";
		$uploadOk = false;
		$no_existe_adjunto = true;

	} else {
		$uploadOk = true;
		$tipo_error = "0";
		$no_existe_adjunto = false;
		$target_dir = "../adjuntos/";
		$target_dir1 = "../adjuntos/";
		// $target_dir = "\\\\10.1.0.131\Reclamos_PDV\\";
		// $target_dir1 =  "\\\\\\\\10.1.0.131\\\Reclamos_PDV\\\\";
		$baseName = $adjunto["name"];
		list($fileName, $fileType) = explode(".", $baseName);


		if ($adjunto["size"] > 25000000) {
			$tipo_error = "4";
			$uploadOk = false;
		}

		if($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "pdf" && $fileType != "mp4" && $fileType != "wmv" && $fileType != "avi" && $fileType != "xlsx" && $fileType != "xls") {
			$tipo_error = "5";
			$uploadOk = false;
			}
		}
		// return array($uploadOk,$tipo_error,$fileType,$target_dir,$no_existe_adjunto);
		if ($tipo_error != 0 ) {

					if ($tipo_error == '4') {
						$respuesta = '<i class="fas fa-info-circle fa-lg"></i>Su solicitud se generó correctamente, aunque el archivo adjunto no se cargo por que supera los 200 Megabyte.';
					} elseif ($tipo_error == '5') {
						$respuesta = '<i class="fas fa-info-circle fa-lg"></i>Su solicitud se generó correctamente, aunque el archivo que intenta archivo adjuntar no es de un tipo valido. (Tipos validos: JPG, JPEG, PNG, PDF, AVI, MP4, WMV Y MKV)';
					}
			}elseif ($uploadOk) {
						// $contador += 1;
						$fecha_file = new DateTime("now");
						$fecha_file = $fecha_file->format('Ymd');
						$nuevo_nombre_archivo =  $centro_costo. "_".$fecha_file."_".$ultimo_registro."_".$contador.".".$fileType;
						$target_file = $target_dir.$nuevo_nombre_archivo;

						while (file_exists($target_file)) {
							$contador += 1;
							$nuevo_nombre_archivo =  $centro_costo. "_".$fecha_file."_".$ultimo_registro."_".$contador.".".$fileType;
							$target_file = $target_dir.$nuevo_nombre_archivo;
						}

						if (move_uploaded_file($adjunto["tmp_name"], $target_file)) {
							$archivo_adjunto = $nuevo_nombre_archivo;
						} else {
							$archivo_adjunto = "";
							$uploadOk = false;
							// $tipo_error = "6";
							$respuesta = '<i class="fas fa-info-circle fa-lg"></i> Su solicitud se generó correctamente, aunque se encontró un error al intentar procesar el archivo adjunto y no se cargó a la solicitud.';
						}

						$sql_adjuntos = "INSERT INTO adjuntos_informe_salas(informe_id, nombre_adjunto, ruta_adjunto)
														VALUES ('$ultimo_registro','$archivo_adjunto','$target_dir1')";
						// $respuesta = "<b>".$sql_adjuntos;
						$query_adjntos = $link->query($sql_adjuntos);
						if ($query_adjntos == false) {
							$respuesta =  "<br>Se perdió la conexión con la base de datos";
						}else {
							$respuesta = "<br>El archivo adjunto N°.".$contador." fue cargado satisfactoriamente.";
						}

				}elseif ($no_existe_adjunto == true) {
						$respuesta = ' <br> Felicitaciones!,su solicitud fue generada correctamente.sin archivo adjunto'.$contador.'';
				}
				return $respuesta;
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
