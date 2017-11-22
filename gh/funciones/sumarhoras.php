<?php
function sumahoras ($hora1,$hora2){
$hora1=explode(":",$hora1);
$hora2=explode(":",$hora2);
$horas=(int)$hora1[0]+(int)$hora2[0];
$minutos=(int)$hora1[1]+(int)$hora2[1];
$segundos=(int)$hora1[2]+(int)$hora2[2];
$horas+=(int)($minutos/60);
$minutos=(int)($minutos%60)+(int)($segundos/60);
$segundos=(int)($segundos%60);

return (intval($horas)<10?'0'.intval($horas):intval($horas)).':'.($minutos<10?'0'.$minutos:$minutos).':'.($segundos<10?'0'.$segundos:$segundos);
}

?>