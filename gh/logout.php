<?php
session_start();
//v2. 25/04/2016 graba el cierre de sesion del usuario

$_SESSION['us'];
$_SESSION['autentica'];
$_SESSION['email'];
$_SESSION['nombre'];

$_SESSION=array();

session_destroy();

header("Location: login.php");
exit();
?>
