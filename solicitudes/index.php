<?php 

//error_reporting(0);
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
	width: 500px;
	padding: 10px;
	background-color:#EAEAEA;
	font-family:Verdana, Geneva, sans-serif;
	font-size:14px;
	color:#000;
}

.text {font-family:Verdana, Geneva, sans-serif;
	   font-size:11px;
}
</style>

<script>
        function generar(aval)
		  {//	alert(document.getElementById("nombre").value);
		  
		  if (aval==""){ alert ("El numero de cedula del empleado es obligatoria")
					document.getElementById('aval').focus();
					return false;
					}
		  
		  
		  
		        document.getElementById("generar").hidden = 'true';
				var certificado=$("input[name='certificado']:checked").val(); 
		
			
				var parametros = 
				{
                "aval": aval,
				};
				//alert(certificado);
				if (certificado == 'P1')
				{
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/permisos/formato_permiso.php',
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
		if (certificado == 'P3')
				{
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/incapacidades/formato_rep_incapacidad.php',
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
		if (certificado == 'P2')
				{
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/vacaciones/formato_vacaciones.php',
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
		if (certificado == 'P4')
				{
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/actualiza_hijos/formato_actualiza.php',
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
		
		if (certificado == 'P5')
				{
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/vacaciones/impresion_vacaciones_autorizadas.php',
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
		if (certificado == 'P6')
				{
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/incapacidades/formato_rep_incapacidad_temp.php',
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
		
		if (certificado == 'P7')
				{
				var parametros = 
				{
                "avalempleado": aval,
				};
					
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/eval_desempeno/avalarevaluador.php',
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
		
		if (certificado == 'P8')
				{
				var parametros = 
				{
                "avalempleado": aval,
				};
					
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/permisos/registro_llegada_permiso.php',
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
		
		if (certificado == 'P9')
				{
				var entrev =prompt ("Digite la cedula de quien realiza la entrevista")
				
				var parametros = 
				{
                "avalempleado": aval,
                "entrev": entrev,
				};
					
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/formato_desempeno/muestra_datos.php',
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
		
		
		
		
		
		} //final 
		     </script>
        
        
        <script>

  
			
			
function buscaremp()
{
	window.open("http://190.144.42.83:9090/plantillas/suministros/buscar_empleado.php", "Buscar empleado", "width=800, height=500")
			
}

</script>
<script>			
				
		 $(function () {
     $("#f_nacimiento" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  yearRange: '-100:+0'
       });
    });
	
function llenar(cedulares)
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
							
						
						document.getElementById("nombre").value = response; //guaradr en un campo de texto
					//	alert ("Seleccione una opcion");
								
					
			
				-->		document.getElementById("nombre").value = response;	
					-->	document.getElementById("cargo").value = "ninguno";				
                    }
        
        });
		}	

function revisar()
{
	if (nombre=="NO"){ 
	alert ("La casilla FECHA DE PERMISO es obligatoria")
							document.getElementById('nombre').focus();
							return false;
							}
}

</script>



        
</head>

<body>
<div id="centro">

<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>
         <td width="16%" height="46" class="encabezados" align="center"><img src="../gh/img/logo-gh.png" width="257" height="108"></td>
    <td width="100" align="center" class="encabezados">SOLICITUDES DE GESTION HUMANA</td>
         <td width="25%" align="right"><img src="../gh/img/maxicassa.png" width="316" height="98" class="formulario"></td>
       </tr>
       </table>
       
  <table width="989" height="141" align="center" class="tablas"  id="login">
 <tr height="200">
    <td >
        <div class="formulario"  style="margin-top: 40px" > 
          <br>
          <p align="center" style="color:#039"><b>Ingrese N° de cedula del empleado:</b>
            <input  name="aval" type="text" class="textbox" id="aval" onChange="llenar(this.value);"  /> 
           
            <span class="text">
            <input type="submit" name="buscarnombre" id="buscarnombre" value="Listado de empleados" onclick="buscaremp()" />
            </span>
          <p align="center" style="color:#039">
            <label>
              <input  style="color:#F00"  name="nombre" border="0" type="text" id="nombre" size="70" readonly="readonly" />
            </label>          
          <p>Seleccione una opcion:          </p>
          <p><span style="text-align: left; font-size: 16px; color: #00C; font-family: Tahoma, Geneva, sans-serif;">
            <input name="certificado" type="radio" class="botones" id="certificado_0" value="P1" />
           Solicitud de permiso</span></p>
          <p><span style="text-align: left; font-size: 16px; color: #00C; font-family: Tahoma, Geneva, sans-serif;">
            <input name="certificado" type="radio" class="botones" id="certificado_4" value="P8" />
          <!--Reporte de llegada y soporte de permiso--></span></p>
          <p><span style="text-align: left; font-size: 16px; color: #00C; font-family: Tahoma, Geneva, sans-serif;">
            <input style="visibility:hidden" name="certificado" type="radio" class="botones" id="certificado_1" value="P2" />
          </span><span style="text-align: left; font-size: 16px; color: #00C; font-family: Tahoma, Geneva, sans-serif;">
            <input style="visibility:hidden"  name="certificado" type="radio" class="botones" id="certificado_2" value="P5" />
            
            <!-- Impresion de Vacaciones Autorizadas--><br />
            <input  name="certificado" type="radio" class="botones" id="certificado_2" value="P6" />
          Reporte de Ausencia Temporal      </span></p>
          <p><span style="text-align: left; font-size: 16px; color: #00C; font-family: Tahoma, Geneva, sans-serif;">
            <input  name="certificado" type="radio" class="botones" id="certificado_2" value="P3" />
          Reporte de incapacidades</span></p>
          <p><span style="text-align: left; font-size: 16px; color: #00C; font-family: Tahoma, Geneva, sans-serif;">
            <input  name="certificado" type="radio" class="botones" id="certificado_2" value="P9" />
          </span><span style="text-align: left; font-size: 16px; color: #00C; font-family: Tahoma, Geneva, sans-serif;">Evaluacion de desempeño</span></p>
         
          <p><span style="text-align: left; font-size: 16px; color: #00C; font-family: Tahoma, Geneva, sans-serif;">
            <input   name="certificado" type="radio" class="botones" id="certificado_3" value="P4" />
 Actualizar informacion de hijos</span></p>
          <p>&nbsp;</p>
          <p align="center"><input name="generar" type="button" id="generar" onclick="generar($('#aval').val()); return false;" value="ACTUALIZAR" class="botones"/></p>
          
        </div>
    </td>
 </tr>
</table>
</div>
<center>
<div id="validador" style="font-family:Verdana, Geneva, sans-serif; width:80%; ">

</div>
   <input type="button" value="Imprimir certificado" id="prn" onclick="imprSelec('validador');"  style="display:none"/>
</center>

</body>
</html>