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
	height: 100px;
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

						
		
			
				-->		document.getElementById("nombre").value = response;	
					-->	document.getElementById("cargo").value = "ninguno";				
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
     $("#f_evaluacion" ).datepicker({
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
  <form action="http://190.144.42.83:9090/plantillas/eval_desempeno/imprimir_evaluacion_gh.php" method="post">
 <tr class="encabezados">   
    <td class="formulario">
        <div id="login" style="margin-top:40px; color:#FFF text-align:left">
        <p><b>Ingrese cedula empleado:</b>
            
          <input name="cedula" type="text" class="textbox" id="cedula"  onchange="llenaractual(this.value);" />
        <p>
          <input name="nombre_actual" type="text" id="nombre_actual" size="80" />        
        <p>
          <input type="submit" name="buscar" id="buscar" value="Buscar" />        
        <p>
        </form>          
          </p>
          <p align="center" style="color:#039">
          </div>
              
          
    </td>
 </tr>
    
</table>
<input type="submit" name="buscarnombre" id="buscarnombre" value="Listado de empleados" onClick="buscaremp()" />


</div>


<div id="programacionent" ></div>
<br><br>

</body>
</html>