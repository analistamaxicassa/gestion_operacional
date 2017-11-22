<?php 

//error_reporting(0);
//recojo variables

 $cedula=$_REQUEST['cedula'];


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Compromiso empleado</title>

 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="../estilos.css"/>


<script>
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
     $("#revision" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  yearRange: '-100:+0'
       });
    });
	
	
	
	
</script>	

 <script>
   function guardar(cedula, compromiso, revision )
        {	//alert(revision);
				var parametros = {
				"cedula": cedula,
				"compromiso": compromiso,
				"f_revision": revision,
				};
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/formato_desempeno/guarda_compromiso.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
						//alert("A C T U A L I Z A D O")
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta").html(response);
						//alert("EL COMPROMISO HA SIDO GUARDADO");
						//document.getElementById('guardar').disabled=true;
						//window.close();			
						
                    }
        
        });
        }
		
		
		function limpiar()
		{
			document.getElementById('compromiso').value = "";
			document.getElementById('revision').value = "";
			
			}
	
		  </script>

	
<link rel="stylesheet" type="text/css" href="../estilos.css"/>
<style type="text/css">
.text {font-family:Verdana, Geneva, sans-serif;
	   font-size:11px;
}
.text {font-family:Verdana, Geneva, sans-serif;
	   font-size:11px;
}
</style>
</head>

<body>
<p class="encabezados">COMPROMISO DE EMPLEADO</p>
<p>Detalle de compromiso
  <label>
    <textarea name="compromiso" cols="25" id="compromiso"></textarea>
  </label>
</p>
<p>Fecha de revisión :<span class="formulario">
  <input name="revision" type="text"  class="text" id="revision"  required="required" />
</span></p>
<p>
  <input name="guardar" type="submit" class="botones" id="guardar" onclick="guardar('<?php echo $cedula;?>', $('#compromiso').val(), $('#revision').val())" value="GUARDAR" />
  <input type="submit" name="otro_compromiso" id="otro_compromiso" value="Agregar siguiente compromiso" onclick="limpiar()"/>
  
</p>
 <input type="submit" style="background:#FFF" name="cerrar" id="cerrar"  onClick="window.close();"value="CERRAR" >
<div id="respuesta" style="font-family:Verdana, Geneva, sans-serif; width:80%; ">

</div>
</body>
</html>