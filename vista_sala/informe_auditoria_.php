<?php
  require_once('../conexionesDB/conexion.php');
  session_start();
  if(!isset($_SESSION['userID']))
	{
		?>
		<script>
		alert("Sesión inactiva");
		location.href="index.php";
		</script>
			<?php
	}
	else
  {
    if (isset($_GET['fecha'])) {
      $fecha = $_GET['fecha'];
    }
    $centro_operacion = $_SESSION['centro_operacion'];
  	list($empresa, $location, $area) = explode("-", $centro_operacion);
    $link_personal=Conectarse_personal();
	}

	?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CLIENTE INTERNO</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
  <body>
    <ol class="breadcrumb">
      <li class="active">Informe auditoria operacional</li>
      <li><a href="inicio.php">Histórico de evaluaciones</a></li>
    </ol>
    <div class="table-responsive col-md-12">
      <table class="table table-bordered">
        <thead>
          <tr class="bg-primary">
            <th>Fecha</th>
            <th>Concepto</th>
            <th>Calificación</th>
            <th>Hallazgo</th>
            <th>Tarea</th>
            <th>Responsable</th>
            <th>Fecha Control</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
        <?php
          //consulta de concepto de sala
          $sql_resumen="SELECT cs.fecha,cs.concepto_esp,par.Descripcion, cs.calificacion,cs.hallazgo,cs.tarea,cs.responsable,cs.fecha_control,cs.ESTADO
          FROM concepto_sala cs INNER JOIN parametros par ON cs.concepto_esp=par.id_parametro
           WHERE cs.cc='$location' AND cs.fecha = '$fecha' ORDER BY cs.calificacion DESC";
          $query_resumen=$link_personal->query($sql_resumen);
          $resumen=$query_resumen->fetch_object();  ///consultar

          if (empty($resumen)) {
            echo 'No existen registros';
          }
          else
          {
            do{
        ?>
                  <tr>
                    <td><?php echo ($resumen->fecha); ?></td>
                    <td><?php echo  ($resumen->Descripcion); ?></td>
                    <td><?php echo ($resumen->calificacion); ?></td>
                    <td><?php echo  ($resumen->hallazgo); ?></td>
                    <td><?php echo  ($resumen->tarea); ?></td>
                    <td><?php echo  ($resumen->responsable); ?></td>
                    <td><?php echo ($resumen->fecha_control); ?></td>
                    <td><?php echo  ($resumen->ESTADO); ?></td>
                  </tr>
        <?php
            }while($resumen=$query_resumen->fetch_object());
            $query_resumen->close();
          }
        ?>
        </tbody>
      </table>
    </div>
</body>
</html>
