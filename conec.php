<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conec = "localhost";
$database_conec = "personal";
$username_conec = "root";
$password_conec = "KcZnMxCUXWmmpBLS";
$conec = mysql_connect($hostname_conec, $username_conec, $password_conec) or trigger_error(mysql_error(),E_USER_ERROR); 
?>