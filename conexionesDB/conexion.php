<?php
  function Conectarse_crm() {
    if (!($link = new mysqli('localhost', 'root', 'KcZnMxCUXWmmpBLS'))) {
      echo "Error conectando al servidor de base de datos.";
      exit();
    }
    if (!($link->select_db('crm'))) {
      echo "Error seleccionando la base de datos.";
      exit();
    }
      return $link;
  }

  function Conectarse_cauth() {
    if (!($link_cauth = new mysqli('localhost', 'root', 'KcZnMxCUXWmmpBLS'))) {
      echo "Error conectando al servidor de base de datos.";
      exit();
    }
    if (!($link_cauth->select_db('cauth'))) {
      echo "Error seleccionando la base de datos.";
      exit();
    }
      return $link_cauth;
  }

  function Conectarse_libreta() {
    if (!($link_caronte = new mysqli('10.1.0.48', 'IT008', 'KcZnMxCUXWmmpBLS'))) {
      echo "Error conectando al servidor de base de datos.";
      exit();
    }
    if (!$link_caronte->set_charset("utf8")) {
    printf("Error cargando el conjunto de caracteres utf8: %s\n", $link_caronte->error);
    exit();
    }
    if (!($link_caronte->select_db('libreta'))) {
      echo "Error seleccionando la base de datos.";
      exit();
    }
      return $link_caronte;
  }

  function Conectarse_caronte() {
    if (!($link_caronte = new mysqli('localhost', 'root', 'KcZnMxCUXWmmpBLS'))) {
      echo "Error conectando al servidor de base de datos.";
      exit();
    }
    if (!$link_caronte->set_charset("utf8")) {
    printf("Error cargando el conjunto de caracteres utf8: %s\n", $link_caronte->error);
    exit();
    }
    if (!($link_caronte->select_db('caronte_bd'))) {
      echo "Error seleccionando la base de datos.";
      exit();
    }
      return $link_caronte;
  }

 function Conectarse_act_man() {
    if (!($link_act = new mysqli('localhost', 'root', 'KcZnMxCUXWmmpBLS'))) {
      echo "Error conectando al servidor de base de datos.";
      exit();
    }
    if (!$link_act->set_charset("utf8")) {
    printf("Error cargando el conjunto de caracteres utf8: %s\n", $link_act->error);
    exit();
    }
    if (!($link_act->select_db('act_man2'))) {
      echo "Error seleccionando la base de datos.";
      exit();
    }
    return $link_act;
  }

  function Conectarse_personal()
  {
    if (!($link_ares = new mysqli('10.1.0.48', 'IT008', 'KcZnMxCUXWmmpBLS'))) {
      echo "Error conectando al servidor de base de datos.";
      exit();
    }
    if (!$link_ares->set_charset("utf8")) {
    printf("Error cargando el conjunto de caracteres utf8: %s\n", $link_ares->error);
    exit();
    }
    if (!($link_ares->select_db('personal'))) {
      echo "Error seleccionando la base de datos.";
      exit();
    }
    return $link_ares;
  }


  function Conectarse_ares2()
  {
    if (!($link_ares = new mysqli('10.1.0.22', 'IT008', 'KcZnMxCUXWmmpBLS'))) {
      echo "Error conectando al servidor de base de datos.";
      exit();
    }
    if (!($link_ares->select_db('ares2'))) {
      echo "Error seleccionando la base de datos.";
      exit();
    }
    return $link_ares;
  }

  function Conectarse_siesa()
  {
    $dsn = "Driver={SQL Server};Server=10.1.0.28;Database=UnoEE;Integrated Security=SSPI;Persist Security Info=False;";
    $link_siesa = odbc_connect( $dsn, 'sa', '.53rg1m4r3C.' );
    if (!$link_siesa)
    {
    	exit( "Error al conectar: " . $link_siesa);
    }
    return $link_siesa;
  }

  function Conectarse_queryx()
  {
    $link_queryx = oci_connect('SRHADMIN', 'SRHADMIN', '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.1.0.197)(PORT = 1521)) (CONNECT_DATA = (SERVICE_NAME = SRHQ7)))');
    if (!$link_queryx) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    return $link_queryx;
  }
?>
