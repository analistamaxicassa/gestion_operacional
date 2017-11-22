
<?php

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

$sql2="SELECT `id`,`descripcion_elemento`,`posible_ubicacion`,`area` FROM `suministros_elementos` order by descripcion_elemento  ";
	$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
			
		
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link rel="stylesheet" type="text/css" href="../estilos.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  
  
<style type="text/css">
.text {font-family:Verdana, Geneva, sans-serif;
	   font-size:11px;
}
</style>
<script>


    
    	
	function crearelemento(descripcion, ubicacion, area)  
        {		
		if (descripcion==""){ alert ("La casilla DESCRIPCION es obligatoria")
					document.getElementById('descripcion').focus();
					}
		if (ubicacion==""){ alert ("La casilla UBICACIÓN es obligatoria")
					document.getElementById('ubicacion').focus();
					}
		if (area==""){ alert ("La casilla AREA es obligatoria")
					document.getElementById('area').focus();
					}
				var parametros = {
				"descripcion": descripcion,
				"ubicacion": ubicacion,
				"area": area,
               	};
				$.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/suministros/guarda_elementos.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                         document.getElementById('ingresar').disabled=true;
						$("#validador").html(response);
											
                    }
        
        });
			}
			
			function nuevo()
			{
				document.getElementById('ingresar').disabled=false;
				document.getElementById('descripcion').value= "";
				document.getElementById('ubicacion').value= "";
				document.getElementById('area').value= "";
				}
			
			</script>
    
    
    
    

</head>
<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">

<br>
  <table width="649" border="1" align="center" style="border-collapse: collapse; font-size: 12px; text-align: center;">
  <td width="92"><A href='http://190.144.42.83:9090/plantillas/suministros/elementos_sala.php'>REGRESAR</A>
    </td>
    <tr>
      <td height="40" colspan="4" align="center"  valign="middle" bgcolor="#99FFFF" class="encabezados" style="border-collapse: collapse; font-size: 18px;">INGRESO DE ELEMENTOS<strong></strong></td>
    </tr>
    <tr>
      <td height="30" align="left">DESCRIPCION
      <label for="f_inicial2"></label></td>
      <td colspan="3" align="left"><input name="descripcion" type="text" required  class="text" id="descripcion"  value="" size="80" style="background:#CCC"  onkeyup="javascript:this.value=this.value.toUpperCase()" />
      
    
      <input type="submit" name="ingresar_mas" id="ingresar_mas" value="Nuevo" onClick="nuevo()" /></td>
    </tr>
    <tr>
      <td width="92" height="30" align="left">UBICACION
      <label for="f_inicial"></label></td>
      
           
      <td width="174" align="left"><label for="ubicacion"></label>
        <select name="ubicacion" id="ubicacion" style="background:#CCC">
           <option value="">Seleccione...</option>
          <option value="Bodega">Bodega</option>
          <option value="Sala">Sala</option>
          <option value="Caja">Caja</option>
          <option value="Oficina">Oficina</option>
          <option value="Archivo">Archivo</option>
         <option value="Infraestructura">Infraestructura</option>
         <option value="Armario IT">Armario IT</option>
          <option value="Planta Arena">Planta Arena</option>
          <option value="Planta Pegantes">Planta Pegantes</option>
          <option value="Camión Pegomax">Camión Pegomax</option>
      </select></td>
      <td width="175" align="left">AREA</td>
      <td width="416" align="left"><label for="area">
        <select name="area" id="area" style="background:#CCC">
          <option value="">Seleccione...</option>
          <option value="Suministros">SUMINISTROS</option>
          <option value="Salud Ocupacional">SALUD OCUPACIONAL</option>
          <option value="Infraestructura">COMUNICACIONES</option>
          <option value="Sistemas IT">SISTEMAS Y TECNOLOGIA</option>
            <option value="Mantenimiento">MANTENIMIENTO</option>
            <option value="Logistica">LOGISTICA</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td height="30" colspan="4" bgcolor="#CCCCCC"><input name="ingresar" type="submit" id="ingresar" onClick="crearelemento($('#descripcion').val(),$('#ubicacion').val(),$('#area').val()); return false;" value="INGRESAR"/			></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <label ></label>	
  <table width="649" border="1" align="center" style="border-collapse: collapse; font-size: 12px; text-align: center;">
  <tr>
    <td height="23" colspan="3" class="encabezados">LISTADO DE ELEMENTOS</td>
    <tr>
      <td height="23" class="subtitulos">ELEMENTO</td>
      <td class="subtitulos">UBICACION</td>
      <td bgcolor="#999999" class="subtitulos"><strong><em>ÁREA</em></strong></td>
    <?php
	do
	{
	?>

    <tr>
    <td width="45" height="23" align="left"><?php echo utf8_encode($rs_qry2->descripcion_elemento); ?></td>
    <td width="92"><?php echo utf8_encode($rs_qry2->posible_ubicacion); ?></td>
    <td width="92"><?php echo utf8_encode($rs_qry2->area); ?></td>
    
    
     <?php
		}
		while($rs_qry2=$qry_sql2->fetch_object());
		?>
	
</table>
  <label></label>
  <p>&nbsp;</p>
  <label></label>
  <p>&nbsp;</p>
  <label></label>
  <br/>
  <p>&nbsp;</p>
  <label style="margin-left:100px;width:210px;"></label> 
</form>
</body>
</html>
