<?php
error_reporting(0);

//recojo variables
$id=$_POST['iditem'];
$cedulaingreso=$_POST['cedulaingreso'];


require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
		
$sql3="SELECT  s.cc cc, s.nombre sala, se.descripcion_elemento, ss.observacion, ss.cantidad, ss.ubicacion, uq.nombre nombreemp, ss.entrega, ss.fecha FROM `suministros_sala` ss INNER JOIN SUMINISTROS_ELEMENTOS se on ss.elemento = se.id
inner join act_man2.usuarios_queryx uq on ss.cedula = uq.cedula inner join salas s on ss.sala = s.cc
WHERE ss.id = '$id'";
		$qry_sql3=$link->query($sql3);		
			$rs_qry3=$qry_sql3->fetch_object();  ///consultar 		
		
	   $sqls = "SELECT cc, nombre FROM `salas` WHERE `activo` = '1' order by nombre";
			$qry_sqls=$link->query($sqls);
			$rs_qrys=$qry_sqls->fetch_object();  ///consultar 
		
		
		
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ARES::Recursos Humanos</title>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
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



function actualizar_responsabledestino(id, saladestino, ubicacion, cantidaddestino, responsablenuevo, cedulaingreso)
{  
		var opcion = document.getElementById("RadioGroup1_0").checked; 
		
	var parametros = {		
				"id": id,
				"saladestino": saladestino,
				"ubicacion": ubicacion,
				"cantidaddestino": cantidaddestino,
				"responsablenew": responsablenuevo,
				"cedulaingreso": cedulaingreso,
				"opcion": opcion,
				};
		$.ajax({
                data: parametros,
                url:'http://190.144.42.83:9090/plantillas/suministros/update_responsable.php', 
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
	
function llenarnuevo(cedulares)
{ 
	var parametros = {		
				"cedulares": cedulares,
				};
		$.ajax({
                data: parametros,
                url:'http://190.144.42.83:9090/plantillas/suministros/buscardatos.php', 
				    type: 'post',
                    beforeSend: function () 
                    {
                        $("#validadorced").html("	");
                    },
        
                    success: function (response) 
                    {
                        //$("#validador").html(response);
						document.getElementById("nombre_nuevo1").value = response; //guaradr en un campo de texto
						
						
		
			
				-->		document.getElementById("nombre").value = response;	
					-->	document.getElementById("cargo").value = "ninguno";				
                    }
        
        });
		}	



</script>

<script language="JavaScript">
function activar(){
document.getElementById('cantidaddestino').style="background-color:gray"
document.getElementById('generar').style="display:initial;" 	


}
function activardistribuir(){
document.getElementById('cantidaddestino').style="display:initial"
document.getElementById('generar'). style="display:initial;" 	
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
              <th scope="col">Asignar o distribuir elementos</th>
            </tr>
          </table>
          <table width="200">
            <tr>
              <td><label>
                <input type="radio" name="RadioGroup1" value="asignar" id="RadioGroup1_0" onClick="activar()" />
                asignar</label></td>
           
              <td><label>
                <input type="radio" name="RadioGroup1" value="distribuir" id="RadioGroup1_1"  onClick="activardistribuir()"; />
                distribuir</label></td>
            </tr>
          </table>
          <p><br>
            <b>Item elemento:  </b>
            <label for="resp_actual"></label>
            <input name="resp_actual" type="text" id="resp_actual"  value="<?php echo $rs_qry3->descripcion_elemento." - ".$rs_qry3->sala; ?>" size="50" readonly="readonly"/>
          </p>
          <p><b>Sala destino:</b>
            <label for="sala_destino"></label>
            <label for="nombre_actual4"></label>
            <label for="saladestino"></label>
            <select name="saladestino" id="saladestino">
              <option value="<?PHP echo $rs_qry3->cc;?>"><?PHP echo $rs_qry3->sala;?></option>
              
          <?php    
			do  
		    {
    	    ?>
          <option value="<?php echo $rs_qrys->cc;?>"> <?php echo  utf8_encode($rs_qrys->nombre); ?></option>
          <?php
   		 }   while ($rs_qrys=$qry_sqls->fetch_object())
  		  ?>
        </select>
            </select>
            <b>Ubicacion: 
            <select name="ubicacion" id="ubicacion">
            <option value="">Seleccione</option>        
            <option value="Archivo">Archivo</option>
            <option value="Armario IT">Armario IT</option>
            <option value="Bodega1">Bodega1</option>
            <option value="Bodega2">Bodega2</option>
            <option value="Bodega3">Bogode3</option>
            <option value="Caja">Caja</option>
            <option value="Camion Pegomax">Camion Pegomax</option>
            <option value="Cocina">Cocina</option>
            <option value="Laboratorio">Laboratorio</option>
            <option value="Mantenimiento">Mantenimiento</option>
            <option value="Oficina">Oficina</option>
            <option value="Planta Arena">Planta Arena</option>
            <option value="Planta Pegante">Planta Pegante</option>
            <option value="Sala">Sala</option>
            </select>
            </b></p>
          <p><b>Cantidad a reasignar:</b>
            <label for="cantidaddestino"></label>
            <input name="cantidaddestino" type="text" id="cantidaddestino" value="<?PHP echo $rs_qry3->cantidad;?>" size="5"/>
            <label for="nombre_actual2"></label>
          </p>
          <p><b>Cedula Responsable Actual:</b>
            <label for="resp_actual3"></label>
            <input name="resp_actual3" type="text" id="resp_actual3"  value="<?PHP echo $rs_qry3->nombreemp;?>" size="60" readonly="readonly"/>
            <label for="nombre_actual3"></label>
          </p>
          <p>
            <b> Cedula Responsable Nuevo: </b>
            <label for="resp_nuevo"></label>
            <input name="resp_nuevo" type="text" id="resp_nuevo" size="15" onChange="llenarnuevo(this.value);" />             <input name="nombre_nuevo1" type="text" id="nombre_nuevo1" size="60" />        
            <span style="color:#039">
             <input name="generar" type="button" id="generar" onclick="actualizar_responsabledestino('<?PHP echo $id;?>',$('#saladestino').val(),$('#ubicacion').val(),$('#cantidaddestino').val(),$('#resp_nuevo').val(), '<?PHP echo $cedulaingreso;?>'); return false;" value="ACTUALIZAR" class="botones"  style="display:none;" 															/>
            </span><br>
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