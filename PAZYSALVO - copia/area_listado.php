<link rel="stylesheet" type="text/css" href="../estilos.css"/>


<?php

//funcion fechas
require_once("FuncionFechas.php");
//$i= 0;


?>	
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script>
		 function consultar(area)
        {	
				var parametros = {
				"area": area,
				};
                $.ajax({
                data: parametros,
                url: 'listado.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta").html(response);
						
						
                    }
        
        });
        }
		
		
		
        </script>
        
</head>
<body style="font-family:Verdana, Geneva, sans-serif; font-size:16px">

 <table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>
         <td width="16%" height="46" class="encabezados" align="center"><img src="../gh/img/logo-gh.png" width="260" height="92"></td>
    <td width="100" align="center" class="encabezados">PROCESO DE GESTION HUMANA</td>
         <td width="25%" align="right"><img src="../gh/img/maxicassa.png" width="268" height="98" class="formulario"></td>
       </tr>
       </table>

  <br>
    <br>
  <table width="830" border="1" align="center" class="formulario" style="border-collapse:collapse">
    <tr>
      <td colspan="6" align="center" valign="middle" class="encabezados">
        <label><strong>PAZ Y SALVO</strong></label>
      </td>
    </tr>
    <tr>
      <td width="86">&nbsp;</td>
      <td width="145" colspan="3">
        <select name="area" size="1" id="area">
        <option value="todos">mostrar paz y salvos.....</option>
          <option value="vb_contabilidad">CONTABILIDAD CENTRAL</option>
          <option value="vb_cartera">CARTER</option>
          <option value="vb_sistemas">SISTEMAS Y TECNOLOGIA</option>
          <option value="vb_infraestructura">COMUNICACIONES</option>
          <option value="vb_auditoria">AUDITORIA</option>
          <option value="vb_ghumana">GESTION HUMANA</option>
          <option value="vb_femcrecer">FEMCRECER</option>
          <option value="vb_nomina">NOMINA</option>
          <option value="vb_sala">ADMIN SALA</option>
          <option value="vb_contapego">CONTABILIDAD PEGOMAX</option>
          <option value="vb_containno">CONTABILIDAD INNOVAPACK</option>
          <option value="vb_produccion">PRODUCCION</option>
          <option value="vb_despachos">DESPACHOS</option>
          <option value="vb_adminpego">ADMIN PEGOMAX</option>
          <option value="vb_gcomercialpego">GERENCIA COMERCIAL PEGO</option>
          
      </select></td>
      <td width="104"><input name="consultar" type="button" class="botones" id="consultar" onClick="consultar($('#area').val()); return false;" value="CONSULTAR" /></td>
      <td width="521">
      <div id="validador"></div></td>
    </tr>
    <tr>
      <td colspan="6"><div id="respuesta"></div></td>
    </tr>
    <tr>
      <td colspan="6">&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <label ></label>
  <p>&nbsp;</p>
  <label></label>
  <p>&nbsp;</p>
  <label></label>
  <p>&nbsp;</p>
  <label></label>
  <br/>
  <p>&nbsp;</p>
  <label style="margin-left:100px;width:210px;"></label> 
</form>
</body>
</html>
