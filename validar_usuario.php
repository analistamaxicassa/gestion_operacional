<?php
	require_once('conexionesDB/conexion.php');
	require_once('logFile.php');

	$mensageErrorLogin = '';

	if (isset($_POST['usuario']))
	{
		$ccUser=$_POST['usuario'];
		$LocationError = "Location: Libreta_calificacionPDV/index.php?mensaje=";
		$Location = "Location: Libreta_calificacionPDV/comercial.php";
	}
	elseif (isset($_POST['userEval']))
	{
		$ccUser=$_POST['userEval'];
		$LocationError = "Location: eval_desempeno/index.php?mensaje=";
		$Location = "Location: eval_desempeno/main.php";
	}
	elseif (isset($_POST['usuarioEntrevista']))
	{
		$ccUser=$_POST['usuarioEntrevista'];
		$LocationError = "Location: entrevista_retiro/index.php?mensaje=";
		$Location = "Location: entrevista_retiro/main.php";
	}

	$link_queryx = Conectarse_queryx();

	$sqlUser = "SELECT EMPLEADO.EMP_NOMBRE||' '||EMPLEADO.EMP_APELLIDO1||' '||EMPLEADO.EMP_APELLIDO2 AS NOMBRE, CARGO.CARGO_NOMBRE AS CARGO FROM EMPLEADO INNER JOIN CARGO ON EMPLEADO.EMP_CARGO = CARGO.CARGO_CODIGO  WHERE EMPLEADO.EMP_CEDULA = '$ccUser'";
	$stid = oci_parse($link_queryx, $sqlUser);
	oci_execute($stid);

	$usuario = oci_fetch_object($stid);

	if ($usuario == false)
	{
		$mensageErrorLogin = '1';
		header($LocationError."".$mensageErrorLogin);
		exit();
	}
	else
	{
		session_start();
		$_SESSION['userID'] = $ccUser;
		$_SESSION['cargo'] = $usuario->CARGO;
		$_SESSION['nombre'] = $usuario->NOMBRE;
		$_SESSION['ingreso_ID'] = session_id();

		if (!(empty($_SESSION['ingreso_ID'])))
		{
			$nuevoIngreso = new LogFile();
			//echo "Se guardo el log de la sesión";
			$nuevoIngreso->insertar($_SESSION['ingreso_ID'], $_SESSION['userID'], $_POST['origen']);
		}
		header($Location);
	}

	oci_free_statement($stid);
	oci_close($link_queryx);
?>
