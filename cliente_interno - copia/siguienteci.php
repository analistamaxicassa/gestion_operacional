
<link rel="stylesheet" type="text/css" href="../estilos.css"/>

<?php

include "../PAZYSALVO/conexion_ares.php";
$link=Conectarse();

echo $cedula=$_POST['cedula'];
$i=$_REQUEST['rs'];
$hoy=date("Y-m-d");


//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");

//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}

  
//conexion sql

			$sql="SELECT educacion, hijosyedades, motivacion, proyeccion, fortalezas, debilidades, recomendaciones FROM cliente_interno where sala = $cedula";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 
				

	$qry_sql=$link->query($sql);
	$rs_qry=$qry_sql->fetch_object();  ///consultar 
	do{
	  $vector1[]=$rs_qry->educacion;
	  $vector2[]=$rs_qry->hijosyedades;
  	  $vector3[]=$rs_qry->motivacion;
      $vector4[]=$rs_qry->proyeccion;
	  $vector5[]=$rs_qry->fortalezas;
	  $vector6[]=$rs_qry->debilidades;
  	  $vector7[]=$rs_qry->recomendaciones;

	  
	}while($rs_qry=$qry_sql->fetch_object());

	$total = count($vector);


	if ($i == $total)
	{
		echo "NO EXISTEN MAS REGISTROS";
		 exit();
	}
    $recomendaciones = $vector7[$i];	
    $debilidades = $vector6[$i];
    $fortalezas = $vector5[$i];
    $proyeccion = $vector4[$i];
    $motivaciones = $vector3[$i];	
    $hijosyedades = $vector2[$i];
    $educacion = $vector1[$i];
    

	
do{
	$query = "SELECT CA.CARGO_NOMBRE, TO_CHAR((SYSDATE - EMP_FECHA_INGRESO)/30,9999)/12 ANTIGUEDAD, EMP.EMP_TIPO_CONTRATO TIPO_CONTRATO
, (SUM(AC.ACUM_VALOR_LOCAL))/3 PROMEDIO
FROM EMPLEADO EMP
,TRH_ACUMULADO AC,CARGO CA, CONCEPTOS CO
WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO  AND EMP.EMP_CODIGO = AC.EMP_CODIGO  AND
AC.ACUM_FECHA_PAGO > SYSDATE - 90  AND AC.CON_CODIGO = CO.CON_CODIGO AND
CO.CON_NATU = 'DEV' AND EMP.EMP_ESTADO <> 'R'  AND EMP.EMP_CODIGO = '$cedula' AND AC.CON_CODIGO <> '130'
GROUP BY CA.CARGO_NOMBRE, TO_CHAR((SYSDATE - EMP_FECHA_INGRESO)/30,9999)/12, EMP.EMP_TIPO_CONTRATO";
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row_n = $stmt->fetch();
		
		$row_n['CARGO_NOMBRE'];
		$row_n ['ANTIGUEDAD'];
		$row_n ['TIPO_CONTRATO'];
		$row_n['PROMEDIO'];
		
	?>
     <script src="//code.jquery.com/jquery-1.10.2.js"></script>

<form method="post" action="../cliente_interno/selecciona_sala.php">
<table border="1" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="100%">
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
<?php
	
  exit();
}while($i <= count($vector));

$link->close();
?>


          
   


