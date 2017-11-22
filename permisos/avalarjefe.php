<link rel="stylesheet" type="text/css" href="../estilos.css"/>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>



</head>
<body style="font-family:Verdana, Geneva, sans-serif; font-size:14px;">
<form method="post" action="../permisos/confirma_permiso.php">
<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>
         <td width="16%" height="46" class="encabezados" align="center"><img src="../gh/img/logo-gh.png" width="257" height="108"></td>
    <td width="100" align="center" class="encabezados">SOLICITUDES DE GESTION HUMANA</td>
         <td width="25%" align="right"><img src="../gh/img/maxicassa.png" width="316" height="98" class="formulario"></td>
       </tr>
       <br>
       </table>
         <br>
           <br>

  <table width="656" border="1" align="center" cellpadding="4" cellspacing="0" class="formulario"   style="border-collapse:collapse; border:solid 1px;">
    <tr>
      <td align="center" valign="middle" bgcolor="#99FFFF"  class="encabezados"><strong>CONTROL DE ACCESO</strong></td>
    </tr>
    <tr valign="middle">
      <td align="center"><p><span style="font-size: 18px">Ingrese su cedula</span></p>
        <p>
          <input name="avaljefe" type="text" class="textbox" id="avaljefe" style="height:40px; font-size:19px; " onBlur="avaljefe(this.value)"/>        
        </p>
        <p>
          <input name="ingresar" type="submit" class="botones" id="ingresar"  style="height:40px; font-size:19px; " value="INGRESAR" />
      </p></td>
    </tr>
  </table>
</form>
</body>
</html>

