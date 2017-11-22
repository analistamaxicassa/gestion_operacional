<?php
  session_start();
  require_once("logFile.php");

  if (isset($_GET['origen']))
  {
    if ($_GET['origen'] == '1')
    {
      $Location = "Location: Libreta_calificacionPDV/index.php";
    }
    elseif ($_GET['origen'] == '2')
    {
      $Location = "Location: eval_desempeno/index.php";
    }
    elseif ($_GET['origen'] == '3')
    {
      $Location = "Location: cliente_interno/index.php";
    }
    elseif ($_GET['origen'] == '4')
    {
      $Location = "Location: entrevista_retiro/index.php";
    }
  }
  if (!(empty($_SESSION['ingreso_ID'])))
	{
		$ingreso = new LogFile();
		//echo "Se guardo el log de cierre de sesión";
    $date_OUT = new DateTime("now");
    $date_OUT = $date_OUT->format('Y-m-d H:i:s');
		$ingreso->actualizar($_SESSION['ingreso_ID'], $date_OUT);
	}

  $_SESSION=array();
  if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000,
          $params["path"], $params["domain"],
          $params["secure"], $params["httponly"]
      );
  }

  session_destroy();

  header($Location);
  exit();
?>
