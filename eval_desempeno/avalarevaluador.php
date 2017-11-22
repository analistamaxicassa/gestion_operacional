<?php

//recojo variables
//$entrevistado=$_POST['avalempleado'];

?>
<link rel="stylesheet" type="text/css" href="../estilos.css"/>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script>

		function avalar (aval)
	        { 	
				var parametros = {
				"nomaval": aval,
				"empleado": <?php echo $entrevistado;?>
				};
                $.ajax({
                data: parametros,
                url: 'nombreavaladorevaldesempeno.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta").html(response);
						//document.getElementById('prn').style.display="block";
						
                    }
        });
        }
		
		</script>



</head>
<body style="font-family:Verdana, Geneva, sans-serif; font-size:14px;">
<form method="post" action="../eval_desempeno/nombreavaladorevaldesempeno.php">


  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="656" border="1" align="center" cellpadding="4" cellspacing="0"   style="border-collapse:collapse; border:solid 1px;">
    <tr class="encabezados">
      <td align="center" valign="middle"><strong>CONTROL DE ACCESO</strong></td>
    </tr>
    <tr valign="middle" class="formulario">
      <td align="center"><p class="subtitulos">Ingrese cedula del evaluador</p>
        <p>
          <input name="aval" type="text" class="textbox" id="aval" style="height:40px; font-size:19px; " onBlur="avalar(this.value)"/>        
          <label>
            <br />
            <input type="text" style="visibility:hidden" name="entrevistado" id="entrevistado" value="<?php echo $entrevistado;?>" />
          </label>
        </p>
        <p>
          <input name="ingresar" type="submit" class="botones" id="ingresar"  style="height:40px; font-size:19px; " value="INGRESAR" />
      </p></td>
    </tr>
  </table>
</form>
</body>
</html>

