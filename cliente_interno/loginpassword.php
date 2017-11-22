<?php
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
$usuario = $_POST['usuario'];

	
	//consulta USUARIO

				
	$sql1="SELECT password FROM `autentica_ci` WHERE cedula = '$usuario'";
			$qry_sql1=$link->query($sql1);
			$rs_qry1=$qry_sql1->fetch_object();  ///consultar 


if (empty($rs_qry1)) {
    echo 'La cedula digitada no esta registrada en la plataforma, verifique';
	exit();
				}			
				
				
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
 		function modificarclave(usuario, anterior, nueva)
		{ 
			var parametros = {
				"usuario": usuario,
				"anterior": anterior,
				"nueva": nueva,
				};
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/cliente_interno/cambiarpassword.php',
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
   
    </header>

 
    <table height="84" align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:#FFF;">
    <tr style="background-color:#3B5998">
    	<td>Clave Anterior</td><td><input type="text" id="anterior"></td>
    </tr>
    <tr style="background-color:#3B5998">
    	<td>Nueva Clave:</td><td><input type="password" id="nueva"></td>
    </tr> 
      <tr>
    	<td</td><td></td>
        
    </tr>
      <tr>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" name="aceptar" id="aceptar" value="Aceptar" onclick= "modificarclave(<?php echo($usuario); ?>,  $('#anterior').val(),  $('#nueva').val());" ></td>
      </tr>
      <tr>
    	
    </tr>    
    </table> 

    <div id="validador"></div>
    </div>
    </center>
<br>
    
    <footer>
    
    </footer>
</body>
</html>