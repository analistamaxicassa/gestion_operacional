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

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

//session_start();


//recojo variables
$cedula=$_POST['aval'];



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
		 
		 if (empty($row_n['NOMBRE']))
		 {echo "NO EXISTE EL EMPLEADO, VERIFIQUE EL No DE DOCUMENTO";
		 exit();
			 }
		
	
	
$query1 = "SELECT TAUS_NOMBRE, TAUS_CODIGO FROM TRH_TIPO_AUSENTISMO TA where TA.TAUS_CODIGO in ('1','2','4','7','8','9','10','15','17')";
$stmt1 = $dbh->prepare($query1);
		$stmt1->execute();
		$row_n1 = $stmt1->fetch();
		
			

		
//		$diagnostico = rtrim($row_n['DIAU_NOMBRE']);
		

//$result = $dbh->query($query1);
		
		
$sql4="SELECT `id`,`cedula`,`finicial`, `ndias` FROM `incapacidades` WHERE cedula = '$cedula' and tipo_incapacidad = '' ";
			$qry_sql4=$link->query($sql4);
			$rs_qry4=$qry_sql4->fetch_object();  ///consultar 	
				
		if (empty($rs_qry4->cedula))
		{
			
		$f_inicial = "";
		$n_dias= "";
		$id= "NO";
		}
		else
		{
		$f_inicial = $rs_qry4->finicial ;
		$n_dias= $rs_qry4->ndias;
		$id= $rs_qry4->id;
		}
		
	$query12 = "SELECT DIAU_CODIGO, DIAU_NOMBRE FROM TRH_DIAG_AUSEN ORDER BY DIAU_CODIGO";
	$stmt12 = $dbh->prepare($query12);
		$stmt12->execute();
		$row_n12 = $stmt12->fetch();
		
	$query13 = "select EN.ENT_CODIGO,  EN.ENT_NOMBRE from COBXEMP cx, ENTIDADES_SERV en where CX.ENT_CODIGO = EN.ENT_CODIGO
and  CX.EMP_CODIGO = '$cedula' and CX.TENT_CODIGO = 'EPS'";
	$stmt13 = $dbh->prepare($query13);
		$stmt13->execute();
		$row_n13 = $stmt13->fetch();
		
				
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
     $("#f_inicial" ).datepicker({
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

function dias_transcurridos(f1,f2)
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
	
	
		 var aFecha1 = f1.split('/');
		 var aFecha2 = f2.split('/'); 
		 var fFecha1 = Date.UTC(aFecha1[0],aFecha1[1]-1,aFecha1[2]); 
		 var fFecha2 = Date.UTC(aFecha2[0],aFecha2[1]-1,aFecha2[2]); 
		 var dif = fFecha2 - fFecha1;
		 var dias = Math.floor(dif / (1000 * 60 * 60 * 24)); 
		 document.getElementById('ndias').value = dias+1;
		

}

function sumaFecha (d, fecha)
{ 
  
  if (isNaN(d))
  {
	  alert("No es correcto el numero de Dias. VERIFIQUE  ");	
	  
  }
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

document.getElementById('f_final').value = fechaFinal;
 }
	
function prorroga(cedula)
{ 	
	
	var parametros = {		
				"cedula": cedula,
				};
		$.ajax({
                data: parametros,
                url:'../incapacidades/buscar_prorroga.php', 
				    type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("	");
                    },
        
                    success: function (response) 
                    {
                     
			/*		 var dato = response.split("-");
					alert(dato);	
						document.getElementById("f_inicial").value = dato[1];
//						document.getElementById("codausentismo").value = dato[2];
						document.getElementById("codausentismo").style.display='none';
						document.getElementById("tincapacidad").value = dato[2];
					 	document.getElementById("tincapacidad").style="visibility:visible";
					 	document.getElementById("entidad").style.display='none';
//						document.getElementsByName("enviar");
						var btnUNO = document.getElementById("enviar");
						btnUNO.style.display='none';
				*/
					    $("#validador").html(response);
					/*	//alert(response);
						//document.getElementById("nombre").value = response; //guaradr en un campo de texto
					-->		document.getElementById("nombre").value = response;	
					-->	document.getElementById("cargo").value = "ninguno";		
					document.getElementById("observacion").value = "prorroga de incapacidad Queryx No. "+dato[0]; //guardar en un campo de texto		
                 */   }
        
        });
	}

function evaluaraus(aus)
  {
	  		 if (aus == '8')
			 	{
				 $("#entidad option[value=625]").attr("selected",true);
					document.getElementById("entidad").style.display='none';
				 }
	}


	
	</script>
    
    
    <script>
	
	 function crearinc(id,cedula, codausentismo, numero_inc, f_inicial,  f_final, ndias, entidad, motivo, observacion, referencia) 
        {	
		document.getElementsByName('Enviar').disabled= 'true';
		
		if (codausentismo==""){ alert ("La casilla TIPO DE INCAPACIDAD es obligatoria")
					document.getElementById('codausentismo').focus();
					}
		if (numero_inc==""){ alert ("La casilla NUMERO DE INCAPACIDAD es obligatoria")
					document.getElementById('numero_inc').focus();
					}
		if (f_inicial==""){ alert ("La casilla FECHA INICIAL es obligatoria")
					document.getElementById('f_inicial').focus();
					}
		if (f_final==""){ alert ("La casilla FECHA FINAL es obligatoria")
					document.getElementById('f_final').focus();

					}
		//if (ndias==""){ alert ("La casilla NUMERO DE DIAS es obligatoria")
			//		document.getElementById('ndias').focus();
				//	}
		if (entidad==""){ alert ("La casilla ENTIDAD es obligatoria")
					document.getElementById('entidad').focus();
					}
		//if (motivo==""){ alert ("La casilla DIAGNOSTICO es obligatoria")
			//		document.getElementById('motivo').focus();
				//	}
		else {
			
			var correo = prompt ("Digite un email para enviar soporte de actividad: ") 
				var parametros = {
				"id": id,
				"cedula": cedula,
				"codausentismo": codausentismo,
				"numero_inc": numero_inc,
				"f_inicial": f_inicial,
				"f_final": f_final,
				"ndias": ndias,
				"entidad": entidad,
				"motivo": motivo,
				"observacion": observacion,	
				"referencia": referencia,	
				"correo": correo,	
				
               	};		
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/solicitudes/selecciona_archivo_soporte.php',
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

<p></p>
<p><br>
</p>
<form>


  <table width="800" border="1" align="center" style="border-collapse: collapse; font-size: 12px; text-align: center;">
    <tr class="encabezados">
      <td height="40" colspan="2" align="center"  valign="middle" style="border-collapse: collapse; font-size: 18px;"><?php echo $row_n['SOCIEDAD']; ?>&nbsp;</td>
      <td colspan="2" align="center" valign="middle"><strong>REPORTE DE INCAPACIDAD</strong></td>
    </tr>
    <tr>
      <td height="30" colspan="2" class="text">NOMBRE DEL TRABAJADOR: 
        <label>
          <input name="nombree" type="text" id="nombree" value="<?php echo $row_n['NOMBRE']; ?>" size="40" />
      </label></td>
      <td colspan="2" class="text">CEDULA: 
        <label for="cedula"></label> <label for="cedula"></label>
        <input name="cedula" type="text" class="textbox" id="cedula" value="<?php echo $cedula; ?>" /> </td>
    </tr>
    <tr>
      <td height="18" colspan="4" bgcolor="#CCCCCC" class="text"><b>DETALLES DE LA INCAPACIDAD</b></td>
    </tr>
    <tr>
      <td height="18" colspan="4" class="encabezados">(La siguiente informacion la encuentra en el documento de incapacidad generado por su entidad de salud)
      <label for="motivo"></label></td>
    </tr>
    <tr>
      <td  style="background-color:#003" width="138" height="30" align="left" class="text" ><label for="tincapacidad">
         <input type="button" name="prorroga2" id="prorroga2" value="Prórroga" onClick="prorroga( $('#cedula').val())" />
     </label></td>
      <td height="30" colspan="2" align="left" class="text" >TIPO DE INCAPACIDAD:
        <select name="codausentismo" id="codausentismo" onChange="evaluaraus(this.value)" >
          <option value="">Seleccione</option>
          <?php    
// 		   while ($row_n1 = $stmt1->fetch())  

			do  
		    {
    	    ?>
          <option value="<?php echo $row_n1['TAUS_CODIGO'];?>"> <?php echo $row_n1['TAUS_NOMBRE']; ?> </option>
          <?php
   		 }   while ($row_n1 = $stmt1->fetch())
  		  ?>
      </select></td>
      <td width="344" align="left" class="text">
        
        INCAPACIDAD No
          <label for="numero_inc2"></label>
        <label for="prorroga"></label>        <input   name="numero_inc" required class="textbox" id="numero_inc" />
        <label for="referencia"></label>
        <input name="referencia" type="text" id="referencia" size="1" style="visibility:hidden" /></td>
    </tr>
    <tr>
      <td height="30" colspan="2" align="left" class="text">FECHA INICIAL 
        <label for="f_inicial"></label>
      <span class="formulario">
      <input name="f_inicial" type="text"  class="textbox" id="f_inicial"  value="<?php echo $f_inicial; ?>" required />
      </span> 
      </td>
      
           
      <td colspan="2" align="left" class="text">DIAS DE INCAPACIDAD(números)
      <input  name="ndias" type="text" class="textbox" id="ndias" size="5" maxlength="3" value="<?php echo $n_dias; ?>"
       onblur="sumaFecha( this.value, $('#f_inicial').val())" />
      <strong>&lt;-- Click Aqui</strong></td>
    </tr>
    <tr>
      <td height="30" colspan="2" align="left" class="text">
      FECHA FINAL
      <input name="f_final" type="text"  style="background-color:#CCC"  class="textbox" id="f_final"  value="" readonly 	
           /></td>
      <td height="30" colspan="2" align="left" class="text">ENTIDAD        
        <label for="entidad"></label>
      <input name="entidad" type="text" id="entidad" value="<?php echo $row_n13['ENT_CODIGO']." ".$row_n13['ENT_NOMBRE']; ?>" readonly /></td>
    </tr>
    <tr>
      <td height="30" colspan="4" class="text"><div id="respuesta" align="left">
        <p>CODIGO DE DIAGNOSTICO: 
          <select name="motivo" id="motivo">
            <option value="">Seleccione->Consultando datos.. 7 segundos</option> 
            <?php    

			do  
		    {
    	    ?>
  
            <option value="<?php echo $row_n12['DIAU_CODIGO'];?>">
              <?php 
			//	$diagnostico = substr($row_n12 ['DIAU_NOMBRE'], 0, 60);
				// echo $row_n12['DIAU_CODIGO']."-".$diagnostico; 
				 echo $row_n12['DIAU_CODIGO']."-".substr($row_n12 ['DIAU_NOMBRE'], 0, 60); ?>
				
                
            </option>
            <?php
   		 }   while ($row_n12 = $stmt12->fetch())
  		  ?>
        </select>
        </p>
      </div></td>
    </tr>
    <tr>
      <td height="30" colspan="4"  class="text"><strong><em>DETALLES DE LA INCAPACIDAD</em></strong>:
        <input name="observacion" type="text" class="textbox" id="observacion" value="" size="100" />
        <label for="otro"></label>
        <input name="Enviar" type="submit" class="botones" onClick="crearinc('<?php echo $id; ?>',$('#cedula').val(),$('#codausentismo').val(),$('#numero_inc').val(),$('#f_inicial').val(),$('#f_final').val(),$('#ndias').val(),'<?php echo $row_n13['ENT_CODIGO']." ".$row_n13['ENT_NOMBRE'] ?>',$('#motivo').val(),$('#observacion').val(), $('#referencia').val()); return false;" value="GENERAR"/></td>
      
    </tr>
  </table>
 
  </form>
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
