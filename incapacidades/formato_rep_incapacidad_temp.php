<link rel="stylesheet" type="text/css" href="../estilos.css"/>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<style type="text/css">
.text {font-family:Verdana, Geneva, sans-serif;
	   font-size:11px;
}
.text1 {font-family:Verdana, Geneva, sans-serif;
	   font-size:11px;
}
.text1 {font-family:Verdana, Geneva, sans-serif;
	   font-size:11px;
}
</style>

<?php

//session_start();


//recojo variables
$cedula=$_POST['aval'];
$hoy=date("d/m/Y");



//conexion
try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		
	 $query = "SELECT SO.NOMBRE_SOCIEDAD SOCIEDAD,  EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , CA.CARGO_NOMBRE,  CC.CENCOS_NOMBRE CC 
        FROM EMPLEADO EM, CARGO CA,  sociedad SO, CENTRO_COSTO CC
        WHERE EM.EMP_CARGO = CA.CARGO_CODIGO  AND EM.EMP_CC_CONTABLE = CC.CENCOS_CODIGO
        AND EM.EMP_SOCIEDAD = SO.COD_SOCIEDAD
        AND EM.EMP_CODIGO = '$cedula'";
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row_n = $stmt->fetch();
		
		$row_n['NOMBRE'];
		$row_n ['SOCIEDAD'];
		$row_n ['CC'];
		$cargo=utf8_encode($row_n['CARGO_NOMBRE']);		
		
?>	



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
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
     dateFormat: 'dd/mm/yy',
     firstDay: 1,
     isRTL: false,
     showMonthAfterYear: false,
     yearSuffix: ''
     };
     $.datepicker.setDefaults($.datepicker.regional['es']);
 

	 $(function () {
     $("#f_final" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  yearRange: '-100:+0'
       });
    });
	
	
				
function val_fecha()
{
					var fechaf = document.getElementById('f_inicial').value;
					//alert (fechaf);
			var f = new Date();
			var g = (f.getFullYear() + "/" + (f.getMonth() +1)+ "/" + f.getDate()); 
		//alert(fechaf);
		//alert(g);
		if (Date.parse(fechaf) > Date.parse(g))
					{ 
					alert ("La fecha inicial debe ser igual o menor del dia de hoy")
					document.getElementById('f_inicial').focus();
					}		

}


function sumaFecha (d, fecha)
{
 var Fecha = new Date();
 var sFecha = fecha || (Fecha.getDate() + "/" + (Fecha.getMonth() +1) + "/" + Fecha.getFullYear());
 var sep = sFecha.indexOf('/') != -1 ? '/' : '-'; 
 var aFecha = sFecha.split(sep);
 var fecha = aFecha[2]+'/'+aFecha[1]+'/'+aFecha[0];
 fecha= new Date(fecha);
 fecha.setDate(fecha.getDate()+parseInt(d-1));
 var anno=fecha.getFullYear();
 var mes= fecha.getMonth()+1;
 var dia= fecha.getDate();
 mes = (mes < 10) ? ("0" + mes) : mes;
 dia = (dia < 10) ? ("0" + dia) : dia;
 var fechaFinal = dia+sep+mes+sep+anno;

document.getElementById('fe_final').value = fechaFinal;
 }
 
 function crearinctmp(cedula, f_inicial, ndias, fe_final, observacion)
 	{
		if (observacion==""){ alert ("Por favor detalle la Causa de la Ausencia")
					document.getElementById('observacion').focus();
					return false;					
					}
		if (fe_final==""){ alert ("Es obligatorio llenar los posibles dias de incapacidad")
					document.getElementById('fe_final').focus();
					return false;
					}
		
		else {
				alert("AUSENTISMO TEMPORAL");
				var correo = prompt ("Digite un email para enviar soporte de actividad: ") 
				
				
				var parametros = {
				"cedula": cedula,
				"f_inicial": f_inicial,
				"fe_final": fe_final,
				"ndias": ndias,
				"observacion": observacion,	
				"correo": correo,	
			         	};		
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/solicitudes/guardar_inc_temporal.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#validador").html(response);
                    }
        
        });
        }
		}

 

	</script>
    

</head>
<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">

<p>&nbsp;</p>
<p>&nbsp;</p>
<p><br>
</p>

  <table width="884" border="1" align="center" style="border-collapse: collapse; font-size: 12px; text-align: center;">
    <tr class="encabezados">
      <td width="312" height="40" align="center" style="border-collapse: collapse; font-size: 18px;"  valign="middle"><?php echo $row_n['SOCIEDAD']; ?>&nbsp;</td>
      <td colspan="3" align="center" valign="middle"><strong>REPORTE DE AUSENCIA TERMPORAL</strong></td>
    </tr>
    <tr>
      <td height="30" colspan="2" class="text">NOMBRE DEL TRABAJADOR: <?php echo $row_n['NOMBRE']; ?></td>
      <td width="416" colspan="2" class="text">CEDULA: 
        <label for="cedula"></label> <label for="cedula"></label>
        <input name="cedula" type="text" class="textbox" id="cedula" value="<?php echo $cedula; ?>" /></td>
    </tr>
    <tr>
      <td height="18" colspan="4" bgcolor="#CCCCCC" class="text"><b>DETALLES DE LA INCAPACIDAD</b></td>
    </tr>
    <tr>
      <td height="18" colspan="4" class="encabezados">NOTA: Las ausencias temporales se deben reportar el mismo dia.</td>
    </tr>
    <tr>
      <td height="30" align="left" class="text">FECHA INICIAL 
        <label for="f_inicial"></label>
      <span class="formulario">
      <input name="f_inicial" type="text"  class="textbox" id="f_inicial"  value="<?php echo $hoy; ?>" readonly />
      </span> 
      </td>
      <td width="134" height="30" align="left" class="text">POSIBLES DIAS DE 
        
      AUSENCIA
        <select name="ndias" id="ndias"  onchange="sumaFecha( this.value, $('#f_inicial').val())">
         <option value="">...</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
      </select></td>
      
           
      <td colspan="2" align="left" class="text">FECHA FINAL
          <input name="fe_final" type="text" style="background-color:#CCC"  class="textbox" id="fe_final"  value="" readonly 	
           />
      </label></td>
    </tr>
   
    <tr>
      <td height="30" colspan="4"  class="text"><strong><em>DETALLES DE LA AUSENCIA:</em></strong>:
        <input name="observacion" type="text" class="textbox" id="observacion" value="" size="100" />
        <label for="otro"></label>
        <input name="Enviar" type="submit" class="botones" value="INFORMAR" onClick="crearinctmp ($('#cedula').val(),$('#f_inicial').val(),$('#ndias').val(),$('#fe_final').val(),$('#observacion').val())"/></td>
      
    </tr>
  </table>
 

<p>&nbsp;</p>
  <label ></label>	
  <p>&nbsp;</p>
  <label></label>
  <p>&nbsp;</p>
  <label></label>
  <p>&nbsp;</p>
  <label></label>
  <br/>
  <p>&nbsp;</p>
  <label style="margin-left:100px;width:210px;"></label> 

</body>
</html>
