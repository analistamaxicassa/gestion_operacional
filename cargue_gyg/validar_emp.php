<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
include_once "conexiones/conexion_cera.php";
include_once "conexiones/conexion_max.php";
include_once "conexiones/conexion_pegomax.php";
include_once "conexiones/conexion_tucassa.php";

session_start();

$emp=$_POST['emp'];
@$num=$_SESSION['numero'];

if(isset($_SESSION['numero']))
{
switch($emp)
{
	//conexiones con odbc
	case "CERA":
	$conexion=$conn_cera;
	break;
	case "MAX":
	$conexion=$conn_max;
	break;
	case "TUC":
	$conexion=$conn_tc;
	break;
}

$sql="SELECT numero FROM gastos1_2000 WHERE numero='$num'";
$result=odbc_exec($conexion,$sql);
$dat=odbc_fetch_array($result);

do{
    $numero=$dat['numero'];
	if($num!=$numero)
	{
		echo "No puede cargar el documento detalle, no ha insertado el encabezado";
	}else{
		echo "Comprobante n&uacute;mero: ".$numero."<br>";
		?>
        <script>
			document.getElementById('enviar').disabled=false;
		</script>
        <?php
	}
		
}while($dat=odbc_fetch_array($result));

}
/*
if($emp=='PEGO')
{

}
*/
?>