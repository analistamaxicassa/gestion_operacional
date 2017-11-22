<?php

//recojo variables
$evaluador=$_POST['evaluador'];
//funcion fechas
require_once('../conexionesDB/conexion.php');

$link_personal=Conectarse_personal();


?>

<link rel="stylesheet" type="text/css" href="../estilos.css"/>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
  <script>

 function paraimpimir()
        {	//alert(cedula);
		var cedulae = prompt ('escriba el numero de cedula');

		alert (cedulae);
window.open('http://190.144.42.83:9090/plantillas/eval_desempeno/imprimir_evaluacion.php?cedulae='+cedulae+'', "Evaluacion de desempeño", "width=800", "height=400")
        }


</script>


</head>
<body>
<form method="post" action="../eval_desempeno/muestra_datos.php">
<table width="982" border="3" align="left">
    <tr>
      <td class="encabezados" colspan="2" align="center" valign="middle"><strong>Evaluaciones programadas</strong></td>
    </tr>
    <tr>
      <td width="186" bgcolor="#B6BCC3">Nombre</td>
      <td width="126">Fecha limite</td>
    </tr>

    </table>
<p></p>
 <?php

 $sql="SELECT `empleados`, `fecha_limite` FROM `evaldesep_programacion` WHERE `evaluador` = '$evaluador'";
			$qry_sql=$link_personal->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar

			if (empty($rs_qry->empleados))
			{
				echo "<br><br> <br>                            NO EXISTE PROGRAMACION PARA ESTE USUARIO";
				exit();
				}

do{
    $programados = $rs_qry->empleados;

	$empprogramado = explode(",", $programados);



  $i = 0;

 do{

    ?>
<table width="982" border="3" align="left" style="font-size: 14px;"  >
    <tr>

      <td width="153"><A href="../eval_desempeno/muestra_datos.php?evaluador=<?php echo $evaluador;?>&empleado=<?php $empprogramado1 = explode("-", $empprogramado[$i]);
						 echo $empprogramado1[0];?>"> <?php echo $empprogramado1[0]; ?></A></td>
       <td width="515"><?php
						  echo  $empprogramado1[1]; ?></td>

      <td width="288"><?php echo $rs_qry->fecha_limite; ?></td>
    </tr>
  </table>
<p>&nbsp;</p>
  </p>



<?php

  $i = $i+1;
 }

//while($rs_qry=$qry_sql->fetch_object());
while($i<count($empprogramado));

 }

while($rs_qry=$qry_sql->fetch_object());

?>
</form>
<table width="982" border="3" align="left" style="font-size: 14px;"  >
    <tr>
  <td> Imprimir Evaluacion
    <input type="button" name="imprimir" id="imprimir" value="Imprimir" onclick="paraimpimir()" />
</td>
  </tr>
  </table>
</body>
</html>
