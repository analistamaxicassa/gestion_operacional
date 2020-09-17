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
    if (isset($_POST['sala']))
    {
      $sala = $_POST['sala'];
    }
    elseif (isset($_GET['sala']))
    {
      $sala = $_GET['sala'];
    }
    $userID= $_SESSION['userID'];

    $link_queryx = Conectarse_queryx();
    $link_personal=Conectarse_personal();
    $link_siesa = Conectarse_siesa();
	}

  $sqltipo="SELECT nombre, tipo_sala, presupuesto, area_exh, area_bod, jefeoperacion FROM salas where cc = '$sala' and activo = '1'";
	$qry_sqltipo=$link_personal->query($sqltipo);
	$rs_qrytipo=$qry_sqltipo->fetch_object();  ///consultar

  $tiposala = $rs_qrytipo->tipo_sala;
  $area_exh = $rs_qrytipo->area_exh;
  $area_bod = $rs_qrytipo->area_bod;
  $nombresala = $rs_qrytipo->nombre;

  $qry_sqltipo->close();

  $sqlpre="SELECT `id` FROM `acceso_cixsala` WHERE `sala` = '$sala' and cedula = '$userID' ";
	$qry_sqlpre=$link_personal->query($sqlpre);
	$rs_qrypre=$qry_sqlpre->fetch_object();  ///consultar

	if (false) {
    echo 'Esta sala no esta habilitada para su consulta';
	exit();
	}
	else {
		$sql20="DELETE FROM `personal`.`venta_sala`";
		$qry_sql20=$link_personal->query($sql20);

  //consulta de ventas de sala
  $fini=date("Ym")."01";
  $ffin=date("Ymd");
  if ($fini == $ffin)
  {
    $ventaSala = 0;
  }
  else
  {
    //consulta en siesa de Ventas
    $ventaSala = 0;
    $q1=odbc_exec($link_siesa,"exec sp_pv_cons_fact_notas 4,'$sala ','FVS','',1,0,0,0,0,'$fini','$ffin',7,0,0,0,2,0,0,10095,'006CV - NO. DE FACTURAS POR C.O',1024,0,1,NULL,NULL,NULL,NULL,NULL,NULL");
    while ($rs1=odbc_fetch_array($q1))
    {
      $siesacc=$rs1['f_co'];
      $siesanumero=$rs1['f_nrodocto'];
      $siesavalor=$rs1['f_valor_subtotal'];

      $ventaSala = $siesavalor + $ventaSala;
      $ins="INSERT INTO `personal`.`venta_sala` (`id`, `cc`, `numero`, `subtotal`) VALUES (NULL, '$siesacc', '$siesanumero', '$siesavalor');";
      //$qry=$link->query($ins);
    }
    odbc_free_result($q1);
    odbc_close($link_siesa);
  }
///aqui**************
$sql="SELECT  tipo_sala, presupuesto, jefeoperacion, localidad, ci_print FROM salas where cc = '$sala' and activo = '1'";
			$qry_sql=$link_personal->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar

	if (empty($rs_qry)) {
    echo 'Esta sala no esta habilitada';
	  exit();
	}
	else
  {
  	$tiposala = $rs_qry->tipo_sala;
  	$presupuesto = $rs_qry->presupuesto;
  	$jefeoperacion = $rs_qry->jefeoperacion;
  	$localidad = $rs_qry->localidad;
	}
////consulta de concepto de sala
  $sql2="SELECT id, fecha, avg(calificacion) concepto, autor FROM `concepto_sala` WHERE cc = '$sala' group by fecha order by id DESC LIMIT 1 ";
		$qry_sql2=$link_personal->query($sql2);
		$rs_qry2=$qry_sql2->fetch_object();  ///consultar

	if (empty($rs_qry2)) {
    $fecha = "La sala no ha sido evaluada.";
		$concepto = "0";
		$autor = "";
	}
	else
  {
		$fecha = $rs_qry2->fecha;
		$concepto = $rs_qry2->concepto;
		$autor =  ($rs_qry2->autor);
	}

// cantidad de empleados
  $query1a = "SELECT count(EMP.EMP_CODIGO) CANTIDAD FROM EMPLEADO EMP
  WHERE (EMP.EMP_CC_CONTABLE LIKE '10-$sala-%' OR EMP.EMP_CC_CONTABLE LIKE '70-$sala-%') AND EMP.EMP_ESTADO <> 'R'";
  $stid = oci_parse($link_queryx, $query1a);
  oci_execute($stid);
  $row_n1a = oci_fetch_object($stid);

// cantidad de asesores
  $query1c = "SELECT count (EMP.EMP_CARGO) CANTIDADASESORES FROM EMPLEADO EMP, cargo ca WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO and
  (EMP.EMP_CC_CONTABLE LIKE '10-$sala-%' OR EMP.EMP_CC_CONTABLE LIKE '70-$sala-%') AND EMP.EMP_ESTADO <> 'R' and EMP.EMP_CARGO in ('113','114','115')";
  $stid2 = oci_parse($link_queryx, $query1c);
  oci_execute($stid2);
  $row_n1c = oci_fetch_object($stid2);
	$cantasesores = $row_n1c->CANTIDADASESORES;

// cantidad de empleados en capacitacion
/*
  $query1d = "SELECT count (EMP.EMP_CODIGO) CANTIDADCAPACI FROM EMPLEADO EMP
  WHERE (EMP.EMP_CC_CONTABLE LIKE '10-099-%' OR EMP.EMP_CC_CONTABLE LIKE '70-099-%') and EMP.EMP_NRO_CONTRATO = '$sala' and EMP.EMP_ESTADO <> 'R'";
  $stid3 = oci_parse($link_queryx, $query1d);
  oci_execute($stid3);
  $row_n1d = oci_fetch_object($stid3);
	//$row_n1d->CANTIDADCAPACI;

// cantidad de empleados en capacitacion detallando cargo
  $query1e = " SELECT count (EMP.EMP_CODIGO) CANTIDADCAPACI, EMP.EMP_CARGO CODCARGO FROM EMPLEADO EMP
  WHERE (EMP.EMP_CC_CONTABLE LIKE '10-099-%' OR EMP.EMP_CC_CONTABLE LIKE '70-099-%') and EMP.EMP_NRO_CONTRATO = '$sala' and EMP.EMP_ESTADO <> 'R'  group by  EMP.EMP_CARGO";
  echo $query1e."<br>";
  $stid4 = oci_parse($link_queryx, $query1e);
  oci_execute($stid4);
  $row_n1e = oci_fetch_object($stid4);
	//$row_n1e->CANTIDADCAPACI;
  //$row_n1e->CODCARGO;
  */
	$cantidadtotal = $row_n1a->CANTIDAD;//+ $row_n1e->CANTIDADCAPACI;

 //MUESTRA LOS EMPLEADOS EN CAPACITACION
 /*
	$queryc = "SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_CODIGO CODCARGO,  CA.CARGO_NOMBRE
  FROM EMPLEADO EMP, CARGO CA, CENTRO_COSTO CC WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO AND EMP.EMP_CC_CONTABLE = CC.CENCOS_CODIGO
  and EMP.EMP_NRO_CONTRATO = '$sala' AND CC.CENCOS_NOMBRE NOT LIKE '%ROTATIVO%' AND EMP.EMP_ESTADO <> 'R' ORDER BY EMP.EMP_CARGO";
  $stid5 = oci_parse($link_queryx, $queryc);
  oci_execute($stid5);
  $row_c = oci_fetch_object($stid5);
  //$row_c->CEDULA;
  //$row_c->NOMBRE;
  //$row_c->CODCARGO;
  //$row_c->CARGO_NOMBRE;

  if ($row_c->CODCARGO == '113' || $row_c->CODCARGO == '114' || $row_c->CODCARGO == '115' )
	{
		$cantasesores = $cantasesores + $row_n1e->CANTIDADCAPACI;
	}*/
  //cierre del else para salasque no son de max ni cera
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
    <ol class="breadcrumb" hidden="true">
      <li class="active">Informe sala</li>
      <li><a href="actualizar_dsalas.php?sala=<?php echo $sala;?>">Modificar sala</a></li>
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
          $sql_resumen="SELECT fecha, concepto_esp, calificacion, hallazgo, tarea, responsable, fecha_control, ESTADO
          FROM concepto_sala WHERE cc='$sala' ORDER BY fecha DESC LIMIT 5";
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
                    <td><?php echo  ($resumen->concepto_esp); ?></td>
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
    <br>
    <div class="table-responsive col-md-12">
      <table class="table table-bordered">
        <thead>
          <tr class="bg-primary">
            <th>CO</th>
            <th>Sala</th>
            <th>Tipo</th>
            <th>Jefe de operación</th>
            <th>Presupuesto</th>
            <th>Ventas mes</th>
            <th>Área de exhibición</th>
            <th>Área de bodega</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo $sala;?></td>
            <td><?php echo $nombresala; ?></td>
            <td><?php echo $tiposala; ?></td>
            <td><?php echo $jefeoperacion; ?></td>
            <td><?php echo "$".number_format($presupuesto, 0, ",", "."); ?></td>
            <td><?php echo "$".number_format($ventaSala, 0, ",", "."); ?></td>
            <td><?php echo $area_exh." M²"; ?></td>
            <td><?php echo $area_bod." M²"; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  <br>
  <div class="col-md-8 col-md-offset-2">
    <div class="btn-group btn-group-justified btn-group-lg my-btn-group-responsive">
      <!--<a type="button" class="btn btn-primary" href="informe_seguimiento.php?sala=<?php //echo $sala; ?>" disabled>Seguimiento de tareas</a>-->
      <a type="button" class="btn btn-primary" href="#" disabled>Seguimiento de tareas</a>
      <a type="button" class="btn btn-primary" href="informe_hist_sala2.php?sala=<?php echo $sala; ?>">Reportes sala</a>
      <a type="button" class="btn btn-primary" href="#" disabled>Libreta de calificaciones</a>
    </div>
  </div>
  <br>
  <div class="col-md-6 col-md-offset-3">
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr class="bg-primary">
          </tr>
        </thead>
        <tbody>
<?php
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
  					$query = "SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_NOMBRE
            FROM EMPLEADO EMP, CARGO CA WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO AND (EMP.EMP_CC_CONTABLE LIKE '10-$sala-%'
            OR EMP.EMP_CC_CONTABLE LIKE '70-$sala-%') AND EMP.EMP_ESTADO <> 'R' ORDER BY EMP.EMP_CARGO";
            $stid7 = oci_parse($link_queryx, $query);
            oci_execute($stid7);
            $row_n = oci_fetch_object($stid7);
            $cedula=$row_n->CEDULA;
            //echo "<br>".$cedula;
            //echo "<br>".$query;
        		$nombre=$row_n->NOMBRE;
        		$cargo=$row_n->CARGO_NOMBRE;
						}
					else
					{
  					$sala = substr($sala, -3);

  					$query = "SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' 			'||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_NOMBRE FROM EMPLEADO EMP, CARGO CA  WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO
  		      AND EMP.EMP_CC_CONTABLE LIKE '40-%' AND EMP.EMP_ESTADO <> 'R' ORDER BY EMP.EMP_CARGO";
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

		    $query = "SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' 			'||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_NOMBRE FROM EMPLEADO EMP, CARGO CA  WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO
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
    $query = "SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_NOMBRE
    FROM EMPLEADO EMP, CARGO CA WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO
    AND EMP.EMP_CC_CONTABLE LIKE '20-$sala-%' AND EMP.EMP_ESTADO <> 'R' ORDER BY EMP.EMP_CARGO";
    $stid7 = oci_parse($link_queryx, $query);
    oci_execute($stid7);
    $row_n = oci_fetch_object($stid7);
    $cedula=$row_n->CEDULA;
    $nombre=$row_n->NOMBRE;
    $cargo=$row_n->CARGO_NOMBRE;
	}

do{
?>
          <tr>
            <td><?php echo $row_n->CARGO_NOMBRE; ?></td>
            <!--<td><a href="../cliente_interno/informe_cliente_interno2.php?cedula=<?php //echo $row_n->CEDULA;?>&sala=<?php //echo $sala;?>"> <?php //echo $row_n->NOMBRE; ?></a></td>-->
            <td><a href="#"> <?php echo $row_n->NOMBRE; ?></a></td>
          </tr>
<?php
  }while(($row_n = oci_fetch_object($stid7)) != false);
  oci_free_statement($stid7);
?>
        </tbody>
      </table>
    </div>
  </div>
<br>
<table border="0" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="60%" align="center" hidden="true">
  <tr>
    <td class="header" colspan="4" align="left" valign="middle"><strong>EN ENTRENAMIENTO FUNCIONAL</strong></td>
    <td width="260" class="header" colspan="6" align="justify" valign="middle">&nbsp;</td>
  </tr>
  <tr>
<?php
//do{
?>
  </tr>
  <tr>
    <td class="header" colspan="4" align="left" valign="middle"><?php //echo  ($row_c->CARGO_NOMBRE); ?></td>
    <td width="111"><a href="../cliente_interno/informe_cliente_interno2.php?cedula=<?php //echo  ($row_c->CEDULA);?>&sala=<?php echo  ($sala);?>"> <?php //echo  ($row_c->NOMBRE); ?></a></td>
  </tr>
<?php
  //}while(($row_c = oci_fetch_object($stid5)) != false);
?>
  <tr>
    <td width="50">&nbsp;</td>
  </tr>
</table>

<table border="0" style="border-collapse:collapse; border:#69F solid 1px; font-family:Verdana, Geneva, sans-serif; font-size:10px " width="60%" align="center" hidden="true">
  <tr>
    <td class="header" colspan="4" align="left" valign="middle"><strong>ROTATIVOS</strong></td>
    <td width="260" class="header" colspan="6" align="justify" valign="middle">&nbsp;</td>
  </tr>
  <tr>
<?php

//do{

  $queryr = "SELECT EMP.EMP_CODIGO CEDULA, EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, CA.CARGO_NOMBRE, LO.COD_LOCALIDAD
  FROM EMPLEADO EMP, CARGO CA, CENTRO_COSTO CC, LOCALIDAD LO
  WHERE EMP.EMP_CARGO = CA.CARGO_CODIGO AND EMP.EMP_CC_CONTABLE = CC.CENCOS_CODIGO AND EMP.EMP_LOCALIDAD = LO.COD_LOCALIDAD
  AND CC.CENCOS_NOMBRE LIKE '%ROTATIVO%'  AND EMP.EMP_ESTADO <> 'R' ORDER BY LO.NOMBRE_LOCALIDAD, EMP.EMP_CARGO";
  $stid8 = oci_parse($link_queryx, $queryr);
  oci_execute($stid8);
  $row_r = oci_fetch_object($stid8);
  $cedula=$row_r->CEDULA;
  $nombre=$row_r->NOMBRE;
  $cargo=$row_r->CARGO_NOMBRE;
  $cod_localidad=$row_r->COD_LOCALIDAD;

	do{
      if ($localidad == $cod_localidad)
  	  {
?>
  </tr>
  <tr>
    <td class="header" colspan="4" align="left" valign="middle"><?php echo  ($row_r->CARGO_NOMBRE); ?></td>
    <td width="111"><a href="../cliente_interno - Copia [2]/informe_cliente_interno2.php?cedula=<?php echo  ($row_r->CEDULA);?>&sala=<?php echo  ($sala);?>"> <?php echo  ($row_r->NOMBRE); ?></a></td>
  </tr>
<?php
      }
    }while(($row_r = oci_fetch_object($stid8)) != false);
    oci_free_statement($stid8);
  }
  oci_close($link_queryx);
?>
  <tr>
    <td width="50">&nbsp;</td>
  </tr>
</table>
    <footer></footer>
</body>
</html>
