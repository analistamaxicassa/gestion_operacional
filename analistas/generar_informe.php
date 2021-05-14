<?php

ini_set('max_execution_time',60);
require_once('../conexionesDB/conexion.php');
require "../vendor/autoload.php";
setlocale(LC_ALL,"es_ES");
session_start();

$link_personal = Conectarse_personal();
$link_queryx_seven = Conectarse_queryx_mysql();
$link_caronte = Conectarse_caronte();

if (isset($_POST['cod_seguimiento']) && !empty($_POST['cod_seguimiento'])) {

  $cod_seguimiento = $_POST['cod_seguimiento'];
  $html = "";

  $sql_centro_costo ="SELECT  gs.codigo_gestion,gs.cod_seguimiento, gs.centro_costo,sa.sala_nombre,gs.fecha, gs.fecha_inspeccion, gs.cod_variable, gs.cod_concepto
										   FROM gestion_salas gs INNER JOIN queryx_seven.salas sa ON gs.centro_costo=sa.centro_costo
										   AND gs.sociedad_ID=sa.sociedad_ID INNER JOIN variables_conceptos vc ON gs.cod_concepto=vc.cod_concepto
										   INNER JOIN  parametros par ON gs.cod_variable= par.id_parametro
										   WHERE gs.cod_seguimiento='$cod_seguimiento' ORDER BY gs.fecha DESC";
  $query_sala = $link_personal->query($sql_centro_costo);
  $resul_sala = $query_sala->fetch_object();
  if (!empty($resul_sala)) {


      $nombre_sala = $resul_sala->sala_nombre;
      $fecha_inspeccion = $resul_sala->fecha_inspeccion;



      $sql_consulta = "SELECT  gs.codigo_gestion,gs.cod_seguimiento, gs.centro_costo,sa.sala_nombre,gs.fecha, gs.cod_variable,par.Descripcion, gs.cod_concepto,vc.descripcion_con,gs.hallazgo,gs.acciones
    										   FROM gestion_salas gs INNER JOIN queryx_seven.salas sa ON gs.centro_costo=sa.centro_costo
    										   AND gs.sociedad_ID=sa.sociedad_ID INNER JOIN variables_conceptos vc ON gs.cod_concepto=vc.cod_concepto
    										   INNER JOIN  parametros par ON gs.cod_variable= par.id_parametro
    										   WHERE gs.cod_seguimiento='$cod_seguimiento' ORDER BY gs.fecha DESC";
      $query_consulta = $link_personal->query($sql_consulta);
      $resul_consulta = $query_consulta->fetch_object();



      $fechaexamen = date("d/m/Y");
      $dia = date("d");
      $mes = date("m");
      $nombremes = "";
      // $html = "";
      $arraymeses = array("01"=>"Enero","02"=>"Febrero","03"=>"Marzo","04"=>"Abril","05"=>"Mayo","06"=>"Junio","08"=>"Julio","08"=>"Agosto","09"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre");
      foreach ($arraymeses as $numeromes=>$nombre_mes) {
        if ($mes == $numeromes) {
          $nombremes = $nombre_mes;
        }
      }
      $año = date("Y");
      $fecha_carta = "Bogotá D.C. ".$dia." del ".$nombremes." de ".$año."<br><br><br>";

      $fecha_ins = date("d/m/Y",strtotime($fecha_inspeccion));
      $dia_inspeccion = date("d",strtotime($fecha_inspeccion));
      $mes_inspeccion = date("m",strtotime($fecha_inspeccion));
      $nombremes_inspeccion = "";
      $arraymeses_inspeccion = array("01"=>"Enero","02"=>"Febrero","03"=>"Marzo","04"=>"Abril","05"=>"Mayo","06"=>"Junio","08"=>"Julio","08"=>"Agosto","09"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre");
      foreach ($arraymeses_inspeccion as $numeromes=>$nombre_mes) {
        if ($mes_inspeccion == $numeromes) {
          $nombremes_inspeccion = $nombre_mes;
        }
      }
      $año_inspeccion = date("Y",strtotime($fecha_inspeccion));
      $fecha_revision = $dia_inspeccion." del ".$nombremes_inspeccion." de ".$año_inspeccion."<br><br><br>";



      $html ='
      <style>

      .center {
          margin: 10px auto;
          display:block;

      }

      body{
        font-size : 14px;
        font-family: Arial;

      }
      .fondo,th {
       border: 1px solid black;
      }
      td{
       border:1px;
       border-style: ridge;
      }
      table{
       font-size:12px;
       font-family: : Arial,Helvetica,sans-serif;
      }
      tr,td{
       text-align:center;
      }
      .fondo_azul{
       background-color:#90D3E7;
      }
      .header {
       border-style: none;
       border:hidden;
      }
      div.a{
        text-align:justify;
      }
      </style>';

      $mpdf = new Mpdf\mpdf(['mode' => 'utf-8', 'format' =>[216, 279],'margin_top'=>50,'margin_bottom'=>50]);
      $mpdf->SetTitle('Informe_Gestion_operacional');
      $mpdf->SetHTMLHeader('<img name="imagen" style="width:1500px;height:1500px;" src="..\img\maxicassa1.png">','O');

      $mpdf->SetHTMLFooter('
      <table class="tabla_sin_fondo" width="100%">
      <tr>
        <td width="30%" style="font-size:10px;font-family: Arial,Helvetica,sans-serif;">Generado: {DATE d-m-Y h:i a}</td>
        <td width="20%" style="text-align:center;font-size:10px;">Página: {PAGENO} de {nbpg}</td>
        <td width="50%" style="text-align:center;font-size:10px;font-family: Arial,Helvetica,sans-serif;">Copyright ©2019 Todos los derechos reservados | UAC - TI </td>
      </tr>
      </table>');


      $html .='<body>';
      $html .= '<div classs="center" style="text-align:center"><strong>INFORME DE LIBRETA OPERACIONAL</strong></div><br><br><br>';
      $html .=  $fecha_carta;
      $html .= '<strong>PUNTO DE VENTA: '.$nombre_sala.'</strong><br><br>';
      $html .= 'A continuación, se presenta el informe de operaciones comerciales, sobre aquellas situaciones que se observaron en visita realizada el día '.$fecha_revision.'';
      $html .=' Importante tener en cuentas las sugerencias, ya que ayudaran en la operación y en el cumplimiento de las políticas y directrices de la compañía.';
      $html .= '<br>Fundamental enviar la evidencia de la corrección de aquellos incumplimientos detectados por WhatsApp o Email corporativo dentro del plazo estipulado.';
      $html .= '<br>Recuerde que todos aquellos requerimientos deben montarse en Hermes al área y/o funcionario que corresponda en plazos ejecutables y nivel de prioridad. <br><br>';

      $contador = 0;
      do {
          $contador += 1;
          $codigo_gestion = $resul_consulta->codigo_gestion;
          $cod_variable = $resul_consulta->cod_variable;
          $nombre_varable = $resul_consulta->Descripcion;
          $cod_concepto = $resul_consulta->cod_concepto;
          $nombre_concepto = $resul_consulta->descripcion_con;
          $hallazgo = $resul_consulta->hallazgo;
          $acciones = $resul_consulta->acciones;

          $sql_temas = "SELECT tg.codigo_gestion,tg.codigo_tema,ct.descripcion_tema
                        FROM temas_gestion tg INNER JOIN conceptos_temas ct ON TG.codigo_tema=ct.cod_tema
                        and tg.codigo_gestion=$codigo_gestion";
          $query_temas = $link_personal->query($sql_temas);
          $resul_temas = $query_temas->fetch_object();
          $temas = "";
          do {
            $codigo_tema = $resul_temas->codigo_tema;
            $nombre_tema = $resul_temas->descripcion_tema;
            $temas .= $nombre_tema.'<br>';


          } while ($resul_temas = $query_temas->fetch_object());



        $html .= '<strong>'.$contador.'. VARIABLE: </strong>'.$nombre_varable.'<br>';
        $html .= '<strong>CONCEPTO: </strong>'.$nombre_concepto.'<br>';
        $html .= '<strong>TEMA(S): </strong>'.$temas.'<br>';
        $html .= '<strong>HALLAZGOS: </strong>'.$hallazgo.'<br>';
        $html .= '<strong>ACCION(ES): </strong>'.$acciones.'<br><br>';

        $sql_adjuntos = "SELECT ruta_adjunto,nombre_adjunto FROM adjuntos_informe_salas WHERE informe_id='$codigo_gestion' order by adjunto_id";
        $query_adjuntos = $link_personal->query($sql_adjuntos);
        $resul_adjuntos = $query_adjuntos->fetch_object();
        if (!empty($resul_adjuntos)) {

          $html .= '<strong>Evidencias:</strong><br>';
        do {
          $ruta_adjunto =$resul_adjuntos->ruta_adjunto;
          $nombre = $resul_adjuntos->nombre_adjunto;
          $adjunto = trim($ruta_adjunto).trim($nombre);

          } while ($resul_adjuntos = $query_adjuntos->fetch_object());

          $html .= '<div classs="center" style="text-align:center">Archivo: '. $nombre.'</div>';
          $html .= '<div class="text-center" align="center">';
          $html .= '<img src="'.$adjunto.'" class="center" style="width:450px;height:450px;">';
          $html .= '</div><br><br><br>';
        }else {
          $html .= 'No hay adjuntos<br><br>';
        }


      } while ($resul_consulta = $query_consulta->fetch_object());


      $html .= '</body>';
      $mpdf->WriteHTML($html);
      $mpdf->Output('informe_operacional.pdf','D');
  }
}
 ?>
