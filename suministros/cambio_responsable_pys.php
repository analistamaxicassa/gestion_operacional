<?php
error_reporting(0);

session_start();
$nomaval= $_SESSION['AVALADOR'];

$cedulaingreso=$nomaval;
$empleado=$_REQUEST['empleado'];

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ARES::Recursos Humanos</title>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="../estilos.css"/>

<style>
#login {
	border-radius: 20px;
	-moz-border-radius: 20px;
	-webkit-border-radius: 20px;
	height: 250px;
	width: 700px;
	padding: 10px;
	background-color:#EAEAEA;
	font-family:Verdana, Geneva, sans-serif;
	font-size:14px;
	color:#000;
}

</style>
         
 <script>

  
 function actualizar_resp(actual, nuevo) 
        {	
		
		if (actual==""){ alert ("La casilla de RESPONSABLE ACTUAL es obligatoria")
					document.getElementById('actual').focus();
					return;
					}
		if (nuevo==""){ alert ("La casilla de RESPONSABLE NUEVO es obligatoria")
					document.getElementById('nuevo').focus();
					return;
					}
		else {
				var parametros = {
				"actual": actual,
				"nuevo": nuevo,
               	};		
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/suministros/actualiza_responsable.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#validador").html(response);
                    }
        
        });
        }
			}


function llenaractual(cedulares)
{
	var parametros = {		
				"cedulares": cedulares,
				};
		$.ajax({
                data: parametros,
                url:'http://190.144.42.83:9090/plantillas/suministros/buscardatos.php', 
				    type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("	");
                    },
        
                    success: function (response) 
                    {
                        //$("#validador").html(response);
						document.getElementById("nombre_actual").value = response; //guaradr en un campo de texto
						
						
		
			
				-->		document.getElementById("nombre").value = response;	
					-->	document.getElementById("cargo").value = "ninguno";				
                    }
        
        });
		}	
	
function llenarnuevo(cedulares)
{
	var parametros = {		
				"cedulares": cedulares,
				};
		$.ajax({
                data: parametros,
                url:'http://190.144.42.83:9090/plantillas/suministros/buscardatos.php', 
				    type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("	");
                    },
        
                    success: function (response) 
                    {
                        //$("#validador").html(response);
						document.getElementById("nombre_nuevo").value = response; //guaradr en un campo de texto
						
						
		
			
				-->		document.getElementById("nombre").value = response;	
					-->	document.getElementById("cargo").value = "ninguno";				
                    }
        
        });
		}	
</script>
        
        
</head>

<body>
<div id="centro">

       
  <table width="789" height="241" align="center" class="tablas">
 <tr>
    <td>
        <div class="formulario" id="login" style="margin-top: 40px"> 
          <table width="90%" border="1" align="center">
            <tr>
              <th scope="col">Asignar Elementos a otro empleado</th>
            </tr>
          </table>
          <p><br>
            <b>Cedula Responsable Actual:</b>
            <label for="resp_actual"></label>
            <input name="resp_actual" type="text" style="background-color:#999" id="resp_actual" onChange="llenaractual(this.value);"  value="<?php echo $empleado; ?>" size="15" />
            <label for="nombre_actual"></label>
          </p>
          <p>
            <b> Cedula Responsable Nuevo: </b>
            <label for="resp_nuevo"></label>
            <input name="resp_nuevo" type="text" id="resp_nuevo" size="15" onChange="llenarnuevo(this.value);" />                    
            <label for="nombre_nuevo"></label>
            <input name="nombre_nuevo" type="text" id="nombre_nuevo" size="60" />
          </p>
          <p align="center" style="color:#039">          
          <p align="center" style="color:#039"><span style="text-align: left; font-size: 16px; color: #00C; font-family: Tahoma, Geneva, sans-serif;"><br />
            <br />
            </span>
          
          <p align="center"><input name="generar" type="button" id="generar" onclick="actualizar_resp($('#resp_actual').val(),$('#resp_nuevo').val(), '<?PHP echo $cedulaingreso;?>'); return false;" value="ACTUALIZAR" class="botones"/></p>
          
        </div>
    </td>
 </tr>
</table>
</div>
<center>
<div id="validador" style="font-family:Verdana, Geneva, sans-serif; width:50%; text-align:center">

</div>
  
</center>

</body>
</html>