<?php
//  cadena de conexión para programa contable de maxceramica
$dsn = "Driver={SQL Server};Server=10.1.0.131;Database=factu04;Integrated Security=SSPI;Persist Security Info=False;";
// conexión con los datos especificados anteriormente
$conn_max = odbc_connect( $dsn, 'sa', 'Tecnologia2013' );
if (!$conn_max) 
{
	exit( "Error al conectar: " . $conn_max);
}
?>
