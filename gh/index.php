<?php
session_start(); //Iniciamos o Continuamos la sesion
if (isset($_POST['aval'])) //Si llego un Nickname via el formulario lo grabamos en la Sesion
{
	$_SESSION['aval'] = $_POST['aval']; //Nickname Grabado
}
?>
<!DOCTYPE html>
<html lang="es">
 <head>
<title>Activity manager .::ares::.</title>
<meta charset="utf-8" />
<link rel="stylesheet" href="css/estilos.css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<style type='text/css'>
tr:nth-child(odd) {
    background-color:#f2f2f2;
}
tr:nth-child(even) {
    background-color:#fbfbfb;
}
</style>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script>
  $(function() {
    $( "#tabs" ).tabs({
	 heightStyle: "fill",
	 active: 7
	});
  });
  </script>
  <script>
         $(document).ready(function(e) 
		 {        
     
				$('#aval').on('keypress', function(tecla)
				{ 
				    if (tecla.which === 13) 
					{ 
						var aval=$('#aval').val() 
						
						if(aval=="")
						{
							$('#validador').html("<span style='font-family:Verdana; color:#FF8000; font-size:10px'><b>igite un numero de cedula valida</b></span>");
							document.getElementById('aval').focus();
							return false
						}
								
						
						var parametros = {"aval": aval,};
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
								if(response!="")
								document.getElementById('formularios').style.display="block";
								//$("#mostrar").html(response);
								
								
							}
						});
					}
				});						
        });
        </script>


</head>

<body>
    <header>
       <h4>
       <table width="100%" border="0" cellpadding="0" cellspacing="0"><tr style="background-color:transparent">
         <td width="16%" height="46" align="center"><img src="img/logo-gh.png" width="222" height="74"></td>
         <td width="10%" align="left">&nbsp;</td>
         <td align="center"><span style="color: #00B7F0; font-size:18px" >Ingrese documento de identidad:</b>
           <input name="aval" type="text" id="aval"   / > 
          </a></span></td>
         <td width="25%" align="right"><img src="img/maxicassa.png" width="279" height="44"></td>
       </tr>
       </table><div id="mostrar"></div>
	  </h4>
	</header>
    <div id="formularios" style="display:none">;
    <div id="tabs" style="font-family:Verdana, Geneva, sans-serif; font-size:10px; margin-top:100px; overflow:hidden;">
     	<ul>
    		<li><a href="#tabs-0">Solicitud de Permisos</a></li>
            <li><a href="#tabs-1">Solicitud de Vacaciones</a></li>
    		<li><a href="#tabs-2">Reporte de Incapacidades</a></li>
       
  		</ul>
        
        <div id="tabs-0">
    	  <iframe src="../permisos/formato_permiso.php" style="width:100%; height:100%; border:none; overflow:auto;">
          </iframe> 
  		</div>
        
        <div id="tabs-1">
    	  <iframe src="../vacaciones/formato_vacaciones.php" style="width:100%; height:100%; border:none; overflow:auto;">
          </iframe> 
  		</div>
        
        <div id="tabs-2">	
    	  <iframe src="../incapacidades/formato_rep_incapacidad.php" style="width:100%; height:50%; border:none; overflow:auto;">
          </iframe> 
  		</div>
    </div>
</div>    
    <footer>
        
    </footer>
</body>
</html>
<?php
//}
?>