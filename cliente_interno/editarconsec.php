<?php

//error_reporting(0);

//recojo variables
 $id=$_POST['consec'];



require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
		
 $sql3="SELECT `fecha`, `concepto_esp`,`calificacion`,`hallazgo`,`tarea`,`fecha_control` FROM `concepto_sala` WHERE id = '$id'";
		$qry_sql3=$link->query($sql3);		
			$rs_qry3=$qry_sql3->fetch_object();  ///consultar 		
		
		
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ARES::Recursos Humanos</title>
  
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  
<link rel="stylesheet" type="text/css" href="../estilos.css"/>

<style>
#login {
	border-radius: 20px;
	-moz-border-radius: 20px;
	-webkit-border-radius: 20px;
	height: 250px;
	width: 700px;
	padding: 10px;
	background-color:#EAEAEA;
	font-family:Verdana, Geneva, sans-serif;
	font-size:14px;
	color:#000;
}

</style>
         
 <script>



function actualizar_id()
{ 
//alert("cambio");
var id = document.getElementById("id").value;
var nota = document.getElementById("nota").value;
var tema = document.getElementById("tema").value;
var labor = document.getElementById("labor").value;
var control = document.getElementById("control").value;

//alert(nota); alert(tema); alert(labor); alert(control); 

	var parametros = {		
				"id": id,
				"calificacion": nota,
				"hallazgo": tema,
				"tarea": labor,
				"fcontrol": control,
				};
		$.ajax({
                data: parametros,
                url:'http://190.144.42.83:9090/plantillas/cliente_interno/update_id.php', 
				    type: 'post',
                    beforeSend: function () 
                    {
                        $("#informedet").html("	");
                    },
        
                    success: function (response) 
                    {
                        $("#informedet").html(response);
                    }
        
        });
		}	
	


</script>
        
       
</head>

<body>

       
  <table width="766" height="481" align="center" class="tablas">
 <tr>
    <td>
        <div class="formulario" id="login" style="margin-top: 40px"> 
          <table width="95%" border="1" align="center">
            <tr>
              <th scope="col">Modificar concepto asignado</th>
            </tr>
          </table>
          <p><br>
            <b>Id:  </b>
            <label for="id"></label>
            <input name="id" type="text" id="id"  value="<?php echo $id ?>" size="8" readonly="readonly"/>
            <input name="concepto" type="text" id="concepto"  value="<?php echo $rs_qry3->concepto_esp; ?>" size="50" readonly="readonly"/>
            <label for="concepto"></label>
            <strong>calificacion</strong>:
        	 <input name="nota" type="text" id="nota"  size="10" value="<?php echo $rs_qry3->calificacion; ?>" />
          </p>
          <p><strong>Hallazgo</strong>: 
            <textarea name="tema" cols="100" id="tema"><?php echo $rs_qry3->hallazgo; ?></textarea>
          </p>
          <p>

          <strong>Tarea:</strong>
          <input name="respuesta" type="text" id="respuesta"  size="100" value="<?php echo $rs_qry3->tarea; ?>" />         

          </p>
          <p>Fecha de control:
            <input name="control" type="text" id="control"  value="<?php echo $rs_qry3->fecha_control; ?>" size="20" />
          </p>
          <p> <span style="color:#039">
          <input name="generar" type="button" id="generar" onclick="actualizar_id()" value="ACTUALIZAR" class="botones"  															/>
          </span></p>
          <p>
            <label for="nombre_actual3"></label>
          </p>
          <p><br>
           <br>
           <br> 
           
          </p>
          <p><span style="color:#039"><br>
           <br>
           <br> 
          </span></p>
          <p align="center" style="color:#039"></div>
    </td>
 </tr>
</table>



  
</center>

</body>
</html>