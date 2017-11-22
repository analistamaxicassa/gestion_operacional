<?php
require_once('conexionesDB/conexion.php');
$link_act=Conectarse_act_man();

if (!(is_numeric($_POST['nombre']) OR empty($_POST['nombre']))) {

	$buscar=strtoupper($_POST['nombre']);
	if (true)
	{
		$sql="SELECT cedula, CONCAT(nombre, ' - ', cargo) AS resultadoEmpleado FROM usuarios_queryx WHERE nombre LIKE '%$buscar%'
		AND (cargo LIKE 'JEFE%' OR cargo LIKE 'ANALISTA%' OR cargo LIKE 'COOR%' OR cargo LIKE 'GERENTE%' OR cargo LIKE 'DIRECTOR%' OR cargo LIKE 'ADMINISTRADOR%')
		AND cargo != 'COOR DE BODEGAS'
		AND cargo != 'COOR DE BODEGA'";
		$qry=$link_act->query($sql);
		$rs=$qry->fetch_object();

	do{
			@$nombre = $rs->resultadoEmpleado;
			@$id = $rs->cedula;
			if (!empty($id))
			{
				echo '<li style="cursor: pointer;" onclick="set_item(\''.str_replace("'", "\'", @$nombre).'\'); pasar_id('.@$id.')">'.@$nombre.'</li>';
			}
		}while($rs=$qry->fetch_object());
	}
}
?>
