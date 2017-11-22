<?php

$sala = $_REQUEST['sala'];
//recojo variables
//$sala=$_POST['sala'];
//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
//$hoy=date("Y-m-d");

?>	

<link rel="stylesheet" type="text/css" href="../estilos.css"/>
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

   <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
function siguiente(sala)
		{	 alert(sala) 
			  //document.getElementById('VB_pazysalvo').disabled=true;
			    i = i+1;
				var parametros = {
				"sala": sala,
				"rs": i,
                 	};
                $.ajax({
                data: parametros,
                url: 'siguienteci.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta").html(response);
						
						
                    }
        
        });
        }
</script>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

</head>
<body>

<?php

	//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
	//conexion sql	
	
	$sql="SELECT cedula, educacion, hijosyedades, motivacion, proyeccion, fortalezas, debilidades, recomendaciones FROM cliente_interno where sala = $sala";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 
	
	if (empty($rs_qry)) {
    echo 'No existen registros';
	exit();
	}
	else {
		//do{
	$cedula = $rs_qry->cedula;	
	$educacion = $rs_qry->educacion;
	$hijosyedades = $rs_qry->hijosyedades;
	$motivacion = $rs_qry->motivacion;
	$proyeccion = $rs_qry->proyeccion;
	$fortalezas = $rs_qry->fortalezas;
	$debilidades = $rs_qry->debilidades;
	$recomendaciones = $rs_qry->recomendaciones;
	
	
	 $query = "SELECT EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE
,EMP.EMP_ESTADO_CIVIL ECIVIL
FROM EMPLEADO EMP
WHERE EMP.EMP_ESTADO <> 'R'  AND EMP.EMP_CODIGO = '$cedula'";
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch();	
		
		$nombre=$row['NOMBRE'];
		$ecivil=$row['ECIVIL'];
		}

?>


<table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="50%">
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>NOMBRE</strong></td>
      <td class="header" colspan="6"  align="justify" ><?php echo utf8_encode($nombre); ?></td>
    </tr>
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Estado Civil</strong></td> 
      <td width="612" class="header" colspan="6"  align="justify" ><?php echo utf8_encode($ecivil); ?></td>      </tr> 
    <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Hijos y Edades</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" valign="middle"><?php echo utf8_encode($hijosyedades); ?></td> 
     </tr> 
 <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Educacion</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" valign="middle"><?php echo utf8_encode($educacion); ?></td>      </tr>
      <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Que lo motiva</strong></td> 
      <td width="612" class="header" colspan="6" align="justify"  valign="middle"><?php echo utf8_encode($motivacion); ?></td>
     </tr>
      <tr>
      <td class="header" colspan="4" align="left" valign="middle"><strong>Proyecciones</strong></td> 
      <td width="612" class="header" colspan="6" align="justify" valign="middle"><?php echo utf8_encode($proyeccion); ?></td> 
     </tr>
      
    </table>
    
</span><br>
  </p>
  <input type="submit" onClick="siguiente('<?php echo ($cedula); ?>')"; name="siguiente" id="siguiente" value="SIGUIENTE EMPLEADO" />
  <p>&nbsp;</p>

</body>
</html>
<script>
window.reload();
</script>
