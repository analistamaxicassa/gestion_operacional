<?php 
require_once('file:///C|/xampp/htdocs/crm/conexion/conexion_siesa.php');


$buscar=strtoupper($_REQUEST['ref']);
if($buscar != "")
{
	
  if(is_numeric($buscar))
  {
	  $sql="SELECT cedula, nombre FROM `usuarios_queryx` where cedula like '$buscar'");
  }else{
	  $sql=odbc_exec($conn,"exec sp_items_leer_por_like $cia,NULL,'$buscar',0,0,0,0,NULL,0,NULL,0,NULL,0,NULL,0,NULL,0,NULL,0,NULL,NULL,9,0,NULL,NULL,0,0,'   ','   ',0,0,NULL,NULL,NULL,1,NULL,0,NULL,0,0,1024");
  }
}
$datos=odbc_fetch_array($sql);

do{
		@$rowid = $datos['rowid'];
		@$item=$datos['Item'];
		@$descripcion=array_values($datos)[2];

    echo '<li style="cursor: pointer;" onclick="set_item(\''.str_replace("'", "\'", @$descripcion).'\');  pasar_id('.@$rowid.'); cantidades('.@$rowid.')">'.@$item." - ".@$descripcion.'</li>';
}while($datos=odbc_fetch_array($sql));

?>