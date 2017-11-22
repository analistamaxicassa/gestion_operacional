<link rel="stylesheet" type="text/css" href="../estilos.css"/>

<style type="text/css">
.text {font-family:Verdana, Geneva, sans-serif;
	   font-size:11px;
}
</style>
<script>

  
 function crearvac (cedula, correo, jefe, periodo, dias, salida, llegada, reemplazo, entrena, email_personal)  
        { alert(entrena); alert(email_personal); 
		if (jefe==""){ alert ("La casilla NOMBRE DE JEFE INMEDIATO es obligatoria")
					document.getElementById('jefe').focus();
					}
		if (correo==""){ alert ("La casilla E-MAIL JEFE es obligatoria")
					document.getElementById('correo').focus();
					}
		if (dias==""){ alert ("La casilla DIAS es obligatoria")
					document.getElementById('dias').focus();
					}
		if (periodo==""){ alert ("La casilla PERIODO Y DIAS es obligatoria")
					document.getElementById('periodo').focus();
					}
		if (salida==""){ alert ("La casilla HORA DE SALIDA es obligatoria")
					document.getElementById('salida').focus();
					}
		if (llegada==""){ alert ("La casilla HORA DE LLEGADA es obligatoria")
					document.getElementById('llegada').focus();
					}
		if (reemplazo==""){ alert ("La casilla REEMPLAZO es obligatoria")
					document.getElementById('reemplazo').focus();
					}
		if (entrena==""){ alert ("La casilla FECHA DE EMPALME es obligatoria para recibir la respuesta")
					document.getElementById('entrena').focus();
					}
		if (email_personal==""){ alert ("La casilla EMAIL DEL EMPLEADO es obligatoria para recibir la respuesta")
					document.getElementById('email_personal').focus();
					}

		else {
				var parametros = {
				"cedula": cedula,
				"correo": correo,
				"jefe": jefe,
				"periodo": periodo,
				"dias": dias,
				"salida": salida,
				"llegada": llegada,
				"reemplazo": reemplazo,
				"entrena": entrena,	
				"email_personal": email_personal,								
               	};
				$.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/vacaciones/autorizavacasjefe.php',
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
			
function val_ced(cedula)
{
					var ced = document.getElementById('cedula').value;
		if (cedula==ced)
					{ alert ("La persona que autoriza no puede ser igual al que solicita")
					document.getElementById('jefe').focus();
					}		

}
  </script>


<?php

//session_start();


//recojo variables
//$cedula=$_POST['aval'];


//$cedula= $_SESSION['avaladorXX'];
$cedula= '52522883';
//$hoy=date("d/m/y");
//$f_solicitud = $hoy;

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
		
	
	
	
$query1 = "SELECT EM.EMP_CODIGO, EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE FROM EMPLEADO EM WHERE EM.EMP_MARCA_TARJETA = 'S' and EM.EMP_ESTADO <> 'R' order by EM.EMP_NOMBRE ";
$stmt1 = $dbh->prepare($query1);
		$stmt1->execute();
		$row_n1 = $stmt1->fetch();
		
$query2 = "SELECT VP.VPEN_PERIODO_INI, VP.VPEN_PERIODO_FIN, VP.VPEN_DIAS_PEND  FROM TRH_VAC_PEN VP WHERE VP.EMP_CODIGO = '$cedula' ORDER BY VP.VPEN_PERIODO_INI";
$stmt2 = $dbh->prepare($query2);
		$stmt2->execute();
		$row_n2 = $stmt2->fetch();

//$result = $dbh->query($query1);
		
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
     dateFormat: 'yy/mm/dd',
     firstDay: 1,
     isRTL: false,
     showMonthAfterYear: false,
     yearSuffix: ''
     };
     $.datepicker.setDefaults($.datepicker.regional['es']);
 
 	 $(function () {
     $("#salida" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  yearRange: '-100:+0'
       });
    });
   
    $(function () {
     $("#llegada" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  yearRange: '-100:+0'
       });
    });
   
	 $(function () {
     $("#entrena" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  yearRange: '-100:+0'
       });
    });
	</script>

</head>
<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">

  <table width="884" border="1" align="center" class="tablas" style="border-collapse: collapse; font-size: 12px;">
    <tr>
      <td width="296" height="40" align="center"  valign="middle" class="encabezados" ><?php echo $row_n['SOCIEDAD']; ?>&nbsp;</td>
      <td colspan="3" align="center" valign="middle" class="encabezados"  ><strong>AUTORIZACION  DE VACACIONES</strong></td>
    </tr>
    <tr>
      <td class="text">NOMBRE DEL TRABAJADOR: <?php echo $row_n['NOMBRE']; ?></span></td>
      <td width="571" colspan="2" class="text">CEDULA: 
      <input name="cedula" type="text" id="cedula" value="<?php echo $cedula; ?>" readonly /> 
      </span></td>
    </tr>
    <tr>
      <td height="30" colspan="2" class="text">CENTRO DE TRABAJO: <?php echo $row_n ['CC']; ?></span></td>
      <td colspan="2" class="text">CARGO: <?php echo $cargo ; ?></span></td>
    </tr>
    <tr>
      <td height="30" colspan="2" class="text">NOMBRE JEFE INMEDIATO:
      <select name="jefe" id="jefe" onChange="val_ced(this.value)">   
         <?php    
// 		   while ($row_n1 = $stmt1->fetch())  
			do  
		    {
    	    ?>
            
        <option value="<?php echo $row_n1['EMP_CODIGO'];?>">
          <?php echo $row_n1['NOMBRE']; ?>
        </option>
            
        <?php
   		 }   while ($row_n1 = $stmt1->fetch())
  		  ?>       
      </select>
      </span></td>
      <td height="30" colspan="2" class="text">E-MAIL JEFE: 
      <input type="email" name="correo" id="correo" required />
      </span></td>
    </tr>
    <tr>
      <td height="30" colspan="2" class="text">PERIODO Y DIAS  
      <select name="periodo" id="periodo">
        <?php    
			do  
		    {
    	    ?>
            
        <option value="<?php echo $row_n2['VPEN_PERIODO_INI'];?>">
          <?php echo $row_n2['VPEN_PERIODO_INI']; 
		  echo " - ";
		  echo $row_n2['VPEN_PERIODO_FIN'];
		  echo " - ";
		  echo $row_n2['VPEN_DIAS_PEND'];
		  echo " DIAS";
		  ?>
        </option>
            
        <?php
   		 }   while ($row_n2 = $stmt2->fetch())
  		  ?>       
            
            
      </select>
      </span></td>
      
           
      <td colspan="2" class="text">DIAS SOLICITADOS 
      <input name="dias" type="text" required  class="text" id="dias"  value="" size="5" />
      </td>
    </tr>
    <tr>
      <td height="30" colspan="2" class="text"><span class="textbox">FECHA DE SALIDA 
      <input type="text" name="salida" id="salida" />
      </td>
      <td colspan="2" class="text"><div id="validador">FECHA ULTIMA DIA DE VACACIONES 
             <input type="text" name="llegada" id="llegada" />
     </div></td>
    </tr>
    <tr>
      <td height="30" colspan="2" class="text">QUIEN REEMPLAZA  :
      <input type="text" name="reemplazo" id="reemplazo" />
    </td>
      <td height="30" colspan="2" class="text">FECHA DE EMPALME:
      <input type="text" name="entrena" id="entrena" />
    </td>
    </tr>
    <tr>
      <td height="30" colspan="4" class="text">EMAIL DEL EMPLEADO: 
      <input type="text" name="email_personal" id="email_personal" />
      </td>
    </tr>
    <tr>
      <td colspan="4">
        <span class="textbox">
        <input name="restablecer" type="reset" class="botones" id="restablecer" onClick="crearvac($('#cedula').val()
,$('#correo').val(),$('#jefe').val(),$('#periodo').val(),$('#dias').val(),$('#salida').val(),$('#llegada').val(),
$('#reemplazo').val(), $('#entrena').val(),$('#email_personal').val()); return false;" value="GENERAR"/>
      </span></td>
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
</form>
</body>
</html>
