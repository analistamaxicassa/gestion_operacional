<?php
  /*require_once('conexionesDB/conexion.php');
  $link_personal=Conectarse_personal();
  $link_queryx = Conectarse_queryx();

  $sql = "SELECT cedula_retirado, motivo, b1p1, b1p2, b1p3, b1p4, b1p5, b1p6, comb1p1, comb1p2, comb1p3, comb1p4, comb1p5, comb1p6, b2p1, b2p2, b2p3, b2p4, b2p5, b2p6, b2p7, b2p8, b2p9, comb2p1, comb2p2, comb2p3, comb2p4, comb2p5, comb2p6, comb2p7, comb2p8, comb2p9, actitud, colaboracion, bloque3, bloque4, bloque5, cedula_ent, fecha_ent FROM entrevista_retiro1";
  $query_entrevistaA=$link_personal->query($sql);
	//$entrevista_antigua=$query_entrevistaA->fetch_object();
  while ($entrevista_antigua=$query_entrevistaA->fetch_object())
  {
    $empleadoRetiradoID = $entrevista_antigua->cedula_retirado;

    if (!(empty($empleadoRetiradoID)))
    {
      $query1 = "SELECT EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, CC.CENCOS_NOMBRE CCQ,
    	CC.CCOS_VAL_ALF1 CIUDAD, to_char(EMP.EMP_FECHA_INI_CONTRATO,'YYYY-MM-DD') FECHA_INI, to_char(EMP.EMP_FECHA_RETIRO,'YYYY-MM-DD') EMP_FECHA_RETIRO,
    	EMP.EMP_CC_CONTABLE, EMP.EMP_CARGO, EMP.EMP_JEFE_CODIGO FROM EMPLEADO EMP, CENTRO_COSTO CC
    	WHERE EMP.EMP_CC_CONTABLE = CC.CENCOS_CODIGO and EMP.EMP_CODIGO = '$empleadoRetiradoID'";
    	//echo "<br>".$query1;
    	$stmt1 = oci_parse($link_queryx, $query1);
    	oci_execute($stmt1);
    	$row1 = oci_fetch_object($stmt1);

    	$nombre = $row1->NOMBRE;
    	$jefe = $row1->EMP_JEFE_CODIGO;
    	$fecha_retiro = $row1->EMP_FECHA_RETIRO;
    	$fecha_ingreso = $row1->FECHA_INI;
    	//$sociedad = $row1->NOMBRE_SOCIEDAD;
    	$nombreCiudad = $row1->CIUDAD;
    	$centroCosto = $row1->EMP_CC_CONTABLE;
    	$codCargo = $row1->EMP_CARGO;
    	//$nombrecc=$row1->CCQ;
    	oci_free_statement($stmt1);

      $evaluadorTemporal = $entrevista_antigua->cedula_ent;
      if ($evaluadorTemporal == "DORIS CASTRO PAUCAR") {
        $evaluadorID = "27470659";
      }elseif ($evaluadorTemporal == "LILIANA RODRIGUEZ AL") {
        $evaluadorID = "52522883";
      }elseif ($evaluadorTemporal == "ANA MARIA VALENCIA") {
        $evaluadorID = "1032477717";
      }elseif ($evaluadorTemporal == "DANIELA GALVIS ZAMBR") {
        $evaluadorID = "1012417013";
      }

      $motivo =$entrevista_antigua->motivo;
      $a1p1 = $entrevista_antigua->b1p1;
      $a1p1_detalle = $entrevista_antigua->comb1p1;
      $a1p2 = $entrevista_antigua->b1p2;
      $a1p2_detalle = $entrevista_antigua->comb1p2;
      $a1p3 = $entrevista_antigua->b1p3;
      $a1p3_detalle = $entrevista_antigua->comb1p3;
      $a1p4 = $entrevista_antigua->b1p4;
      $a1p4_detalle = $entrevista_antigua->comb1p4;
      $a1p5 = $entrevista_antigua->b1p5;
      $a1p5_detalle = $entrevista_antigua->comb1p5;
      $a1p6 = $entrevista_antigua->b1p6;
      $a1p6_detalle = $entrevista_antigua->comb1p6;
      $f1p1 = $entrevista_antigua->b2p1;
      $f1p1_detalle = $entrevista_antigua->comb2p1;
      $f1p2 = $entrevista_antigua->b2p2;
      $f1p2_detalle = $entrevista_antigua->comb2p2;
      $f1p3 = $entrevista_antigua->b2p3;
      $f1p3_detalle = $entrevista_antigua->comb2p3;
      $f1p4 = $entrevista_antigua->b2p4;
      $f1p4_detalle = $entrevista_antigua->comb2p4;
      $f1p5 = $entrevista_antigua->b2p5;
      $f1p5_detalle = $entrevista_antigua->comb2p5;
      $f1p6 = $entrevista_antigua->b2p6;
      $f1p6_detalle = $entrevista_antigua->comb2p6;
      $f1p7 = $entrevista_antigua->b2p7;
      $f1p7_detalle = $entrevista_antigua->comb2p7;
      $f1p8 = $entrevista_antigua->b2p8;
      $f1p8_detalle = $entrevista_antigua->comb2p8;
      $f1p9 = $entrevista_antigua->b2p9;
      $f1p9_detalle = $entrevista_antigua->comb2p9;
      $actitud = $entrevista_antigua->actitud;
      $disposicion = $entrevista_antigua->colaboracion;
      $aspectosPositivos = $entrevista_antigua->bloque3;
      $aspectosMejorar = $entrevista_antigua->bloque4;
      $observacion = $entrevista_antigua->bloque5;
      $fechaEntrevista = $entrevista_antigua->fecha_ent;

      $sql = "INSERT INTO entrevista_retiro( empleadoRetiradoID, fecha_ingreso, fecha_retiro, nombreCiudad, centroCosto, codCargo, evaluadorID, fechaEntrevista, jefe, motivo, a1p1, a1p1_detalle, a1p2, a1p2_detalle, a1p3, a1p3_detalle, a1p4, a1p4_detalle,
      a1p5, a1p5_detalle, a1p6, a1p6_detalle, f1p1, f1p1_detalle, f1p2, f1p2_detalle, f1p3, f1p3_detalle, f1p4, f1p4_detalle, f1p5, f1p5_detalle, f1p6, f1p6_detalle, f1p7, f1p7_detalle, f1p8, f1p8_detalle, f1p9, f1p9_detalle, actitud, disposicion, aspectosPositivos, aspectosMejorar, observacion) VALUES ('$empleadoRetiradoID','$fecha_ingreso','$fecha_retiro','$nombreCiudad','$centroCosto','$codCargo','$evaluadorID','$fechaEntrevista','$jefe','$motivo','$a1p1','$a1p1_detalle','$a1p2','$a1p2_detalle','$a1p3','$a1p3_detalle','$a1p4','$a1p4_detalle',
      '$a1p5','$a1p5_detalle','$a1p6','$a1p6_detalle','$f1p1','$f1p1_detalle','$f1p2','$f1p2_detalle','$f1p3','$f1p3_detalle','$f1p4','$f1p4_detalle','$f1p5','$f1p5_detalle','$f1p6','$f1p6_detalle','$f1p7','$f1p7_detalle','$f1p8','$f1p8_detalle',
      '$f1p9','$f1p9_detalle','$actitud','$disposicion','$aspectosPositivos','$aspectosMejorar','$observacion')";
      echo $sql."<br>";
      $insertEntrevista=$link_personal->query($sql);

      //header("Location: main.php?mensaje=1");
      //exit();
    }
  }
  oci_close($link_queryx);
  $link_personal->close();*/
  phpinfo();
 ?>
