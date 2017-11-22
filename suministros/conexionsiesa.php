<?php
//conexion con siesa
//  cadena de conexión
$dsn = "Driver={SQL Server};Server=10.1.0.28;Database=UnoEE;Integrated Security=SSPI;Persist Security Info=False;";
// conexión con los datos especificados anteriormente
$conn = odbc_connect( $dsn, 'sa', '.53rg1m4r3C.' );
if (!$conn)
{
exit( "Error al conectar: " . $conn);
}


//consulta sql

exec sp_pv_cons_fact_notas 4,'   ','FVS','',1,0,0,0,0,'20161101','20161125',7,0,0,0,2,0,0,10095,'006CV - NO. DE FACTURAS POR C.O',1024,0,1,NULL,NULL,NULL,NULL,NULL,NULL



// ejecucion
$fini=date("Ym")."01";
$ffin=date("Ymd");

$q1=odbc_exec($conn,"exec sp_pv_cons_fact_notas 7,'   ','   ','',1,0,0,0,0,'$fini','$ffin',$cia,0,0,0,2,0,0,10095,'crm_ventas_subtotal',1024,0,1,NULL,NULL,NULL,NULL,NULL,NULL");
$rs1=odbc_fetch_array($q1);

$neto=0;

do{
 $valneto=$rs1['f_valor_neto_local'];
 $vendedor=$rs1['f_vendedor_razon_social'];
 $cliente=$rs1['f_cliente_fact_razon_soc'];
 $neto=$neto+$valneto;
 
 $ins="INSERT INTO ds_tmp_panel1 (valor, vendedor, cliente) VALUES ('$valneto','$vendedor','$cliente')";
 $qry=$link->query($ins);
 
}while($rs1=odbc_fetch_array($q1));
odbc_close($conn);




?>








<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
</body>
</html>