<?php
require_once('../../conexionesDB/conexion.php');
// $link_queryx_seven = Conectarse_queryx_mysql();
$link_personal = Conectarse_personal();
session_start();

if (isset($_POST['sala_codigo'],$_POST['cod_variable'],$_POST['cod_concepto'])) {


	 $centro_costo = $_POST['sala_codigo'];
	 $cod_variable = $_POST['cod_variable'];
	 $cod_concepto = $_POST['cod_concepto'];

				$sql = "SELECT codigo_gestion, calificacion FROM gestion_salas
								WHERE centro_costo='$centro_costo' AND cod_variable=$cod_variable AND cod_concepto=$cod_concepto
								ORDER BY codigo_gestion DESC LIMIT 1";
				// exit($sql);
				$qry = $link_personal->query($sql);
				$resul_califica = $qry->fetch_object();
				if (!empty($resul_califica)) {

				header("Content-Type: application/json");
				$arr = array();

					$calificacion = $resul_califica->calificacion;
					$codigo_gestion_califica = $resul_califica->codigo_gestion;
					$arr[0] = $calificacion;
					$arr[1] = $codigo_gestion_califica;
				}else {
					$arr[0] = 0;
					$arr[1] = 0;
				}
				echo json_encode($arr);
				exit();

}

?>
