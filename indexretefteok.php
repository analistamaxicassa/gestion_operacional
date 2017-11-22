<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Generador de Certificados</title>
<style>
#login {
	border-radius: 20px;
	-moz-border-radius: 20px;
	-webkit-border-radius: 20px;
	height: 350px;
	width: 700px;
	padding: 10px;
	background-color:#EAEAEA;
	font-family:Verdana, Geneva, sans-serif;
	font-size:14px;
	color:#000;
}

</style>
<link rel="stylesheet" type="text/css" href="mediaprint.css" media="print"/>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script>
        function generar(cedula, anio, mes)
        {	
				var parametros = {
                "cedula": cedula,
                "anio": anio,
				"mes": mes,
				};
                $.ajax({
                data: parametros,
                url: 'certificadoretefuente2.php',
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
		
		
		 function pregenerar(cedula, anio, mes)
        {	
				var parametros = {
                "cedula": cedula,
                "anio": anio,
				"mes": mes,
				};
                $.ajax({
                data: parametros,
                url: 'certificadoretefuente1.php',
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
<table align="center">
 <tr>
    <td>
        <div id="login" style="margin-top:40px; text-align:left"> 
          <br>
          <p align="center" style="color:#039"><b>Ingrese documento de identidad:</b> <input type="text" id="cedula"  /> </p>
          <br>
          <p align="center"><b>Certificados Retencion en la fuenta:</b></p>
          <p><br />
          <center>
          Año (AAAA)
          
            <input type="text" id="anio" size="15" />
            mes (M)
            
            <input type="text" id="mes" size="20" />
            
            </center><br />
            <br />
          </p>
          <p align="center">
            <input type="button" value="Generar certificado" onclick="generar($('#cedula').val(), $('#anio').val(), $('#mes').val()); return false;"/>
          </p>
          <p align="center">&nbsp;</p>
          <p align="center">
            <input type="button" value="Generar PRE certificado" onclick="pregenerar($('#cedula').val(), $('#anio').val(), $('#mes').val()); return false;"/>
          </p>
          
        </div>
    </td>
 </tr>
</table>
</div>
<br><br>
<center>
<div id="validador">
<br>
</div>
   <input type="button" value="Imprimir certificado" id="prn" onclick="imprSelec('validador');"  style="display:none"/>
</center>

</body>
</html>