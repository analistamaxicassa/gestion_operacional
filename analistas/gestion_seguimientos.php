<?php
require_once('../conexionesDB/conexion.php');
require "../vendor/autoload.php";
session_start();
// $userID = $_SESSION['userID'];
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$link_personal = Conectarse_personal();
$link_caronte = Conectarse_caronte();
$resultado = "";

if (isset($_POST['centro_costo'],$_POST['fecha_inspeccion'],$_POST['usuario_radica']) && !empty($_POST['centro_costo']) && !empty($_POST['fecha_inspeccion']) && !empty($_POST['usuario_radica']))
   {
     $usuario = $_POST['usuario_radica'];
     $centro_costo = $_POST['centro_costo'];
     $fecha_inspeccion = $_POST['fecha_inspeccion'];
     $estado = $_POST['estado'];

    // INSERTAR REGISTRO DEL SEGUIMIENTO
    $sql_insert = "INSERT INTO seguimiento_salas( centro_costo, fecha_creacion, hora, num_conceptos, fecha, estado,usuario)
                   VALUES ('$centro_costo',CURDATE(),CURTIME(),0,'$fecha_inspeccion',$estado,$usuario)";
    $query_insert = $link_personal->query($sql_insert);
    if ($query_insert ==  false) {
      $resultado .= "Se perdió la conexión con la base de datos, intentelo de nuevo mas tarde";

    }else {
        $resultado .= "Se ha realizado la creacion del seguimiento correctamente";
    }

}elseif(isset($_POST['cod_seguimiento'],$_POST['centro_costo'],$_POST['estado_cerrado']) and !empty($_POST['cod_seguimiento']) and !empty($_POST['centro_costo'])){
    $cod_seguimiento = $_POST['cod_seguimiento'];
    $centro_costo = $_POST['centro_costo'];
    $estado_cerrado = $_POST['estado_cerrado'];



    $sql_update = "UPDATE seguimiento_salas SET estado = $estado_cerrado  WHERE cod_seguimiento = '$cod_seguimiento'
                   AND centro_costo = '$centro_costo'";
    $query_update = $link_personal->query($sql_update);
    if ($query_update == false) {
      $resultado .= "Se perdió la conexión con la base de datos, intentelo de nuevo mas tarde";

    }else {
        $resultado .= "Se ha realizado el cierre del seguimiento correctamente.";

        $sql_consulta = "SELECT ss.cod_seguimiento, ss.centro_costo, sa.sala_nombre,ss.fecha_creacion, ss.hora, ss.num_conceptos, ss.fecha, ss.estado,emp.emp_nombre
                          FROM seguimiento_salas ss INNER JOIN queryx_seven.salas sa ON ss.centro_costo= sa.centro_costo
                          INNER JOIN queryx_seven.empleado emp  ON ss.usuario=emp.emp_codigo
                          WHERE ss.cod_seguimiento='$cod_seguimiento'";
        $query_consulta = $link_personal->query($sql_consulta);
        $resul_consulta = $query_consulta->fetch_object();
        if (!empty($resul_consulta)) {

          $nombre_sala = $resul_consulta->sala_nombre;
          $fecha  = $resul_consulta->fecha;
          $num_conceptos = $resul_consulta->num_conceptos;
          $usuario_radica = $resul_consulta->emp_nombre;

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
            $mailer->Password = 'M41l3rD43m0n*';
            $mailer->SMTPSecure = 'tls';
            $mailer->Port = 587;

            $mailer->CharSet = 'UTF-8';
            $mailer->setFrom('ares@ceramigres.com', 'Informe de Gestión Operacional');

            // $mailer->addAdress('goperaciones@ceramigres.com');
           $mailer->addAddress('desarrollador@ceramigres.com');

            $correo .= '<div style="width:95%; border:6px solid #f6bc1c; padding:6px;">';
            $correo .= '<div style="width:97%; border:3px ridge #002F87;padding:6px;">';
            $correo .= '<h3>Hola buen día,</h3><br>';
            $correo .= '<ul>';
            $correo .= 'El funcionario <b>'.ucwords(strtolower($usuario_radica)).'</b> terminó un seguimiento de gestión operacional.Esta es una respuesta';
            $correo .= ' automática confirmando el cierre del mismo, los detalles del seguimiento se encuentran a continuación: <br>';
            $correo .= '<b>Código Seguimiento: </b>'.$cod_seguimiento.'* <br>';
            $correo .= '<b>Ubicación: </b>'.$centro_costo." - ".ucwords(strtolower($nombre_sala)).'<br>';
            $correo .= '<b>Cantidad Conceptos: </b>'.$num_conceptos.'<br>';
            $correo .= '<b>Fecha del seguimiento: </b>'.$fecha.'<br><br>';

            // $correo .= '<b>Informado: </b>'.ucwords(strtolower($nombre_informado)).'<br><br>';
            $correo .= '<br>Para consultar este seguimiento y los detalles ingrese al siguiente <a href="http://10.1.0.126/gestion_operacional/gerentes/index.php">enlace</a>.<br>';
            $correo .= '* Puede utilizar este código para buscar más fácilmente las gestiones que tiene asociadas';
            $correo .= '</ul>';
            $correo .= '<ul><br>Gracias por su atención.</ul>';
            $correo .= '</div></div>';

            $mailer->isHTML(true);
            $mailer->Subject = 'Nuevo Seguimiento Gestión Operacional';
            $mailer->Body = $correo;


            $mailer->send();
            $mailer->ClearAllRecipients();
            $resultado .= "Correo enviado correctamente";

          } catch (Exception $e) {
            $resultado .= "Falla en el envío del mensaje. INFO: " . $mailer->ErrorInfo;
          }

        }

    }

}else {
  $resultado .= "No hay datos para registrar el seguimiento";
}
echo $resultado;
exit();

 ?>
