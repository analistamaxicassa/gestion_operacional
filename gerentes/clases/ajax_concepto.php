<?php
require_once('../../conexionesDB/conexion.php');
// $link_queryx_seven = Conectarse_queryx_mysql();
$link_personal = Conectarse_personal();
session_start();

if (isset($_POST['variable'])) {

	 $buscar = $_POST['variable'];

				$sql = "SELECT cod_concepto, descripcion_con FROM variables_conceptos
								WHERE cod_variable='$buscar' and estado=1";
				$qry = $link_personal->query($sql);
				$salas = $qry->fetch_object();

 		echo '<select class="form-control" id="cod_concepto" name="cod_concepto" onchange="buscar_tema();busca_calificacion()" required>
							<option value="">Seleccione...</option>';

					do{
						$cod_concepto = $salas->cod_concepto;
						$nombre_concepto = $salas->descripcion_con;
							if (!empty($cod_concepto))
							{
							echo '<option value="'.$cod_concepto.'">'.$nombre_concepto.'</option>';
							}
					}while($salas = $qry->fetch_object());

					echo '</select>';


}elseif(isset($_POST['cod_concepto'])) {

	 $buscar = $_POST['cod_concepto'];

				$sql = "SELECT cod_tema,descripcion_tema FROM conceptos_temas
								WHERE cod_concepto= $buscar and estado=1";
				$qry = $link_personal->query($sql);
				$salas = $qry->fetch_object();

 		echo '<select class="form-control" id="cod_tema" name="cod_tema" required>
							<option value="">Seleccione ...</option>';
					do{
						$cod_tema = $salas->cod_tema;
						$nombre_tema = $salas->descripcion_tema;
							if (!empty($cod_tema))
							{
							echo '<option value="'.$cod_tema.'">'.$nombre_tema.'</option>';
							}
					}while($salas = $qry->fetch_object());

					echo '</select>';


}




?>
