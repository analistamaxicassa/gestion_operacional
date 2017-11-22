<?php 

error_reporting(0);

//recojo variables


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
		
	/*	//eliminar tabla temporal de empleados activos
			$sql20="DELETE FROM `personal`.`empleados_cargostmp`";
			$qry_sql20=$link->query($sql20);*/
				  
		   $sqls = "SELECT cc, nombre FROM `salas` WHERE `activo` = '1' order by nombre";
			$qry_sqls=$link->query($sqls);
			$rs_qrys=$qry_sqls->fetch_object();  ///consultar 
			
			
			  $sqls1 = "SELECT id, descripcion_elemento, posible_ubicacion FROM `suministros_elementos` 
			 order by descripcion_elemento";
			$qry_sqls1=$link->query($sqls1);
			$rs_qrys1=$qry_sqls1->fetch_object();  ///consultar 
			
	/*	//se crear tabal con los cargos de los empleados para no realizar tanta consulta a la BDqueryx
$query = "	SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_NOMBRE CARGO FROM EMPLEADO EMP, cargo ca WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO and EMP.EMP_ESTADO <> 'R'";
		//	$qry_sqlcargo=$link->query($sqlcargo);
		//	$rs_qrycargo=$qry_sqlcargo->fetch_object();  ///consultar 
	
	
					$stmt = $dbh->prepare($query);
					$stmt->execute();
					$row = $stmt->fetch();	
			do  
		    {	
		 $cedular=$row['CEDULA'];
		$nombreemp=$row['NOMBRE'];
		$cargo=$row['CARGO'];
		
		
		
		
$sql3="INSERT INTO `personal`.`empleados_cargostmp` (`cedula`, `nombre`, `cargo`)
 VALUES ('$cedular', '$nombreemp', '$cargo');"; 
$qry_sql3=$link->query($sql3);

 }   while ($row = $stmt->fetch());
 */


	
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
  <title>Inventario de Suministros</title>
  
  <link rel="stylesheet" type="text/css" href="../estilos.css"/>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
   
  <script src="http://momentjs.com/downloads/moment.min.js"></script>
<script>

 function almacena(sala,elemento, tipo, serie, marca, cantidad, ubicacion, cedula, observacion, condicion)  
        { 
		if (elemento==""){ alert ("La casilla DESCRIPCION DE ELEMENTO es obligatoria")
					document.getElementById('elemento').focus();
					return false;
					}  
		if (sala==""){ alert ("La casilla SALA es obligatoria")
					document.getElementById('sala').focus();
					return false;
					}  
		if (cantidad=="0"){ alert ("La casilla CANTIDAD es obligatoria")
					document.getElementById('cantidad').focus();
					return false;
					} 
		if (ubicacion==""){ alert ("La casilla UBICACION es obligatoria")
					document.getElementById('ubicacion').focus();
					return false;
					}
		if (cedula==""){ alert ("La casilla CEDULA es obligatoria")
					document.getElementById('cedula').focus();
					return false;
					} 
		if (estado==""){ alert ("La casilla ESTADO es obligatoria")
					document.getElementById('estado	').focus();
					return false;
					} 
		
		var parametros = {
				"sala": sala,
				"nombre": elemento,
				"tipo": tipo,
				"serie": serie,
				"marca": marca,
				"cantidad": cantidad,
				"ubicacion": ubicacion,
				"cedula": cedula,
				"observacion": observacion,
				"condicion": condicion,
				};
		$.ajax({
                data: parametros,
                url:'http://190.144.42.83:9090/plantillas/suministros/guardarsuministros.php', 
				       type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("");
                    },
        
                    success: function (response) 
                    {
						alert ("Registro guardado");
                        $("#validador").html(response);
					document.getElementById('elemento').value = '';
					document.getElementById('cantidad').value = '0';						
					//document.getElementById('ubicacion').value = '';
					//document.getElementById('cedula').value = '';						
					document.getElementById('observacion').value = '';						
					document.getElementById('estado').value = '';
					document.getElementById('nombre').value = '';

                    }
        
        });
		}
	
		
					
function gsala()
{ 
	var sala = document.getElementById('sala').value;
	location.href="imprimir_inventario.php?sala="+sala+""
	
	}
	
			
					
function gsalae()
{ 
	if (empleado==""){ alert ("La casilla cedula empleado es obligatoria")
					document.getElementById('empleado').focus();
					return false;
					}  
	//var sala = document.getElementById('sala').value;
	var empleado = document.getElementById('empleado').value;
	
	var parametros = {		
				"empleado": empleado,
				};
		$.ajax({
                data: parametros,
                url:'../suministros/imprimir_inventario_emp.php', 
				    type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("	");
                    },
        
                    success: function (response) 
                    {
                        $("#validador").html(response);
						//document.getElementById("nombre").value = response; //guaradr en un campo de texto
						
						
		
			
				-->		document.getElementById("nombre").value = response;	
					-->	document.getElementById("cargo").value = "ninguno";				
                    }
        
        });
	
	
	
	
	
	
	//location.href="imprimir_inventario_emp.php?empleado="+empleado+""
	
	}


-->	**** ojo aqui estoy utilizando datos que traigo de una consulta y los coloco en el mismo formulario ****
function llenar(cedulares)
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
                        $("#validador").html("	");
                    },
        
                    success: function (response) 
                    {
                        //$("#validador").html(response);
						document.getElementById("nombre").value = response; //guaradr en un campo de texto
						
						
		
			
				-->		document.getElementById("nombre").value = response;	
					-->	document.getElementById("cargo").value = "ninguno";				
                    }
        
        });
		}	
	
	
	
    </script>

</head>
<body>


<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>
         <td width="16%" height="46" class="encabezados" align="center"><img src="../gh/img/logo-gh.png" width="257" height="108"></td>
    <td width="100" align="center" class="encabezados">SOLICITUDES DE GESTION HUMANA</td>
         <td width="25%" align="right"><img src="../gh/img/maxicassa.png" width="316" height="98" class="formulario"></td>
       </tr>
</table>
<form>
<br>
<br> 
  <table width="80%" border="0" align="center" class="formulario" >
   
    <tr>
      <td colspan="7" align="left" valign="middle"><h2 class="encabezados">INVENTARIO DE SUMINISTROS </h2></td>
    </tr>

    <tr>
      <td colspan="7" align="left" valign="middle"><strong><em>        Nota: </br>
        </em></strong>
        * Lea atentamente cada uno de los campos y diligencie segun la revision efectuada</td>
    </tr>

    <tr>
      <td width="137" align="center" valign="middle" class="formulario" style="background-color:#999"><strong>Sala</strong></td>
      <td colspan="6"  align="justify" > <select style="font-size:20px" name="sala"  id="sala"  >
       <option value="">Seleccione..</option>
        <?php    
			do  
		    {
    	    ?>
        <option value="<?php echo $rs_qrys->cc;?>"> <?php echo  $rs_qrys->nombre; ?></option>
        <?php
   		 }   while ($rs_qrys=$qry_sqls->fetch_object())
  		  ?>
      </select></td>
    </tr>
    <tr>
      <td height="23" align="left" valign="middle" class="formulario">&nbsp;</td>

     <td colspan="6"  align="justify" >&nbsp;</td>
    </tr>

    <tr class="formulario">
      <td colspan="7" align="center" valign="middle" ><p class="encabezados">&nbsp;</p></td>
    </tr>
 
    <tr>
      <td height="39" colspan="2" align="left" valign="middle" bgcolor="#999999"><strong>Descripcion:</strong></td>
      <td height="39" colspan="5" align="left" valign="middle" class="subtitulos"><select name="elemento" id="elemento">
        <option value="">Seleccione</option>
        <?php    
			do  
		    {
    	    ?>
        <option value="<?php echo $rs_qrys1->id;?>"> <?php echo utf8_encode($rs_qrys1->descripcion_elemento); ?></option>
        <?php
   		 }   while ($rs_qrys1=$qry_sqls1->fetch_object())
  		  ?>
      </select></td>
    </tr>
    <tr>
      <td align="left" valign="middle" bgcolor="#999999" ><strong>Ubicacion</strong></td>
      <td align="left" valign="middle" bgcolor="#999999" ><strong>Cantidad</strong></td>
      <td colspan="3" align="center" valign="middle" bgcolor="#999999"><strong>Cedula del responsable</strong></td>
      <td width="107" align="left" valign="middle" bgcolor="#999999" ><strong>Observación</strong></td>
      <td width="291" align="left" valign="middle" bgcolor="#999999" ><strong>Estado </strong></td>
    </tr>
    <tr>
      <td align="left" valign="middle" ><select name="ubicacion" id="ubicacion">
        <option value="">Seleccione</option>
        <option value="Archivo">Archivo</option>
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
      </select></td>
      <td align="left" valign="middle" class="subtitulos"><select name="cantidad" id="cantidad" >
        <option value="0">0</option>
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
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="119">119</option>
      </select></td>
      <td colspan="3" align="left" valign="middle" class="subtitulos"><input name="cedula" type="text" id="cedula" onChange="llenar(this.value);" size="15"></td>
      <td align="left" valign="middle" class="subtitulos"><input name="observacion" type="text" id="observacion" size="80"></td>
      <td align="left" valign="middle" class="subtitulos"><select name="estado" id="estado" >
        <option value="">Seleccione</option>
        <option value="Bueno">Bueno</option>
        <option value="Regular">Regular</option>
        <option value="Malo">Malo</option>
      </select></td>
    </tr>
    <tr>
      <td align="left" valign="middle" >&nbsp;</td>
      <td align="left" valign="middle" class="formulario"><strong>Tipo</strong></td>
      <td colspan="3" align="left" valign="middle" class="formulario">Serie</td>
      <td align="left" valign="middle" class="formulario">Marca</td>
      <td align="left" valign="middle" class="subtitulos">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="middle" >&nbsp;</td>
      <td align="left" valign="middle" class="subtitulos"><label for="tipo"></label>
      <input type="text" name="tipo" id="tipo"></td>
      <td colspan="3" align="left" valign="middle" class="subtitulos"><label for="serie"></label>
      <input type="text" name="serie" id="serie"></td>
      <td align="left" valign="middle" class="subtitulos"><label for="marca"></label>
      <input type="text" name="marca" id="marca"></td>
      <td align="left" valign="middle" class="subtitulos"><input type="button" name="guardar" id="guardar" value="Guardar"  onClick="almacena($('#sala').val(),$('#elemento').val(), $('#tipo').val(),$('#serie').val(),$('#marca').val(),  $('#cantidad').val(), $('#ubicacion').val(), $('#cedula').val(),  $('#observacion').val(),$('#estado').val());"></td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="middle" class="subtitulos">Nombre del Responsable:</td>
      <td colspan="4" align="left" valign="middle" class="subtitulos"><input name="nombre" type="text" class="intro_tk" id="nombre" value="" size="80"></td>
    </tr>
    <tr>
      <td colspan="5" align="left" valign="middle" class="formulario"><a href="#" onClick="gsala()">VER INFORME TOTAL </a></td>
      <td colspan="2" align="left" valign="middle" class="subtitulos"><p>
        
      Digite la cedula
        <input type="text" name="empleado" id="empleado">
        <input type="button" name="impresion_empleado" id="impresion_empleado" value="INFORME POR EMPLEADO" onClick="gsalae()">
      </p></td>
    </tr>
    <tr class="formulario">
      <td colspan="7" align="left" valign="middle" class="subtitulos">&nbsp;</td>
    </tr>
    <tr class="formulario">
      <td colspan="7" align="left" valign="middle" class="subtitulos"><input type="submit" name="cambiar" id="cambiar" value="." hidden="true"></td>
    </tr>
  </table>
</form>

<div id="validador"> 

</div>

</body>
</html>
