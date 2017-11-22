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
        function generar(cedula, val, des)
        {	
                var certificado=$("input[name='certificado']:checked").val(); 
				var parametros = {
                "cedula": cedula,
                "certificado": certificado,
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
<div id="centro">
<table align="center">
 <tr>
    <td>
        <div id="login" style="margin-top:40px; text-align:left"> 
          <br>
          <p align="center" style="color:#039"><b>Ingrese documento de identidad:</b> <input type="text" id="cedula"  /> </p>
          <br>
          <p align="center"><b>Certificados disponibles:</b></p>
          <p>
          <input type="radio" name="certificado" value="P1" id="certificado_0" />Certificado laboral retirado sin salario
            <br />
          <input type="radio" name="certificado" value="P2" id="certificado_1" />Certificado laboral salario+aux alim promedio
            <br />
          <input type="radio" name="certificado" value="P3" id="certificado_2" />Certificado laboral salario+aux alimentacion mensual
            <br />
          <input type="radio" name="certificado" value="P4" id="certificado_3" />Certificado laboral salario+comision promedio+aux rodamiento
            <br />
          <input type="radio" name="certificado" value="P5" id="certificado_4" />Certificado laboral salario+comision promedio
            <br />
          <input type="radio" name="certificado" value="P6" id="certificado_5" />Solicitud practica examen médico de retiro
            <br />
          <input type="radio" name="certificado" value="P7" id="certificado_6" />Retiro de Cesantias parcial $
          <label for="valorcentias"></label>
            <input type="text" id="valorcesantias" size="15" />
            Destino
            <label for="destinocesantias"></label>
            <input type="text" id="destinocesantias" size="20" />
            <br />
            <input type="radio" name="certificado" value="P8" id="certificado_7" />Retiro de Cesantias por Retiro
            <br />
          </p>
          <p align="center"><input type="button" value="Generar certificado" onclick="generar($('#cedula').val(), $('#valorcesantias').val(), $('#destinocesantias').val()); return false;"/></p>
          
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