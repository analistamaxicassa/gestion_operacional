<?php
  require_once('../conexionesDB/conexion.php');
  $link_personal=Conectarse_personal();
  session_start();
  if (isset($_POST['nombreCiudad']))
  {
    $jefe = $_POST['ejecutorID'];
    $motivo = $_POST['motivo'];
    $a1p1 = $_POST['a1p1'];
    $a1p1_detalle = $_POST['a1p1_detalle'];
    $a1p2 = $_POST['a1p2'];
    $a1p2_detalle = $_POST['a1p2_detalle'];
    $a1p3 = $_POST['a1p3'];
    $a1p3_detalle = $_POST['a1p3_detalle'];
    $a1p4 = $_POST['a1p4'];
    $a1p4_detalle = $_POST['a1p4_detalle'];
    $a1p5 = $_POST['a1p5'];
    $a1p5_detalle = $_POST['a1p5_detalle'];
    $a1p6 = $_POST['a1p6'];
    $a1p6_detalle = $_POST['a1p6_detalle'];
    $f1p1 = $_POST['f1p1'];
    $f1p1_detalle = $_POST['f1p1_detalle'];
    $f1p2 = $_POST['f1p2'];
    $f1p2_detalle = $_POST['f1p2_detalle'];
    $f1p3 = $_POST['f1p3'];
    $f1p3_detalle = $_POST['f1p3_detalle'];
    $f1p4 = $_POST['f1p4'];
    $f1p4_detalle = $_POST['f1p4_detalle'];
    $f1p5 = $_POST['f1p5'];
    $f1p5_detalle = $_POST['f1p5_detalle'];
    $f1p6 = $_POST['f1p6'];
    $f1p6_detalle = $_POST['f1p6_detalle'];
    $f1p7 = 0;
    $f1p7_detalle = "";
    $f1p8 = $_POST['f1p8'];
    $f1p8_detalle = $_POST['f1p8_detalle'];
    $f1p9 = $_POST['f1p9'];
    $f1p9_detalle = $_POST['f1p9_detalle'];
    $actitud = $_POST['actitud'];
    $disposicion = $_POST['disposicion'];
    $aspectosPositivos = $_POST['aspectosPositivos'];
    $aspectosMejorar = $_POST['aspectosMejorar'];
    $observacion = $_POST['observacion'];

    $fechaEntrevista = $_POST['fechaEntrevista'];
    $evaluadorID = $_SESSION['userID'];
    //$evaluadorCargo = $_SESSION['cargo'];
    $codCargo = $_POST['codCargo'];
    $centroCosto = $_POST['centroCosto'];
    $nombreCiudad = $_POST['nombreCiudad'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    if ($_POST['fecha_retiro'] == "No se registra la fecha de retiro")
    {
      $fecha_retiro = $_POST['fechaEntrevista'];
    }
    else
    {
      $fecha_retiro = $_POST['fecha_retiro'];
    }
    $empleadoRetiradoID = $_POST['empleadoRetiradoID'];

    $sql = "INSERT INTO entrevista_retiro( empleadoRetiradoID, fecha_ingreso, fecha_retiro, nombreCiudad, centroCosto, codCargo, evaluadorID, fechaEntrevista, jefe, motivo, a1p1, a1p1_detalle, a1p2, a1p2_detalle, a1p3, a1p3_detalle, a1p4, a1p4_detalle,
    a1p5, a1p5_detalle, a1p6, a1p6_detalle, f1p1, f1p1_detalle, f1p2, f1p2_detalle, f1p3, f1p3_detalle, f1p4, f1p4_detalle, f1p5, f1p5_detalle, f1p6, f1p6_detalle, f1p7, f1p7_detalle, f1p8, f1p8_detalle, f1p9, f1p9_detalle, actitud, disposicion, aspectosPositivos, aspectosMejorar, observacion) VALUES ('$empleadoRetiradoID','$fecha_ingreso','$fecha_retiro','$nombreCiudad','$centroCosto','$codCargo','$evaluadorID','$fechaEntrevista','$jefe','$motivo','$a1p1','$a1p1_detalle','$a1p2','$a1p2_detalle','$a1p3','$a1p3_detalle','$a1p4','$a1p4_detalle',
    '$a1p5','$a1p5_detalle','$a1p6','$a1p6_detalle','$f1p1','$f1p1_detalle','$f1p2','$f1p2_detalle','$f1p3','$f1p3_detalle','$f1p4','$f1p4_detalle','$f1p5','$f1p5_detalle','$f1p6','$f1p6_detalle','$f1p7','$f1p7_detalle','$f1p8','$f1p8_detalle',
    '$f1p9','$f1p9_detalle','$actitud','$disposicion','$aspectosPositivos','$aspectosMejorar','$observacion')";
    //echo $sql."<br>";
    $insertEntrevista=$link_personal->query($sql);
    $link_personal->close();
    header("Location: main.php?mensaje=1");
    exit();
  }
 ?>
