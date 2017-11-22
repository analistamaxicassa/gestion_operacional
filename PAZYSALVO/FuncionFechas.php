<?php

function fechaletra($fecha)
{
 $fecha_esp	 = str_replace("/", "-", $fecha);
 $dia = substr($fecha_esp, 0, 2);
 $mes   = substr($fecha_esp, 3, 2);
//$anio=date("Y", strtotime(substr($fecha_esp, 6,2)));
 $anio=(substr($fecha_esp,6,4));
//$anio2 = date("Y", strtotime($fecha));

if ($mes=="01") $mes="Enero";
if ($mes=="02") $mes="Febrero";
if ($mes=="03") $mes="Marzo";
if ($mes=="04") $mes="Abril";
if ($mes=="05") $mes="Mayo";
if ($mes=="06") $mes="Junio";
if ($mes=="07") $mes="Julio";
if ($mes=="08") $mes="Agosto";
if ($mes=="09") $mes="Septiembre";
if ($mes=="10") $mes="Octubre";
if ($mes=="11") $mes="Noviembre";
if ($mes=="12") $mes="Diciembre";

return $dia." de ".$mes."/".$anio;    
//echo $fecha;
}  

?>