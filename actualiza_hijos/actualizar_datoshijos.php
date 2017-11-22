
<?php 

//error_reporting(0);


//recojo variables
$cedula=$_POST['cedula'];


require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

$sql2a="SELECT id, `nombre_hijo`,`apellido_hijo` FROM `hijos` WHERE `cod_empleado` = '$cedula' ";
		$qry_sql2a=$link->query($sql2a);
			$rs_qry2a=$qry_sql2a->fetch_object();  ///consultar 
			





$sql2="SELECT `id_hijo`, `nombre_hijo`,`apellido_hijo`, `genero`, `f_nacimiento`, `educacion`, `programa`, `colegio`, `grado`, `jornada`, `aficiones`, `talento` FROM `hijos` WHERE `cod_empleado` = '$cedula' ";
		$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
			
			
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
   function val_hijo(id)
        {	
				var parametros = {
				"id": id,
				};
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/actualiza_hijos/actualizar_datoshijos2.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
						//alert("P R O C E S A D O")
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta").html(response);
//						document.getElementById('guardar').disabled=true;
									
						
                    }
        
        });
        }


	  </script>

          
</head>
<body>


      


<div id="accordion">
  
<h3>ACTUALIZACION DE DATOS DE HIJOS</h3>
  <div>
    <p>
    <table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="80%" height="11%">
    
	     <tr>
          
           <td height="27" colspan="4" align="left" valign="middle" class="encabezados"><strong>Nombre</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"> <label for="nombre"></label>
        <label>
          <select name="hijos" id="hijos" onChange="val_hijo(this.value)">
          <option value="">Seleccione...</option>
          <?php    
			do  
		    {
    	    ?>
             
          <option value="<?php echo $rs_qry2a->id?>"> <?php echo $rs_qry2a->nombre_hijo." ".$rs_qry2a->apellido_hijo ?> </option>
          <?php
   		 }   while ($rs_qry2a=$qry_sql2a->fetch_object())
  		  ?>
           
          </select>
        </label></td>  
     </tr>
      <tr>
       
      
  </tr>
   <tr>

   
        <td height="16" colspan="6" align="center" valign="middle" class="header">&nbsp;</td>
  </tr>
</table>

    </p>
  </div>
</div>
 <div id="respuesta"></div>                
<footer style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold">

 </footer>
 

 
 

