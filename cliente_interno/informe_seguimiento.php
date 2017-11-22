<script>
 function consultarinformedet(sala, fechainf)
	  {	alert(sala); alert(fechainf)
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

					//window.open('http://190.144.42.83:9090/plantillas/formato_desempeno/ingreso_compromiso.php?cedula='+cedula+'', "Compromiso de Empleado", "width=400", "height=100")

						$("#informedet").html(response);
						 {

					    // document.getElementById('guardar').disabled=true;
		                $("#validador").html(response);

                    }

                    }

        });
        }



function validarFecha(fecha){

 var fechaArr = fecha.split('/');
 alert ("validar fecha"); alert (fechaArr[0]);
 var dia = fechaArr[0];
		 if(dia.length != 2 || isNaN(dia)== true){
			 alert ("El formato es DD/MM/AAAA, verifique" );
			 var fnueva = prompt ("Digite la nueva fecha de control de la tarea(DD/MM/YYYY): ")
			 //return false;

					var mes = fechaArr[1];
					if(mes.length != 2){
			 alert ("El formato es DD/MM/AAAA, verifique" );
			 var fnueva = prompt ("Digite la nueva fecha de control de la tarea(DD/MM/YYYY): ")
			 //return false;
						 }
				var aho = fechaArr[1];
				if(aho.length != 4){
					 alert ("El formato es DD/MM/AAAA, verifique" );
					 var fnueva = prompt ("Digite la nueva fecha de control de la tarea(DD/MM/YYYY): ")
					 //return false;
					 }
		}


	if(dia < 31)
			{

				if(mes < 13);
				{
					var aho = fechaArr[2];
					if(aho <2017){
						return true;
						}
						 return false;
					}
					 return false;
//				}
	//		  return false;

// var plantilla = new Date(dia, mes - 1, aho);//mes empieza de cero Enero = 0
 //alert (plantilla);
 //if(!plantilla || plantilla.getDate() == dia && plantilla.getMonth() == mes -1 && plantilla.getFullYear() == aho){
 //return true;
 }else{
 //return false;
 }
}
		 function cambioestado(estado, id, sala)
		        {
					alert(estado);
				if(estado == 'APLAZADO')
						{
							//alert("entro");
						var fnueva = prompt ("Digite la nueva fecha de control de la tarea(DD/MM/YYYY): ")
						}
				if(estado == "")
						{
						exit();
						}
				if(estado == 'CUMPLIDO'){
					var fnueva = new Date();
					alert(fnueva);
					}

					while(fnueva=='')
					{
					alert ("no ha ingresado una fecha valida");
					var fnueva = prompt ("Digite la nueva fecha de control de la tarea(DD/MM/YYYY): ")
					}

				//var dia = fnueva.substring(0,1);
				//var mes = fnueva.substring(4,5);
				//var anio = fnueva.substring(7,10);

				//if(dia > 31)

				//if (fnueva.indexOf('/')==-1) {
				//alert("Debe ingresar una fecha valida. El formato debe ser DD/MM/AAAA");
				//return false;
				//}

				//validarFecha(fnueva);

				var parametros = {
				"estado": estado,
				"fnueva": fnueva,
				"id": id,
				"sala": sala,

				};


                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/cliente_interno/cambio_estado_tarea.php',
                type: 'post',
                   beforeSend: function ()
                    {
                        $("#respuesta").html("Validando, espere por favor...");
                    },

                    success: function (response)
                    {
                        $("#respuesta").html(response);
						 {

					     document.getElementById('nvoestado').disabled=true;
		                $("#validador").html(response);

                    }

                    }

        });
        }



function validaFechaDDMMAAAA(fecha){
	alert("ingreso a funcion");
	var dtCh= "/";
	var minYear=1900;
	var maxYear=2100;
	function isInteger(s){
		var i;
		for (i = 0; i < s.length; i++){
			var c = s.charAt(i);
			if (((c < "0") || (c > "9"))) return false;
		}
		return true;
	}
	function stripCharsInBag(s, bag){
		var i;
		var returnString = "";
		for (i = 0; i < s.length; i++){
			var c = s.charAt(i);
			if (bag.indexOf(c) == -1) returnString += c;
		}
		return returnString;
	}
	function daysInFebruary (year){
		return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
	}
	function DaysArray(n) {
		for (var i = 1; i <= n; i++) {
			this[i] = 31
			if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
			if (i==2) {this[i] = 29}
		}
		return this
	}
	function isDate(dtStr){
		var daysInMonth = DaysArray(12)
		var pos1=dtStr.indexOf(dtCh)
		var pos2=dtStr.indexOf(dtCh,pos1+1)
		var strDay=dtStr.substring(0,pos1)
		var strMonth=dtStr.substring(pos1+1,pos2)
		var strYear=dtStr.substring(pos2+1)
		strYr=strYear
		if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
		if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
		for (var i = 1; i <= 3; i++) {
			if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
		}
		month=parseInt(strMonth)
		day=parseInt(strDay)
		year=parseInt(strYr)
		if (pos1==-1 || pos2==-1){
			return false
		}
		if (strMonth.length<1 || month<1 || month>12){
			return false
		}
		if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
			return false
		}
		if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
			return false
		}
		if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
			return false
		}
		return true
	}
	if(isDate(fecha)){
		return true;
	}else{
		return false;
	}
}
		</script>


<?php
set_time_limit(300);

error_reporting(0);
 $sala = $_GET['sala'];
//  $sala = '441';

	session_start();
	$usuingreso= $_SESSION['ced'];


require_once('../PAZYSALVO/conexion_ares.php');
$link=Conectarse();

////consulta de fechas de informe por sala

			$sql3="SELECT fecha FROM `concepto_sala` WHERE cc = '$sala' group by fecha order by `fecha` asc";
			$qry_sql3=$link->query($sql3);
			$rs_qry3=$qry_sql3->fetch_object();  ///consultar



 $sql="SELECT id, `fecha`,`concepto_esp`, `hallazgo`, `tarea`, `responsable`,`fecha_control` FROM `concepto_sala` WHERE `cc` = '$sala'  and tarea <> '' and (estado = 'PENDIENTE' || estado = 'APLAZADO')  ";

/* $sql="SELECT `fecha`,`concepto_esp`, `hallazgo`, `tarea`, `responsable`,`fecha_control` FROM `concepto_sala` WHERE cumplida = '0' and `cc` = '$sala'  and tarea <> ''";*/
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar

	if (empty($rs_qry)) {
    echo 'Esta sala no tiene tareas pendientes';
	exit();
	}
	else {
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CLIENTE INTERNO</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Merriweather:700i" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../estilos.css">
  </head>
<body>
  <ol class="breadcrumb">
    <li><a href="informe_sala.php?sala=<?php echo $sala;?>">Informe sala</a></li>
    <li class="active">Seguimiento de tareas</li>
  </ol>
<table  align="center" width="100%" border="1">
    <tr class="encabezados">
      <th colspan="7" class="encabezados" scope="row">INFORME DE SEGUIMIENTO</th>
    </tr>
    <tr>
      <th scope="row">FECHA</th>
      <th scope="row">CONCEPTO</th>
      <th scope="row">HALLAZGO</th>
      <th scope="row">TAREA</th>
      <th scope="row">RESPONSABLE</th>
      <th scope="row">FECHA DE CONTROL</th>
      <th scope="row">NUEVO ESTADO</th>
    </tr>

  <?php
do{
?>
    <tr>
      <th><?php echo $rs_qry->fecha ?></th>

      <th><input name="<?php echo $rs_qry->id ?>" type="text" id="idcompromiso<?php echo $rs_qry->id ?>" value="<?php echo $rs_qry->id ?>" size="5" hidden="hidden">
      <?php echo $rs_qry->concepto_esp  ?></th>
      <th class="tablas"><?php echo $rs_qry->hallazgo ?></th>
      <td class="tablas"><?php echo $rs_qry->tarea ?></td>
      <td><?php echo $rs_qry->responsable?></td>
      <td><?php echo $rs_qry->fecha_control ?></td>
      <td><label>
        <select name="nvoestado" id="nvoestado"  onChange="cambioestado(this.value, $('#idcompromiso<?php echo $rs_qry->id ?>').val(), <?php echo $sala ?>)" ON>
          <option value="">seleccione..</option>
          <option value="CUMPLIDO">CUMPLIDO</option>
          <option value="APLAZADO">APLAZADO</option>
        </select>


      </label></td>
    </tr>


<?php
  }
while($rs_qry=$qry_sql->fetch_object());

?>
 </table>

<p>&nbsp;</p>
<p>&nbsp;</p>
<br>
<br>
<br>
<?php
  		}
	?>

    <footer>

    </footer>
</body>
</html>
