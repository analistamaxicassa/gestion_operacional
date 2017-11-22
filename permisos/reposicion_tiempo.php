<?php 

//error_reporting(0);
//recojo variables

 $cedula=$_REQUEST['cedula'];
 $hora=$_REQUEST['hora'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reposicion de Tiempo</title>

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
     $("#f_reposicion" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  yearRange: '-100:+0'
       });
    });
	
	
	
	
</script>	

 <script>
   function guardar(cedula, hora, fecha, inicio, final)
        {	
				var parametros = {
				"cedula": cedula,
				"hora": hora,
				"fecha": fecha,
				"inicio": inicio,
				"final": final,
				};
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/permisos/guarda_reposiciont.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
						//alert("A C T U A L I Z A D O")
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta").html(response);
						//alert("A C T U A L I Z A D O SEGURO")
						document.getElementById('guardar').disabled=true;
						window.close();			
						
                    }
        
        });
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
<p class="encabezados">REPOSICION DE TIEMPO</p>
<p>
  <label>
    Fecha:<span class="formulario">
    <input name="f_reposicion" type="text"  class="text" id="f_reposicion"  value="" required="required" />
    </span></label>
</p>
<p>Desde la(s) 
  <label>
    <input name="inicio" type="text" id="inicio" size="10" />
  </label>
   a las 
   <label>
  <input name="final" type="text" id="final" size="10" />
</label> 
horas
</p>
<p>
  <input type="submit" name="guardar" id="guardar" value="GUARDAR" onclick="guardar('<?php echo $cedula;?>', '<?php echo $hora;?>', $('#f_reposicion').val(), $('#inicio').val(),$('#final').val())" />
</p>
<div id="respuesta" style="font-family:Verdana, Geneva, sans-serif; width:80%; ">

</div>
</body>
</html>