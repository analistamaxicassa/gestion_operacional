<link rel="stylesheet" href="/resources/demos/style.css">
<script>
    $("input[name='nombre']").val('');
    $("input[name='ecivil']").val('');
    $("input[name='cargo']").val('');
    $("input[name='antiguedad']").val('');
    $("input[name='contrato']").val('');
    $("input[name='promedio']").val('');
</script>
<?php
	//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}

$Iden = (is_numeric($_POST['cedulanuevo']))?$_POST['cedulanuevo']:NULL;
 
if(!is_null($Iden)){
    $Consulta = "SELECT EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE
,EMP.EMP_ESTADO_CIVIL ECIVIL, CA.CARGO_NOMBRE, TO_CHAR((SYSDATE - EMP_FECHA_INGRESO)/30,9999)/12 ANTIGUEDAD, EMP.EMP_TIPO_CONTRATO TIPO_CONTRATO
, (SUM(AC.ACUM_VALOR_LOCAL))/3 PROMEDIO
FROM EMPLEADO EMP,TRH_ACUMULADO AC,CARGO CA, CONCEPTOS CO
WHERE EMP.EMP_ESTADO <> 'R' AND EMP.EMP_CODIGO = '$cedulanuevo' and EMP.EMP_CARGO = CA.CARGO_CODIGO AND EMP.EMP_CODIGO = AC.EMP_CODIGO AND
AC.ACUM_FECHA_PAGO > SYSDATE - 90 AND AC.CON_CODIGO = CO.CON_CODIGO AND
CO.CON_NATU = 'DEV' AND EMP.EMP_ESTADO <> 'R' AND EMP.EMP_CODIGO = '$cedula' AND AC.CON_CODIGO <> '130'
GROUP BY EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2, EMP.EMP_ESTADO_CIVIL, CA.CARGO_NOMBRE, TO_CHAR((SYSDATE - EMP_FECHA_INGRESO)/30,9999)/12, EMP.EMP_TIPO_CONTRATO";

$stmt = $dbh->prepare($query);
$stmt->execute();
$row = $stmt->fetch(); 


    if($row == 0){
        echo "<script>alert('No hay valores que coincidan con la búsqueda.');</script>";
    } else {
?>
        <script>
            $("input[name='Arti']").val("<?php echo $Registro['Articulo'];?>");
            $("input[name='Precio']").val("<?php echo $Registro['Precio'];?>");
        </script>
<?php 
    }
} else {
    echo "<script>alert('Estas metiendo un valor no numérico');</script>";
}
?>


*************



<?php 

//recojo variables
$cedula=$_POST['cedula'];

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();


$query = "SELECT EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE
,EMP.EMP_ESTADO_CIVIL ECIVIL, CA.CARGO_NOMBRE, TO_CHAR((SYSDATE - EMP_FECHA_INGRESO)/30,9999)/12 ANTIGUEDAD, EMP.EMP_TIPO_CONTRATO TIPO_CONTRATO
, (SUM(AC.ACUM_VALOR_LOCAL))/3 PROMEDIO
FROM EMPLEADO EMP,TRH_ACUMULADO AC,CARGO CA, CONCEPTOS CO
WHERE EMP.EMP_ESTADO <> 'R' AND EMP.EMP_CODIGO = '$cedulanuevo' and EMP.EMP_CARGO = CA.CARGO_CODIGO AND EMP.EMP_CODIGO = AC.EMP_CODIGO AND
AC.ACUM_FECHA_PAGO > SYSDATE - 90 AND AC.CON_CODIGO = CO.CON_CODIGO AND
CO.CON_NATU = 'DEV' AND EMP.EMP_ESTADO <> 'R' AND EMP.EMP_CODIGO = '$cedula' AND AC.CON_CODIGO <> '130'
GROUP BY EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2, EMP.EMP_ESTADO_CIVIL, CA.CARGO_NOMBRE, TO_CHAR((SYSDATE - EMP_FECHA_INGRESO)/30,9999)/12, EMP.EMP_TIPO_CONTRATO" ;

$stmt = $dbh->prepare($query);
$stmt->execute();
$row = $stmt->fetch(); 

$nombreemp=$row['NOMBRE'];
$ecivil=$row['ECIVIL'];
$cargonombre=$row['CARGO_NOMBRE'];
$ant=$row['ANTIGUEDAD'];
$tcontrato=$row['TIPO_CONTRATO'];
$promediosalario=$row['PROMEDIO'];


 ?> 

















<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>



</head>

<body>


<form>
    <label style="width:100px; float:left;">ID</label><input type="text" name="Identifica" value=""> Nota: Poniendo el id se rellenan los otros datos solos.<br>
    <label style="width:100px; float:left;">Articulo</label><input type="text" name="Arti" value=""><br>
    <label style="width:100px; float:left;">Precio</label><input type="text" name="Precio" value=""><br>
</form>
<p>&nbsp;</p>
</body>
</html>