<?php
require_once('conexionesDB/conexion.php');
// $link_act=Conectarse_act_man();
$link_queryx_seven = Conectarse_queryx_mysql();

if (isset($_POST['nombre'])) {


if (!(is_numeric($_POST['nombre']) OR empty($_POST['nombre']))) {

	$buscar=strtoupper($_POST['nombre']);
	if ($_POST['tipoRol']=='ejecutor') {
		$sql = "SELECT EMP.EMP_CODIGO AS cedula, CONCAT(EMP.EMP_NOMBRE, ' - ', CA.CARGO_NOMBRE) AS resultadoEmpleado, EMP.EMP_EMAIL
		FROM EMPLEADO EMP INNER JOIN CARGO CA ON EMP.EMP_CARGO = CA.CARGO_CODIGO WHERE EMP.EMP_NOMBRE LIKE '%$buscar%' AND EMP.EMP_ESTADO <> 'R'";
		$qry=$link_queryx_seven->query($sql);
		$rs=$qry->fetch_object();

		do{
				@$nombre = $rs->resultadoEmpleado;
				@$correo = $rs->EMP_EMAIL;
				@$id = $rs->cedula;

				//Validación para traer datos del jefe del ejecutorID
				$sql = "SELECT EMP_JEFE_CODIGO FROM empleado where EMP_CODIGO='$id' AND EMP_ESTADO <> 'R'";
				$query_jefe = $link_queryx_seven->query($sql);
				$resul_jefe = $query_jefe->fetch_object();
				@$cod_jefe = $resul_jefe->EMP_JEFE_CODIGO;

				$sql_nomjefe = "SELECT EMP.EMP_CODIGO AS cedula, CONCAT(EMP.EMP_NOMBRE, ' - ', CA.CARGO_NOMBRE) AS resultadoEmpleado, EMP.EMP_EMAIL
				FROM EMPLEADO EMP INNER JOIN CARGO CA ON EMP.EMP_CARGO = CA.CARGO_CODIGO WHERE EMP.EMP_CODIGO='$cod_jefe' AND EMP.EMP_ESTADO <> 'R'";
				// $nombreJefe = $sql_nomjefe;
				$query_nomjefe=$link_queryx_seven->query($sql_nomjefe);
				$result_nomjefe=$query_nomjefe->fetch_object();
				@$nombreJefe = $result_nomjefe->resultadoEmpleado;
				//Termina Validación

				if (!empty($id))
				{
					echo '<li style="cursor: pointer;" onclick="set_item1(\''.str_replace("'", "\'", @$nombre).'\'); pasar_id1('.@$id.');buscarResponsable('.@$cod_jefe.'); jefeEjecutor(\''.str_replace("'", "\'", @$nombreJefe).'\')">'.@$nombre.'</li>';
				}
		}while($rs=$qry->fetch_object());
	}
	elseif ($_POST['tipoRol']=='responsable')
	{
		$sql = "SELECT EMP.EMP_CODIGO AS cedula, CONCAT(EMP.EMP_NOMBRE, ' - ', CA.CARGO_NOMBRE) AS resultadoEmpleado, EMP.EMP_EMAIL
		FROM EMPLEADO EMP INNER JOIN CARGO CA ON EMP.EMP_CARGO = CA.CARGO_CODIGO WHERE EMP.EMP_NOMBRE LIKE '%$buscar%'
		AND EMP.EMP_ESTADO <> 'R'";
		$qry=$link_queryx_seven->query($sql);
		$rs=$qry->fetch_object();

			do{
					@$nombre = $rs->resultadoEmpleado;
					@$correo = $rs->EMP_EMAIL;
					@$id = $rs->cedula;
					if (!empty($id))
					{
						echo '<li style="cursor: pointer;" onclick="set_item2(\''.str_replace("'", "\'", @$nombre).'\'); pasar_id2('.@$id.')">'.@$nombre.'</li>';
					}
			}while($rs=$qry->fetch_object());
	}elseif ($_POST['tipoRol']=='informado')
	{
		$sql = "SELECT EMP.EMP_CODIGO AS cedula, CONCAT(EMP.EMP_NOMBRE, ' - ', CA.CARGO_NOMBRE) AS resultadoEmpleado, EMP.EMP_EMAIL
		FROM EMPLEADO EMP INNER JOIN CARGO CA ON EMP.EMP_CARGO = CA.CARGO_CODIGO WHERE EMP.EMP_NOMBRE LIKE '%$buscar%' AND EMP.EMP_ESTADO <> 'R'";
		$qry=$link_queryx_seven->query($sql);
		$rs=$qry->fetch_object();

			do{
					@$nombre = $rs->resultadoEmpleado;
					@$correo = $rs->EMP_EMAIL;
					@$id = $rs->cedula;
					if (!empty($id))
					{
						echo '<li style="cursor: pointer;" onclick="set_item3(\''.str_replace("'", "\'", @$nombre).'\'); pasar_id3('.@$id.')">'.@$nombre.'</li>';
					}
			}while($rs=$qry->fetch_object());
		}
	}
}
// if (!(is_numeric($_POST['nombre']) OR empty($_POST['nombre']))) {
//
// 	$buscar=strtoupper($_POST['nombre']);
// 	if (true)
// 	{
// 		$sql="SELECT cedula, CONCAT(nombre, ' - ', cargo) AS resultadoEmpleado FROM usuarios_queryx WHERE nombre LIKE '%$buscar%'
// 		AND (cargo LIKE 'JEFE%' OR cargo LIKE 'ANALISTA%' OR cargo LIKE 'COOR%' OR cargo LIKE 'GERENTE%' OR cargo LIKE 'DIRECTOR%' OR cargo LIKE 'ADMINISTRADOR%')
// 		AND cargo != 'COOR DE BODEGAS'
// 		AND cargo != 'COOR DE BODEGA'";
// 		$qry=$link_act->query($sql);
// 		$rs=$qry->fetch_object();
//
// 	do{
// 			@$nombre = $rs->resultadoEmpleado;
// 			@$id = $rs->cedula;
// 			if (!empty($id))
// 			{
// 				echo '<li style="cursor: pointer;" onclick="set_item(\''.str_replace("'", "\'", @$nombre).'\'); pasar_id('.@$id.')">'.@$nombre.'</li>';
// 			}
// 		}while($rs=$qry->fetch_object());
// 	}
// }


?>
