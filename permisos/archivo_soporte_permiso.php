<link rel="stylesheet" type="text/css" href="../estilos.css"/>

<?php



//error_reporting(0);
//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

//recojo variables

//$cedula=$_POST['avalempleado'];
//$cedula='52522883';


?>	
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="../estilos.css"/>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reporte de llegada</title>


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
  <br>
    <br>
  <table width="961" border="1" align="left" >
    <tr align="center">
      <td width="927" height="30">&nbsp;</td>
    </tr>

  <tr class="formulario">
    <td height="22" class="encabezados"><b>ADJUNTE LA DOCUMENTACION SOPORTE DEL PERMISO</b></td>
  </tr>
  <tr class="formulario">
    <td height="22"><p><b>El nombre del archivo debe ser renombrado asi: (No. Cedula)-(Fecha de permiso) </b></p>
      <p><b>EJ: 79852258-31-JUL-2017</b></p>
        
      <form action="http://190.144.42.83:9090/plantillas/solicitudes/guardar_archivo_permiso.php" method="post" enctype="multipart/form-data">
Seleccione el archivo:
  <input name="archivo" type="file" class="textbox" id="archivo" />
  <input type="submit" class="botones" value="Guardar" />
  <br>
<br>
     </form>
     
      
      <br />
      <br /></td>
  </tr>
  <tr class="formulario">
    <td height="22">&nbsp;</td>
  </tr>
</table>
</body>
</html>
