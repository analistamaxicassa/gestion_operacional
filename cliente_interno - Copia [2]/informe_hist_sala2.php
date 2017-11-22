
<link rel="stylesheet" type="text/css" href="../estilos.css"/>

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  

  <script>
		 function guardardet(sala, concepto_det, calificacion, hallazgo, tarea, responsable, fcontrol, autor)
        {	
				var parametros = {
				"sala": sala,
				"concepto_det": concepto_det,
				"calificacion": calificacion,
				"hallazgo": hallazgo,
				"tarea": tarea,
				"responsable": responsable,
				"fcontrol": fcontrol,
				"autor": autor,
				};
                $.ajax({
                data: parametros,
                url: 'guardarcs.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta").html(response);
						 {
						
					     document.getElementById('guardar').disabled=true;
		                $("#validador").html(response);

                    }
						
                    }
        
        });
        }
	
	 function consultarinformedet(sala, autor, fechainf)
	  {	
				var parametros = {
				"sala": sala,
				"autor": autor,
				"fechainf": fechainf,
				};
                $.ajax({
                data: parametros,
                url: 'informe_detallado_sala2.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#informedet").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#informedet").html(response);
						 {
						
					    // document.getElementById('guardar').disabled=true;
		                $("#validador").html(response);

                    }
						
                    }
        
        });
        }
       
		
        </script>
 </script>
 <script>

 function send_sala(sala)
        { 
				
				var parametros = {
				"sala": sala,
				};
                $.ajax({
                data: parametros,
                url: 'enviar_informe.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta").html(response);
						 {
						//alert("P R O C E S A D O")
						
					     document.getElementById('enviar').disabled=true;
		                $("#respuesta").html(response);

                    }
						
                    }
        
        });
        }
</script>

 
<script type="text/javascript">
function imprSelec(informedet){
	var ficha=document.getElementById(informedet);
    var ventimp=window.open(' ','popimpr');
	ventimp.document.write(ficha.innerHTML);
	ventimp.document.close();
	ventimp.print();
	ventimp.close();
}
</script> 

   


<table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="60%" align="center">
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>FECHA</strong></td>
      <td class="header" colspan="6"  align="justify" ><strong>AUTOR</strong></td>
      <td class="header"  align="justify" ><strong>CONCEPTO</strong></td>
    </tr>

<?php

//error_reporting(0);
//$sala = '511';
$sala = $_REQUEST['sala'];
//$sala=$_POST['sala'];

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

session_start();  
$cedingreso = $_SESSION['ced'];

if($_SESSION['us'] == '2') {
	
	?>
	
	  <script>
		alert( "USTED NO TIENE PERMISOS PARA INGRESAR A ESTA SECCION")
		
	location.href="selecciona_sala.php?sala=<?php echo $sala ?>"
	
	  </script>
      <?php
	exit();
	}

//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}

////consulta de concepto de sala

			$sql2="SELECT id, fecha, avg(calificacion) concepto, autor FROM `concepto_sala` WHERE cc = '$sala' group by fecha order by id DESC";
			$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
				
		
	if (empty($rs_qry2)) {
    echo 'No existen registros';
	exit();
	}

	else {
		 $rs_qry2->fecha;	
		 $rs_qry2->concepto;
		 $rs_qry2->autor;
			}
do{
	?>
    
<script src="//code.jquery.com/jquery-1.10.2.js"></script>

<form method="post" action="../cliente_interno/selecciona_sala.php">
   <tr>
      <td class="header" colspan="4" align="left" valign="middle"><?php echo utf8_encode($rs_qry2->fecha); ?></td> 
      <td class="header" colspan="6"  align="justify" ><?php echo utf8_encode($rs_qry2->autor); ?></td>
      <td width="281" class="header"  align="justify" > <?php echo number_format(($rs_qry2->concepto),2); ?></td>
    </tr> 

<?php
}
while($rs_qry2=$qry_sql2->fetch_object());	
//}
?>	

<?php
 
//conexion sql

			$sql="SELECT tipo_sala, presupuesto, jefeoperacion FROM salas where cc = '$sala' and activo = '1'";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 
				
		
	if (empty($rs_qry)) {
    echo 'No existen registros';
	exit();
	}
	else {
		
	$tiposala = $rs_qry->tipo_sala;	
	$presupuesto = $rs_qry->presupuesto;
	$jefeoperacion = $rs_qry->jefeoperacion;
		
		
		
		
		}
		
		// nombre de evaluador
		 $query = "SELECT EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE
	FROM EMPLEADO EMP WHERE  EMP.EMP_CODIGO = '$cedingreso'" ;

		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch();	
		
		$nombreemp=$row['NOMBRE'];
				
		

////consulta de concepto de sala

			 $sql2="SELECT id, fecha, avg(calificacion) concepto, autor FROM `concepto_sala` WHERE cc = '$sala' group by fecha order by id DESC LIMIT 1 ";
			$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
				
		
	if (empty($rs_qry2)) {
    echo 'No existen registros';
	exit();
	}
	else {
		$fecha = $rs_qry2->fecha;	
		$concepto = $rs_qry2->concepto;
		$autor = $rs_qry2->autor;
			}

    
////consulta de fechas de informe por sala

			 $sql3="SELECT fecha FROM `concepto_sala` WHERE cc = '$sala' group by fecha";
			$qry_sql3=$link->query($sql3);
			$rs_qry3=$qry_sql3->fetch_object();  ///consultar 
		
	?>


<br> <br>
</table>

<p><br>
</p>
<table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" class="header" >
  <tr class="encabezados">
   
     </tr>
  <tr>
    <th scope="row">CONCEPTO</th>
    <td><select name="concepto_det" id="concepto_det">
      <option value="">Seleccione...</option>
      <option value="UBICACION">UBICACION</option>
      <option value="FACHADA">FACHADA</option>
      <option value="ROMPETRAFICO">ROMPETRAFICO</option>
      <option value="VITRINA">VITRINA</option>
      <option value="EXHIBICION, PUNTO DE REBOSE.">EXHIBICION, PUNTO DE REBOSE.</option>
      <option value="MARCACION PRECIO Vs DESCUENTO (BRILLA) ">MARCACION PRECIO Vs DESCUENTO (BRILLA) </option>
      <option value="COMUNICACIÓN INTERNA">COMUNICACIÓN INTERNA</option>
      <option value="COMUNICACIÓN EXTERNA(CAMPAÑA DEL MES)">COMUNICACIÓN EXTERNA(CAMPAÑA DEL MES)</option>
      <option value="INVENTARIO">INVENTARIO</option>
      <option value="ORDEN Y ASEO EN BODEGA">ORDEN Y ASEO EN BODEGA</option>
      <option value="MARCACION PRODUCTO">MARCACION PRODUCTO</option>
      <option value="CLIENTE INTERNO">CLIENTE INTERNO</option>
      <option value="GEOREFERENCIACION">GEOREFERENCIACION</option>
      <option value="CONOCIMIENTO DEL CLIENTE EXTERNO">CONOCIMIENTO DEL CLIENTE EXTERNO</option>
      <option value="INFORME DE LA COMPETENCIA">INFORME DE LA COMPETENCIA</option>
      <option value="PORTAFOLIO">PORTAFOLIO</option>
      <option value="PRECIOS">PRECIOS</option>
      <option value="INFRAESTRUCTURA">INFRAESTRUCTURA</option>
      <option value="PROCESOS Y/O PROCEDIMIENTOS">PROCESOS Y/O PROCEDIMIENTOS</option>
      <option value="INFORMATICA Y TECNOLOGIA ">INFORMATICA Y TECNOLOGIA </option>
      <option value="ANALISIS TRIANGULO - PENTAGONO">ANALISIS TRIANGULO - PENTAGONO</option>
      <option value="HORARIOS-ACTIVIDADES DE MICROMERCADEO">HORARIOS-ACTIVIDADES DE MICROMERCADEO</option>
      <option value="SOLICITUDE DE LA SALA">SOLICITUDE DE LA SALA</option>
      <option value="REVISIÓN LIBRO VISITAS Y PENDIENTES">REVISIÓN LIBRO VISITAS Y PENDIENTES</option>
    </select></td>
    
  </tr>
  <tr>
  </tr>
  <tr>
    <th scope="row">CALIFICACION</th>
    <td><select name="calificacion" id="calificacion">
      <option value="5">5</option>
      <option value="4.5">4.5</option>
      <option value="4">4</option>
      <option value="3.5">3.5</option>
      <option value="3">3</option>
      <option value="2.5">2.5</option>
      <option value="2">2</option>
      <option value="1.5">1.5</option>
      <option value="1">1</option>
    </select></td>
   
  </tr>
  <tr>
    <th scope="row">HALLAZGO</th>
    <td><textarea name="hallazgo" cols="4" rows="4"  id="hallazgo"></textarea></td>
  
  </tr>
  <tr>
    <th scope="row">TAREA</th>
    <td><textarea name="tarea" cols="4" rows="4" id="tarea"></textarea></td>
  
  </tr>
  <tr>
    <th scope="row">RESPONSABLE</th>
    <td><input type="text" name="responsable" id="responsable" /></td>
  
  </tr>
  <tr>
    <th scope="row">FECHA DE CONTROL</th>
    <td><input type="text" name="fcontrol" id="fcontrol" /></td>
   
  </tr>
  <tr>
    <th scope="row">&nbsp;</th>
    <td><input type="submit" name="guardardet" id="guardardet"  onclick= "guardardet('<?php echo $sala;?>', $('#concepto_det').val(),  $('#calificacion').val(),  $('#hallazgo').val(), $('#tarea').val(), $('#responsable').val(),  $('#fcontrol').val(), '<?php echo utf8_encode($nombreemp); ?>'); return false;" value="Guardar" /></td>
   
  </tr>
 
</table>

 <table align="center" width="95%" border="0">
   <tr>
     <th scope="row">&nbsp;</th>
   </tr>
<div id="informedet"></div> 



</table>
 


 

<table  align="center" width="20%" border="1">
   <tr>
     <th scope="row">
       <select name="fechainf" id="fechainf">
              <option value="">seleccione... </option>
              <?php    
			do  
		    {
    	    ?>
         <option value="<?php echo $rs_qry3->fecha;?>">
                <?php echo $rs_qry3->fecha; ?>
         </option>
              
              <?php
   		 }   while ($rs_qry3=$qry_sql3->fetch_object())
  		  ?>       
       </select>
       
       
     </select></th>
     <td><input name="inf_anterior" type="submit" class="botones" id="inf_anterior"  onClick= "consultarinformedet('<?php echo $sala;?>', '<?php echo utf8_encode($rs_qry2->autor); ?>', $('#fechainf').val()); return false;"  value="Ver Informe" /></td>
     <td><input name="enviar" type="submit" class="botones" id="enviar" onclick="send_sala('<?php echo $sala;?>')" value="Enviar Informe" /></td>
      <td><input name="imprimir" type="button" class="botones" id="prn" onClick="imprSelec('informedet');" value="imprimir" ></td>
   </tr>
 </table>

 <p>&nbsp;</p>
 <p>&nbsp;</p>
 <p>&nbsp;</p>
 <p><br>
</p>

  
<div id="respuesta"></div> 
<br>
<a href="informe_sala.php?sala=<?php echo $sala?>">REGRESAR</a>