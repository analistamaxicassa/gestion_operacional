<link rel="stylesheet" type="text/css" href="../estilos.css"/>

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
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script>
        function generar(cedula, sucesion, val, des)
        {	
                var certificado=$("input[name='certificado']:checked").val(); 
				var parametros = {
                "cedula": cedula,
                "certificado": certificado,
				"sucesion": sucesion,
				"val": val,
				"des": des,
				};
                $.ajax({
                data: parametros,
                url: 'certificadolaboral.php',
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
<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>
         <td width="16%" height="46" class="encabezados" align="center"><img src="gh/img/logo-gh.png" width="281" height="122"></td>
    <td width="100" align="center" class="encabezados">PROCESO DE GESTION HUMANA</td>
         <td width="25%" align="right"><img src="gh/img/maxicassa.png" width="398" height="74" class="formulario"></td>
       </tr>
       </table>


<div id="centro">
  
  <table align="center" class="formulario">
 <tr class="encabezados">   
    <td class="formulario">
        <div id="login" style="margin-top:40px; color:#FFF text-align:left"><br>
          <p align="center" style="color:#039"><b>Ingrese documento de identidad:</b>
           <input type="text" class="textbox" id="cedula"  /> 
          <p align="center"><b>Sin sucesion</b>
            <input type="text" id="sucesion" size="1"  /> 
            <br>
          <p align="center"><b>Certificados disponibles:</b></p>
          <p>
          <input name="certificado" type="radio" class="botones" id="certificado_0" value="P1" />Certificado laboral retirado sin salario
            <br />
          <input name="certificado" type="radio" class="botones" id="certificado_1" value="P2" />Certificado laboral salario+aux alim promedio
            <br />
          <input name="certificado" type="radio" class="botones" id="certificado_2" value="P3" />Certificado laboral salario+aux alimentacion mensual
            <br />
          <input name="certificado" type="radio" class="botones" id="certificado_3" value="P4" />Certificado laboral salario+comision promedio+aux rodamiento
            <br />
          <input name="certificado" type="radio" class="botones" id="certificado_4" value="P5" />Certificado laboral salario+comision promedio
            <br />
            <input name="certificado" type="radio" class="botones" id="certificado_8" value="P9" />Certificado laboral salario+comision promedio+aux Alimentacion
            <br />
             <input name="certificado" type="radio" class="botones" id="certificado_9" value="P10" />Certificado laboral salario+aux Alimentacion+aux rodamiento
            <br />
          <input name="certificado" type="radio" class="botones" id="certificado_5" value="P6" />Solicitud practica examen médico de retiro
            <br />
          <input name="certificado" type="radio" class="botones" id="certificado_6" value="P7" />Retiro de Cesantias parcial $
          <label for="valorcentias"></label>
            <input type="text" class="textbox" id="valorcesantias" size="15" />
            Destino
            <label for="destinocesantias"></label>
            <input type="text" class="textbox" id="destinocesantias" size="20" />
            <br />
            <input name="certificado" type="radio" class="botones" id="certificado_7" value="P8" />Retiro de Cesantias por Retiro
            <br />
          </p>
          <p align="center">&nbsp;</p>
          <p align="center">
            <input type="button" class="botones" onclick="generar($('#cedula').val(),  $('#sucesion').val(), $('#valorcesantias').val(), $('#destinocesantias').val()); return false;" value="Generar certificado"/>
          </p>
          
        </div>
    </td>
 </tr>
</table>
</div>
<br><br>
<center>
<div id="validador" style="font-family:Verdana, Geneva, sans-serif; width:50%;">
</div>
   <input type="button" value="Imprimir certificado" id="prn" onclick="imprSelec('validador');"  style="display:none"/>
</center>

</body>
</html>