<link rel="stylesheet" type="text/css" href="../estilos.css"/>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Generador de Certificados</title>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script>
    
		 function crear(cedula, fretiro, mretiro, flimite, correo, correo2, pego)
        {					
				var certificado=$("input[name='certificado']:checked").val(); 

				var parametros = { 

                "cedula": cedula,
				"fretiro": fretiro,
				"mretiro": mretiro,
				"flimite": flimite,
				"correo": correo,
				"correo2": correo2,
				"pego": pego,								
				"certificado": certificado,
               	};
                $.ajax({
                data: parametros,
                url: 'pazysalvo.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#validador").html(response);
						document.getElementById('prn').style.display="block";
						
                    }
        
        });
        }
		
		 function actualizar(cedula)
        {	
				
				var parametros = {
                "cedula": cedula,
				};
                $.ajax({
                data: parametros,
                url: 'actualizar_fecha.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#validador").html(response);
						//document.getElementById('prn').style.display="block";
						
                    }
        
        });
        }
        </script>
        
<script type="text/javascript">
function imprSelec(validador){
	var ficha=document.getElementById(validador);
    var ventimp=window.open(' ','popimpr');
	ventimp.document.write(ficha.innerHTML);
	ventimp.document.close();
	ventimp.print();
	ventimp.close();
}
</script>
</head>

<body>
<div id="centro">

<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>
         <td width="16%" height="46" class="encabezados" align="center"><img src="../gh/img/logo-gh.png" width="220" height="72"></td>
    <td width="100" align="center" >PROCESO  DE GESTION HUMANA</span></td>
         <td width="25%" align="left"><img src="../gh/img/maxicassa.png" width="207" height="71" class="formulario"></td>
       </tr>
       </table>
  <table align="center">
 <tr class="formulario">
   <td class="subtitulos" align="center"><span class="subtitulos">SOLICITUD DE PAZ Y SALVO</span></td>
 </tr>
 <tr class="formulario">
    <td align="center">
        <div class="login" id="login" style="margin-top:40px; text-align:center"> 
          <span class="subtitulos">
          <script>
		  function valor()
		  {
		  if(document.getElementById('pego').value == "0")
		  	{
			document.getElementById('pego').value = "1"
			}
		  else 
			  	{
		  document.getElementById('pego').value = "0"
		       }
			  
		  }
		  
		  </script>
          </span>
          <p align="center" style="color:#039"><span class="subtitulos"><b>Ingrese documento de identidad:</b>
            <input type="text" class="textbox" id="cedula"  />          
            <input name="pego" type="checkbox" class="botones" id="pego" onClick="valor()" value="0" />
            Pegomax</span>
          <p align="center" style="color:#039"><span class="subtitulos">            Motivo de retiro: 
            <input name="motivo_retiro" type="text" class="textbox" id="motivo_retiro" /> 
            Fecha de Retiro: 
            <input name="fecha_retiro" type="text" class="textbox" id="fecha_retiro" />
          
          </span>
          <p align="center" style="color:#039"><span class="subtitulos">Correo Sala:
            <input name="correo" type="text" class="textbox" id="correo" />
Correo adicional:       
            <input name="correo2" type="text" class="textbox" id="correo2" />
          </span>
          <p align="center" style="color:#039"><span class="subtitulos">Fecha limite:
  <input name="fecha_limite" type="text" class="textbox" id="fecha_limite" />
            
          </span>
          <p align="center" style="color:#039">          
          <p align="center" style="color:#039">          
          <p>
            <span class="subtitulos">
            <input name="certificado" type="radio" class="botones" id="certificado_0" value="P1" />
            Solicitar             
               <input name="certificado" type="radio" class="botones" id="certificado_1" value="P2" />
          Consultar
          <br />
          <br />
          </span></p>
          <p><span class="subtitulos"><br />
          
          
          
            <input name="Enviar" type="submit" class="botones" onclick=
"crear($('#cedula').val(),$('#fecha_retiro').val(),$('#motivo_retiro').val(),$('#fecha_limite').val(),$('#correo').val(),$('#correo2').val(),$('#pego').val()); return false;" value="GENERAR"/			>			
            <input name="actualizar" type="submit" class="botones"  id="actualizar"  onclick="actualizar($('#cedula').val())" value="Cambiar fecha limite a hoy" />

          </span></p>
          
        </div>
    </td>
 </tr>
 <tr>
   <td height="41" align="center">&nbsp;</td>
 </tr>
  </table>
</div>
<br><br>
<center>
<div id="validador" style="font-family:Verdana, Geneva, sans-serif; width:50%;">
</div>
   <input type="button" value="Imprimir certificado" id="prn" onClick="imprSelec('validador');"  style="display:none"/>
</center>

</body>
</html>