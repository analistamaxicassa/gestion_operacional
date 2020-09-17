<?php
require_once('../conexionesDB/conexion.php');
// require "../vendor/autoload.php";
session_start();
$userID = $_SESSION['userID'];

$link_personal = Conectarse_personal();
$link_caronte = Conectarse_caronte();
$resultado = "";

if (isset($_POST['codigo_gestion'],$_POST['estado'],$_POST['seguimiento']) && !empty($_POST['estado']) && !empty($_POST['seguimiento']))
 {
   $cod_gestion = $_POST['codigo_gestion'];
   $estado = $_POST['estado'];
   $Seguimiento = $_POST['seguimiento'];

  // INSERTAR REGISTRO DEL SEGUIMIENTO
  $sql_insert = "INSERT INTO segui_gestion_salas(cod_gestion, fecha, hora, estado, descripcion, usuario_registro)
                VALUES ($cod_gestion,CURDATE(),CURTIME(),$estado,'$Seguimiento','$userID')";
  $query_insert = $link_personal->query($sql_insert);
  if ($query_insert ==  false) {
    $resultado .= "Se perdió la conexión con la base de datos, intentelo de nuevo mas tarde";

  }else {
    //ACTUALIZAR EL ESTADO EN GESTION_SALAS
    $sql_update = "UPDATE gestion_salas SET estado_gestion='$estado' WHERE codigo_gestion=$cod_gestion";
    $query_update = $link_personal->query($sql_update);
    if ($query_update == true) {
      $resultado .= "Se ha realizado el seguimiento correctamente";

    }else {
      $resultado .= "Se perdió la conexión con la base de datos, intentelo de nuevo mas tarde";

    }
  }

}else {
  $resultado = "No hay datos para registrar el seguimiento";
}
echo $resultado;
exit();

 ?>
