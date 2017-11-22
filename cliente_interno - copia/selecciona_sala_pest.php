<?php

//recojo variables
$sala=$_POST['sala'];


//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
//$hoy=date("Y-m-d");

?>			
<!DOCTYPE html>
<html lang="es">
 <head>
<title>Cliente Interno .::ares::.</title>
 <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Activity manager .:ares:.</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="../estilos.css"/>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <script>
  $(function() {
    $( "#tabs" ).tabs({
	heightStyle: "fill",
	active: 7
	});
  });
</script>

</head>
 <body>
     <div id="tabs" style="font-family:Verdana, Geneva, sans-serif; font-size:10px; margin-top:0px; overflow:hidden">
     	<ul>
    		<li><a href="#tabs-0">Datos Personales</a></li>
            <li><a href="#tabs-1">Datos Laborales</a></li>
    		<li><a href="#tabs-2">Calificacion</a></li>
  		</ul>
        
        <div id="tabs-0">
    	 <iframe src="datos_personales.php?sala=<?php echo $sala;?>" style="width:100%; height:100%; border:none; overflow:auto;">
          </iframe> 
  		</div>
        
        <div id="tabs-1">
    	 <iframe src="datos_laborales.php?sala=<?php echo $sala;?> " style="width:100%; height:100%; border:none; overflow:auto;">
          </iframe> 
  		</div>
        
        <div id="tabs-2">
    	 <iframe src="calificacion.php?sala=<?php echo $sala;?>" style="width:100%; height:100%; border:none; overflow:auto;">
          </iframe> 
  		</div>
    </div>
    <footer>
        
    </footer>
</body>
</html>