<?php
// cadena de conexion para trabajar con instancia en odbc
$_TEMP = array();
$_TEMP["server"] = '10.1.0.11\TUCASASAS'; //server de base de datos
$_TEMP["database"] = 'factu01'; //nombre de la base de datos
$_TEMP["username"] = 'sa';
$_TEMP["password"] = 'Temporal123';
$connection_string = 'DRIVER={SQL SERVER};SERVER='. $_TEMP["server"] . ';DATABASE=' . $_TEMP["database"];
$conn_tc = odbc_connect($connection_string, $_TEMP["username"], $_TEMP["password"]);
unset( $connection_string ); //libera variables
unset( $_TEMP );
?>