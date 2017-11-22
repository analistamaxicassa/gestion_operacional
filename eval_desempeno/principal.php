<?php
  require_once('../conexionesDB/conexion.php');
  session_start();
  $link_queryx = Conectarse_queryx();
  $link_personal = Conectarse_personal();
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
    $userId =$_SESSION['userID'];

		$sql = "SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_NOMBRE, EMP.EMP_NRO_VISA,
    EMP.EMP_CC_CONTABLE, CC.CENCOS_NOMBRE FROM EMPLEADO EMP, CARGO CA, CENTRO_COSTO CC WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO AND EMP.EMP_ESTADO <> 'R' AND EMP.EMP_CC_CONTABLE = CC.CENCOS_CODIGO AND EMP.EMP_CODIGO = '$userId' ORDER BY EMP.EMP_CARGO";
		$stid = oci_parse($link_queryx, $sql);
		oci_execute($stid);

		$usuario = oci_fetch_object($stid);
		$codigoCC = $usuario->EMP_CC_CONTABLE;
    $centro_costo = explode('-', $codigoCC , 3);
		//echo "pepe ".$centro_costo[0]."<br>";
    $sala = $centro_costo[1];
    //echo "pepe ".$sala."<br>";
    //echo "pepe ".$centro_costo[2]."<br>";
    $sql2 = "SELECT nombre FROM salas WHERE cc = '$sala'";
    $query_sala=$link_personal->query($sql2);
    $nombre_sala=$query_sala->fetch_object();
    if ($nombre_sala == false)
    {
      $cencos_nombre = $usuario->CENCOS_NOMBRE;
      $centro_costo = explode('-', $cencos_nombre , 3);
      $nombreSala = $centro_costo[0]." ".$centro_costo[1];
    }
    else
    {
      $nombreSala = $nombre_sala->nombre;
    }

  }

  oci_free_statement($stid);
	//oci_close($link_queryx);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Evaluación de desempeño</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>
    <h4 align="center"><?php echo "".$nombreSala; ?></h4>
    <div class="col-md-6 col-md-offset-3">
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr class="bg-primary">
            </tr>
          </thead>
          <tbody>
  <?php
    if ($sala == '099') {
      $area = $sala."-".$centro_costo[2];
      $query = "SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' 			'||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_NOMBRE, EMP.EMP_CARGO, EMP.EMP_NRO_VISA FROM EMPLEADO EMP, CARGO CA  WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO
      AND EMP.EMP_CC_CONTABLE LIKE '%$area' AND EMP.EMP_ESTADO <> 'R'
      ORDER BY EMP.EMP_CARGO";
      $stid7 = oci_parse($link_queryx, $query);
      oci_execute($stid7);
      $row_n = oci_fetch_object($stid7);
      $cedula=$row_n->CEDULA;
      $nombre=$row_n->NOMBRE;
      $cargo=$row_n->CARGO_NOMBRE;
      $lugar = $row_n->EMP_NRO_VISA;
    }
    else
    {
      $query = "SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_NOMBRE, EMP.EMP_CARGO
      FROM EMPLEADO EMP, CARGO CA WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO AND (EMP.EMP_CC_CONTABLE LIKE '10-$sala-%'
      OR EMP.EMP_CC_CONTABLE LIKE '70-$sala-%') AND EMP.EMP_ESTADO <> 'R' ORDER BY EMP.EMP_CARGO";
      $stid7 = oci_parse($link_queryx, $query);
      oci_execute($stid7);
      $row_n = oci_fetch_object($stid7);
      $cedula=$row_n->CEDULA;
      //echo $query."<br>";
      $nombre=$row_n->NOMBRE;
      $cargo=$row_n->CARGO_NOMBRE;
      $lugar = $sala;
    }
    /*
  	$findme   = 'T';
  	$pos = strpos($sala, $findme);

  	if ($pos === false)
  	{
  			$findme   = 'P';
  			$pos = strpos($sala, $findme);

  			if ($pos === false)
  			{
  					$findme   = 'I';
  					$pos = strpos($sala, $findme);

  					if ($pos === false)
  					{
              $query = "SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_NOMBRE, EMP.EMP_CARGO
              FROM EMPLEADO EMP, CARGO CA WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO AND (EMP.EMP_CC_CONTABLE LIKE '10-$sala-%'
              OR EMP.EMP_CC_CONTABLE LIKE '70-$sala-%') AND EMP.EMP_ESTADO <> 'R' ORDER BY EMP.EMP_CARGO";
              $stid7 = oci_parse($link_queryx, $query);
              oci_execute($stid7);
              $row_n = oci_fetch_object($stid7);
              $cedula=$row_n->CEDULA;
              //echo "<br>".$cedula;
              echo $query."<br>";
          		$nombre=$row_n->NOMBRE;
          		$cargo=$row_n->CARGO_NOMBRE;
						}
  					else
  					{
    					$sala = substr($sala, -3);

    					$query = "SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' 			'||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_NOMBRE, EMP.EMP_CARGO FROM EMPLEADO EMP, CARGO CA  WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO
    		      AND EMP.EMP_CC_CONTABLE LIKE '40-%' AND EMP.EMP_ESTADO <> 'R' ORDER BY EMP.EMP_CARGO";
              echo $query."<br>";
              $stid7 = oci_parse($link_queryx, $query);
              oci_execute($stid7);
              $row_n = oci_fetch_object($stid7);
              $cedula=$row_n->CEDULA;
              $nombre=$row_n->NOMBRE;
              $cargo=$row_n->CARGO_NOMBRE;
  					}
  			}
  			else
  			{
    			$sala = substr($sala, -3);
    			$otro = $rs_qry->ci_print;

  		    $query = "SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' 			'||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_NOMBRE, EMP.EMP_CARGO FROM EMPLEADO EMP, CARGO CA  WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO
          AND EMP.EMP_CC_CONTABLE LIKE '$otro%' AND EMP.EMP_ESTADO <> 'R'
          ORDER BY EMP.EMP_CARGO";
          $stid7 = oci_parse($link_queryx, $query);
          oci_execute($stid7);
          $row_n = oci_fetch_object($stid7);
          $cedula=$row_n->CEDULA;
          $nombre=$row_n->NOMBRE;
          $cargo=$row_n->CARGO_NOMBRE;
  			}
  	}
  	else
  	{
  	  $sala = substr($sala, -3);
      $query = "SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_NOMBRE, EMP.EMP_CARGO
      FROM EMPLEADO EMP, CARGO CA WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO
      AND EMP.EMP_CC_CONTABLE LIKE '20-$sala-%' AND EMP.EMP_ESTADO <> 'R' ORDER BY EMP.EMP_CARGO";
      $stid7 = oci_parse($link_queryx, $query);
      oci_execute($stid7);
      $row_n = oci_fetch_object($stid7);
      $cedula=$row_n->CEDULA;
      $nombre=$row_n->NOMBRE;
      $cargo=$row_n->CARGO_NOMBRE;
  	}
    */
  do{
  ?>
            <tr>
              <td><?php echo $row_n->CARGO_NOMBRE; ?></td>
              <td><a href="muestra_datos.php?cedula=<?php echo $row_n->CEDULA;?>&sala=<?php echo $sala;?>"> <?php echo $row_n->NOMBRE; ?></a></td>
              <td><?php echo $row_n->EMP_CARGO; ?></td>
              <td><?php echo ""; ?></td>
            </tr>
  <?php
    }while(($row_n = oci_fetch_object($stid7)) != false);
    oci_free_statement($stid7);
  ?>
          </tbody>
        </table>
      </div>
    </div>
  </body>
</html>
