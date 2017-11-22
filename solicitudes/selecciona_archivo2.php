<?php

//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

?>	
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

<link rel="stylesheet" type="text/css" href="../estilos.css"/>

<style type="text/css">
.centrar {
	text-align: center;
}
.centrar {
	text-align: center;
}
</style>
	
</head>
<body>
<blockquote>
<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>
         <td width="16%" height="46" class="encabezados" align="center"><img src="../gh/img/logo-gh.png" width="257" height="108"></td>
    <td width="100" align="center" class="encabezados">SOLICITUDES DE GESTION HUMANA</td>
         <td width="25%" align="right"><img src="../gh/img/maxicassa.png" width="316" height="98" class="formulario"></td>
       </tr>
       </table>
  <table width="880" border="1" align="left" class="formulario" >
    <tr>
    <td width="225" height="30" class="encabezados"><i>ENFERMEDAD GENERAL - ACCIDENTE DE TRABAJO </td>
      <td width="250" height="30" class="encabezados">ACCIDENTE DE TRANSITO: </td>
      <td width="239" class="encabezados" ><i>LICENCIA DE MATERNIDAD: </td>
      <td width="219" class="encabezados" >LICENCIA DE PATERNIDAD: </td>
    </tr>
    <tr align="center">
      <td height="30" align="left"><ol>
        <li>
          <h5 class="formulario">Incapacidad</h5>
        </li>
        <li>
          <h5 class="formulario">Historia clínica</h5>
        </li>
      </ol>      <p align="center">&nbsp;</p></td>
      <td height="30"  align="left"><div>
        <ol>
          <li>
            <h5 class="formulario">Incapacidad</h5>
          </li>
          <li>
            <h5 class="formulario">Historia clínica</h5>
          </li>
          <li>
            <h5 class="formulario">Informe de transito</h5>
          </li>
          <li>
            <h5 class="formulario">Copia del SOAT</h5>
          </li>
        </ol>
      </div></td>
      <td  align="left"><ol>
        <li>
          <h5 class="formulario">Incapacidad</h5>
        </li>
        <li>
          <h5 class="formulario">Historia clínica</h5>
        </li>
        <li>
          <h5 class="formulario">Registro civil</h5>
        </li>
        <li>
          <h5 class="formulario">Fotocopia de la cédula de la madre</h5>
        </li>
      </ol>      </td>
      <td  align="left"><ol>
        <li>
          <h5 class="formulario">Incapacidad </h5>
        </li>
        <li>
          <h5 class="formulario">Historia clínica de la madre</h5>
        </li>
        <li>
          <h5 class="formulario">Registro civil </h5>
        </li>
        <li>
          <h5 class="formulario">Fotocopia Cédula  del padre y de la madre</h5>
        </li>
      </ol>      </td>	
    </tr>
    <tr align="center">
      <td height="30" colspan="4" align="left" class="encabezados">ADJUNTE LA DOCUMENTACION SEGUN EL CASO</td>
    </tr>
    <tr align="center">
      <td height="30" colspan="4" align="left"><p>El nombre del archivo debe ser asignado asi: (No. Cedula)-(nombre del Documento) </p> <form action="guardar_archivoinc.php" method="post" enctype="multipart/form-data">
        <p>EJ: 79852258-incapacidad - 79852258-historiaclinica</p>
      <p>Seleccione el archivo: 
        <input type="file" name="archivo" id="archivo" />
        <input type="submit" class="botones" value="Guardar" />
        </form>
      </p>
      <form action="index.php" method="post" enctype="multipart/form-data">
        <input name="salir" type="submit" class="botones" id="salir" value="SALIR" />
      </form></td>
    </tr>
     
  </tr>
</table>
</body>
</html>
