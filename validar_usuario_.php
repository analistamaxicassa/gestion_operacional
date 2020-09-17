<?php
	require_once('conexionesDB/conexion.php');
	require_once('logFile.php');

	$mensageErrorLogin = '';
	if (isset($_POST['usuario_administrador']))
	{
		$ccUser=$_POST['usuario_administrador'];
		$LocationError = "Location: vista_sala/index.php?mensaje=";
		$Location = "Location: vista_sala/inicio.php";
		$validarGerente = false;
	}
	elseif (isset($_POST['usuario']))
	{
		$ccUser = $_POST['usuario'];
		$claveUsuario = $_POST['claveUsuario'];
		$LocationError = "Location: gerentes/index.php?mensaje=";
		$Location = "Location: gerentes/menu_bar.php";
		$validarGerente = true;
	}
	elseif (isset($_POST['usuarioEntrevista']))
	{
		$ccUser=$_POST['usuarioEntrevista'];
		$LocationError = "Location: entrevista_retiro/index.php?mensaje=";
		$Location = "Location: entrevista_retiro/main.php";
	}

	$link_queryx_seven = Conectarse_queryx_mysql();
	$sql_user = "SELECT EMP.EMP_NOMBRE, CA.CARGO_NOMBRE, EMP.EMP_CC_CONTABLE FROM EMPLEADO EMP INNER JOIN CARGO CA ON EMP.EMP_CARGO = CA.CARGO_CODIGO
	WHERE EMP.EMP_CODIGO = '$ccUser' AND EMP.EMP_ESTADO <> 'R'";
	$query_user = $link_queryx_seven->query($sql_user);
	$datos_user = $query_user->fetch_object();

	if ($datos_user == false)
	{
		$mensageErrorLogin = '1';
		header($LocationError."".$mensageErrorLogin);
		exit();
	}
	else
	{
		if ($validarGerente) {
			$link_personal = Conectarse_personal();
			$sql="SELECT perfil, estado FROM autentica_ci WHERE cedula='$ccUser' AND password='$claveUsuario'";
			$resultado = $link_personal->query($sql);
			$userClienteInterno=$resultado->fetch_object();

			if (empty($userClienteInterno))
			{
				$mensageErrorLogin = '2';
				header("Location: gerentes/index.php?mensaje=$mensageErrorLogin");
				exit();
			}
			elseif ($userClienteInterno->estado != '1')
			{
				$mensageErrorLogin = '3';
				header("Location: gerentes/index.php?mensaje=$mensageErrorLogin");
				exit();
			}
		}

		session_start();
		$_SESSION['userID'] = $ccUser;
		$_SESSION['cargo'] = $datos_user->CARGO_NOMBRE;
		$_SESSION['nombre'] = $datos_user->EMP_NOMBRE;
		$_SESSION['centro_operacion'] = $datos_user->EMP_CC_CONTABLE;
		$_SESSION['ingreso_ID'] = session_id();
		if ($validarGerente)
		{
			$_SESSION['perfil'] = $userClienteInterno->perfil;
			$_SESSION['estado'] = $userClienteInterno->estado;
		}

		if (!(empty($_SESSION['ingreso_ID'])))
		{
			$nuevoIngreso = new LogFile();
			//echo "Se guardo el log de la sesión";
			$nuevoIngreso->insertar($_SESSION['ingreso_ID'], $_SESSION['userID'], $_POST['origen']);
		}
		header($Location);
	}
	$query_user->close();
	$link_queryx_seven->close();
?>
