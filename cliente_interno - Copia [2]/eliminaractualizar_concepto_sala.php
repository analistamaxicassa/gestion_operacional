
<link rel="stylesheet" type="text/css" href="../estilos.css"/>

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

<?php

//error_reporting(0);
//$sala = '552';
//$sala = $_REQUEST['sala'];
$sala=$_POST['sala'];
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

session_start();  
$cedingreso = $_SESSION['ced'];


  
  
//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		
//conexion sql

			echo $sql="SELECT tipo_sala, presupuesto, jefeoperacion FROM salas where cc = '$sala' and activo = '1'";
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

			 $sql2="SELECT fecha, concepto, autor FROM `concepto_sala` WHERE cc = '$sala' order by id desc limit 1";
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
	?>
    
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
 <script>
		 function guardarcs()
        {	
		var sala=document.getElementById('sala').value;
		var concepto=document.getElementById('concepto').value;
		var autor=document.getElementById('autor').value;
		alert(sala); alert(concepto); alert(autor)
				var parametros = {
				"sala": sala,
				"concepto": concepto,
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
						
					    // document.getElementById('guardar').disabled=true;
		                $("#validador").html(response);

                    }
						
                    }
        
        });
        }
		
		
		
        </script>


<p><br>
</p>
<input type="hidden" id="sala"  value="<?php echo $sala?>"/>
<table border="0" align="center" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="80%">
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><span class="encabezados">REGISTRO DE VISITA SALA</span></td>
      <td colspan="6" valign="middle">&nbsp;</td>
    </tr>
    <tr>

      <td class="header" colspan="4" align="left" valign="middle"><strong>Autor</strong></td> 
      <td colspan="6" valign="middle">
       
      <input name="autor" type="text" id="autor"  value="<?php echo $nombreemp?>" readonly="readonly"/></td> 
     </tr>
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><label for="concepto_det"></label>
        <select name="concepto_det" id="concepto_det">
          <option value="UBICACION">UBICACION</option>
          <option value="FACHADA">FACHADA</option>
          <option value="ROMPETRAFICO">ROMPETRAFICO</option>
          <option value="VITRINA">VITRINA</option>
          <option value="EXHIBICION, PUNTO DE REBOSE.">EXHIBICION, PUNTO DE REBOSE.</option>
          <option value="COMUNICACIÓN INTERNA">COMUNICACIÓN INTERNA</option>
          <option value="COMUNICACIÓN EXTERNA">COMUNICACIÓN EXTERNA</option>
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
      <td colspan="3" valign="middle"><label for="calificacion"></label>
        <select name="calificacion" id="calificacion">
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
      <td width="287" valign="middle"><label for="hallazgo"></label>
      <textarea name="hallazgo" id="hallazgo" cols="45" rows="5"></textarea></td>
      <td width="3" valign="middle"><label for="tarea"></label>
      <textarea name="tarea" id="tarea" cols="45" rows="5"></textarea></td>
      <td width="1" valign="middle"><label for="responsable"></label>
      <textarea name="responsable" id="responsable" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Concepto</strong></td>
      <td class="header" colspan="6" align="justify" valign="middle">
       
      <textarea name="concepto" id="concepto" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><input align="right" name="guardar" type="button" class="botones" onclick= "guardarcs();" id="guardar" value="GUARDAR" />
      <a href="informe_sala.php?sala=<?php echo $sala?>">REGRESAR</a></td>
      <td class="header" colspan="6" align="justify" valign="middle">&nbsp;</td>
    </tr> 
</table>
