<?php
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();


	session_start();
	$usuingreso= $_SESSION['ced'];
?>	

<!DOCTYPE html>
 
<html lang="es">
 
<head>
<title>CLIENTE INTERNO</title>
<meta charset="utf-8" />

<link rel="stylesheet" type="text/css" href="../estilos1.css">

  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script>
        $(document).ready(function(e) {        
     
				$('#password').on('keypress', function(tecla)
				{ 
				   if (tecla.which === 13) 
					{ 
						var usuario=$('#usuario').val() 
						var password=$('#password').val()
							if(usuario=="" || password=="")
							{
								$('#validador').html("<span style='font-family:Verdana; color:#FF8000; font-size:10px'><b>Los campos usuario o password, no pueden estar vacios</b></span>");
								document.getElementById('usuario').focus();
								return false
							}
				
					 var parametros = {
					 "usuario": usuario,
					 "password": password,};
					 $.ajax({
					 data: parametros,
					 url: 'validarusuario.php',
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
			});
        });
		
		$(document).ready(function(e) 
		{        
			$('#tik').on('keypress', function(tecla)
			{ 
				if (tecla.which === 13) 
				{ 	
					var tk = $('#tik').val();
					
						var parametros = {
                		"tk": tk,};
                			$.ajax({
								data: parametros,
								url: 'tickets/gestion/trazabilidad_usu.php',
								type: 'post',
								beforeSend: function () 
								{
									$("#validador").html("Validando, espere por favor...");
								},
					
								success: function (response) 
								{
									$("#validador").html("");
									$("#intro").hide();
									$("#trazab").show();	
					   			$("#trazab").html(response);	
								}
			
        					});
					}
				});
        });
		
		
		function cerrar()
		{
			location.href="login.php";
		}
		
		function cambiarclave(usuario)
		{
		if (usuario=="")
				{
		alert ("ES NECESARIO LLENAR EL CAMPO DE USUARIO CON SU No DE CEDULA")
								document.getElementById('usuario').focus();
								return false
				}
		
				var parametros = {
				"usuario": usuario,
				};
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/cliente_interno/loginpassword.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#validador").html(response);
						 
					//	document.getElementById('tbl_ppal').style.display="none"
					    // document.getElementById('consultar').disabled=true;
		                //$("#validador").html(response);
					}
                    
	      });
		 
		}
		
		function olvideclave(usuario)
		{
		if (usuario=="")
				{
		alert ("ES NECESARIO LLENAR EL CAMPO DE USUARIO CON SU No DE CEDULA")
								document.getElementById('usuario').focus();
								return false
				}
		
				var parametros = {
				"usuario": usuario,
				};
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/cliente_interno/olvidopassword.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#validador").html(response);
						 
					//	document.getElementById('tbl_ppal').style.display="none"
					    // document.getElementById('consultar').disabled=true;
		                //$("#validador").html(response);
					}
                    
	      });
		 
		}
        </script>

</head>

<body>
    <header>
       <h4>
       <table width="100%" border="10" cellpadding="0" cellspacing="0">
       <tr style="background-color:transparent">
         <td width="26%" height="46"><img src="../gh/img/logo-gh.png" width="185" height="46"></td>
         <td width="50%" align="center" valign="middle"><div style="font-family:Verdana, Geneva, sans-serif; font-size:12px; width:600px; height:60px; text-align:center" class="intro_tk">
     <br>
     <b style="color:#333">CLIENTE INTERNO</b></div>
    </td>
         <td align="right">
         <img src="../gh/img/maxicassa.png" width="279" height="44">
         </td>
       </tr>
       </table>
	 </h4>
    </header>
    <div style="height:5px" class="header_base">
    </div>
    <div id="respuestalo"><div>
    <div id="trazab" style="background-color:#FFF; border:solid 1px #0CF; height:250px; width:600px; display:none; text-align:left; position:fixed; margin-top:250px; margin-left:460px"></div>
    <center>
    <div style="margin-top:200px" >
    <p><br>
      <br><br>
    </p>
    <table width="622" height="584" align="center" class="login" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:#FFF;">
      <tr style="background-color:#3B5998">
    	<td width="221" style="font-size:18px">Usuario</td><td width="389"><input height="50" width="300"  type="text" id="usuario" name="usuario"></td>
    </tr>
    <tr style="background-color:#3B5998">
    	<td style="font-size:18px">Password:</td><td><input height="50" width="300" type="password" id="password"></td>
    </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
      </tr>
      <tr>
        <td><input height="50" width="300"  title="Debe digitar el usuario" type="submit" name="cambiarclave" id="cambiarclave" onClick= "cambiarclave( $('#usuario').val())" value="Cambiar Clave"></td>
        <td><input height="50" width="300"  title="Debe digitar el usuario" type="submit" name="olvide" id="olvide"  onClick= "olvideclave( $('#usuario').val())" value="Olvide mi clave :("></td>
      </tr>
      <tr>
        <td></td>
        <td>&nbsp;</td>
      </tr>    
  </table>
    <br><br>

    <div id="validador"></div>
    </div>
</center>
<br>
    
    <footer>
    
    </footer>
</body>
</html>