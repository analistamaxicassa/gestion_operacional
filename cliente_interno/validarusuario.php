<?php
	require_once('../conexionesDB/conexion.php');
	$link_personal=Conectarse_personal();

	if (isset($_POST['usuario'])) {
		$ccUser=$_POST['usuario'];
		$claveUsuario=$_POST['claveUsuario'];

		//TODO evalua si el empleado esta aun vinvualdo con la empresa

		$sql="SELECT perfil, estado FROM autentica_ci WHERE cedula='$ccUser' AND password='$claveUsuario'";
		$resultado = $link_personal->query($sql);
		$userClienteInterno=$resultado->fetch_object();

		if (empty($userClienteInterno))
		{
			$mensageErrorLogin = '1';
			header("Location: index.php?mensaje=$mensageErrorLogin");
			exit();
		}
		elseif ($userClienteInterno->estado != '1')
		{
			$mensageErrorLogin = '2';
			header("Location: index.php?mensaje=$mensageErrorLogin");
			exit();
		}
		else
		{
			$link_queryx = Conectarse_queryx();
			$sqlUser = "SELECT EMPLEADO.EMP_NOMBRE||' '||EMPLEADO.EMP_APELLIDO1||' '||EMPLEADO.EMP_APELLIDO2 AS NOMBRE, CARGO.CARGO_NOMBRE AS CARGO FROM EMPLEADO INNER JOIN CARGO ON EMPLEADO.EMP_CARGO = CARGO.CARGO_CODIGO  WHERE EMPLEADO.EMP_CEDULA = '$ccUser'";
			$stid = oci_parse($link_queryx, $sqlUser);
			oci_execute($stid);

			$usuario = oci_fetch_object($stid);

			session_start();
			$_SESSION['userID'] = $ccUser;
			$_SESSION['perfil'] = $userClienteInterno->perfil;
			$_SESSION['estado'] = $userClienteInterno->estado;
			$_SESSION['ingreso_ID'] = session_id();

			if ($usuario != false)
			{
				$_SESSION['cargo'] = $usuario->CARGO;
				$_SESSION['nombre'] = $usuario->NOMBRE;
			}

			if (!(empty($_SESSION['ingreso_ID'])))
			{
				//$nuevoIngreso = new LogFile();
				//echo "Se guardo el log de la sesión";
				//$nuevoIngreso->insertar($_SESSION['ingreso_ID'], $_SESSION['userID']);
			}
			header("Location: main.php");
			oci_free_statement($stid);
			oci_close($link_queryx);
		}
		$resultado->close();
		$link_personal->close();
	}
?>
