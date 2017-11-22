<?php
set_time_limit(300);

$sala = $_GET['sala'];



require_once('../PAZYSALVO/conexion_ares.php');
$link=Conectarse();

//conexion con siesa
//  cadena de conexión
$dsn = "Driver={SQL Server};Server=10.1.0.28;Database=UnoEE;Integrated Security=SSPI;Persist Security Info=False;";
// conexión con los datos especificados anteriormente
$conn = odbc_connect( $dsn, 'sa', '.53rg1m4r3C.' );
if (!$conn)
{
exit( "Error al conectar: " . $conn);
}

//consulta de ventas de sala

$fini=date("Ym")."01";
$ffin=date("Ymd");
$diasproy = number_format((substr("$ffin", -2)), 0, ",", ".")
;

//consulta en siesa de Ventas

$ventas = 0;
$q1=odbc_exec($conn,"exec sp_pv_cons_fact_notas 4,'$sala ','FVS','',1,0,0,0,0,'$fini','$ffin',7,0,0,0,2,0,0,10095,'006CV - NO. DE FACTURAS POR C.O',1024,0,1,NULL,NULL,NULL,NULL,NULL,NULL");
$rs1=odbc_fetch_array($q1);
echo "exec sp_pv_cons_fact_notas 4,'$sala ','FVS','',1,0,0,0,0,'$fini','$ffin',7,0,0,0,2,0,0,10095,'006CV - NO. DE FACTURAS POR C.O',1024,0,1,NULL,NULL,NULL,NULL,NULL,NULL"."<br>";

do{

 $siesacc=$rs1['f_co'];
 $siesanumero=$rs1['f_nrodocto'];
 $siesavalor=$rs1['f_valor_subtotal'];

$ventas = $siesavalor + $ventas;
$ins="INSERT INTO `personal`.`venta_sala` (`id`, `cc`, `numero`, `subtotal`) VALUES (NULL, '$siesacc', '$siesanumero', '$siesavalor');";
 //$qry=$link->query($ins);

}while($rs1=odbc_fetch_array($q1));
odbc_free_result($q1);
odbc_close($conn);
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
	text-align: left;

}

</style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>VENTAS DE SALA</title>

  <link rel="stylesheet" type="text/css" href="../estilos.css"/>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>


</head>
<body>

<p>

<form>
<div id="validador">


  <table width="32%" border="1" align="center"  style="border-collapse:collapse">

    <tr>
      <td width="44%" align="left" valign="middle" class="subtitulos"><h2 class="intro_tkg">VENTA ACTUAL</h2></td>
      <td width="56%" align="left" valign="middle">$<span style="font-size:12px"><?php echo number_format($ventas, 0, ",", ".");?></span></td>
    </tr>
  </table>
  <p><span class="encabezados">
  <input type="submit" style="background:#FFF" name="cerrar" id="cerrar"  onClick="window.close();"value="CERRAR" >
  </span></p>
</div></form>
 <p>
