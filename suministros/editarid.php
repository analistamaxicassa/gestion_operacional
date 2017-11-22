<?php

error_reporting(0);

//recojo variables
$id=$_POST['ideditar'];



require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
		
$sql3=" SELECT descripcion_elemento, tipo, serie, marca, observacion FROM `suministros_sala` ss inner join suministros_elementos se on ss.elemento = se.id WHERE ss.id = '$id'";
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

var id = document.getElementById("id").value;
var tipo = document.getElementById("tipoid").value;
var serie = document.getElementById("tiposerie").value;
var marca = document.getElementById("tipomarca").value;
var observacionotra = document.getElementById("observacionotra").value;

//alert(tipo); alert(tipo); alert(serie); alert(marca); 

	var parametros = {		
				"id": id,
				"tipo": tipo,
				"serie": serie,
				"marca": marca,
				"observacion": observacionotra,
				};
		$.ajax({
                data: parametros,
                url:'http://190.144.42.83:9090/plantillas/suministros/update_idelemento.php', 
				    type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("	");
                    },
        
                    success: function (response) 
                    {
                        $("#validador").html(response);
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
              <th scope="col">Modificar elemento</th>
            </tr>
          </table>
          <p><br>
            <b>Id:  </b>
            <label for="id"></label>
            <input name="id" type="text" id="id"  value="<?php echo $id ?>" size="8" readonly="readonly"/>
            <input name="elemento" type="text" id="elemento"  value="<?php echo $rs_qry3->descripcion_elemento; ?>" size="50" readonly="readonly"/>
            <label for="elemento"></label>
          </p>
          <p>Tipo:
        	 <input name="tipoid" type="text" id="tipoid"  size="10" value="<?php echo $rs_qry3->tipo; ?>" />

          
          Serie: 
        <input name="tiposerie" type="text" id="tiposerie"  size="20" value="<?php echo $rs_qry3->serie; ?>" />

          Marca: 
		<input name="tipomarca" type="text" id="tipomarca"  size="8" value="<?php echo $rs_qry3->marca; ?>" />         

          </p>
          <p>observacion:
            <input name="observacionotra" type="text" id="observacionotra"  value="<?php echo $rs_qry3->observacion; ?>" size="50" />
          </p>
          <p><span style="color:#039">
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