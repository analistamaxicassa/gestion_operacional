
<?php
  require_once('../conexionesDB/conexion.php');
  $link_personal=Conectarse_personal();
  $link_queryx = Conectarse_queryx();
  /*
  $fechaInicial = new DateTime($_POST['fechaInicial']);
  $fecha_inicial = $fechaInicial->format('d/m/y');
  $fechaFinal = new DateTime($_POST['fechaFinal']);
  $fecha_final = $fechaFinal->format('d/m/y');
  */
  $dateIni = $_POST['fechaInicial'];
  $dateFin = $_POST['fechaFinal'];

  $sqlTruncateEmp="TRUNCATE TABLE personal.empleados_retiradostmp";
  $qry_truncateEmp=$link_personal->query($sqlTruncateEmp);

  $query = "SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, PAR.PDEF_FECORTE FECHA_RETIRO, EMP.EMP_TELEFONO TELEFONO
  FROM empleado emp, TRH_PARAMETROS_DEF par WHERE EMP.EMP_CODIGO = PAR.EMP_CODIGO UNION
  SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, EMP.EMP_FECHA_RETIRO FECHA_RETIRO , EMP.EMP_TELEFONO TELEFONO
  FROM EMPLEADO EMP WHERE EMP.EMP_ESTADO = 'R' AND (EMP.EMP_FECHA_RETIRO BETWEEN '$dateIni' AND '$dateFin') and EMP.EMP_CARGO not in ('112','133') ORDER BY FECHA_RETIRO DESC";

  //echo $query."<br>";
  $stid = oci_parse($link_queryx, $query);
	oci_execute($stid);

	while ($row = oci_fetch_object($stid))
	{
		$cedular=$row->CEDULA;
		$nombreemp=$row->NOMBRE;
		$fecha_retiro=$row->FECHA_RETIRO;
		$telefono=$row->TELEFONO;

		$sqlInsertEmp="INSERT INTO personal.empleados_retiradostmp (cedula, nombre, fecha_retiro, telefono)
		VALUES ('$cedular', '$nombreemp', '$fecha_retiro', '$telefono')";
    //echo $sqlInsertEmp."<br>";
		$qry_insertEmp=$link_personal->query($sqlInsertEmp);
	}
	oci_free_statement($stid);
	oci_close($link_queryx);

	$sqlEmpleadoR="SELECT cedula, nombre, fecha_retiro, telefono FROM empleados_retiradosTMP WHERE not exists (select 1 from entrevista_retiro where entrevista_retiro.empleadoRetiradoID = empleados_retiradosTMP.cedula);";
	$qry_EmpleadoR=$link_personal->query($sqlEmpleadoR);
	$list_empleadoR=$qry_EmpleadoR->fetch_object();
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
  		<li><a href="main.php">Principal</a></li>
  		<li class="active">Seleccionar empleado</li>
  	</ol>
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Entrevista empleados retirados</h3>
            </div>
            <div class="panel-body">
              <form role="form" action="muestra_datos.php" method="post">
                <fieldset>
                  <div class="form-group">
                    <label for="empleadoRetirado">Lista de empleados retirados:</label>
                    <select name="empleadoRetirado" class="form-control" required>
                      <option value="">Seleccione un empleado</option>
<?php
                      if ($list_empleadoR == false)
                      {
                        //TODO Mostrar que no hay datos disponibles
                      }
                      else
                      {
                      do{
?>
                      <option value="<?php echo $list_empleadoR->cedula;?>">
                        <?php echo $list_empleadoR->fecha_retiro."-".$list_empleadoR->nombre; ?>
                      </option>
<?php
                        }while($list_empleadoR=$qry_EmpleadoR->fetch_object());
                      }
                      $qry_EmpleadoR->close();
                      $link_personal->close();
?>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary">Buscar <i class="glyphicon glyphicon-search"></i></button>
                </fieldset>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
