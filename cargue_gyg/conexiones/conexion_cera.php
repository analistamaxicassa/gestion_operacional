<?php
//  cadena de conexión
$dsn = "Driver={SQL Server};Server=10.1.0.10;Database=Factu02;Integrated Security=SSPI;Persist Security Info=False;";
// conexión con los datos especificados anteriormente
$conn_cera = odbc_connect( $dsn, 'sa', 'trespies' );
if (!$conn_cera) 
{
	exit( "Error al conectar: " . $conn_cera);
}
?>


