
<?php 

//error_reporting(0);


//recojo variables
$id=$_POST['id'];


require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

$sql2="SELECT `id_hijo`, `nombre_hijo`,`apellido_hijo`, `genero`, `f_nacimiento`, `educacion`, `programa`, `colegio`, `grado`, `jornada`, `aficiones`, `talento` FROM `hijos` WHERE `id` = '$id' ";
		$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
			
			
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CLIENTE INTERNO</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
 
<link rel="stylesheet" type="text/css" href="../estilos.css"/>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <script>
   function act_hijo(id, educacion, programa, colegio, grado, jornada, aficiones, talentos)
        {	//alert("ACTUALIZANDO");
				var parametros = {
				"id": id,
				"educacion": educacion,
				"programa": programa,
				"colegio": colegio,
				"grado": grado,
				"jornada": jornada,
				"aficiones": aficiones,
				"talentos": talentos,
				};
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/actualiza_hijos/actualizar_hijo.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
						alert("A C T U A L I Z A D O")
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta").html(response);
						document.getElementById('guardar').disabled=true;
									
						
                    }
        
        });
        }
		
	
		  </script>

          
</head>
<body>


      
<div id="respuesta"></div>

<div id="accordion">

  <div>
    <p>
    <table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="72%" height="82%">
    
	     <tr>
          
           <td height="27" colspan="4" align="left" valign="middle" class="encabezados"><strong>Nombre</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"> <label for="nombre"></label>
        <input name="nombre" type="text" class="subtitulos" id="nombre" value="<?php echo utf8_encode($rs_qry2->nombre_hijo." ".$rs_qry2->apellido_hijo); ?>" size="100" readonly></td>  
     </tr>
      <tr>
       
      <td height="26" colspan="4" align="left" valign="middle" bgcolor="#999999" class="encabezados"><strong>Educacion</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><label for="educacion"></label>
        <label>
          <select name="educacione" id="educacione">
          <option value="<?php echo utf8_encode($rs_qry2->educacion); ?>"> <?php echo utf8_encode($rs_qry2->educacion); ?></option>
           <option value="ingresa_proximo_semestre">Ingresa el proximo semestre</option>
        <option value="no_existen_recursos">No existen recursos</option>
        <option value="toma_corto_descanso">Toma un corto descanso</option>
        <option value="no_deside_que_estudiar">No deside que estudiar</option>
        <option value="no_quiere">No quiere estudiar</option>
         <option value="jardin">Jardin</option>
        <option value="primaria">Primaria</option>
        <option value="secundaria">Secundaria</option>
         <option value="tecnico">Tecnico</option>
        <option value="tecnologo">Tecnologo</option>
        <option value="profesional">Profesional</option>
        <option value="especializacion">Especialización</option>
          
          </select>
      </label></td>
     </tr>
      <tr>
       
      <td height="32" colspan="4" align="left" valign="middle"  bgcolor="#999999" class="encabezados"><strong>Programa</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><input name="programa" type="text" id="programa" size="100" value="<?php echo utf8_encode($rs_qry2->programa); ?>"></td>
     </tr>

      <tr>
    
      <td height="26" colspan="4" align="left" valign="middle" class="encabezados"><strong>Colegio</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><label for="colegio"></label>
       
        <input type="text" name="colegio" id="colegio" size="100" value="<?php echo utf8_encode($rs_qry2->colegio); ?>"></td> 
     </tr>
      <tr>
    
      <td height="52" colspan="4" align="left" valign="middle" class="encabezados"><strong>Grado</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><label for="grado"></label>
        <select name="grado" id="grado">
          <option value="<?php echo utf8_encode($rs_qry2->grado); ?>"><?php echo utf8_encode($rs_qry2->grado); ?></option>
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
      </select></td> 
  </tr>
  <tr>
     
      <td height="73" colspan="4" align="left" valign="middle" class="encabezados"><strong>Jornada</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><label for="grado"></label>
        <select name="jornada" id="jornada">
          <option value="<?php echo utf8_encode($rs_qry2->jornada); ?>"><?php echo utf8_encode($rs_qry2->jornada); ?></option>
		 <option value="mañana">Mañana</option>
          <option value="tarde">Tarde</option>
          <option value="noche">Noche</option>
          <option value="dia">Todo el dia</option>
    </select>
        
       
        </td> 
  </tr>
  <tr>
    <td height="73" colspan="4" align="left" valign="middle" class="encabezados">Aficiones</td>
    <td class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><input type="text" name="aficiones" id="aficiones" size="100" value="<?php echo utf8_encode($rs_qry2->aficiones); ?>"></td>
  </tr>
  <tr>
    <td height="73" colspan="4" align="left" valign="middle" class="encabezados">Talentos</td>
    <td class="header" colspan="6" align="justify" bgcolor="#999999" valign="middle"><input type="text" name="talentos" id="talentos" size="100" value="<?php echo utf8_encode($rs_qry2->talento); ?>"></td>
  </tr>
   <tr>

   
        <td class="header" colspan="6" align="center" valign="middle"><input align="right" name="guardar" type="submit" class="botones" onclick="act_hijo('<?php echo $id;?>', $('#educacione').val(), $('#programa').val(),$('#colegio').val(),  $('#grado').val(),$('#jornada').val(), $('#aficiones').val(),$('#talentos').val())" id="guardar" value="GUARDAR" /></td>
  </tr>
</table>

    </p>
  </div>
</div>
                
<footer style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold">

 </footer>
 
 

