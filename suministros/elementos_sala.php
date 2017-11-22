  
<style type="text/css">
.text {font-family:Verdana, Geneva, sans-serif;
	   font-size:11px;
}
</style>

<?php
require_once('../PAZYSALVO/conexion_ares.php'); 


$cedulaingreso = $_REQUEST['cedula'];

//$cedulaingreso = '52522883';


$link=Conectarse();

							  
		   $sqls = "SELECT cc, nombre FROM `salas` WHERE `activo` = '1' order by nombre";
			$qry_sqls=$link->query($sqls);
			$rs_qrys=$qry_sqls->fetch_object();  ///consultar 


		  $sql1 = "SELECT id, descripcion_elemento FROM `suministros_elementos` order by descripcion_elemento ";
			$qry_sql1=$link->query($sql1);
			$rs_qry1=$qry_sql1->fetch_object();  ///consultar 
						


?>	



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>INVENTARIO SUMINISTROS</title>
<link rel="stylesheet" type="text/css" href="../estilos.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
    
    	
	function entregaelemento(sala, elemento, tipo, serie, marca, observacion, cantidad, ubicacion, cedula, nombre, entrega, fecha)  
        {  
		if (sala==""){ alert ("La casilla SALA es obligatoria")
					document.getElementById('ubicacion').focus();
					return false;
					}  
		if (elemento==""){ alert ("La casilla ELEMENTO es obligatoria")
					document.getElementById('nhijos').focus();
					return false;
					} 
		if (cantidad==""){ alert ("La casilla CANTIDAD es obligatoria")
					document.getElementById('tdoc_identidad').focus();
					return false;
					}
		if (ubicacion==""){ alert ("La casilla RESPONSABLE es obligatoria")
					document.getElementById('doc_identidad').focus();
					return false;
					} 
		if (cedula==""){ alert ("La casilla RESPONSABLE es obligatoria")
					document.getElementById('doc_identidad').focus();
					return false;
					} 

		if (entrega==""){ alert ("La casilla ENTREGA es obligatoria")
					document.getElementById('doc_identidad').focus();
					return false;
					} 
		if (fecha==""){ alert ("La casilla FECHA DE ENTREGA es obligatoria")
					document.getElementById('fecha').focus();
					return false;
					} 

			var parametros = {
				"sala": sala,
				"elemento": elemento,
				"tipo": tipo,
				"serie": serie,
				"marca": marca,
				"observacion": observacion,
				"cantidad": cantidad,
				"ubicacion": ubicacion,
				"cedula": cedula,
				"nombre": nombre,
				"entrega": entrega,
				"fecha": fecha,
               	};
				$.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/suministros/guarda_elementos_sala.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
						 document.getElementById('ingresar').disabled=true;
                        $("#validador").html(response);
											
                    }
        
        });
			}
			
function informe(sala)  
        {  
				var parametros = {
				"sala": sala,
               	};
				$.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/suministros/informe_sala.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#validador").html(response);
											
                    }
        
        });
			}
			
			
	function buscarserie(serie)  
        {  
				var parametros = {
				"serie": serie,
               	};
				$.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/suministros/buscarserie.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#validador").html(response);
											
                    }
        
        });
			}		
			
		
		
  </script>
  
  <script language="JavaScript">
function activarentrega(){
document.getElementById('elemento').style="display:initial";
document.getElementById('elemento').value="";
document.getElementById('nombre').style="display:initial";
document.getElementById('nombre').value="";
document.getElementById('cantidad').style="display:initial";
document.getElementById('cantidad').value="";
document.getElementById('ubicacion').style="display:initial";
document.getElementById('ubicacion').value="";
document.getElementById('observacion').style="display:initial";
document.getElementById('observacion').value="";
document.getElementById('cedula').style="display:initial";
document.getElementById('cedula').value="";
document.getElementById('entrega').style="display:initial";
document.getElementById('entrega').value="";
document.getElementById('fecha').style="display:initial";
document.getElementById('fecha').value="";
 document.getElementById('ingresar').disabled=false;
//document.getElementById('informe').style="display:none";
}

function dardebaja(cedulaingreso)
				{
				
				var id = prompt ("Digite el ID del elemento a eliminar: ")
				
				if (id==""){ alert ("Debe digitar el ID del elemento ")
					document.getElementById('id').focus();
					return false;
					}  
					
				if (id != null)
				
				{
					var parametros = { 
					"id": id,
					"cedulaingreso": cedulaingreso,
					};
					$.ajax({
					data: parametros,
					url: 'http://190.144.42.83:9090/plantillas/suministros/eliminar_elementos_sala.php',
					type: 'post',
						beforeSend: function () 
						{
							$("#validador").html("Validando, espere por favor...");
						},
			
						success: function (response) 
						{
							$("#validador").html(response);
												
						}
			
						});
					}
				exit();
}

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
	
function reimpresion()  
        {  
			var iditem = prompt ("Digite el ID del elemento a reimprimir: ")
			if (iditem==""){ alert ("Debe digitar el ID del elemento ")
					document.getElementById('id').focus();
					return false;
					}  	
			if (iditem != null)
				
				{
				var parametros = { 
				"iditem": iditem,
               	};
				$.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/suministros/reimpirmir_elementos.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#validador").html(response);
											
                    }
        
        });
		}
				exit();
}	

function reimprimirxcedula()  
        {  
			var cedula = prompt ("Digite el No de Cedula: ")
				
			if (cedula != null)
				
				{
						var parametros = { 
				"empleado": cedula,
               	};
				$.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/suministros/imprimir_inventario_emp.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#validador").html(response);
						document.getElementById("prn").style="display:none"
											
                    }
        
        });
		}
				exit();
}	
	
function reasignar(cedulaingreso)
				{
				
			var iditem = prompt ("Digite el ID del elemento a reasignar: ")
			
			if (iditem != null)
				
				{
			if (iditem==""){ alert ("Debe digitar el ID del elemento ")
					document.getElementById('iditem').focus();
					return false;
					}  
			 else {
			
				
				var parametros = { 
				"iditem": iditem,
				"cedulaingreso": cedulaingreso,
               	};
				$.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/suministros/reasignar_elementos.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#validador").html(response);
											
                    }
        
        });
			 }
			 }
				exit();
}		
	
	function intercambiar(cedulaingreso)
				{
				
				
				var parametros = { 
				
				"cedulaingreso": cedulaingreso,
               	};
				$.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/suministros/intercambio_responsable.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#validador").html(response);
											
                    }
        
        });
}		
	
	function reasignartotal(cedulaingreso)
				{
				
				
				var parametros = { 
				
				"cedulaingreso": cedulaingreso,
               	};
				$.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/suministros/cambio_responsable.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#validador").html(response);
											
                    }
        
        });
}		
	
	function editar()
				{
				var ideditar = prompt ("Digite el ID del elemento a editar: ") 
				
				var parametros = { 
				
				"ideditar": ideditar,
               	};
				$.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/suministros/editarid.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#validador").html(response);
											
                    }
        
        });
}

function buscarserie()
				{
					var serie = prompt ("Digite la serie a buscar: ") 
				var parametros = { 
				
				"serie": serie,
               	};
				$.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/suministros/buscarserie.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#validador").html(response);
											
                    }
        
        });
}	

   function acciones()
			{ 
			
			
	var accion = document.getElementById("otras").value 
							
				if (accion == "editarid")
				{  
					editar();
					}
					
				if (accion == "buscarserie")
				{ 
					buscarserie();
				};	
				
				if (accion == "reimprimir")
				{  reimpresion();
					}
					
				if (accion == "reasignar")
				{  var cedulaingreso =  ('<?php echo $cedulaingreso;?>')
					reasignar(cedulaingreso);
					}
				
				if (accion == "intercambiar")
				{  var cedulaingreso = ('<?php echo $cedulaingreso;?>')
					intercambiar(cedulaingreso);
					}
					
				if (accion == "reasignartotal")
				{  var cedulaingreso = ('<?php echo $cedulaingreso;?>')
					reasignartotal(cedulaingreso);
					}
					
			
				if (accion == "reimprimirxcedula")
				{  
					reimprimirxcedula();
					}
				}	
				
				if (accion == "editarid")
				{ 
					editar();
				};
				
				


function buscaremp()
{
	window.open("http://190.144.42.83:9090/plantillas/suministros/buscar_empleado.php", "Buscar empleado", "width=800, height=500")
			
}	

	
	
</script>

         <script>
     $.datepicker.regional['es'] = {
     closeText: 'Cerrar',
     prevText: '<Ant',
     nextText: 'Sig>',
     currentText: 'Hoy',
     monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
     monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
     dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
     dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
     dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
     weekHeader: 'Sm',
     dateFormat: 'yy/mm/dd',
     firstDay: 1,
     isRTL: false,
     showMonthAfterYear: false,
     yearSuffix: ''
     };
     $.datepicker.setDefaults($.datepicker.regional['es']);
 
 	 $(function () {
     $("#fecha" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  yearRange: '-100:+0'
       });
    });
   
	
	</script>   
<script>   
 	
    
  </script>  

</head>
<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">

<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>
         <td width="16%" height="6" align="center">&nbsp;</td>
    <td width="100" align="center" class="intro_tkg"><strong><em>ADMINISTRACIÓN DE SUMINISTROS</em></strong></td>
         <td width="25%" align="right"><img src="../gh/img/maxicassa.png" width="268" height="98" class="formulario"></td>
       </tr>
       </table>
  <p>&nbsp;</p>
  <table bgcolor="#CCC" width="537" border="0" align="center" style="border-collapse: collapse; font-size: 12px; text-align: center; ">
  
    <tr>
      <td height="40" colspan="5" align="center"  valign="middle" bgcolor="#99FFFF" class="encabezados" style="border-collapse: collapse; font-size: 18px;">INVENTARIO DE  ELEMENTOS</td>
    </tr>
    <tr>
      <td height="33" align="left">SALA
      <label for="f_inicial4"></label></td>
      <td align="left"><label for="elemento">
        <select name="sala" id="sala">
          <option value="">Seleccione.. </option>
          <?php    
			do  
		    {
    	    ?>
          <option value="<?php echo $rs_qrys->cc;?>"> <?php echo  utf8_encode($rs_qrys->nombre); ?></option>
          <?php
   		 }   while ($rs_qrys=$qry_sqls->fetch_object())
  		  ?>
        </select>
      </label></td>
      <td align="left"><input name="asignar" type="button" class="botones" id="asignar" 
      onclick="activarentrega()" value="Nueva entrega" /></td>
      <td colspan="2" align="left"><input name="informe" type="submit" class="botones" id="informe" value="Generar informe" onClick="informe($('#sala').val())" /></td>
    </tr>
    <tr>
      <td height="19" align="left">&nbsp;</td>
      <td colspan="4" align="left">&nbsp;</td>
    </tr>
    <tr>
      <td width="91" height="5" align="left">ELEMENTO
      </td>
      
           
      <td colspan="2" align="left">
       </td>
      <td align="left"><label for="tipo">TIPO</label></td>
      <td align="left"><input type="text" name="tipo" id="tipo" /></td>
    </tr>
    <tr>
      <td height="6" colspan="3" align="left"><select name="elemento" id="elemento" style="visibility:hidden" >
        <option value="">Seleccione.. </option>
        <?php    
			do  
		    {
    	    ?>
        <option value="<?php echo $rs_qry1->id;?>"> <?php echo  utf8_encode($rs_qry1->descripcion_elemento); ?></option>
        <?php
   		 }   while ($rs_qry1=$qry_sql1->fetch_object())
  		  ?>
      </select></td>
      <td align="left"><label for="serie">SERIE</label></td>
      <td align="left"><input type="text" name="serie" id="serie" /></td>
    </tr>
    <tr>
      <td height="15" colspan="3" align="left"><a href='http://190.144.42.83:9090/plantillas/suministros/ingreso_elementos.php'>CREAR ELEMENTO</a></td>
      <td align="left"><label for="marca">MARCA</label></td>
      <td align="left"><input type="text" name="marca" id="marca" /></td>
    </tr>
    <tr>
      <td height="30" align="left">CANTIDAD</td>
      <td colspan="4" align="left">
        <select name="cantidad" id="cantidad" style="visibility:hidden">
        <option value="">Seleccione..</option>
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
      </select></td>
    </tr>
    <tr>
      <td height="30" align="left">OBSERVACION</td>
      <td colspan="4" align="left"><label for="observacion"></label>
      <input name="observacion" type="text" id="observacion" style="visibility:hidden" size="70" /></td>
    </tr>
    <tr>
      <td height="30" align="left">UBICACION</td>
      <td align="left"><label for="ubicacion"></label>
        <select name="ubicacion" id="ubicacion" style="visibility:hidden">
         <option value="">Seleccione</option>
        <option value="Sala">Sala</option>
        <option value="Caja">Caja</option>
        <option value="Bodega1">Bodega1</option>
        <option value="Bodega2">Bodega2</option>
        <option value="Bodega3">Bogode3</option>
        <option value="Oficina">Oficina</option>
        <option value="Archivo">Archivo</option>
        <option value="Infraestructura">Infraestructura</option>
        <option value="Armario IT">Armario IT</option>
        <option value="Cocina">Cocina</option>
        <option value="Planta Arena">Planta Arena</option>
        <option value="Planta Pegante">Planta Pegante</option>
        <option value="Laboratorio">Laboratorio</option>
        <option value="Mantenimiento">Mantenimiento</option>
        <option value="Camion Pegomax">Camion Pegomax</option>
      </select></td>
      <td align="left">CEDULA</td>
      <td colspan="2" align="left"><p>
        <label for="responsable" ></label>
        <label for="cedula"></label>
        <input type="text" name="cedula" id="cedula" style="visibility:hidden" onChange="llenar(this.value);" />
        <input type="submit" name="buscarnombre" id="buscarnombre" value="Listado de empleados" onClick="buscaremp()" />
        <span class="subtitulos">
        <input name="nombre" type="text" class="intro_tk" id="nombre" value="" size="50" />
      </span> </p></td>
    </tr>
    <tr>
      <td height="30" align="left">ENTREGADO POR</td>
      <td align="left"><label for="entrega"></label>
      <input name="entrega" type="text" id="entrega" size="30" style="visibility:hidden" /></td>
      <td width="120" align="left"><p>FECHA</br>
      </p></td>
      <td width="350" colspan="2" align="left"><label for="fecha"></label>
      <input type="text" name="fecha" id="fecha" style="visibility:hidden" /></td>
    </tr>
    <tr>
      <td height="30" bgcolor="#CCCCCC">&nbsp;</td>
      <td height="30" bgcolor="#CCCCCC"><label for="otras">
        <input name="ingresar" type="submit" id="ingresar" onClick="entregaelemento($('#sala').val(),$('#elemento').val(), $('#tipo').val(),$('#serie').val(),$('#marca').val(),$('#observacion').val(),$('#cantidad').val(),$('#ubicacion').val(),$('#cedula').val(), $('#nombre').val(),$('#entrega').val(),$('#fecha').val()); return false;" value="ENTREGA DE ELEMENTO"/			>
      </label></td>
      
      
      <td height="30" bgcolor="#CCCCCC">&nbsp;</td>
      <td height="30" colspan="2" bgcolor="#CCCCCC">OPCIONES
        <select name="otras" id="otras"  >
          <option value="">Seleccionar..</option>
          <option value="reimprimirxcedula" selected="selected">Reimprimir acta x cedula</option>
          <option value="reimprimir">Reimprimir acta x item</option>
          <option value="reasignartotal">Reasignar x cedula</option>
          <option value="reasignar">Reasignar o distribuir x item</option>
          <option value="intercambiar">Intercambiar Elementos entre cedulas</option>          
          <option value="dardebaja">Reemplazar elemento</option>
          <option value="editarid">Editar elemento</option>
          <option value="buscarserie">Buscar serie de un elemento</option>
        </select>
      <input name="reimpresion" type="button" class="botones" id="reimpresion" value="Ir.." onClick="acciones()" /></td>
    </tr>

  </table>
<div id="validador" align="center">

</div>

<p  align="center">&nbsp;</p>
<p  align="center">&nbsp;</p>
<p  align="center">
  <input  type="button" name="imprimir" id="prn" value="imprimir" onClick="imprSelec('validador');" />
</p>
<p  >&nbsp;</p>

  <p>&nbsp;</p>
  <label ></label>	
  <p>&nbsp;</p>
  <label></label>
  <p>&nbsp;</p>
  <label></label>
  <p>&nbsp;</p>
  <label></label>
  <br/>
  <p>&nbsp;</p>
  <label style="margin-left:100px;width:210px;"></label> 
</form>
</body>
</html>
