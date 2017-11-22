<?php
require_once('../conexionesDB/conexion.php');

//recojo variables
$evaluador=$_POST['aval'];
$entrevistado=$_POST['entrevistado'];

if (empty($evaluador)) {
  echo 'Debe ingresar su clave de ingreso';
}
 else {
   //conexion
		$link_queryx = Conectarse_queryx();

		$queryx = "SELECT EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 AVALADOR FROM EMPLEADO EM WHERE EM.EMP_CODIGO = '$evaluador'";
    $stid = oci_parse($link_queryx, $queryx);
    oci_execute($stid);

    while (($row = oci_fetch_object($stid)) != false) {
        // Use nombres de atributo en mayúsculas para cada columna estándar de Oracle
        $nomaval1 = $row->AVALADOR;
    }

    oci_free_statement($stid);
    oci_close($link_queryx);

		//$nomaval1 = $row_n['AVALADOR'];
		$_SESSION['AVALADOR']=$nomaval1;

		if (empty($nomaval1)) {
    	echo 'No digito correctamente su Clave, vuelva al menu de Autorizar';
		exit;
		}
		 else {
       echo "la consulta fue correcta";
	 	}
?>

<link rel="stylesheet" type="text/css" href="../estilos.css"/>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<body style="font-family:Verdana, Geneva, sans-serif; font-size:14px;">
<form method="post" action="listado_programado.php">

  <table width="656" border="1" align="center" cellpadding="4" cellspacing="0"   style="border-collapse:collapse; border:solid 1px;">
    <tr>
      <td align="center" valign="middle" class="encabezados"><strong>CONTROL DE ACCESO</strong></td>
    </tr>
    <tr valign="middle">
      <td align="center"><p><span style="font-size: 18px">Bienvenido</span></p>
        <p> <?php echo $nomaval1."<br>";
                  echo $evaluador."<br>";
                  echo $entrevistado."<br>";
          ?> &nbsp;</p>
        <p>
          <input type="submit" name="ingresar" id="ingresar" value="INGRESAR"  style="height:40px; font-size:19px; " />
        </p>
        <p>
          <label>
            <input name="evaluador" type="text" style="visibility:hidden" id="evaluador" value="<?php echo $evaluador;?>">
          </label>
      </p></td>
    </tr>
  </table>
</form>
<?php
}
?>

</body>
</html>
