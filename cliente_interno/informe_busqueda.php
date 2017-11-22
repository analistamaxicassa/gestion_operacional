<?php
  $empleado = $_POST['empleado'];
  $empresa = $_POST['empresa'];

  require_once('../conexionesDB/conexion.php');
  $link_queryx = Conectarse_queryx();

 //MUESTRA LOS EMPLEADOS
  $queryc = "SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_NOMBRE, CC.CENCOS_NOMBRE, SUBSTR(EMP.EMP_CC_CONTABLE,4,3) UBICACION
  FROM EMPLEADO EMP, CARGO CA, CENTRO_COSTO CC
  WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO AND EMP.EMP_CC_CONTABLE = CC.CENCOS_CODIGO AND (EMP.EMP_NOMBRE LIKE '%$empleado%'  or EMP.EMP_APELLIDO1 LIKE '%$empleado%' or EMP.EMP_APELLIDO2 LIKE '%$empleado%' ) AND EMP.EMP_SOCIEDAD = '$empresa' AND  EMP.EMP_ESTADO <> 'R'";
	$stid = oci_parse($link_queryx, $queryc);
  oci_execute($stid);

  $empleado = oci_fetch_object($stid);
  if ($empleado == false) {
    echo 'No existen registros';
    exit;
  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <title>Help Desk</title>
  <meta charset="utf-8"/>
  <link rel="stylesheet" type="text/css" href="../estilos1.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
</head>
<body>
  <header></header>
  <br> <br> <br> <br> <br> <br>
  <table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:12px " width="80%" align="center">
  </table>
<br>
<?php
do{
?>
<table border="0" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="50%" align="center">
  <td width="250"><A href="informe_cliente_interno2.php?cedula=<?php echo utf8_encode($empleado->CEDULA);?>&sala=<?php echo utf8_encode($empleado->UBICACION);?>"> <?php echo utf8_encode($empleado->NOMBRE); ?></A></td>
  <td  colspan="4" align="left" valign="middle"><?php echo utf8_encode($empleado->CENCOS_NOMBRE); ?></td>
</tr>
</table>
<?php
}
while(($empleado = oci_fetch_object($stid)) != false);
//}
?>
    <footer></footer>
</body>
</html>
