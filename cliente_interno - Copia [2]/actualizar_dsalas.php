
<?php 
session_start();

//error_reporting(0);
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
$sala= $_REQUEST['sala'];





if($_SESSION['us'] == '1') {
	
	?>
	
	  <script>
		alert( "USTED NO TIENE PERMISOS PARA INGRESAR A ESTA SECCION")
		
	location.href="selecciona_sala.php?sala=<?php echo $sala ?>"
	
	  </script>
      <?php
	exit();
	}

	//consulta tabla salas
	 $sql1="SELECT * FROM `salas` where activo = '1' and cc = '$sala' ";
			$qry_sql1=$link->query($sql1);
			$rs_qry1=$qry_sql1->fetch_object();  ///consultar 


?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CLIENTE INTERNO</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
 
<link rel="stylesheet" type="text/css" href="../estilos.css"/>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <script>
   function guardardsala (sala, nombre, tipo_sala, localidad, presupuesto, jefe_operacion, activo)
        {	
				var parametros = {
				"sala": sala,
				"nombre": nombre,
				"tipo_sala": tipo_sala,
				"localidad": localidad,
				"presupuesto": presupuesto,
				"jefe_operacion": jefe_operacion,
				"activo": activo,
				};
                $.ajax({
                data: parametros,
                url: 'guardardsala.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
						//alert("P R O C E S A D O")
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta").html(response);
						document.getElementById('guardar').disabled=true;
									
						
                    }
        
        });
        }
		  </script>

 <script>
   function crearsala (ccnuevo, nombre, tipo_sala, localidad, presupuesto, jefe_operacion)
        {	alert(ccnuevo);
				var parametros = {
				"ccnuevo": ccnuevo,
				"nombre": nombre,
				"tipo_sala": tipo_sala,
				"localidad": localidad,
				"presupuesto": presupuesto,
				"jefe_operacion": jefe_operacion,
				
				};
                $.ajax({
                data: parametros,
                url: 'crearsala.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
						//alert("P R O C E S A D O")
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta").html(response);
						document.getElementById('crear').disabled=true;
									
						
                    }
        
        });
        }
		  </script>          <script>
   function limpiar ()
        {	
			 	document.getElementById('nombre').value = ""
            	document.getElementById('tipo_sala').value = ""
            	document.getElementById('localidad').value = ""
            	document.getElementById('presupuesto').value = ""
            	document.getElementById('jefe_operacion').value = ""
				document.getElementById('activo').value = "1";
        }
		  </script>
          
          
</head>
<body>


      
<div id="respuesta"></div>

<div id="accordion">
  
<h2>ACTUALIZACION DE DATOS DE SALAS</h2>
  <div>
    <p>
    <table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="80%" height="82%">
    
	<A href="selecciona_sala.php?sala=<?php echo $sala?>">REGRESAR</A>
    
      
         <tr>
           <td height="27" colspan="4" align="left" valign="middle" class="encabezados"><strong>Centro de costo</strong></td>
           <td class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><label for="cc"></label>
           <input type="submit" name="cc" id="cc" onClick="limpiar()"  value="NUEVA">
           <label for="ccnuevo"></label>
           <input name="ccnuevo" type="text" id="ccnuevo" size="5"></td>
         </tr>
         <tr>
          
           <td height="27" colspan="4" align="left" valign="middle" class="encabezados"><strong>Nombre</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"> <label for="nombre"></label>
      <input name="nombre" type="text" id="nombre" size="100" value="<?php echo utf8_encode($rs_qry1->nombre); ?>"></td>  
     </tr>
      <tr>
       
      <td height="26" colspan="4" align="left" valign="middle" bgcolor="#999999" class="encabezados"><strong>Tipo de sala</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><label for="tipo_sala"></label>
        <input name="tipo_sala" type="text" id="tipo_sala" size="100" value="<?php echo utf8_encode($rs_qry1->tipo_sala); ?>"></td>
     </tr>
      <tr>
       
      <td height="32" colspan="4" align="left" valign="middle"  bgcolor="#999999" class="encabezados"><strong>Localidad</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><input name="localidad" type="text" id="localidad" size="100" value="<?php echo utf8_encode($rs_qry1->localidad); ?>"></td>
     </tr>

      <tr>
    
      <td height="26" colspan="4" align="left" valign="middle" class="encabezados"><strong>Presupuesto</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><label for="presupuesto"></label>
       
        <input type="text" name="presupuesto" id="presupuesto" size="100" value="<?php echo utf8_encode($rs_qry1->presupuesto); ?>"></td> 
     </tr>
      <tr>
    
      <td height="52" colspan="4" align="left" valign="middle" class="encabezados"><strong>Jefe de operacion</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><label for="jefe_operacion"></label>
      
        <input type="text" name="jefe_operacion" id="jefe_operacion" size="100" value="<?php echo utf8_encode($rs_qry1->jefeoperacion); ?>"></td> 
  </tr>
  <tr>
     
      <td height="73" colspan="4" align="left" valign="middle" class="encabezados"><strong>Activo</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><label for="jefe_operacion"></label>
      
        <input type="text" name="activo" id="activo" size="100" value="<?php echo utf8_encode($rs_qry1->activo); ?>"></td> 
  </tr>
   <tr>

   
        <td class="header" colspan="6" align="center" valign="middle"><input align="right" name="guardar" type="button" class="botones" onclick= "guardardsala(<?php echo($sala); ?>,  $('#nombre').val(),  $('#tipo_sala').val(), $('#localidad').val(), $('#presupuesto').val(), $('#jefe_operacion').val(), $('#activo').val());" id="guardar" value="GUARDAR" />
        <input align="right" name="crear" type="button" class="botones" onclick= "crearsala($('#ccnuevo').val(),  $('#nombre').val(),  $('#tipo_sala').val(), $('#localidad').val(), $('#presupuesto').val(), $('#jefe_operacion').val());" id="crear" value="GUARDAR NUEVA SALA" /></td>
  </tr>
</table>

    </p>
  </div>
</div>
                
<footer style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold">

 </footer>
 
 

