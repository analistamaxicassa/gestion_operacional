
<link rel="stylesheet" type="text/css" href="../estilos.css"/>

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script>
		 function guardarcs(sala, concepto, autor)
        {	
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
						
					     document.getElementById('guardar').disabled=true;
		                $("#validador").html(response);

                    }
						
                    }
        
        });
        }
		
		
		
        </script>

<?php

//error_reporting(0);
//$sala = '552';
$sala = $_REQUEST['sala'];
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
  
  
  
//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		
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

<p><span class="encabezados">REGISTRO DE VISITA SALA</span><br>
</p>
<table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="63%">
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Autor</strong></td> 
      <td width="433" class="header" colspan="6" align="justify" valign="middle"><input name="autor" type="text" id="autor" size="70" /></td> 
     </tr>
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Concepto</strong></td>
      <td class="header" colspan="6" align="justify" valign="middle"><label for="autor"></label>
        <label for="concepto"></label>
      <textarea name="concepto" id="concepto" cols="45" rows="5"></textarea></td>
    </tr> 
</table>
<span class="header">
<input align="right" name="guardar" type="button" class="botones" onclick= "guardarcs($('#sala').val(),  $('#concepto').val(), $('#autor').val());" id="guardar" value="GUARDAR" />
</span>