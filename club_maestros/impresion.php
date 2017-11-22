<?php 

error_reporting(0);

//recojo variables
$cedula=$_POST['aval'];

//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
$hoy=date("d/m/Y");

	//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}

			
/*  $query = "SELECT EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, SO.NOMBRE_SOCIEDAD
from empleado EMP, sociedad so
where EMP.EMP_SOCIEDAD = SO.COD_SOCIEDAD AND EMP.EMP_CODIGO = '$cedula'" ;
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row_n = $stmt->fetch();
		
		$row_n['NOMBRE'];
		$row_n['NOMBRE_SOCIEDAD'];*/
		

/*	$sql0="SELECT `id_hijo`+1 idhijo, ubicacion, nhijos FROM `hijos` WHERE `cod_empleado` = '$cedula' order by id_hijo desc limit 1";
			  $qry_sql0=$link->query($sql0);
			$rs_qry0=$qry_sql0->fetch_object();  ///consultar 

			if (empty($rs_qry0)) {
						
   						 $id_hijo = '1';
							//exit;
								}
			else{
			  $id_hijo = $rs_qry0->idhijo;
			  $ubicacion = $rs_qry0->ubicacion;
			  $qhijos = $rs_qry0->nhijos;
			  
			}*/
	
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

 function guardarhijo (ubicacion, nhijos, empresa, cedula, id_hijo, tdoc_identidad, doc_identidad, nombre_hijo, apellido_hijo, genero, f_nacimiento, noestudia, basica, superior,  colegio, grado, carrera, jornada, aficiones, talentos, trabaja)  
        {
		if (ubicacion==""){ alert ("La casilla UBICACION es obligatoria")
					document.getElementById('ubicacion').focus();
					}  
		if (nhijos==""){ alert ("La casilla NUMERO DE HIJOS es obligatoria")
					document.getElementById('nhijos').focus();
					} 
		if (tdoc_identidad==""){ alert ("La casilla TIPO DE DOCUMENTO es obligatoria")
					document.getElementById('tdoc_identidad').focus();
					}
		if (doc_identidad==""){ alert ("La casilla DOCUMENTO DE IDENTIDAD es obligatoria")
					document.getElementById('doc_identidad').focus();
					} 
		if (nombre_hijo==""){ alert ("La casilla NOMBRE DE HIJO es obligatoria, Llenela y oprimir el boton DAR CLICK")
					document.getElementById('nombre_hijo').focus();
					}		
		if (genero==""){ alert ("La casilla GENERO es obligatoria")
					document.getElementById('genero').focus();
					}
		if (f_nacimiento==""){ alert ("La casilla FECHA DE NACIMIENTO es obligatoria")
					document.getElementById('f_nacimiento').focus();
					}
		if (noestudia==""&&basica==""&&superior==""){ alert ("No ha seleccionado la EDUCACION")
					document.getElementById('f_nacimiento').focus();
					}
		if (aficiones==""){ alert ("La casilla AFICIONES es obligatoria")
					document.getElementById('aficiones').focus();
					}
		if (talentos==""){ alert ("La casilla TALENTOS es obligatoria. Los talentos son actividades en las cuales su hijo se desempeña bien")
					document.getElementById('talentos').focus();
					}

		else {
			
				var respuesta=confirm("ACEPTAR: Si todos los campos en gris estan llenos, de los contrario oprima CANCELAR y diligencie completamente");
     			if(respuesta==true){
					
				var parametros = {
				"ubicacion": ubicacion,
				"nhijos": nhijos,
				"empresa": empresa,
				"cedula": cedula,
				"tdoc_identidad": tdoc_identidad,
				"doc_identidad": doc_identidad,
				"id_hijo": id_hijo,
				"nombre_hijo": nombre_hijo,
				"apellido_hijo": apellido_hijo,
				"genero": genero,
				"noestudia": noestudia,				
				"basica": basica,
				"superior": superior,
				"f_nacimiento": f_nacimiento,
				"colegio": colegio,
				"grado": grado,
				"carrera": carrera,
				"jornada": jornada,
				"aficiones": aficiones,
				"talentos": talentos,	
				"trabaja": trabaja,	
               	};
				$.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/actualiza_hijos/guarda_hijo.php',
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
			 else
         return 0;
        }
		
			}
	
	
	
	function verificar_hijo(cedula)  
        {   
				var parametros = {
				"cedula": cedula,
               	};
				$.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/actualiza_hijos/verificar_hijo.php',
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

</script>

<script>
function concate(nombre1, nombre2, apellido1, apellido2)
{
	var nombrehijo =  nombre1 +' '+ nombre2;
	var apellidohijo =  apellido1 +' '+ apellido2 ;
	   
		document.getElementById('nombre_hijo').value = nombrehijo;
		document.getElementById('apellido_hijo').value = apellidohijo;


	//return(nombre);
	};
</script>

<script language="JavaScript">
function edad(f1, f2){

 var aFecha1 = f1.split('/'); 
 var aFecha2 = f2.split('/'); 
 var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]); 
 var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]); 
 var dif = fFecha2 - fFecha1;
 var dias = Math.floor(((dif / (1000 * 60 * 60 * 24)))/360); 


document.getElementById('pepe').value = dias + " años"
 
 }
</script>

<script language="JavaScript">
function activar(){
document.getElementById('basica').style="display:initial"
document.getElementById('superior').style="display:none"
document.getElementById('noestudia').style="display:none"
document.getElementById('basica').className="subtitulos"
document.getElementById('grado').style.visibility = "visible";
document.getElementById('colegio').style.visibility = "visible";
document.getElementById('carrera').style.visibility = "hidden";
document.getElementById('jornada').style.visibility = "visible";

}
</script>

<script language="JavaScript">
function activarsuperior(){
document.getElementById('superior').style="display:initial"
document.getElementById('basica').style="display:none"
document.getElementById('noestudia').style="display:none"
document.getElementById('superior').className="subtitulos"
document.getElementById('grado').style.visibility = "visible";
document.getElementById('colegio').style.visibility = "visible";
document.getElementById('carrera').style.visibility = "visible";
document.getElementById('jornada').style.visibility = "visible";

}
</script>

<script language="JavaScript">
function activarno(){
document.getElementById('noestudia').style="display:initial";
document.getElementById('basica').style="display:none";
document.getElementById('superior').style="display:none";
document.getElementById('noestudia').className="subtitulos";
document.getElementById('grado').style.visibility = "hidden";
document.getElementById('colegio').style.visibility = "hidden";
document.getElementById('carrera').style.visibility = "hidden";
document.getElementById('jornada').style.visibility = "hidden";
}
</script>





</head>
<body>

<p>
<div align="center"></div>
<form  id="formulario" action="">	
  <table width="80%" border="0" align="center"  style="border-collapse:collapse">
   
    <tr>
      <td colspan="8" align="left" valign="middle"><h2 class="encabezados">SOLICITUD DE AFILIACION CLUB DE MAESTROS </h2>
      <h2 class="encabezados">EL ESPECIALISTA</h2></td>
    </tr>
   
    <tr>
      <td align="left" valign="middle">SALA DE VENTAS</td>
      <td colspan="7" align="left" valign="middle"><select name="sala" id="sala">
      </select></td>
    </tr>
    <tr>
      <td align="left" valign="middle">NOMBRE DE ASESOR</td>
      <td colspan="7" align="left" valign="middle"><label>
        <input name="asesor" type="text" class="intro_tk" id="asesor" size="60">
      </label></td>
    </tr>
    <tr>
      <td colspan="8" align="left" valign="middle">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="8" align="left" valign="middle"><em><strong>DATOS PERSONALES</strong></em></td>
    </tr>
    <tr>
      <td align="left" valign="middle">NOMBRES Y APELLIDOS</td>
      <td colspan="7" align="left" valign="middle"><label>
        <input name="nombre" type="text" class="intro_tk" id="nombre" size="60">
      </label></td>
    </tr>
    <tr>
      <td align="left" valign="middle">No  CEDULA</td>
      <td align="left" valign="middle"><input name="cedula" type="text" class="intro_tk" id="cedula" size="20"></td>
      <td width="88"  align="justify" >expedida en</td>
      <td colspan="5"  align="justify" ><input name="cedula2" type="text" class="intro_tk" id="cedula2" size="20"></td>
    </tr>
    <tr>
      <td align="left" valign="middle">GENERO</td>
      <td width="140" align="left" valign="middle"><input type="radio" name="RadioGroup1" value="opción" id="RadioGroup1_0">
Masculino </td>
      <td colspan="2"  align="justify" ><table width="200">
          
          <tr>
            <td><label>
              <input type="radio" name="RadioGroup1" value="opción" id="RadioGroup1_1">
              Femenino
            </label></td>
          </tr>
      </table></td>
      <td width="122" colspan="2"  align="justify" >Fecha de Nacimiento</td>
      <td colspan="2"  align="justify" ><label>
        <input name="fnacimiento" type="text" class="intro_tk" id="fnacimiento" size="25">
      </label></td>
    </tr>
    <tr>
      <td colspan="2" align="left" valign="middle">ESTADO CIVIL</td>
      <td colspan="2" align="left" valign="middle"><input name="ecivil" type="text" class="intro_tk" id="ecivil" size="25"></td>
      <td colspan="2" align="left" valign="middle">No DE HIJOS</td>
      <td colspan="2" align="left" valign="middle"><input name="hijos" type="text" class="intro_tk" id="hijos" size="25"></td>
    </tr>
    <tr>
      <td colspan="2" align="left" valign="middle">DIRECCION RESIDENCIA</td>
      <td colspan="2" align="left" valign="middle"><input name="direccion" type="text" class="intro_tk" id="direccion" size="30"></td>
      <td colspan="2" align="left" valign="middle">CIUDAD</td>
      <td colspan="2" align="left" valign="middle"><input name="ciudad" type="text" class="intro_tk" id="ciudad" size="25"></td>
    </tr>
    <tr>
      <td width="173" align="left" valign="middle">TELEFONO</td>
      <td colspan="2" align="left" valign="middle"><input name="telefono" type="text" class="intro_tk" id="telefono" size="15"></td>
      <td width="127"  align="justify" >CELULAR</td>
      <td colspan="2"  align="justify" ><input name="celular" type="text" class="intro_tk" id="celular" size="15"></td>
      <td width="65"  align="justify" >E-MAIL</td>
      <td width="143"  align="justify" ><input name="email" type="text" class="intro_tk" id="email" size="15"></td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="middle">EMPRESA PARA LA QUE TRABAJA
        <label for="id_hijo"></label>      </td>
      <td colspan="5" align="left" valign="middle"><input name="emplabora" type="text" class="intro_tk" id="emplabora" style="background:#CCC" size="45"></td> 
    </tr> 
    <tr>
      <td height="19" colspan="8" align="left" valign="middle">&nbsp;</td>
    </tr>
    
  </table>
  <p>&nbsp;</p>
  <table width="80%" border="1" align="center">
    <tr>
      <td><p>&nbsp;</p>
        <p align="justify">Yo _________________ identificado con cedula de ciudadania No ________________ Expedida en ______________ actuando en nombre propio y conforme a la ley 1581 de 2012 y demas Decretos reglamentarios, autorizo a la EMPRESA para el tratamiento y manejo de mis datos personales el cual consiste en recolectar, almacenar, depurar, usar analizar, circular, actualizar, cruzar informacion propia, encuestas de satisfaccion, fidelizacion, estadisticos, y demas actividades de mercadeo y publicidad; análisis de información; inteligencia de mercado; envio de informacion acerca de nuestros productos, serviocios, pronmociones, eventos, alianzas y ofertas entre otros; y merjoramiento de servicio asi como me comprometo con el club a:</p>
        <p>1. Dejar en alto el nombre de la compañia Ceramigres y del Club El Especialista.</p>
        <p>2. Informacion a la Dirección general del Club, por escrito, cualquier cambio de mi estado cvivil o cualquiera de los datos suministrados.</p>
        <p>3. A utilizar el carnet como documento personal e Intrasferible.</p>
        <p>_________________</p>
        <p>Firma del titular</p>
        <p>CC. ______________ de ____________ Fecha de radicado: _______________ Anexar cedula.</p>
      <p>Recibido por el funcinario _________________</p></td>
    </tr>
    <tr>
      <td width="743"><p>
        <input type="submit" name="nvo_hijo" id="nvo_hijo" value="Guardar e Imprimir"  onClick="guardarhijo($('#ubicacion').val(), $('#nhijos').val(), $('#empresa').val(),'<?php echo $cedula;?>','<?php echo $id_hijo;?>',$('#tdoc_identidad').val(),$('#doc_identidad').val(),$('#nombre_hijo').val(), $('#apellido_hijo').val(), $('#genero').val(),$('#f_nacimiento').val(), $('#noestudia').val(), $('#basica').val(),$('#superior').val(),$('#colegio').val(),$('#grado').val(),$('#carrera').val(),$('#jornada').val(),$('#aficiones').val(), $('#talentos').val(), $('#trabaja').val()); return false;" >
      </p></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  </p>
  </p>
</form>
 <p>