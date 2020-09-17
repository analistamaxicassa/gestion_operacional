<?php
	require_once('conexionesDB/conexion.php');
	require_once('logFile.php');

	$mensageErrorLogin = '';
	if (isset($_POST['usuario_administrador']))
	{
		$ccUser = $_POST['usuario_administrador'];
		$claveUsuario = $_POST['claveUsuario'];
		$LocationError = "Location: vista_sala/index.php?mensaje=";
		// $Location = "Location: vista_sala/inicio.php";
		$Location = "Location: vista_sala/menu_admin.php";
		$validarGerente = false;
		$validar_admin = true;
	}
	elseif (isset($_POST['usuario']))
	{
		$ccUser = $_POST['usuario'];
		$claveUsuario = $_POST['claveUsuario'];
		$LocationError = "Location: gerentes/index.php?mensaje=";
		$Location = "Location: gerentes/menu_bar.php";
		$validarGerente = true;
		$validar_admin = false;
	}
	// elseif (isset($_POST['usuarioEntrevista']))
	// {
	// 	$ccUser = $_POST['usuarioEntrevista'];
	// 	$LocationError = "Location: entrevista_retiro/index.php?mensaje=";
	// 	$Location = "Location: entrevista_retiro/main.php";
	// }
	$captcha = ($_POST['g-recaptcha-response']);
	$secret = '6LcJuqMUAAAAAMCYhxqZrONR9hgrbuVrECfZNWFs';
	$origen= 'Auditoria Operacional';

	$link_queryx_seven = Conectarse_queryx_mysql();
	$link_personal = Conectarse_personal();


	$sql_user = "SELECT EMP.EMP_NOMBRE, CA.CARGO_CODIGO,CA.CARGO_NOMBRE, EMP.EMP_CC_CONTABLE, EMP.EMP_SOCIEDAD,SO.sociedad_ID
							FROM EMPLEADO EMP INNER JOIN CARGO CA ON EMP.EMP_CARGO = CA.CARGO_CODIGO
							INNER JOIN SOCIEDAD SO ON EMP.EMP_SOCIEDAD= SO.COD_SOCIEDAD
							WHERE EMP.EMP_CODIGO = '$ccUser' AND EMP.EMP_ESTADO <> 'R'";
	$query_user = $link_queryx_seven->query($sql_user);
	if ($query_user == false)
	{
		$mensageErrorLogin = '1';
		header($LocationError."".$mensageErrorLogin);
		exit();
	}
	else
	{
		$datos_user = $query_user->fetch_object();
		if (empty($datos_user)) {
			$mensageErrorLogin = '1';
			header($LocationError."".$mensageErrorLogin);
			exit();
		}

		if (!$captcha){
				$mensageErrorLogin = '6';
				header($LocationError.$mensageErrorLogin);
				exit();
				}

				$response= file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");
	      $arr= json_decode($response,TRUE);
	      if($arr['success'])
	      {

			if ($validarGerente) {

				$sql_acceso = "SELECT password FROM control_acceso WHERE usuario_ID = '$ccUser'";
				$query_acceso = $link_queryx_seven->query($sql_acceso);
				$resultado_control = $query_acceso->fetch_object();

				if (empty($resultado_control)) {
					$mensageErrorLogin = '5';
					header($LocationError.$mensageErrorLogin);
					exit();
				}else {
					$contraseña = $resultado_control->password;

					if (password_verify($claveUsuario,$contraseña)) {


						// $sql="SELECT perfil, estado FROM autentica_ci WHERE cedula='$ccUser' AND password='$claveUsuario'";
						$sql = "SELECT perfil, estado FROM autentica_ci WHERE cedula='$ccUser'";
						$resultado = $link_personal->query($sql);
						$userClienteInterno = $resultado->fetch_object();

						if (empty($userClienteInterno))
						{
							$mensageErrorLogin = '2';
							header($LocationError.$mensageErrorLogin);
							exit();
						}
						elseif ($userClienteInterno->estado != '1')
						{
							$mensageErrorLogin = '3';
							header($LocationError.$mensageErrorLogin);
							exit();
						}

					}else {
						$mensageErrorLogin = '4';
						header($LocationError.$mensageErrorLogin);
						exit();
					}
				}

				session_start();
				$_SESSION['cod_sociedad'] = $datos_user->sociedad_ID;
				$_SESSION['userID'] = $ccUser;
				$_SESSION['cod_cargo'] = $datos_user->CARGO_CODIGO;
				$_SESSION['cargo'] = $datos_user->CARGO_NOMBRE;
				$_SESSION['nombre'] = $datos_user->EMP_NOMBRE;
				$_SESSION['centro_costo'] = $datos_user->EMP_CC_CONTABLE;
				if (isset($_POST['radioSala'])) {
					$_SESSION['centro_operacion'] = $_POST['select_sala'];
				} else {
					$_SESSION['centro_operacion'] = $datos_user->EMP_CC_CONTABLE;
				}

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
					$nuevoIngreso->insertar($_SESSION['ingreso_ID'], $_SESSION['userID'], $origen);
				}
				header($Location);

		}elseif($validar_admin) {

			$cod_cargo = $datos_user->CARGO_CODIGO;
			if ($cod_cargo == '101' OR $cod_cargo == '118' ) {

				$sql_acceso = "SELECT password FROM control_acceso WHERE usuario_ID = '$ccUser'";
				$query_acceso = $link_queryx_seven->query($sql_acceso);
				$resultado_control = $query_acceso->fetch_object();

				if (empty($resultado_control)) {
					$mensageErrorLogin = '5';
					header($LocationError.$mensageErrorLogin);
					exit();

				}else {
					$contraseña = $resultado_control->password;

					if (password_verify($claveUsuario,$contraseña)) {

						session_start();
						$_SESSION['cod_sociedad'] = $datos_user->sociedad_ID;
						$_SESSION['userID'] = $ccUser;
						$_SESSION['cod_cargo'] = $cod_cargo;
						$_SESSION['cargo'] = $datos_user->CARGO_NOMBRE;
						$_SESSION['nombre'] = $datos_user->EMP_NOMBRE;
						// $_SESSION['centro_operacion'] = $datos_user->EMP_CC_CONTABLE;
						if (isset($_POST['radioSala'])) {
							$_SESSION['centro_operacion'] = $_POST['select_sala'];
						} else {
							$_SESSION['centro_operacion'] = $datos_user->EMP_CC_CONTABLE;
						}

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
							$nuevoIngreso->insertar($_SESSION['ingreso_ID'], $_SESSION['userID'], $origen);
						}
						header($Location);

					}else {
						$mensageErrorLogin = '4';
						header($LocationError.$mensageErrorLogin);
						exit();
					}
				}


			}else {

					$mensageErrorLogin = '2';
					header($LocationError.$mensageErrorLogin);
					exit();
			}
		}

	}else {
		$mensageErrorLogin = '7';
		header($LocationError.$mensageErrorLogin);
		exit();
	}
}
	$query_user->close();
	$link_queryx_seven->close();
?>
