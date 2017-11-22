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

			
  $query = "SELECT EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, SO.NOMBRE_SOCIEDAD
from empleado EMP, sociedad so
where EMP.EMP_SOCIEDAD = SO.COD_SOCIEDAD AND EMP.EMP_CODIGO = '$cedula'" ;
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row_n = $stmt->fetch();
		
		$row_n['NOMBRE'];
		$row_n['NOMBRE_SOCIEDAD'];
		

	$sql0="SELECT `id_hijo`+1 idhijo, ubicacion, nhijos FROM `hijos` WHERE `cod_empleado` = '$cedula' order by id_hijo desc limit 1";
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
			  
			}
	
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
<form  id="formulario">	
  <table width="750" border="1" align="center"  style="border-collapse:collapse">
   
    <tr>
      <td colspan="5" align="left" valign="middle"><h2 class="encabezados">ACTUALIZACION DE DATOS</h2></td>
    </tr>
   
    <tr>
      <td colspan="5" align="left" valign="middle"><strong><em>        Nota: </br>
        </em></strong>
        * Lea atentamente cada uno de los campos y mensajes al finalizar</br>
         
        * Diligencie el formulario en letra mayuscula</td>
    </tr>
    <tr>
      <td width="164" align="left" valign="middle"><strong>Cedula Empleado</strong></td>
      <td colspan="4"  align="justify" > <?php echo   $cedula; ?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Nombre Empleado</strong></td>
      <td colspan="4"  align="justify" ><?php echo $row_n['NOMBRE']; ?></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Empresa</strong></td>
      <td colspan="4"  align="justify" >
      <input type="text" name="empresa" id="empresa" readonly value="<?php echo $row_n['NOMBRE_SOCIEDAD']; ?>"></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Ubicacion</strong></td>
      <td colspan="4" align="left" valign="middle"><p>
        <label for="ubicacion"></label>
        Ciudad - Sala </br>
        <input name="ubicacion" type="text" id="ubicacion" size="50" class="subtitulos"  value="<?php echo $ubicacion; ?>">
        </br>
      </p></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Numero total de hijos:</strong></td>
      <td colspan="4" align="left" valign="middle"><label for="nhijos"></label>
        <select name="nhijos" id="nhijos" class="subtitulos">
		  <option value="<?php echo $qhijos; ?>"><?php echo $qhijos; ?></option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
      </select></td>
    </tr>
    <tr>
      <td  colspan="8" align="center" valign="middle"><h4 class="intro_tk">INFORMACION HIJOS</h4></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Nro de hijo</strong></td>
      <td colspan="4"  align="justify" ><input name="id_hijo" type="text" id="id_hijo" class="subtitulos"  value="<?php echo $id_hijo; ?>" size="5" readonly></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Document de Identidad</strong></td> 
    <td colspan="4"  align="justify" ><label for="tdoc_identidad"></label>
      <select name="tdoc_identidad" id="tdoc_identidad" style="background:#CCC">
      <option value="">Seleccione..</option>
        <option value="RC">Registro Civil</option>
        <option value="TI">Tarjeta de Identidad</option>
        <option value="CC">Cedula</option>
      </select> 
      No.      
      <label for="doc_identidad"></label>
      <input type="text" name="doc_identidad" id="doc_identidad" style="background:#CCC">      <label for="id_hijo"></label></td>      
    </tr> 
    <tr>
      <td height="81" rowspan="3" align="left" valign="middle"><strong>Nombres y Apellidos COMPLETOS</strong></td> 
      <td align="justify" valign="middle" class="textbox">PRIMER NOMBRE</td>
      <td align="justify" valign="middle" class="textbox">SEGUNDO NOMBRE</td>
      <td align="justify" valign="middle" class="textbox">PRIMER APELLIDO</td>
      <td align="justify" valign="middle" class="textbox">SEGUNDO APELLIDO</td> 
    </tr>
    <tr>
      <td align="justify" valign="middle"><input style="background:#CCC" type="text" name="nombre1" id="nombre1"></td>
      <td align="justify" valign="middle"><input style="background:#CCC" type="text" name="nombre2" id="nombre2"></td>
      <td align="justify" valign="middle"><input style="background:#CCC" name="apellido1" type="text" id="apellido1" size="29" 
             ></td>
      <td align="justify" valign="middle"><input style="background:#CCC" type="text" name="apellido2" id="apellido2"></td>
    </tr>
    <tr>
      <td  colspan="4" align="justify" valign="middle"><input type="submit" name="unir" id="unir" value="Click aquí" onClick="concate($('#nombre1').val(), $('#nombre2').val(), $('#apellido1').val(), $('#apellido2').val()); return false;">        <input  name="nombre_hijo" type="text" id="nombre_hijo" size="30" 
          readonly >
      <input name="apellido_hijo" type="text" id="apellido_hijo" size="50" readonly></td>
    </tr> 
 <tr>
      <td align="left" valign="middle"><strong>Genero</strong></td> 
    <td  colspan="4" align="justify" valign="middle"><label for="genero"></label>
      <select name="genero" size="1" id="genero" style="background:#CCC">
      <option value="">Seleccione...</option>
        <option value="M">Masculino</option>
        <option value="F">Femenino</option>
      </select></td>      
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Fecha Nacimiento (DD/MM/AAAA)</strong></td> 
      <td colspan="2" align="justify"  valign="middle">
    
        <h6>
          <input name="f_nacimiento" type="text"  id="f_nacimiento"  style="background:#CCC" onChange="edad(this.value, '<?php echo $hoy; ?>' )"   required/>          
          Ej: (31/12/2005)
      </td>
      <td align="justify"  valign="middle">Edad:</td>
      <td align="justify"  valign="middle">
      <input name="pepe" type="text" class="subtitulos" id="pepe" size="10"  readonly />
      </td>
    </tr>
    <tr>
      <td rowspan="2" align="left" valign="middle"><p><strong>EDUCACION</strong> (Actualmente)</p></td>
      <td colspan="2" align="left" valign="middle"> <p>
          <input type="radio" name="educacion" value="noestudia" id="educacion_2" onClick="activarno();">
           <strong> No estudia </strong></label>
          <label for="noestudia"></label>
      </p>
    </td>
      
      <td align="justify" valign="middle"><table width="178">
        <tr>
          <td width="126"><label>
            <input type="radio" name="educacion" value="basica" id="educacion_0" onClick="activar();">
            <strong> Estudios Básicos </strong> (Jardín, Primaria, Secundaria)</label></td>
          </tr>
        <tr>
          
          </tr>
        </table>
      <td colspan="2" align="justify" valign="middle"><input type="radio" name="educacion" value="superior" id="educacion_1" onClick="activarsuperior();"> 
        <strong> Estudios superiores </strong>
</tr>
    <tr>
      <td colspan="2" align="left" valign="middle"><select name="noestudia" size="1" id="noestudia"  style="display:none;">
         <option value="">Seleccione..</option>
         <option value="menor_de_edad">Menor de edad (Bebé)</option>
        <option value="ingresa_proximo_semestre">Ingresa el proximo semestre</option>
        <option value="no_existen_recursos">No existen recursos</option>
        <option value="toma_corto_descanso">Toma un corto descanso</option>
        <option value="no_deside_que_estudiar">No deside que estudiar</option>
        <option value="no_quiere">No quiere estudiar</option>
      </select></td>
      <td align="justify" valign="middle"><select name="basica" size="1" id="basica" style="display:none;">
        <option value="">Seleccione..</option>
        <option value="jardin">Jardin</option>
        <option value="primaria">Primaria</option>
        <option value="secundaria">Secundaria</option>
        </select>    
      <td colspan="2" align="justify" valign="middle"><select name="superior" id="superior" style="display:none;">
        <option value="">Seleccione</option>
        <option value="tecnico">Tecnico</option>
        <option value="tecnologo">Tecnologo</option>
        <option value="profesional">Profesional</option>
        <option value="especializacion">Especialización</option>
      </select>      
         
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Grado/Semestre/Nivel</strong></td>
      <td colspan="4" align="justify" valign="middle"><label for="superior"></label>
        <select name="grado" size="1" id="grado" style="background:#CCC">
          <option value="">Seleccione..</option>
          <option value="jardin">Jardin</option>
          <option value="transicion">Transición</option>
          <option value="primero">Primero</option>
          <option value="segundo">Segundo</option>
          <option value="tercero">Tercero</option>
          <option value="cuarto">Cuarto</option>
          <option value="quinto">Quinto</option>
          <option value="sexto">Sexto</option>
          <option value="septimo">Septimo</option>
          <option value="octavo">Octavo</option>
          <option value="noveno">Noveno</option>
          <option value="decimo">Decimo</option>
          <option value="Undecimo">Undecimo</option>
        </select>
        </strong></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Entidad educativa</strong></td> 
      <td colspan="4" align="justify" valign="middle"><label for="colegio"></label>
      <input name="colegio" type="text" id="colegio" size="100" style="background:#CCC" ></td> 
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Nombre de programa</strong></td>
      <td colspan="4" align="justify" valign="middle"><label for="carrera"></label>
      <input name="carrera" type="text" id="carrera" size="100" style="background:#CCC">        <label for="grado"></label></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Jornada</strong></td>
      <td colspan="4" align="justify" valign="middle"><label for="jornada"></label>
        <select name="jornada" size="1" id="jornada" style="background:#CCC">
           <option value="">No Aplica</option>
          <option value="mañana">Mañana</option>
          <option value="tarde">Tarde</option>
          <option value="noche">Noche</option>
          <option value="dia">Todo el dia</option>
      </select></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><p><strong>P</strong><strong>asatiempos/aficiones</strong></p></td>
      <td colspan="4" align="justify" valign="middle"><label for="aficiones"></label>
      <input name="aficiones" type="text" id="aficiones" size="100" style="background:#CCC"></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Destrezas/Habilidades</strong></td>
      <td colspan="4" align="justify" valign="middle"><label for="talentos"></label>
      <input name="talentos" type="text" id="talentos" size="100" style="background:#CCC"></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong>Actualmente Trabaja?</strong></td>
      <td colspan="4" align="justify" valign="middle"><select name="trabaja" id="trabaja" style="background:#CCC">
        <option value="no">NO</option>
        <option value="si">SI</option>
      </select></td>
    </tr>
    <tr>
      <td align="left" valign="middle">&nbsp;</td>
      <td width="180" colspan="2" align="justify" valign="middle"><input type="submit" name="nvo_hijo" id="nvo_hijo" value="Guardar Hijo"  onClick="guardarhijo($('#ubicacion').val(), $('#nhijos').val(), $('#empresa').val(),'<?php echo $cedula;?>','<?php echo $id_hijo;?>',$('#tdoc_identidad').val(),$('#doc_identidad').val(),$('#nombre_hijo').val(), $('#apellido_hijo').val(), $('#genero').val(),$('#f_nacimiento').val(), $('#noestudia').val(), $('#basica').val(),$('#superior').val(),$('#colegio').val(),$('#grado').val(),$('#carrera').val(),$('#jornada').val(),$('#aficiones').val(), $('#talentos').val(), $('#trabaja').val()); return false;" ></td>
      <td width="197" colspan="-2" align="justify" valign="middle"><input type="submit" name="verificar" id="verificar" value="Consultar" onClick="verificar_hijo(<?php echo $cedula;?>); return false;"></td>
      <td width="252" colspan="-2" align="justify" valign="middle"><input type="submit" name="salir" id="salir" value="Salir" onClick="window.location.href='http://190.144.42.83/ares/index.php';"></td>
      
    </tr>
    
  </table>
  </p>
  </p>
</form>
 <p>