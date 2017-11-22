<?php
	$sala=$_POST['mySala'];
	list($centro_operacion, $salaName) = explode("-", $_POST['mySala'], 2);
	$fecha = new DateTime('NOW');
	$fechaActual = $fecha->format('Y-m-d');

	require_once('../conexionesDB/conexion.php');
	$link=Conectarse_libreta();

	//evalua si ya existe libreta
	$sql4 = "SELECT log_eval_ID AS id FROM log_evaluacion WHERE Date(hora_evaluacion) = '$fechaActual' AND sala = '$centro_operacion'";
	$qry_sql4=$link->query($sql4);
	$rs_qry4=$qry_sql4->fetch_object();  ///consultar

	if(empty($rs_qry4->id))
	{
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<style type='text/css'>
			tr:nth-child(odd) {
			    background-color:#f2f2f2;
			}
			tr:nth-child(even) {
				background-color: #fbfbfb;
				font-size: 14;
			}
		</style>
	  <title>Evaluacion de Desempeño</title>
	  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="../estilos.css">
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script>
			function pregunta()
			{
			if(confirm("Esta seguro"))
			return true;
			else
			return false;
			}
		</script>
  	<script>
 			function xverificar()
			{
			//alert("ingreso");
			var x = document.getElementById("RadioGroup1_0").checked;
			var y = document.getElementById("RadioGroup1_1").checked;
			var z = document.getElementById("RadioGroup1_2").checked;
			if(x){
				 <?php echo "b1";?>
				}
			if(y){
				 <?php echo "b2";?>
				}
			if(z)
			{
				 <?php  echo "b3";?>
			}
			return true;
			}

			function activarno(id, carita)
			{//alert(id); alert(carita);
				var item = "observacion"+id;
			if (carita == '1'|| carita == '3' )
				{
				document.getElementById(item).style="display:initial";
				var observacion = prompt ("Detalle las razones por las cuales no se obtiene carita Feliz:","")
				while(observacion == null || observacion  == "")
					{
						alert ("Por favor detalle su calificacion");
						var observacion = prompt ("Detalle las razones por las cuales no se obtiene carita Feliz:","")
						document.getElementById(item).focus();
					}

				document.getElementById(item).value = observacion;
				}
			if (carita == '5')
			{	//alert ('felicitaciones');
				var observacion = "";
				document.getElementById(item).value = observacion;
				document.getElementById(item).style="display:none";
				}

			}

 			function guardared(cedula, cargo, nombreent, sociedad, fevaluacion, aspecto)
      {
				//alert(aspecto);
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
		</script>
	</head>
<body>
<p>
<form method="post" action="guardarevaluacion.php">
<table width="100%" border="1" align="center">
      <tr>
        <th colspan="2" scope="col">LISTA DE CHEQUEO ADMINISTRADOR PUNTO DE VENTA</th>
      </tr>
      <tr>
        <th width="23%" scope="col">Sala</th>
        <th width="77%" scope="col" align="left">
          <label>
            <input type="text" name="salaName" value="<?php echo $salaName; ?>" readonly>
						<input type="hidden" name="centro_operacion" value="<?php echo $centro_operacion; ?>">
        </label></th>
      </tr>
      <tr>
        <th height="8" colspan="2"  scope="col"></th>
      </tr>
</table>
  <table width="100%" border="0" align="center">
<?php
			$sql4 = "SELECT  aspecto FROM `check_list_pva`  GROUP BY ASPECTO order by ASPECTO" ;
			$qry_sql4=$link->query($sql4);
			$rs_qry4=$qry_sql4->fetch_object();  ///consultar
			do{
?>
      <tr>
        <td width="497" class="encabezados" ><span class="subtitulos">
          <label>
            <input name="aspecto" border="0" type="text" class="encabezados" id="aspecto" value="<?php echo $rs_qry4->aspecto; ?>" readonly>
          </label>
        </span></td>
        <td width="61" class="encabezados"><img src="..\Libreta_calificacionPDV\img/CARITA TRISTE.jpg" width="71" height="60"></td>
        <td width="70" class="encabezados"><img src="..\Libreta_calificacionPDV\img/CARITA NEUTRA.jpg" width="63" height="61"></td>
        <td width="61" class="encabezados"><img src="..\Libreta_calificacionPDV\img/CARITA FELIZ.jpg" width="64" height="63"></td>
        <td width="386" colspan="2" class="encabezados">Observación </td>
      </tr>
<?php
		 	$sql3 ="SELECT id,  operacion, aspecto FROM `check_list_pva` where aspecto = '$rs_qry4->aspecto' order by id" ;
			$qry_sql3=$link->query($sql3);
			$rs_qry3=$qry_sql3->fetch_object();  ///consultar
			 //$siga = 1;
		do{
?>
    <tr>
      <td align="left" valign="middle"  style="font-size:10px" >
				<input type="hidden" name="check_list<?php echo $rs_qry3->id; ?>" value="<?php echo $rs_qry3->id; ?>">
      	<textarea cols="80" class="formulario" readonly><?php echo $rs_qry3->operacion;   ?></textarea>
			</td>
      <td colspan="3" align="center" valign="middle"><table width="200">
        <tr>
          <td><label>
            <input type="radio" name="RadioGroup1<?php echo $rs_qry3->id; ?>" value="1" id="RadioGroup1_0" onClick="activarno('<?php echo $rs_qry3->id ?>', this.value)" required>
          </label></td>
          <td><input type="radio" name="RadioGroup1<?php echo $rs_qry3->id; ?>" value="3" id="RadioGroup1_1" onClick="activarno('<?php echo $rs_qry3->id ?>', this.value)"></td>
          <td><input type="radio" name="RadioGroup1<?php echo $rs_qry3->id; ?>" value="5" id="RadioGroup1_2" onClick="activarno('<?php echo $rs_qry3->id ?>', this.value)"></td>
        </tr></table>
      <td colspan="2" align="left" valign="middle"><p>
        <label>
          <textarea name="observacion<?php echo $rs_qry3->id; ?>" cols="2" rows="3" readonly class="textbox" id="observacion<?php echo $rs_qry3->id; ?>"></textarea>
        </label>
      </p></td>
     </tr>
		 </td>
		  <?php
			//echo $siga;
		}	while($rs_qry3=$qry_sql3->fetch_object());
		}		while($rs_qry4=$qry_sql4->fetch_object());
?>
   </table>
   <input name="ingresar" type="submit" class="botones" id="ingresar" value="GUARDAR" />
	</form>
<?php
	}
	else
	{
	  echo "LA LIBRETA DE CALIFICACION ".$fechaActual." DE LA SALA ".$salaName." YA FUE GENERADA";
	}
?>
 </body>
</html>
