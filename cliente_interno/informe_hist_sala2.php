<?php
  require_once('../conexionesDB/conexion.php');
  session_start();
  $sala=$_GET['sala'];
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Auditoria Operacional</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../estilos.css"/>
<script>
	 function consultarinformedet(sala, fechainf)
	  {//	alert(sala); alert(fechainf)
				var parametros = {
				"sala": sala,
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
	    function modificar()
	  {
			var consec = prompt ("Digite el consecutivo a modificar: ")
		alert(consec);
				var parametros = {
				"consec": consec,
				};
                $.ajax({
                data: parametros,
                url: 'editarconsec.php',
                type: 'post',
                   beforeSend: function ()
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
                    success: function (response)
                    {
                        $("#modificar").html(response);
						 {
					    // document.getElementById('guardar').disabled=true;
		                $("#modificar").html(response);
                    }
                    }
        });
        }
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
<title>INFORME DE SALA</title>
  </head>
  <body>
    <ol class="breadcrumb">
      <li><a href="informe_sala.php?sala=<?php echo $sala;?>">Informe sala</a></li>
      <li class="active">Reportes sala</li>
    </ol>
    <div class="container">
      <div class="table-responsive col-md-8 col-md-offset-2">
        <table class="table table-bordered">
          <thead>
            <tr class="bg-primary">
              <th>Fecha</th>
              <th>Concepto</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody>
<?php

  error_reporting(0);
  $link_queryx = Conectarse_queryx();
  $link=Conectarse_personal();
  $fecha = new DateTime('NOW');
  $fechaActual = $fecha->format('Y-m-d');


  //consulta de concepto de sala
	$sql2="SELECT id, fecha, concepto_esp, ESTADO FROM concepto_sala WHERE cc = '$sala' order by fecha DESC LIMIT 10";
	$qry_sql2=$link->query($sql2);
	$rs_qry2=$qry_sql2->fetch_object();  ///consultar


	if (empty($rs_qry2)) {
    echo 'No existen registros';
    //exit();
	}
	else
  {
		$rs_qry2->fecha;
		$rs_qry2->concepto_esp;
		$rs_qry2->ESTADO;
	}
do{
?>
        <tr>
          <td><?php echo $rs_qry2->fecha; ?></td>
          <td> <?php echo $rs_qry2->concepto_esp; ?></td>
          <td><?php echo $rs_qry2->ESTADO; ?></td>
        </tr>
<?php }while($rs_qry2=$qry_sql2->fetch_object()); ?>
      </tbody>
    </table>
  </div>
</div>
<?php
  //conexion sql
	$sql="SELECT tipo_sala, presupuesto, jefeoperacion FROM salas where cc = '$sala' and activo = '1'";
	$qry_sql=$link->query($sql);
	$rs_qry=$qry_sql->fetch_object();  ///consultar

	if (empty($rs_qry)) {
    echo 'No existen registros';
    //exit();
	}
	else {
	$tiposala = $rs_qry->tipo_sala;
	$presupuesto = $rs_qry->presupuesto;
	$jefeoperacion = $rs_qry->jefeoperacion;
	}

  $nombreEmpleado = $_SESSION['nombre'];
  //consulta de concepto de sala
	$sql2="SELECT id, fecha, avg(calificacion) concepto, autor FROM `concepto_sala` WHERE cc = '$sala' group by fecha order by id DESC LIMIT 1 ";
	$qry_sql2=$link->query($sql2);
	$rs_qry2=$qry_sql2->fetch_object();  ///consultar

	if (empty($rs_qry2)) {
    echo 'No existen registros';
    //exit();
	}
	else {
		$fecha = $rs_qry2->fecha;
		$concepto = $rs_qry2->concepto;
		$autor = $rs_qry2->autor;
	}

  //consulta de fechas de informe por sala
	$sql3="SELECT fecha FROM `concepto_sala` WHERE cc = '$sala' group by fecha order by `fecha` asc";
	$qry_sql3=$link->query($sql3);
	$rs_qry3=$qry_sql3->fetch_object();  ///consultar

	//	echo "<br>";
	$sql4="SELECT fecha fechault FROM `concepto_sala` WHERE cc = '$sala' group by fecha order by `fecha` ASC LIMIT 1";
	$qry_sql4=$link->query($sql4);
	$rs_qry4=$qry_sql4->fetch_object();  ///consultar

//consulta de email de sala
 	$sqla="SELECT email, nombre FROM email_permisos where cc = '10-$sala'";
	$qry_sqla=$link->query($sqla);
	$rs_qrya=$qry_sqla->fetch_object();  ///consultar
	$rs_qrya->email;
?>


<br>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Nueva visita</h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="guardarcs.php" method="post" accept-charset="utf-8">
                        <fieldset>
                            <div class="form-group">
                              <label for="fecha_visita">Fecha de inspección:</label>
                              <input type="date" name="fecha_visita" value="<?php echo $fechaActual; ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                              <label for="concepto_det">Concepto:</label>
                              <select name="concepto_det" class="form-control" required>
                                <option value="">Seleccione un concepto</option>
                                <option value="UBICACION">UBICACION</option>
                                <option value="FACHADA">FACHADA</option>
                                <option value="ROMPETRAFICO">ROMPETRAFICO</option>
                                <option value="VITRINA">VITRINA</option>
                                <option value="ORDEN Y ASEO EN BODEGA">ORDEN Y ASEO EN BODEGA</option>
                                <option value="GEOREFERENCIACION">GEOREFERENCIACION</option>
                                <option value="FACILIDAD PARA LLEGAR AL ALMACEN">FACILIDAD PARA LLEGAR AL ALMACEN</option>
                                <option value="EXHIBICION, PUNTO DE REBOSE">EXHIBICION, PUNTO DE REBOSE.</option>
                                <option value="INFRAESTRUCTURA">INFRAESTRUCTURA</option>
                                <option value="INVENTARIO">INVENTARIO</option>
                                <option value="PORTAFOLIO">PORTAFOLIO</option>
                                <option value="MARCACION BAJA ROTACION Y NO MOVIMIENTO">MARCACION BAJA ROTACION Y NO MOVIMIENTO</option>
                                <option value="PRECIOS">PRECIOS</option>
                                <option value="INFORME DE LA COMPETENCIA">INFORME DE LA COMPETENCIA</option>
                                <option value="CLIENTE INTERNO">CLIENTE INTERNO</option>
                        	      <option value="INFORME DE TRAFICO">INFORME DE TRAFICO</option>
                                <option value="CONOCIMIENTO DEL CLIENTE">CONOCIMIENTO DEL CLIENTE</option>
                                <option value="COMUNICACIÓN INTERNA">COMUNICACIÓN INTERNA</option>
                                <option value="COMUNICACIÓN EXTERNA">COMUNICACIÓN EXTERNA</option>
                                <option value="PROCESOS Y/O PROCEDIMIENTOS">PROCESOS Y/O PROCEDIMIENTOS</option>
                                <option value="INFORMATICA Y TECNOLOGIA">INFORMATICA Y TECNOLOGIA </option>
                                <option value="REVISIÓN LIBRO VISITAS Y PENDIENTES">REVISIÓN LIBRO VISITAS Y PENDIENTES</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="nota">Calificación:</label>
                              <select name="nota" class="form-control" required>
                                <option value="">Seleccione un valor para la calificación</option>
                                <option value="5">5</option>
                                <option value="4.5">4.5</option>
                                <option value="4">4</option>
                                <option value="3.5">3.5</option>
                                <option value="3">3</option>
                                <option value="2.5">2.5</option>
                                <option value="2">2</option>
                                <option value="1.5">1.5</option>
                                <option value="1">1</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="hallazgo">Hallazgo:</label>
                              <textarea name="hallazgo" cols="4" rows="4" class="form-control" placeholder="Describa el hallazgo" required></textarea>
                            </div>
                            <div class="form-group">
                              <label for="tarea">Tarea:</label>
                              <textarea name="tarea" cols="4" rows="4" class="form-control" placeholder="Describa la tarea" required></textarea>
                            </div>
                            <div class="form-group">
                              <label for="responsable">Responsable:</label>
                              <select name="responsable" class="form-control" required>
                                <option value="">Seleccione un responsable</option>
                                <option value="<?php echo $rs_qrya->email;?>">ADMINISTRADOR</option>
                                <option value="auditoria@ceramigres.com">AUDITORIA</option>
                                <option value="jabastecimiento@ceramigres.com">CADENA ABASTECIMIENTO</option> <!-- TODO Obtener el email-->
                                <option value="procesos@ceramigres.com">CAPACITACION</option>
                                <option value="cartera@ceramigres.com">CARTERA</option>
                                <option value="contabilidad@ceramigres.com">CONTABILIDAD</option>
                                <option value="ejecucion@ceramigres.com">COOR. OPERACIONES</option>
                                <option value="eperico@ceramigres.com">DESARROLLO ORGANIZACIONAL</option>
                                <option value="fleon@ceramigres.com">GESTION HUMANA</option>
                                <option value="dbautista@ceramigres.com">LINEA BAÑOS Y COCINAS</option>
                                <option value="jlinea.instalacion@ceramigres.com">LINEA INST Y MANTENIMIENTO</option>
                                <option value="jrevestimientos@ceramigres.com"> LINEA REVESTIMIENTO</option>
                                <option value="personal@ceramigres.com">JEFE DE PERSONAL</option>
                                <option value="juridico@ceramigres.com">JURIDICO</option>
                                <option value="jmercadeo@ceramigres.com">MERCADEO</option>
                                <option value="merchandising@ceramigres.com">MERCHANDISING</option>
                                <option value="druiz@ceramigres.com">SISTEMAS Y TECNOLOGIA</option>
                                <option value="tesoreria@ceramigres.com">TESORERIA</option>
                                <option value="soportetecnologia@ceramigres.com">SOPORTE APLICACION </option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="fcontrol">Fecha control:</label>
                              <input type="date" name="fcontrol" value="" class="form-control" required>
                              <input type="hidden" name="evaluador" value="<?php echo utf8_encode($_SESSION['nombre']); ?>">
                              <input type="hidden" name="sala" value="<?php echo $sala; ?>">
                            </div>
                            <input type="submit" class="btn btn-primary" value="Guardar">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

 <table align="center" width="95%" border="0">
   <tr>
     <th scope="row">&nbsp;</th>
   </tr>
<div id="informedet"></div>
<div id="modificar"></div>



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
     <td><input name="inf_anterior" type="submit" class="botones" id="inf_anterior"  onClick= "consultarinformedet('<?php echo $sala;?>', $('#fechainf').val()); return false;"  value="Ver Informe" /></td>
     <td><input name="enviar" type="submit" class="botones" id="enviar" onclick="send_sala('<?php echo $sala;?>')" value="Enviar Informe" /></td>
      <td><input name="imprimir" type="button" class="botones" id="prn" onClick="imprSelec('informedet');" value="imprimir" ></td>
    <td><input name="modificar" type="submit" class="botones" id="modificar" onClick="modificar();" value="modificar " ></td>

  </tr>

 </table>

 <p>&nbsp;</p>
 <p>&nbsp;</p>
 <p>&nbsp;</p>
 <p><br>
</p>


<div id="respuesta"></div>
  </body>
</html>
