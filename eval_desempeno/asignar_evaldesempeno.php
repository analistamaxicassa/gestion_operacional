<?php 
//error_reporting(0);

	//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}


			
$query = "select E.EMP_CARGO, CA.CARGO_NOMBRE from empleado e, cargo ca where e.emp_estado = 'R' and E.EMP_CARGO = CA.CARGO_CODIGO
 group by E.EMP_CARGO, CA.CARGO_NOMBRE order by CA.CARGO_NOMBRE";

		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch();	
		

 ?>
		


<link rel="stylesheet" type="text/css" href="../estilos.css"/>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Generador de Certificados</title>
<style>
#login {
	border-radius: 20px;
	-moz-border-radius: 20px;
	-webkit-border-radius: 20px;
	height: 200px;
	width: 700px;
	padding: 10px;
	background-color:#EAEAEA;
	font-family:Verdana, Geneva, sans-serif;
	font-size:14px;
	color:#000;
}

</style>

  <script>   
  
  function llenaractual(cedulares)
{  
	var parametros = {		
				"cedulares": cedulares,
				};
		$.ajax({
                data: parametros,
			    url:'../suministros/buscardatos.php', 
				    type: 'post',
                    beforeSend: function () 
                    {
                        $("#validadorbuscar").html("	");
                    },
        
                    success: function (response) 
                    {
                        //$("#validador").html(response);
						
						document.getElementById("nombre_actual").value = response; //guaradr en un campo de texto
						//document.getElementById("correo").value = $correo; //guaradr en un campo de texto

						
		
			
				-->		document.getElementById("nombre").value = response;	
					-->	document.getElementById("cargo").value = "ninguno";				
                    }
        
        });
		}	


 function llenaremail(cedulares)
{ // alert(cedulares);
	var parametros = {		
				"cedulares": cedulares,
				};
		$.ajax({
                data: parametros,
			    url:'../suministros/buscardatosemail.php', 
				    type: 'post',
                    beforeSend: function () 
                    {
                        $("#validadorbuscar").html("	");
                    },
        
                    success: function (response) 
                    {
                        //$("#validador").html(response);
						
						document.getElementById("correo").value = response; //guaradr en un campo de texto
						//document.getElementById("correo").value = $correo; //guaradr en un campo de texto

						
		
			
				-->		document.getElementById("nombre").value = response;	
					-->	document.getElementById("cargo").value = "ninguno";				
                    }
        
        });
		}	
  
     function val_cargo(cargo, cedulaevalua, f_seguimiento, correo)
{// alert(f_seguimiento);
				var parametros = {
				"cargo": cargo,
				"cedulaevalua": cedulaevalua,
				"f_seguimiento": f_seguimiento,
				"correo": correo,
				};
				 $.ajax({
                data: parametros,
                url: 'programacion.php?cargo='+cargo+', cedulaevalua='+cedulaevalua+', f_seguimiento='+f_seguimiento+', correo='+correo+'',
                type: 'post',
                   beforeSend: function () 
                   {
                        $("#programacionent").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#programacionent").html(response);
					//document.getElementById('tbl_ppal').style.display="none"	
                    }
					  });		

}
 

     $.datepicker.regional['es'] = {
     closeText: 'Cerrar',
     prevText: '<Ant',
     nextText: 'Sig>',
     currentText: 'Hoy',
     monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
     monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
     dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
     dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
     dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
     weekHeader: 'Sm',
     dateFormat: 'yy/mm/dd',
     firstDay: 1,
     isRTL: false,
     showMonthAfterYear: false,
     yearSuffix: ''
     };
     $.datepicker.setDefaults($.datepicker.regional['es']);
 
 	 $(function () {
     $("#f_seguimiento" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  yearRange: '-100:+0'
       });
    });
   
   </script>
   
   <script>
function buscaremp()
{
	window.open("http://190.144.42.83:9090/plantillas/suministros/buscar_empleado.php", "Buscar empleado", "width=800, height=500")
}
			
</script>
		
     

 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script> 
 
</head>

<body>



<div id="centro">
  
  <table align="center" class="formulario">
 <tr class="encabezados">   
    <td class="formulario">
        <div id="login" style="margin-top:40px; color:#FFF text-align:left">
          <p><b>Ingrese documento de Evaluador:</b>
            <input type="text" class="textbox" id="cedulaevalua" onChange="llenaractual(this.value);"  />
<input type="submit" name="buscarnombre" id="buscarnombre" value="Listado de empleados" onClick="buscaremp()" />
            <input name="nombre_actual" type="text" id="nombre_actual" size="60" />          
          </p>
          <p>
            <input type="submit" name="E-MAIL" id="E-MAIL" value="E-mail" onclick="llenaremail($('#cedulaevalua').val());" />
            <label>
              <input name="correo" type="text" id="correo" size="50" />
            </label>
          </p>
          <p>Fecha limite de evaluacion 
            <input name="f_seguimiento" type="text"  class="text" id="f_seguimiento"  value="" required />
          </p>
          <p align="center"><b>Seleccione los cargos</b>
            <label>
              <select name="cargos" id="cargos" onChange="val_cargo(this.value, $('#cedulaevalua').val(),  $('#f_seguimiento').val(), $('#correo').val() )" > 
                <option value="">seleccione... </option>
                <?php    
			do  
		    {
    	    ?>
                <option value="<?php echo $row['EMP_CARGO'];?>">
                <?php echo $row['CARGO_NOMBRE'];?>
                </option>
                
                <?php
   		 }   while ($row = $stmt->fetch())
  		  ?>       
              </select>
            </label>
        
          
        
        
          
        </div>
    </td>
 </tr>
 <tr class="encabezados">
   <td class="formulario">&nbsp;</td>
 </tr>
  </table>
</div>
 <div id="programacionent" ></div>
<br><br>
<center>
<div id="validador" style="font-family:Verdana, Geneva, sans-serif; width:50%;">	
</div>
   <input type="button" value="Imprimir certificado" id="prn" onClick="imprSelec('validador');"  style="display:none"/>
</center>

</body>
</html>