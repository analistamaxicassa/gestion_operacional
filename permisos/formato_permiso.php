<html> 

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FORMATO DE PERMISOS</title>
<head>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="../estilos.css"/>

<style type="text/css">
.text {font-family:Verdana, Geneva, sans-serif;
	   font-size:11px;
}
</style>

<script>
 function crear(cedula, f_solicitud, jefe, f_permiso, salida, llegada, motivo, observacion, correo, correoemp, nombreemp, codcc, correo2) 
        {	//alert ("Esta solicitud serà enviada a: ".correo); 
		if (jefe==""){ alert ("La casilla NOMBRE DE JEFE INMEDIATO es obligatoria")
					document.getElementById('jefe').focus();
					return false;
					}
		if (correo==""){ alert ("La casilla E-MAIL JEFE es obligatoria")
					document.getElementById('correo').focus();
					return false;
					}
		if (f_solicitud==""){ alert ("La casilla FECHA DE SOLICITUD es obligatoria")
					document.getElementById('f_solicitud').focus();
					return false;
					}
		if (f_permiso==""){ alert ("La casilla FECHA DE PERMISO es obligatoria")
					document.getElementById('f_permiso').focus();
					return false;
					}
		if (salida==""){ alert ("La casilla HORA DE SALIDA es obligatoria")
					document.getElementById('salida').focus();
					return false;
					}
		if (llegada==""){ alert ("La casilla HORA DE LLEGADA es obligatoria o si no aplica, digitar hora del fin de la jornada")
					document.getElementById('llegada').focus();
					return false;
					}
		if (motivo==""){ alert ("La casilla MOTIVO es obligatoria")
					document.getElementById('motivo').focus();
					return false;
					}
		if (correoemp==""){ alert ("La casilla E-MAIL PERSONAL es obligatoria para recibir la respuesta")
					document.getElementById('correoemp').focus();
					return false;
					}
		else {
				var parametros = {
				"cedula": cedula,
				"f_solicitud": f_solicitud,
				"jefe": jefe,
				"f_permiso": f_permiso,
				"salida": salida,
				"llegada": llegada,
				"motivo": motivo,
				"observacion": observacion,	
				"correo": correo,
				"correoemp": correoemp,	
				"nombreemp": nombreemp,
				"codcc": codcc,
				"correo2": correo2,
				
								
               	};
							
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/permisos/autorizajefe.php',
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
					return false;
					}		

}

function diaactual(fecha)
{
					var aniop = fecha.substring(0, 4);
					var hoy = new Date();
					var anio = hoy.getFullYear();
					
					if (aniop == anio){
							var mesp = parseInt(fecha.substring(5,7));
							var mes = hoy.getMonth();
							var mm = mes + 1;
								if (mesp == mm){
									var diap = parseInt(fecha.substring(8,10));	
									var dia= hoy.getDate();				
											if (diap == dia){
										alert ("Recuerde: EL PROXIMO PERMISO DEBE SOLICITARLO UN DIA ANTES");						
											}exit();
										}
								exit();	
						}
					exit();	

}

  </script>


<?php
error_reporting(0);

session_start();


//recojo variables
$cedula=$_POST['aval'];


//$cedula= $_SESSION['aval'];
//$cedula= '52522883';
//$hoy=date("d/m/y");
//$f_solicitud = $hoy;

//conexion

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();


try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		
	$query = "SELECT SO.NOMBRE_SOCIEDAD SOCIEDAD,  EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , CA.CARGO_NOMBRE,  CC.CENCOS_NOMBRE CC, EM.EMP_CC_CONTABLE CODCC, EM.EMP_CARGO CARGO
        FROM EMPLEADO EM, CARGO CA,  sociedad SO, CENTRO_COSTO CC
        WHERE EM.EMP_CARGO = CA.CARGO_CODIGO  AND EM.EMP_CC_CONTABLE = CC.CENCOS_CODIGO
        AND EM.EMP_SOCIEDAD = SO.COD_SOCIEDAD
        AND EM.EMP_CODIGO = '$cedula'";
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row_n = $stmt->fetch();
		
		$nombre = $row_n['NOMBRE'];
		$row_n ['SOCIEDAD'];
		$row_n ['CC'];
		$codcc = substr($row_n ['CODCC'], 0, -7);
		$cargo=utf8_encode($row_n['CARGO_NOMBRE']);
 	$codcargo = $row_n ['CARGO'];
		
			if ($codcargo == '101') 
			{	
			$correo2 = "goperacionesza@ceramigres.com";
						}
			

		

$query1 = "SELECT EM.EMP_CODIGO, EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE
	 FROM EMPLEADO EM WHERE EM.EMP_MARCA_TARJETA = 'S' and EM.EMP_ESTADO <> 'R' order by EM.EMP_NOMBRE ";
		$stmt1 = $dbh->prepare($query1);
				$stmt1->execute();
				$row_n1 = $stmt1->fetch();
				
		
	 	$sql="SELECT email FROM email_permisos where cc = '$codcc'";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 

		

			if ($rs_qry->email) {	
			
							?>	
							<script>
							document.getElementById('correo').value = 'personal@ceramigres.com'
							document.getElementById('jefe').disabled = true
							document.getElementById('correo').readOnly = true
							document.getElementById('jefe').value= '1088266151'
							
							</script>
							
							<?php
                                    
								}

	
?>	




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
     $("#f_solicitud" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  yearRange: '-100:+0'
       });
    });
   
	 $(function () {
     $("#f_permiso" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  yearRange: '-100:+0'
       });
    });


function activar()
{
	document.getElementById('llegada').style="display:initial";
	}
	
	function calculafecha()
{
	var horas = document.getElementById('llegada').value - document.getElementById('salida').value
	if (horas > 4)
	{
		alert("Los permisos solo estan autorizados hasta 4 horas y se estan solicitando "+horas+" horas, No se debe incluir la hora de almuerzo entre el permiso, por favor verifique")
		}
	

	}
	
	
	function noautoriza()
{
	document.getElementById('data').checked=false;
	document.getElementById('correoemp').value= "";
	alert("Desactivando esta casilla usted no recibida respuesta a su solicitud")
	}
	
	function calcula()
{
	var horas = document.getElementById('llegada').value - document.getElementById('salida').value
	//alert(horas);
	if (horas > 4)
	{
		alert("Los permisos solo estan autorizados hasta 4 horas y se estan solicitando "+horas+" horas, No se debe incluir la hora de almuerzo entre el permiso, por favor verifique, de lo contrario agregue en observaciones la fecha y hora de la reposicion del tiempo adicional")
		
window.open("http://190.144.42.83:9090/plantillas/permisos/reposicion_tiempo.php?cedula="+<?php echo $cedula;?>	+"&&hora="+horas+"", "Reposicion de horas", "width=400, height=450")

		}	

	}
	</script>

</head>
<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">

  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="66%" border="0" style="border-collapse: collapse; font-size: 12px;">
    <tr class="encabezados">
      <td width="401" height="40" align="center"   valign="middle" class="encabezados"><?php echo $row_n['SOCIEDAD']; ?>&nbsp;</td>
      <td colspan="3" align="center" valign="middle"><strong>SOLICITUD DE PERMISO</strong></td>
    </tr>
    <tr>
      <td height="45" colspan="2" class="formulario"><span class="formulario"><span class="formulario"><strong>NOMBRE DEL TRABAJADOR:</strong>
<input name="nombreemp" type="text" id="nombreemp" value="<?php echo $row_n['NOMBRE']; ?> " size="33" readonly />
      </span></span></td>
      <td colspan="2" class="formulario"><p class="formulario"><span class="formulario"><strong>CEDULA:</strong>
        <input type="text" name="cedula" id="cedula" value="<?php echo $cedula; ?>" readonly />      
      </span></p>
      <p class="formulario"><span class="formulario"><strong>CARGO</strong>:<?php echo $cargo ; ?></span></p></td>
    </tr>
    <tr>
      <td height="30" colspan="2" class="formulario"><strong>CENTRO DE TRABAJO:</strong>
      <input name="sala" type="text" id="sala" value="<?php echo $row_n ['CC']; ?>" size="38" readonly /></td>
      <td colspan="2" class="formulario"><strong>E-MAIL EMPLEADO: <strong>
      <input type="email" name="correoemp" id="correoemp" />
      </strong></strong></td>
    </tr>
    <tr>
      <td height="6" colspan="4" bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
    <tr>
      <td height="30" colspan="2" class="formulario"><span class="formulario"><span class="formulario"><strong>NOMBRE JEFE INMEDIATO:</strong>
<select name="jefe" id="jefe" onChange="val_ced(this.value)">
        <option value="">Seleccione...</option>
          <?php    
// 		   while ($row_n1 = $stmt1->fetch())  
			do  
		    {
    	    ?>
             
          <option value="<?php echo $row_n1['EMP_CODIGO'];?>"> <?php echo $row_n1['NOMBRE']; ?> </option>
          <?php
   		 }   while ($row_n1 = $stmt1->fetch())
  		  ?>
           <option value="10267795">JUAN MANUEL VILLAMIL</option>
        </select>
      </span></span></td>
      <td height="30" colspan="2" class="formulario"><span class="formulario"><span class="formulario"><strong>E-MAIL JEFE:</strong>
      <input type="email" name="email" id="correo" size="40" required />      
      </span></span></td>
    </tr>
    <tr>
      <td height="30" colspan="2" class="formulario"><span class="formulario"><span class="formulario"><strong>FECHA DE SOLICITUD</strong>
      <input name="f_solicitud" type="text"  class="text" id="f_solicitud"  value="" required />      
      </span></span></td>
      
           
      <td colspan="2" class="formulario"><span class="formulario"><span class="formulario"><strong>FECHA DE PERMISO</strong>
      <input name="f_permiso" type="text" required  class="text" id="f_permiso"  value="" size="20" onChange="diaactual(this.value)" />      
      </span></span></td>
    </tr>
    <tr>
      <td height="30" colspan="2" class="formulario"><span class="formulario"><span class="formulario"><strong>HORA DE SALIDA</strong>
<select name="salida" id="salida" onFocus="activar()">
        <option value="6">6:00 AM </option>
        <option value="6.5">6:30 AM</option>
        <option value="7">7:00 AM</option>
        <option value="7.5">7:30 AM</option>
        <option value="8">8:00 AM</option>
        <option value="8.5">8:30 AM</option>
        <option value="9">9:00 AM</option>
        <option value="9.5">9:30 AM</option>
        <option value="10">10:00 AM</option>
        <option value="10.5">10:30 AM</option>
        <option value="11">11:00 AM</option>
        <option value="11.5">11:30 AM</option>
        <option value="12">12:00 PM</option>
        <option value="12.5">12:30 PM</option>
        <option value="13">1:00 PM</option>
        <option value="13.5">1:30 PM</option>
        <option value="14">2:00 PM</option>
        <option value="14.5">2:30 PM</option>
        <option value="15">3:00 PM</option>
        <option value="15.5">3:30 PM</option>
        <option value="16">4:00 PM</option>
        <option value="16.5">4:30 PM</option>
        <option value="17">5:00 PM</option>
        </select>
      </span></span></td>
      <td colspan="2" class="formulario"><div id="validador"><strong><span class="formulario"><span class="formulario">HORA DE LLEGADA 
                <select name="llegada" id="llegada"  style="display:none;" onChange="calcula()" >
                  <option value="18">Seleccione...</option>
                  <option value="6.5">6:30 AM</option>
                  <option value="7">7:00 AM</option>
                  <option value="7.5">7:30 AM</option>
                  <option value="8">8:00 AM</option>
                  <option value="8.5">8:30 AM</option>
                  <option value="9">9:00 AM</option>
                  <option value="9.5">9:30 AM</option>
                  <option value="10">10:00 AM</option>
                  <option value="10.5">10:30 AM</option>
                  <option value="11">11:00 AM</option>
                  <option value="11.5">11:30 AM</option>
                  <option value="12">12:00 PM</option>
                  <option value="12.5">12:30 PM</option>
                  <option value="13">1:00 PM</option>
                  <option value="13.5">1:30 PM</option>
                  <option value="14">2:00 PM</option>
                  <option value="14.5">2:30 PM</option>
                  <option value="15">3:00 PM</option>
                  <option value="15.5">3:30 PM</option>
                  <option value="16">4:00 PM</option>
                  <option value="16.5">4:30 PM</option>
                  <option value="17">5:00 PM</option>
                  <option value="17.5">5:30 PM</option>
                  <option value="18">6:00 PM</option>
                   <option value="18.5">6:30 PM</option>
                  <option value="19">7:00 PM</option>
                  <option value="19.5">7:30 PM</option>
                  <option value="20">8:00 PM</option>
                  <option value="20.5">8:30 PM</option>
                  <option value="21">9:00 PM</option>
                  <option value="21.5">9:30 PM</option>
                </select>
      </span></span></strong></div></td>
    </tr>
    <tr>
      <td height="30" colspan="2" class="formulario"><div id="respuesta"><span class="formulario"><span class="formulario"><strong>MOTIVO DE PERMISO</strong> :
<select name="motivo" id="motivo">
		<option value="">Seleccione..</option>
          <option value="13">SALUD</option>
          <option value="11">DEBERES CIUDADANOS</option>
          <option value="14">ACOMPAÑAMIENTO FAMILIA</option>
          <option value="11">CALAMIDAD DOMESTICA</option>
          <option value="11">DILIGENCIAS PERSONALES</option>
          <option value="11">ESTUDIO</option>
          <option value="16">PERMISO HORAS COMPENSADAS</option>
          </select>
      </span></span></div></td>
      <td width="211" height="30" class="formulario">&nbsp;</td>
      <td width="213"><h5>Autorizo enviar a mi correo electrónico respuesta del presente tramite
          <input name="data" type="checkbox" id="data" onChange="noautoriza()" checked="CHECKED"/>
        <label for="data"></label>
      </h5></td>
    </tr>
    <tr class="formulario">
      <td height="30" colspan="4" bgcolor="#CCCCCC"><p class="header"><strong><em>DESCRIBA DETALLADAMENTE EL MOTIVO DEL PERMISO:</em></strong></p></td>
    </tr>
    <tr class="formulario">
      <td height="30" colspan="4">      <span class="header">
      <input name="observacion" type="text" id="observacion" value="" size="140" />
      </span></td>
    </tr>
    <tr class="formulario">
      <td colspan="4"><span class="header">
      
       
      
      <input name="Restablecer" type="reset" class="botones" onClick="crear($('#cedula').val(),$('#f_solicitud').val(),$('#jefe').val(),$('#f_permiso').val(),$('#salida').val(),$('#llegada').val(),$('#motivo').val(),$('#observacion').val(),$('#correo').val(),$('#correoemp').val(),$('#nombreemp').val(),' <?php echo $codcc ?>',' <?php echo $correo2 ?>'); return false;" value="GENERAR"/>
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
