<?php 

//error_reporting(0);

//recojo variables
$CC=$_POST['sala'];

//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

 ?>



<!doctype html>
<html lang="en">
<head>


<style type='text/css'>
tr:nth-child(odd) {
    background-color:#f2f2f2;
}
tr:nth-child(even) {
	background-color: #fbfbfb;
	
	
}

</style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Actualizacion Datos</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="../estilos.css">
 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script src="http://momentjs.com/downloads/moment.min.js"></script>
<script>

 function guardarmaestro (sala, nombre, cedula, expe, genero, fnacimiento, ecivil, hijos, direccion, ciudad, telefono, celular, email,  emplabora, nombreref, telefonoref,  emailref) 
         { // alert(hijos);
		if (sala==""){ alert ("La casilla SALA es obligatoria")
					document.getElementById('sala').focus();
					return false;
					}  
	
		if (nombre==""){ alert ("La casilla NOMBRE es obligatoria")
					document.getElementById('nombre').focus();
					return false;
					}
		if (cedula==""){ alert ("La casilla CEDULA es obligatoria")
					document.getElementById('cedula').focus();
					return false;
					} 
		if (expe==""){ alert ("La casilla EXPEDIDA es obligatoria")
					document.getElementById('expe').focus();
					return false;
					}		
		if (genero==""){ alert ("La casilla GENERO es obligatoria")
					document.getElementById('genero').focus();
					return false;
					}
		if (fnacimiento==""){ alert ("La casilla FECHA DE NACIMIENTO es obligatoria")
					document.getElementById('fnacimiento').focus();
					return false;
					}
		if (ecivil==""){ alert ("La casilla ESTADO CIVIL es obligatoria")
					document.getElementById('ecivil').focus();
					return false;
					}
		if (direccion==""){ alert ("La casilla DIRECCION es obligatoria")
					document.getElementById('direccion').focus();
					return false;
					}
		if (ciudad==""){ alert ("La casilla CIUDAD es obligatoria")
					document.getElementById('ciudad').focus();
					return false;
					}
		if (celular==""){ alert ("La casilla CELULAR es obligatoria")
					document.getElementById('celular').focus();
					return false;
					}
	
	
		else {
			
				var respuesta=confirm("ACEPTAR: Si todos los campos en gris estan llenos, de los contrario oprima CANCELAR y diligencie completamente");
     			if(respuesta==true){
						
				var parametros = {
				"sala": sala,
				"nombre": nombre,
				"cedula": cedula,
				"expe": expe,
				"genero": genero,
				"fnacimiento": fnacimiento,
				"ecivil": ecivil,
				"hijos": hijos,
				"direccion": direccion,
				"ciudad": ciudad,				
				"telefono": telefono,
				"celular": celular,
				"email": email,
				"emplabora": emplabora,
					};
				$.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/club_maestros/guardar_maestro.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#validador").html(response);
							//imprSelec('validador');	
							document.getElementById("nvo_maestro").style.display = 'none';				
                    }
        
        });
		}
			 else
         return 0;
        }
		
			}
	
function duplex(cedula)
{
	var parametros = {		
				"cedula": cedula,
				};
		$.ajax({
                data: parametros,
                url:'http://190.144.42.83:9090/plantillas/club_maestros/duplex_maestro.php', 
				    type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador2").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
						//alert(response);
                       $("#validador2").html(response);
					if(response == 1){
					//	alert("algo pasa")
					}
				//		}	
					else {	
					//	alert("sigue pasando");
						document.getElementById("nombre").value = response; //guaradr en un campo de texto
						alert ("EL MAESTRO "+response+"YA PERTENECE AL CLUB DE ESPECIALISTAS");
						document.getElementById("nvo_maestro").style.display = 'none';	
						window.open("http://190.144.42.83:9090/plantillas/solicitudes/comercial.php");
					-->	document.getElementById("cargo").value = "ninguno";	
								
					}
                   }
        
        });
		}	
</script>
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
     $("#fnacimiento" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  yearRange: '-70:-18'
       });
    });
	
	    function justNumbers(e)
            {
            var keynum = window.event ? window.event.keyCode : e.which;
            if ((keynum == 8) || (keynum == 46))
            return true;
             
            return /\d/.test(String.fromCharCode(keynum));
            }
	
/*	function ValidaMail(emaile) {
		alert (emaile)
   if(emaile, FILTER_VALIDATE_EMAIL) {
       return true;
    } else {
       return false;
    }
} */
</script>



</head>
<body>

<p>


<div id="validador">
  </div>

  

  <table width="80%" border="0" align="center"  style="border-collapse:collapse">
   
    <tr>
      <td colspan="7" align="left" valign="middle"><h2 class="encabezados">AFILIACION CLUB DE MAESTROS &quot;EL ESPECIALISTA&quot;</h2></td>
    </tr>
   
    <tr>
      <td colspan="7" align="left" valign="middle">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="7" align="left" valign="middle"><em><strong>DATOS PERSONALES</strong></em></td>
    </tr>
    <tr>
      <td align="left" valign="middle">No  CEDULA      </td>
      <td align="left" valign="middle"><input name="cedula" type="text" class="intro_tk" id="cedula" size="20" onkeypress="return justNumbers(event);" onChange="duplex(this.value)"></td>
      <td colspan="5" align="left" valign="middle">expedida en
      <input name="expe" type="text" class="intro_tk" id="expe" size="20" style="text-transform:uppercase;"></td>
    </tr>
    <tr>
      <td align="left" valign="middle">NOMBRES Y APELLIDOS</td>
      <td colspan="6" align="left" valign="middle"><input name="nombre" type="text" class="intro_tk" id="nombre" size="60" style="text-transform:uppercase;"></td>
    </tr>
    <tr>
      <td align="left" valign="middle">GENERO</td>
      <td width="210" align="left" valign="middle"><label>
        <select name="genero" id="genero">
          <option value="">Seleccione...</option>
          <option value="F">FEMENINO</option>
          <option value="M">MASCULINO</option>
        </select>
      </label></td>
      <td colspan="2"   align="right" >Fecha de Nacimiento</td>
      <td colspan="2"  align="justify" ><label>
        <input name="fnacimiento" type="text" class="intro_tk" id="fnacimiento" size="25">
      </label></td>
    </tr>
    <tr>
      <td align="left" valign="middle">ESTADO CIVIL</td>
      <td align="left" valign="middle"><label>
        <select name="ecivil" id="ecivil">
        <option value="">Seleccione...</option>
          <option value="SOLTERO">SOLTERO</option>
          <option value="CASADO">CASADO</option>
          <option value="U. LIBRE">U. LIBRE</option>
          <option value="SEPARADO">SEPARADO</option>
        </select>
      </label></td>
      <td colspan="2" align="left" valign="middle">&nbsp;</td>
      <td width="73" align="left" valign="middle">HIJOS</td>
      <td align="left" valign="middle"><label>
        <select name="hijos" id="hijos">
        <option value="">Seleccione...</option>
          <option value="0">0</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td align="left" valign="middle">DIRECCION RESIDENCIA</td>
      <td align="left" valign="middle"><input name="direccion" type="text" class="intro_tk" id="direccion" size="30" style="text-transform:uppercase;"></td>
      <td colspan="2" align="left" valign="middle">&nbsp;</td>
      <td align="left" valign="middle">CIUDAD</td>
      <td align="left" valign="middle"><input name="ciudad" type="text" class="intro_tk" id="ciudad" size="25" style="text-transform:uppercase;"></td>
    </tr>
    <tr>
      <td width="182" align="left" valign="middle">TELEFONO</td>
      <td colspan="2" align="left" valign="middle"><input name="telefono" type="text" class="intro_tk" id="telefono" size="15" 
      onkeypress="return justNumbers(event);">
      CELULAR</td>
      <td width="143"  align="justify" ><input name="celular" type="text" class="intro_tk" id="celular" size="15" onkeypress="return justNumbers(event);"></td>
      <td  align="justify" >E-MAIL</td>
      <td width="254"  align="justify" ><input name="email" type="text" class="intro_tk" id="email" size="25"></td>
     
    </tr>
    <tr>
      <td colspan="3" align="left" valign="middle">EMPRESA PARA LA QUE TRABAJA
        <label for="id_hijo"></label> 
        (Opcional)     </td>
      <td colspan="4" align="left" valign="middle"><input name="emplabora" type="text" class="intro_tk" id="emplabora" size="45" style="text-transform:uppercase;" ></td>

    </tr> 
    <tr>
      <td height="19" colspan="7" align="left" valign="middle">&nbsp;</td>
    </tr>
    
  </table>
  <p>&nbsp;</p>
  <table width="80%" border="0" align="center">
    <tr>
      <td width="8" align="center"><p>
        <input type="submit" name="nvo_maestro" id="nvo_maestro" value="Guardar e Imprimir"  onClick="guardarmaestro($('#sala').val(), $('#nombre').val(),$('#cedula').val(),$('#expe').val(),$('#genero').val(), $('#fnacimiento').val(), $('#ecivil').val(),$('#hijos').val(), $('#direccion').val(), $('#ciudad').val(),$('#telefono').val(),$('#celular').val(),$('#email').val(),$('#emplabora').val()); return false;" >
      </p></td>
    </tr>
    
    
  </table>

  
 
  

  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  </p>
  </p>

 <p>