<?php
// conexion servidor pegomax con instancia 
$serverName = "10.1.10.103\sqlexpress2, 1433"; //serverName\instanceName

// Puesto que no se han especificado UID ni PWD en el array  $connectionInfo,
// La conexión se intentará utilizando la autenticación Windows.
$connectionInfo = array( "Database"=>"factu03", "UID"=>"sa", "PWD"=>"Pegomax2010");
$conn_pego = sqlsrv_connect( $serverName, $connectionInfo);

/*if($conn_pego ) {
     echo "Conexi&oacute;n establecida.<br />";
}else{                                           
     echo "Conexión no se pudo establecer.<br />";
     die( print_r( sqlsrv_errors(), true));
}*/
?>
