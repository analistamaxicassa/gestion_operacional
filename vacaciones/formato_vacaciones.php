<link rel="stylesheet" type="text/css" href="../estilos.css"/>

<style type="text/css">
.text {font-family:Verdana, Geneva, sans-serif;
	   font-size:11px;
}
</style>
<script>

  
 function crearvac (cedula, correo, jefe, periodo, dias, salida, llegada, reemplazo, entrena, email_personal, nombre, cc, emergencia)  
        { 
		if (jefe==""){ alert ("La casilla NOMBRE DE JEFE INMEDIATO es obligatoria")
					document.getElementById('jefe').focus();
					return false;
					}
		if (correo==""){ alert ("La casilla E-MAIL JEFE es obligatoria")
					document.getElementById('correo').focus();
					}
		if (dias==""){ alert ("La casilla DIAS SOLICITADOS es obligatoria")
					document.getElementById('diasotros').focus();
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
		if (emergencia==""){ alert ("La casilla CONTACTO EN CASO DE EMERGENCIA es obligatoria para recibir la respuesta")
					document.getElementById('emergencia').focus();
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
				"nombre": nombre,
				"cc": cc,
				"emergencia": emergencia,								
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
	/*		
function val_d(dias, diaspen)
{	alert(dias)	

	    var diass = (parseInt(dias));
		var diasp = (parseInt(diaspen));	
		var cedulae = document.getElementById('cedula').value;
		var periodov = document.getElementById('periodo').value;
			var parametros = {
				"periodov": periodov,
				"cedulae": cedulae,
				"diase": diass,
				"diasp": diasp,
			   	};
				$.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/vacaciones/verificarvacas.php',
                type: 'post',
               /*    beforeSend: function () 
                    {
                     $("#validador1").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                       //alert (response);
					  // document.getElementById('cedula').value= (response) 
					
					
						/*if (diass > diasp)
					{ 
					alert ("Los dias solicitados exceden los autorizados en este periodo");
					
					}		
						
						
						$("#validador1").html(response);
											
                    }
          });

					

}*/

function val_d(dias, diaspen ,diastomados)
{	

	    var diass = (parseInt(dias));
		var diasp = diaspen.substring(19) - diastomados;	
			
							
		if (diass > diasp)
		{
			alert ("Los dias solicitados exceden los autorizados en este periodo, verifique cuantos se han tomado");
			document.getElementById('diasotro').value = "";
			document.getElementById('diasotro').focus();
					return false;
		}
}


function revisarfecha()
{	

	   		document.getElementById('salida').value > document.getElementById('llegada').focus();
					alert("Verifique que la feha de llegada sea posterior a la fecha de Salida");
					
		
}
  </script>


<?php

//session_start();


//recojo variables
$cedula=$_POST['aval'];


//$cedula= $_SESSION['avaladorXX'];
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
		
		
		
		
		 $query = "SELECT SO.NOMBRE_SOCIEDAD SOCIEDAD,  EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , CA.CARGO_NOMBRE,  CC.CENCOS_NOMBRE CC, EM.EMP_CC_CONTABLE
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
		//echo $codcc = trim($row_n['EMP_CC_CONTABLE']);
		//echo $codcc = explode("-",$row_n['EMP_CC_CONTABLE']);
		 $codcc = trim(substr($row_n ['EMP_CC_CONTABLE'], 0, -7));
		//$comercial = $codcc[3];
		//echo $comercial = substr($row_n['EMP_CC_CONTABLE'], 0, -7);
		
		if($codcc =='10-099'||$codcc =='70-099'||$codcc == '20-099')
			 {
				 $emailsala = " ";
				$sala = "ADMINISTRACION ";
			}
			else
			{   
			$sql="SELECT email emailpunto FROM email_permisos where cc = '$codcc'";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 
				
				$emailsala = $rs_qry->emailpunto;
				$sala= substr($emailsala, 0, -15); 
		
					if ($rs_qry->emailpunto)
					 {	
							?>	
							<script>
							document.getElementById('correo').value = 'personal@ceramigres.com'
							document.getElementById('jefe').disabled = true
							document.getElementById('jefe').value= '1088266151'
							document.getElementById('reemplazo').disabled = true
							document.getElementById('reemplazo').value = 'campo para Jefe de personal'
							document.getElementById('entrena').disabled = true
							document.getElementById('entrena').value = 'Campo para Jefe de personal'

							</script>
							<?php
            		 }
			}
	
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

<!DOCTYPE html>

   <head>
       <meta charset="utf-8" />
       <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <meta name="viewport" content="width=device-width,initial-scale=1"> 

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
	  yearRange: '-100:+100'
       });
    });
   
    $(function () {
     $("#llegada" ).datepicker({
      changeMonth: true,
      changeYear: true,
	   yearRange: '-100:+100'
       });
    });
   
	 $(function () {
     $("#entrena" ).datepicker({
      changeMonth: true,
      changeYear: true,
	   yearRange: '-100:+100'
       });
    });
	
	
/*
function buscar() {
//    var textoBusqueda = $("input#periodo").val();
	var textoBusqueda = document.getElementById('periodo').value;
	alert (textoBusqueda);
	     if (textoBusqueda != "") {
        $.post("http://190.144.42.83:9090/plantillas/vacaciones/verificarvacas.php", {valorBusqueda: textoBusqueda}, function(mensaje) {
            $("#resultadoBusqueda").html(mensaje);
         }); 
     } else { alert("entrro aqui")
        $("#resultadoBusqueda").html('');
        };
		
	
		
};*/
</script>
	
   <script>
	function buscar(periodov)
{ 
		var cedulae = document.getElementById('cedula').value;
		//var diase = document.getElementById('diasotros').value;
			var parametros = {
				"periodov": periodov,
				"cedulae": cedulae,
			//	"diase": diase,
			   	};
				$.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/vacaciones/verificarvacas.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador1").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    { 
                        $("#diastomados").val(response);
											
                    }
          });
		  
				/*	var ced = document.getElementById('cedula').value;
		if (cedula==ced)
					{ alert ("La persona que autoriza no puede ser igual al que solicita")
					document.getElementById('jefe').focus();
					return false;
					}		*/

}
	</script>

</head>
<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">


  <p>&nbsp;</p>
  <table width="884" border="1" align="center" class="formulario" style="border-collapse: collapse; font-size: 12px;">
    <tr>
      <td width="254" height="40" align="center"  valign="middle" class="encabezados" ><?php echo $row_n['SOCIEDAD']; ?>&nbsp;</td>
      <td colspan="3" align="center" valign="middle"class="encabezados"><strong>SOLICITUD DE VACACIONES</strong></td>
    </tr>
    <tr class="textbox">
      <td height="30" colspan="2" class="text">NOMBRE DEL TRABAJADOR: <?php echo $row_n['NOMBRE']; ?>
      <label for="nombre"></label></td>
      <td colspan="2" class="text">CEDULA: 
        <label for="cedula"></label> <label for="cedula"></label>
        <input name="cedula" type="text" id="cedula" value="<?php echo $cedula; ?>" readonly /> </td>
    </tr>
    <tr>
      <td height="30" colspan="2" class="text">CENTRO DE TRABAJO: <?php echo $row_n ['CC']; ?></td>
      <td colspan="2">CARGO: <?php echo $cargo ; ?></td>
    </tr>
    <tr>
      <td height="36" colspan="2" class="text">NOMBRE JEFE INMEDIATO:
        <label for="emp_marca_tarjeta"></label>
       <select name="jefe"  id="jefe" onChange="val_ced(this.value)">   
  		   <option value="">Seleccione...</option>
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
		</select></td>
      <td height="36" colspan="2" class="text">E-MAIL JEFE: 
        <label for="correo"></label>
      <input name="correo" type="email" required class="textbox" id="correo" /></td>
    </tr>
    <tr>
      <td height="30" colspan="2" class="text">PERIODO Y DIAS 
      <?php $diaspen = $row_n2['VPEN_DIAS_PEND']; ?> 
      
     
    
        <label for="periodo"></label>
        <select name="periodo"  id="periodo"  onChange="buscar(this.value)"> 
              <option value="">Seleccione...</option>


		 <?php    
			do  
		    {
    	    ?>
   
        <option value="<?php echo $row_n2['VPEN_PERIODO_INI']. " - ".$row_n2['VPEN_PERIODO_FIN'].$row_n2['VPEN_DIAS_PEND'];?>">
      	  <?php echo $row_n2['VPEN_PERIODO_INI']; 
		  echo " - ";
		  echo $row_n2['VPEN_PERIODO_FIN'];
		  echo " - ";
		  echo $diaspen =  $row_n2['VPEN_DIAS_PEND'];
		  echo " DIAS";
		 // $periodo2 =  $_POST['periodo'];
		  ?>
        </option>
       
        <?php
   		 }   while ($row_n2 = $stmt2->fetch());
  		
		  ?>       
		
       
      </select></td>
      
         
      <td colspan="2" class="text"> <p>
	  
	  
        Dias disfrutados de este periodo: 
            <input name="diastomados" type="text" id="diastomados" size="5" readonly="readonly">
        <strong>Dias Solicitados: </strong>
        <input name="diasotro" type="text" id="diasotro"  onChange="val_d(this.value, $('#periodo').val() ,$('#diastomados').val())"
                 size="5">
                 
               
      </p>
        <p>
        </p>
		 
      </div></td>
       
    </tr>
    <tr>
      <td height="30" colspan="2" class="text">FECHA DE SALIDA 
        <label for="salida"></label>
        <input name="salida" type="date"  id="salida" /></td>
      <td colspan="2"><div id="validador">FECHA ULTIMO DIA DE VACACIONES
          <label for="llegada"></label>
             <input name="llegada" type="date" id="llegada" onChange="revisarfecha()" />
         
      </div></td>
    </tr>
    <tr>
      <td height="30" colspan="2" class="text">QUIEN REEMPLAZA  :
        <label for="motivo2"></label>
        <label for="reemplazo"></label>
      <input name="reemplazo" type="text" class="textbox" id="reemplazo" size="50" /></td>
      <td height="30" colspan="2" class="text">FECHA DE EMPALME:
        <label for="entrena"></label>
      <input name="entrena" type="text" class="textbox" id="entrena" size="50" /></td>
    </tr>
    <tr>
      <td height="30" class="text">EMAIL DEL EMPLEADO:</td>
      <td width="124" height="30" class="text"><input name="email_personal" type="text" class="textbox" id="email_personal" /></td>
      <td width="188" height="30" class="text"><label for="email_personal"></label>
EN CASO DE EMERGENCIA COMUNICARSE A:</td>
      <td width="290" height="30" class="text"><label for="emergencia"></label>
      <input type="text" name="emergencia" id="emergencia" /></td>
    </tr>
    <tr>
      <td colspan="4">
      <input name="restablecer" type="reset" class="botones" id="restablecer" onClick="crearvac($('#cedula').val()
,$('#correo').val(),$('#jefe').val(),$('#periodo').val(),$('#diasotro').val(),$('#salida').val(),$('#llegada').val(),
$('#reemplazo').val(), $('#entrena').val(),$('#email_personal').val(), '<?php echo $row_n['NOMBRE']; ?>', '<?php echo $row_n ['CC']; ?>',$('#emergencia').val()); return false;" value="GENERAR"/>
      </td>
          </tr>
  </table>

<p><div id="#validador">
		 </div></p>
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
