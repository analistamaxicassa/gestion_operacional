<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Leer archivo file cisa</title>
<script type="text/javascript" src="../js/jquery-ui-1.10.2.custom/js/jquery-1.9.1.js"></script>
<script>
function habilitar()
{
	document.getElementById('tipo_0').disabled=false;
	document.getElementById('tipo_1').disabled=false;
}

function activar()
{
	document.getElementById('enviar').disabled=false;
}
</script>

</head> 
<form method="post" action="leerarchivos.php" enctype="multipart/form-data">
<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
<br><br><br>
<?php session_start(); //echo $_SESSION['numero'];?>
<table width="719" border="0" align="center">
  <tr>
    <td colspan="2" align="center" bgcolor="#D8D8D8"><p style="font-weight: bold">CARGAR ARCHIVOS QUERYX A G&amp;G</p></td>
  </tr>
  <tr>
    <td width="246" height="44" align="center"><p>Empresa
        <select name="empresa" id="empresa" onchange="habilitar();">
        <option>Seleccione</option>
        <option value="CERA">Ceramigres</option>
        <option value="MAX">Maxceramica</option>
        <option value="PEGO">Pegomax</option>
        <option value="TUC">TuCassa</option>
      </select>
    </p></td>
    <td width="463" align="center">&nbsp;Archivo a insertar:
          <input type="radio" name="tipo" value="ENC" id="tipo_0" disabled="disabled"/>
          Encabezado
          <input type="radio" name="tipo" value="DET" id="tipo_1" disabled="disabled"/>
  Detalle      </tr>
  <tr>
    <td height="44" colspan="2" align="center"><hr><br>
      <input type="file" name="archivo" id="archivo" onchange="activar();"/>
&nbsp;
<input type="submit" name="enviar" id="enviar" value="Procesar cruce de información" disabled="disabled" /><br><br>
<div id="documento">
</div>
</td>
  </tr>
  <tr>
    <td colspan="2" align="center" bgcolor="#D8D8D8"><span style="color: #F00">NOTA:</span> Antes de ejecutar la acción verifique que el archivo exista.</td>
  </tr>
</table>
</body>
</form>
</html>