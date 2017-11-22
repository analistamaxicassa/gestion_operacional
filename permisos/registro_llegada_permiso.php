<link rel="stylesheet" type="text/css" href="../estilos.css"/>

<?php



//error_reporting(0);
//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

//recojo variables

$cedula=$_POST['avalempleado'];
//$cedula='52522883';



//conexion
try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		

	$sql="SELECT  salida, llegada, observacion, f_final, correo FROM permisos where cedula = '$cedula' and `confirmado` = '1' order by f_final desc limit 1";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 		
			
			if (empty ($rs_qry->f_final) )
				{
				echo "NO EXISTEN REGISTROS";
				exit();
				}
				
				$ll =substr($rs_qry->llegada, 3,1); 
				
			if($ll == '5')
			{ 
				$hola = "30";
				//echo $hola;
				}
			else{
				
				$hola = "00";
				
				}		
				
				$hllegada = substr($rs_qry->llegada, 0,2); 
			
			
	 $llegada = $hllegada." : ".$hola;
			
	
?>	
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="../estilos.css"/>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reporte de llegada</title>


<script>

 function reporte(correo, cedula, llegada) 
        {	
			var hll = document.getElementById('rhora').value
			var mll = document.getElementById('rminuto').value
	
				var parametros = {
				"correo": correo,
				"cedula": cedula,
				"llegada": llegada,					
				"hll": hll,																
				"mll": mll,									
               	};
							
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/permisos/enviarreporte.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#validador").html(response);
						window.location.href = "http://190.144.42.83:9090/plantillas/permisos/archivo_soporte_permiso.php";				
                    }
        
        });
        }
			
			
function mueveReloj(){
	//alert("ingreso");
    momentoActual = new Date()
    hora = momentoActual.getHours()
    minuto = momentoActual.getMinutes()
//	alert(minuto);
	
    segundo = momentoActual.getSeconds()

    horaImprimible = hora + ":" + minuto

//    document.form_reloj.reloj.value = horaImprimible
	document.getElementById('llegue').value = horaImprimible
	
	var horadef = hora - <?php echo $hllegada; ?>;
	var minutodefO = minuto - <?php echo $hola; ?>;
	
		
	var tiempo = "El tiempo adicional del permiso fue de "+horadef+" horas y "+minutodefO+" minutos. Por favor adjunte el soporte del permiso y reporte la reposicion de tiempo a su jefe inmediato de ser necesario";
	alert (tiempo);
	alert ("AHORA PUEDE ADJUNTAR EL SOPORTE DEL PERMISO...MUCHAS GRACIAS");
	
	
	
	
}

			
function calcular(){
	
	
	var horadef = document.getElementById('rhora').value - <?php echo $hllegada; ?> - 1 ;
	
	if(document.getElementById('rminuto').value > <?php echo $hola; ?>)
	{
	var minutodefO = document.getElementById('rminuto').value - <?php echo $hola; ?>;
	}
	else {
//	var minutodefO = document.getElementById('rminuto').value + <?php echo $hola; ?>;
	
		var mn = document.getElementById('rminuto').value;
		var mn1 = <?php echo ($hola); ?>
		//alert(mn);
	var minutodef0 = parseInt(mn) + parseInt(mn1);
	//alert(minutodef0);
	//+ mn;
	
	}
		
	var tiempo = "El tiempo adicional del permiso fue de "+horadef+" horas y "+minutodef0+" minutos. Por favor adjunte el soporte del permiso y reporte la reposicion de tiempo a su jefe inmediato de ser necesario";
	alert (tiempo);
	alert ("A CONTINUACION ADJUNTE EL SOPORTE DEL PERMISO...MUCHAS GRACIAS");
	
	reporte('<?php	echo $rs_qry->correo; ?>','<?php	echo $cedula; ?>', '<?php	echo $llegada; ?>');
	
	
}
</script>


<style type="text/css">
.centrar {
	text-align: center;
}
.centrar {
	text-align: center;
}
</style>
	
</head>
<body>

  <br>
    <br>
  <table width="961" border="1" align="left" >
    <tr align="center" class="encabezados">
      <td width="128" height="30">Fecha de permiso</td>
      <td width="108" height="30">Salida</td>
      <td width="144" >Llegada</td>
      <td width="212" >observacion</td>
      <td width="335" class="intro_tk" >REGISTRO DE LLEGADA</td>
    </tr>
    <tr align="center">
      <td height="30" align="center"><?php	echo $rs_qry->f_final; ?></td>
      <td height="30"  align="center"><?php	echo $rs_qry->salida; ?></td>
      <td  align="center"><label>
        <input name="horapermiso" type="text" id="horapermiso" value="<?php	echo $llegada; ?>" readonly />
      </label>        </td>
      <td  align="left"><?php	echo $rs_qry->observacion; ?></td>
      <td  align="left">
        <p>
          <label>
            Hora        </label>
          <select name="rhora" id="rhora">
            <option value="">..</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>



          </select>
          <label>
            :
              <select name="rminuto" id="rminuto"  onchange="calcular()">
                <option value="">..</option>
                <option value="05">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="25">25</option>
                <option value="30">30</option>
                <option value="35">35</option>
                <option value="40">40</option>
                <option value="45">45</option>
                <option value="50">50</option>
                <option value="55">55</option>
                <option value="00">00</option>
              </select>
          </label>
        </p></td>
    </tr>
</table>
  <p>&nbsp;</p>
</body>
</html>
