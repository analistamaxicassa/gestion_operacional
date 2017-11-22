<?php 

//error_reporting(0);
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
	
	//consulta tabla ED_DEF_ASPECTOS
 	$sql1="SELECT * FROM ed_def_aspectos";
			$qry_sql1=$link->query($sql1);
			$rs_qry1=$qry_sql1->fetch_object();  ///consultar 


//conexion
try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit();
		}
		
		$queryx = "SELECT CARGO_CODIGO, CARGO_NOMBRE FROM CARGO order by CARGO_NOMBRE ";
		$stmt = $dbh->prepare($queryx);
		$stmt->execute();
		$row_n = $stmt->fetch();
		
	


	
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EVALUACION DE DESEMPEÑO</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
 
<link rel="stylesheet" type="text/css" href="../estilos.css"/>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <script>
   function guardaroperacion (cargo, aspecto, operacion, perfil, opcion)
        {	alert (opcion);
				var parametros = {
				"cargo": cargo,
				"aspecto": aspecto,
				"operacion": operacion,
				"perfil": perfil,
				"opcion": opcion,
				};
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/eval_desempeno/guardaroperacion.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
						//alert("P R O C E S A D O")
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta").html(response);
						//document.getElementById('guardar').disabled=true;
						document.getElementById("cargo").value = ""
						document.getElementById("operacion").value = ""
						document.getElementById("perfil").value = ""
						document.getElementById("defaspecto").value = ""
						document.getElementById("operacion1").value = ""
						document.getElementById("operacion2").value = ""
									
						
                    }
        
        });
        }
		  </script>
          
</head>
<body>
<div id="respuesta"></div>


  
<h2>ASPECTOS DE EVALUACION DE DESEMPEÑO</h2>
  <div>
    <p>
    <table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="80%" height="57%">
    

    
       
         <tr>
           <td height="27" colspan="4" align="left" valign="middle" class="encabezados"><strong>CARGO</strong></td>
           <td class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><label for="ccsala" ></label>
             <select name="cargo" id="cargo">
            <option value="">Seleccione...</option>
             <?php 
			 do {
			 ?>
             
              <option value="<?php echo utf8_encode($row_n['CARGO_CODIGO']); ?>"><?php echo utf8_encode($row_n['CARGO_NOMBRE']); ?></option>
             <?php
			 }
			 while ($row_n = $stmt->fetch())
			 ?>
              
      </select>
           <label for="centrodecosto"></label></td>
        
     
      <tr>
      <td height="88" colspan="4" align="left" valign="middle" class="encabezados"><strong>OPERACIONALIDAD</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><label for="operacion"></label>
        <input name="operacion" type="text" id="operacion" value=" " size="100"></td> 
  </tr>
     
     
        <tr>
        <td height="28" colspan="4" align="left" valign="middle" class="header">&nbsp;</td>
        <td class="header" colspan="6" align="center" valign="middle"><input align="right" name="guardar" type="button" class="botones" onclick= "guardaroperacion($('#cargo').val(), $('#defaspecto').val(), $('#operacion').val(),  $('#perfil').val(), '1');" id="guardar" value="GUARDAR" /></td>
  </tr>
</table>

    </p>
    
   <table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="80%" height="82%">
    

    
       
         <tr>
           <td height="27" colspan="4" align="left" valign="middle" class="encabezados"><strong>PERFIL</strong></td>
           <td class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><label for="ccsala" ></label>
             <select name="perfil" id="perfil">
            <option value="">Seleccione...</option>
            <option value="1">GERENCIA GENERAL</option>
            <option value="2">GERENCIA AREA</option>
            <option value="3">JEFATURA AREA</option>
            <option value="4">COORDINADOR</option>
            <option value="5">PROFESIONAL ANALISTA</option>
            <option value="6">ASESOR FACILITADOR</option>
            <option value="7">AUX ADMIN</option>
            <option value="8">AUX OPERATIVO</option>
            <option value="9">APRENDIZ</option>
             </select>
           <label for="centrodecosto"></label></td>
         </tr>
         <td height="27" colspan="4" align="left" valign="middle" class="encabezados"><strong>ASPECTO</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"> <label for="hijos_edades">
        <select name="defaspecto" id="defaspecto">
        <option value="">Seleccione...</option>
         <option value="3">RELACIONAMIENTO</option>
         <option value="4">INNOVACION Y APRENDIZAJE</option> 
        </select>
      </label></td>  
     </tr>
     
      <tr>
      <td height="73" colspan="4" align="left" valign="middle" class="encabezados"><strong>OPERACIONALIDAD</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><label for="operacion"></label>
        <input name="operacion1" type="text" id="operacion1" value=" " size="100"></td> 
  </tr>
     
     
        <tr>
        <td height="28" colspan="4" align="left" valign="middle" class="header">&nbsp;</td>
        <td class="header" colspan="6" align="center" valign="middle"><input align="right" name="guardar" type="button" class="botones" onclick= "guardaroperacion($('#cargo').val(), $('#defaspecto').val(), $('#operacion1').val(),  $('#perfil').val(), '2');"  value="GUARDAR" /></td>
  </tr>
</table>
   <p>&nbsp;</p>
   <table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="80%" height="82%">
    

    
       
         <tr>
           <td height="21" colspan="6" align="left" valign="middle" class="encabezados"><strong>GENERAL</strong></td>
             
        
     
      <tr>
      <td height="152" colspan="4" align="left" valign="middle" class="encabezados"><strong>OPERACIONALIDAD</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><label for="operacion"></label>
        <input name="operacion2" type="text" id="operacion2" value=" " size="100"></td> 
  </tr>
     
     
        <tr>
        <td height="28" colspan="4" align="left" valign="middle" class="header">&nbsp;</td>
        <td class="header" colspan="6" align="center" valign="middle"><input align="right" name="guardar" type="button" class="botones" onclick= "guardaroperacion($('#cargo').val(), $('#defaspecto').val(), $('#operacion2').val(),  $('#perfil').val(), '3');"  value="GUARDAR" /></td>
  </tr>
</table>

</div>
                
<footer style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold">

 </footer>
 
 

