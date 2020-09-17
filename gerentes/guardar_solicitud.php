<?php
  session_start();
  require_once('../conexionesDB/conexion.php');
  require_once('../dominios_maxicassa.php');
  //require_once("solicitud.php");
  require "../vendor/autoload.php";

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  $link_queryx_seven = Conectarse_queryx_mysql();
  $link_caronte = Conectarse_caronte();
  $mensaje = "";

if (isset($_POST["usuario"])) {

  $cod_sociedad = $_SESSION['cod_sociedad'];
  $solicitante = $_POST["usuario"];
  $ejecutor = $_POST["cod_ejecutor"];
  $nombre_ejecutor = $_POST['nom_ejecutor'];
  $responsable = $_POST["cod_responsable"];
  $nombre_responsable = $_POST['nom_responsable'];
  $informado = $_POST["cod_informado"];
  $nombre_informado = $_POST['nom_informado'];
  $descripcion = $_POST["descripcion"];
  $prioridad = $_POST["prioridad"];
  $estado = $_POST["estado"];
  $sala_codigo = $_POST['sala_codigo'];
  $codigo_sociedad = $_POST['codigo_sociedad'];

  //CARGUE DE DOCUMENTOS
    // $valida='';
    //  if (!empty($_FILES['file_adjunto']["name"])) {
    //
    //        $adjunto = $_FILES['file_adjunto'];
    //        $contadoradjunto = 1;
    //        $valida .= validar_archivo($adjunto, $usuario, $ultimo, $link_personal,$contadoradjunto);
    //    }

  // $codigo_sociedad = $POST['codigo_sociedad'];

  if (empty($_FILES["file_adjunto"]["name"])) {
    $archivo_adjunto = "";
    $uploadOk = false;
    $no_existe_adjunto = true;

  } else {
    $uploadOk = true;
    $no_existe_adjunto = false;
    $target_dir = "../../hermes/adjuntos/";
    $baseName = $_FILES["file_adjunto"]["name"];
    list($fileName, $fileType) = explode(".", $baseName);


    if ($_FILES["file_adjunto"]["size"] > 20388600) {
      $tipo_error = "4";
      $uploadOk = false;
    }

    if($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "pdf" ) {
      $tipo_error = "5";
      $uploadOk = false;
    }

    if ($uploadOk) {
      $fecha_file = new DateTime("now");
    	$fecha_file = $fecha_file->format('Ymd');
      $aleatorio = rand(1, 100);
      $nuevo_nombre_archivo = $fecha_file."_".$sala_codigo."_".$aleatorio.".".$fileType;
      $target_file = $target_dir.$nuevo_nombre_archivo;

      while (file_exists($target_file)) {
        $aleatorio2 = rand(1, 100);
        $nuevo_nombre_archivo = $fecha_file."_".$sala_codigo."_".$aleatorio2.".".$fileType;
        $target_file = $target_dir.$nuevo_nombre_archivo;
      }

      if (move_uploaded_file($_FILES["file_adjunto"]["tmp_name"], $target_file)) {
        $archivo_adjunto = $nuevo_nombre_archivo;
      } else {
        $archivo_adjunto = "";
        $uploadOk = false;
        $tipo_error = "6";
      }
    } else {
      $archivo_adjunto = "";
    }
  }
  // if(!(empty($_SESSION["userID"]) AND empty($_POST["prioridad"])))
  // {
    //$solicitud_id, $solicitante, $ejecutante, $responsable, $informado, $descripcion, $prioridad, $estado, $fecha_cumpliento
    //print_r($_POST);exit;
  	$fechaTemporal = new DateTime("now");

    //codigo para determinar numero días con base en consulta BD
    // $prioridad= $_POST["prioridad"];
    $sql_dias = "SELECT num_dias,Descripcion from parametros WHERE id_parametro='$prioridad' and Tipo_ID=1";
    $query_dias = $link_caronte->query($sql_dias);
    $resul_dias= $query_dias->fetch_object();
    $num_dias= $resul_dias->num_dias;
    $nombre_prioridad=$resul_dias->Descripcion;
    //finaliza código consulta días
    if ($num_dias<10) {
      $parametro= "P0".$num_dias."D";
    }else {
      $parametro= "P".$num_dias."D";
    }
    switch ($prioridad)
    {
      case '1':
        $fechaTemporal->add(new DateInterval($parametro));
        $fecha_cumpliento = $fechaTemporal->format('Y-m-d');
        break;
      case '2':
        $fechaTemporal->add(new DateInterval($parametro));
        $fecha_cumpliento = $fechaTemporal->format('Y-m-d');
        break;
      case '3':
        $fechaTemporal->add(new DateInterval($parametro));
        $fecha_cumpliento = $fechaTemporal->format('Y-m-d');
        break;
      default:
        $mensaje .= 'La solicitud no tiene una prioridad asignada.';
        break;
    }
    $contador = 0;
    $sql_ultimo ="SELECT MAX(solicitud_id) AS Ultimo FROM solicitud";
    $query_ultimo= $link_caronte->query($sql_ultimo);
    $resultado_ultimo = $query_ultimo->fetch_object();
    $ultimo = $resultado_ultimo->Ultimo;
    $ultimo += 1;
    if ($contador == 0) {

    $sql_solicitud = "INSERT INTO solicitud (solicitud_id,cod_origen, Sociedad_ID,solicitante, ejecutante, responsable, informado, descripcion, prioridad, estado, fecha_cumpliento, sala_ID, file_adjunto)
    VALUES ('$ultimo',2,'$codigo_sociedad','$solicitante', '$ejecutor', '$responsable', '$informado', '$descripcion', '$prioridad', '$estado', '$fecha_cumpliento', '$sala_codigo', '$archivo_adjunto')";
    // echo $sql_solicitud;
    // exit();
    $query_solicitante = $link_caronte->query($sql_solicitud);
    if ($query_solicitante == false) {

      // header("Location: principal.php?mensaje=3");
      $mensaje .= '<i class="fas fa-exclamation-triangle fa-lg"></i> Se encontraron algunos errores y <strong>el sistema no pudo generar su solicitud.</strong>';
    }
  }
  $contador = 1;

    $sql_correo = "SELECT EMP_EMAIL FROM EMPLEADO WHERE EMP_CODIGO = '$ejecutor' OR EMP_CODIGO = '$responsable' OR EMP_CODIGO = '$informado'";
    $query_correo = $link_queryx_seven->query($sql_correo);

    $array_correo = array();
    while ($datos_correo = $query_correo->fetch_object()) {
      if (!($datos_correo->EMP_EMAIL == 'NA')) {
        $correos = $datos_correo->EMP_EMAIL;
        $pos = strpos($correos, ',');
        if ($pos === false) {
          $esEmpresarial = identificar_mail_empresarial($correos);
          if ($esEmpresarial) {
            $array_correo[] = $correos;
          }
        } else {
          list($correo_personal, $correo_empresarial) = explode(",", $correos);
          $array_correo[] = $correo_empresarial;
        }
      }
    }
    $size_correo = count($array_correo);
    //var_dump($array_correo);
    if($size_correo > 0)
    {
      $sql_sala = "SELECT sala_nombre FROM salas WHERE centro_costo = '$sala_codigo' and Sociedad_ID='$cod_sociedad'";
      $query_sala = $link_queryx_seven->query($sql_sala);
      $resultado_sala = $query_sala->fetch_object();
      $sala_nombre = $resultado_sala->sala_nombre;
      $nombre_solicitante = $_SESSION['nombre'].' - '.ucwords($_SESSION['cargo']);
      $fecha_actual = new DateTime("now");
    	$fecha_actual = $fecha_actual->format('Y-m-d');

      $mailer = new PHPMailer(true);
      $correo='';
      try {
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
        $mailer->setFrom('ares@ceramigres.com', 'HERMES Gestor de Solicitudes');
        // if ($size_correo == 1) {
        //   $mailer->addAddress($array_correo[0]);
        // } elseif ($size_correo == 2) {
        //   $mailer->addAddress($array_correo[0]);
        //   $mailer->addAddress($array_correo[1]);
        // } elseif ($size_correo == 3) {
        //   $mailer->addAddress($array_correo[0]);
        //   $mailer->addAddress($array_correo[1]);
        //   $mailer->addAddress($array_correo[2]);
        // }
         $mailer->addAddress('desarrollador@ceramigres.com');

        $correo .= '<div style="width:95%; border:6px solid #f6bc1c; padding:6px;">';
        $correo .= '<div style="width:97%; border:3px ridge #002F87;padding:6px;">';
        $correo .= '<h3>Hola buen día,</h3><br>';
        $correo .= '<ul>';
        $correo .= 'El funcionario <b>'.ucwords(strtolower($nombre_solicitante)).'</b> realizó una solicitud en la herramienta Hermes.Esta es una respuesta';
        $correo .= ' automática confirmando la creación de la solicitud, los detalles de la misma se encuentran a continuación: <br>';
        $correo .= '<b>Código: </b>'.$ultimo.'* <br>';
        $correo .= '<b>Descripción: </b><i>"'.$descripcion.'"</i>.<br>';
        $correo .= '<b>Origen </b>: '.ucwords(strtolower($sala_nombre)).'<br>';
        $correo .= '<b>Fecha límite de gestión: </b>'.$fecha_cumpliento.'<br>';
        $correo .= '<b>Prioridad: </b>'.$nombre_prioridad.'<br>';
        $correo .= '<b>Ejecutor: </b>'.ucwords(strtolower($nombre_ejecutor)).'<br>';
        $correo .= '<b>Responsable: </b>'.ucwords(strtolower($nombre_responsable)). '<br>';
        $correo .= '<b>Informado: </b>'.ucwords(strtolower($nombre_informado)).'<br><br>';
        $correo .= '<br>Para gestionar esta solicitud ingrese al siguiente <a href="http://190.144.42.83:81/hermes/index.php">enlace</a>.<br>';
        $correo .= '* Puede utilizar este código para buscar más fácil la solicitud dentro de Hermes según el rol y la prioridad';
        $correo .= '</ul>';
        $correo .= '<ul><br>Gracias por su atención.</ul>';
        $correo .= '</div></div>';

        $mailer->isHTML(true);
        $mailer->Subject = 'HERMES: Nueva solicitud desde Gestion Operacional';
        $mailer->Body = $correo;


        $mailer->send();
        $mailer->ClearAllRecipients();
        $mensaje .= "Correo enviado correctamente";

      } catch (Exception $e) {
        $mensaje .= "Falla en el envío del mensaje. INFO: " . $mailer->ErrorInfo;
      }
    }
    if ($uploadOk) {
      // header("Location: principal.php?mensaje=2");
      // exit();
      $mensaje .= '<i class="fas fa-trophy fa-lg"></i> ¡Felicitaciones!, <strong>su solicitud fue generada correctamente.</strong> El archivo adjunto fue cargado satisfactoriamente.';

    } elseif ($no_existe_adjunto) {
     $mensaje .= '<i class="fas fa-trophy fa-lg"></i> ¡Felicitaciones!, <strong>su solicitud fue generada correctamente.</strong>';
      // header("Location: principal.php?mensaje=1");
      // exit();
    } elseif ($tipo_error == '4') {
      $mensaje .= '<i class="fas fa-info-circle fa-lg"></i> <strong>Su solicitud se generó correctamente</strong>, aunque el archivo adjunto no se cargo por que supera los 20 Megabyte.';
      // header("Location: principal.php?mensaje=4");
      // exit();
    } elseif ($tipo_error == '5') {
      $mensaje .= '<i class="fas fa-info-circle fa-lg"></i> <strong>Su solicitud se generó correctamente</strong>, aunque el archivo que intenta archivo adjuntar no es de un tipo valido. (Tipos validos: JPG, JPEG, PNG & PDF)';
      // header("Location: principal.php?mensaje=5");
      // exit();
    } elseif ($tipo_error == '6') {
    $mensaje .= '<i class="fas fa-info-circle fa-lg"></i> <strong>Su solicitud se generó correctamente</strong>, aunque se encontró un error al intentar procesar el archivo adjunto y no se cargó a la solicitud.';
      // header("Location: principal.php?mensaje=6");
      // exit();
    }

      echo $mensaje;

  }else {
    $mensaje .= "No hay suficientes datos para almacenar";
    echo $mensaje;
  }
  // }




?>
