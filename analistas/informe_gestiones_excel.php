<?php
require_once('../conexionesDB/conexion.php');
$link_queryx_mysql = Conectarse_queryx_mysql();
$link_personal = Conectarse_personal();
$link_caronte = Conectarse_caronte();
session_start();



require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;


if (isset($_POST['informe'],$_POST['consulta_sql']) && !empty($_POST['consulta_sql'])) {

  // $sociedad= $_SESSION['cod_sociedad_ing'];
  $consulta_sql = $_POST['consulta_sql'];
  $fecha_actual= new DateTime("now");
  $fecha_actual= $fecha_actual->format('Y-m-d');
  $fileName = "Informe_Operacional.xlsx";

  $sql_informe = $consulta_sql;
  // echo $sql_informe;
  // exit();
  $query_informe = $link_personal->query($sql_informe);
  $resultado_informe = $query_informe->fetch_object();

    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();


    // Set document properties
    $spreadsheet->getProperties()->setCreator('informacion Gestiones')
        ->setLastModifiedBy('Victor_Sanabria')
        ->setTitle('Informe Datos Permisos')
        ->setSubject('Gestion Humana')
        ->setDescription('Reporte de gestiones')
        ->setKeywords('office 2007 openxml php')
        ->setCategory('Reportes');
        // Add some data
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(1, 1, 'INFORME DE DATOS GESTIONES A PDV');
            $spreadsheet->getActiveSheet()->mergeCells('A1:P1');
            // $spreadsheet->getActiveSheet()->mergeCells('B3:D3');
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth('40');
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
            // $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth('50');
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth('50');
            $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);
            $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth('40');
            // $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(false);
            $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth('50');
            $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
            // $spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
            // $spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
            // $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
            // $spreadsheet->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);

            $styleTitulosVisitas = [
              'font' => [
                'bold' => true,
              ],
              'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
              ],
              'borders' => [
                'outline' => [
                  'borderStyle' => Border::BORDER_THICK,
                  'color' => ['argb' => 'FF000000'],
                ],
              ],
            ];
            $styleColorMagenta = [
              'font' => [
                'bold' => false,
              ],
              'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
              ],
              'fill' => [
                'fillType' => Fill::FILL_GRADIENT_LINEAR,
                // 'rotation' => 90,
                'startColor' => [
                  'argb' => 'DFF0D8',
                ],
                'endColor' => [
                  'argb' => 'DFF0D8',
                ],
              ],
            ];
            $styleColorwarning = [
              'font' => [
                'bold' => false,
              ],
              'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
              ],
              'fill' => [
                'fillType' => Fill::FILL_GRADIENT_LINEAR,
                // 'rotation' => 90,
                'startColor' => [
                  'argb' => 'FCF8E3',
                ],
                'endColor' => [
                  'argb' => 'FCF8E3',
                ],
              ],
            ];
            $styleColordanger = [
              'font' => [
                'bold' => false,
              ],
              'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
              ],
              'fill' => [
                'fillType' => Fill::FILL_GRADIENT_LINEAR,
                // 'rotation' => 90,
                'startColor' => [
                  'argb' => 'F2DEDE',
                ],
                'endColor' => [
                  'argb' => 'F2DEDE',
                ],
              ],
            ];
            $styleThinBlackBorderOutline = [
              'borders' => [
                'allBorders' => [
                  'borderStyle' => Border::BORDER_THIN,
                  'color' => ['argb' => 'FF000000'],
                ],
              ],
            ];

            $rango_titulos = "A1:O1";
            $spreadsheet->getActiveSheet()->getStyle($rango_titulos)->applyFromArray($styleTitulosVisitas);

            $fila = 2;
            $spreadsheet->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(1, $fila, 'CODIGO')
            ->setCellValueByColumnAndRow(2, $fila, 'CENTRO COSTO')
            ->setCellValueByColumnAndRow(3, $fila, 'NOMBRE SALA')
            ->setCellValueByColumnAndRow(4, $fila, 'FECHA ')
            ->setCellValueByColumnAndRow(5, $fila, 'FECHA INSPECCION')
            ->setCellValueByColumnAndRow(6, $fila, 'VARIABLE')
            ->setCellValueByColumnAndRow(7, $fila, 'CONCEPTO')
            ->setCellValueByColumnAndRow(8, $fila, 'TEMA')
            ->setCellValueByColumnAndRow(9, $fila, 'CALIFICACION')
            ->setCellValueByColumnAndRow(10, $fila, 'HALLAZGO')
            ->setCellValueByColumnAndRow(11, $fila, 'ACCIONES')
            ->setCellValueByColumnAndRow(12, $fila, 'FECHA CONTROL')
            ->setCellValueByColumnAndRow(13, $fila, 'OBSERVACION')
            ->setCellValueByColumnAndRow(14, $fila, 'CODIGO HERMES')
            ->setCellValueByColumnAndRow(15, $fila, 'ESTADO');
            // ->setCellValueByColumnAndRow(16, $fila, 'LLEGADA')
            // ->setCellValueByColumnAndRow(17, $fila, 'UNIDADES');
            // ->setCellValueByColumnAndRow(17, $fila, 'ESTADO')
            // ->setCellValueByColumnAndRow(18, $fila, 'OBSERVACIONES');


            $rango_titulos = "A".$fila.":O".$fila;
            $spreadsheet->getActiveSheet()->getStyle($rango_titulos)->applyFromArray($styleTitulosVisitas);

            do {
                // $contador += 1;
                $codigo_gestion = $resultado_informe->codigo_gestion;
                $centro_costo = $resultado_informe->centro_costo;
                $sala_nombre = $resultado_informe->sala_nombre;
                $fecha_registro = $resultado_informe->fecha;
                $fecha_inspeccion = $resultado_informe->fecha_inspeccion;
                $variable = $resultado_informe->variable;
                $nom_concepto = $resultado_informe->descripcion_con;
                $calificacion = $resultado_informe->calificacion;
                $hallazgo = $resultado_informe->hallazgo;
                $acciones = $resultado_informe->acciones;
                $fecha_control = $resultado_informe->fecha_control;
                $observacion = $resultado_informe->observacion;
                $cod_hermes = $resultado_informe->cod_sol_hermes;
                $nom_estado = $resultado_informe->nom_estado;

                if ($calificacion >= 9) {
                  $color_fila = $styleColorMagenta;
                }elseif ($calificacion >= 7 and $calificacion <= 8) {
                  $color_fila = $styleColorwarning;
                }elseif($calificacion >= 0 and $calificacion <= 6) {
                  $color_fila = $styleColordanger;
                }




                $sql_cantidad = "SELECT count(codigo) as cantidad FROM temas_gestion WHERE codigo_gestion='$codigo_gestion'";
                $query_cantidad = $link_personal->query($sql_cantidad);
                $resul_cantidad = $query_cantidad->fetch_object();
                $cantidad_temas = $resul_cantidad->cantidad;
                $nuevo_valor=0;
                if ($cantidad_temas>1) {
                  $nuevo_valor = $fila+$cantidad_temas;
                   $spreadsheet->getActiveSheet()->mergeCells("A".($fila).":A".($nuevo_valor));
                     // $spreadsheet->getActiveSheet()->getStyle("A".($fila).":A".($nuevo_valor))->applyFromArray($styleColorMagenta);
                   $spreadsheet->getActiveSheet()->mergeCells("B".($fila).":B".($nuevo_valor));

                   $spreadsheet->getActiveSheet()->mergeCells("C".($fila).":C".($nuevo_valor));
                   $spreadsheet->getActiveSheet()->mergeCells("D".($fila).":D".($nuevo_valor));
                   $spreadsheet->getActiveSheet()->mergeCells("E".($fila).":E".($nuevo_valor));
                   $spreadsheet->getActiveSheet()->mergeCells("F".($fila).":F".($nuevo_valor));
                   $spreadsheet->getActiveSheet()->mergeCells("G".($fila).":G".($nuevo_valor));
                   $spreadsheet->getActiveSheet()->mergeCells("I".($fila).":I".($nuevo_valor));
                   $spreadsheet->getActiveSheet()->mergeCells("J".($fila).":J".($nuevo_valor));
                   $spreadsheet->getActiveSheet()->mergeCells("K".($fila).":K".($nuevo_valor));
                   $spreadsheet->getActiveSheet()->mergeCells("L".($fila).":L".($nuevo_valor));
                   $spreadsheet->getActiveSheet()->mergeCells("M".($fila).":M".($nuevo_valor));
                   $spreadsheet->getActiveSheet()->mergeCells("N".($fila).":N".($nuevo_valor));
                   $spreadsheet->getActiveSheet()->mergeCells("O".($fila).":O".($nuevo_valor));

                   // $spreadsheet->getActiveSheet()->getStyle("A".$fila.":O".$fila)->applyFromArray($color_fila);
                   $spreadsheet->getActiveSheet()->getStyle("A".($fila).":O".($nuevo_valor))->applyFromArray($color_fila);
              }


                $sql_temas = "SELECT tg.codigo,tg.codigo_gestion,tg.codigo_tema,ct.descripcion_tema, tg.valor
                              FROM temas_gestion tg INNER JOIN conceptos_temas ct
                              ON TG.codigo_tema=ct.cod_tema WHERE codigo_gestion='$codigo_gestion'";
                $query_temas = $link_personal->query($sql_temas);
                $resul_temas = $query_temas->fetch_object();

                do {

                  $codigo_tema = $resul_temas->codigo;
                  $nom_tema = $resul_temas->descripcion_tema;

                  ++$fila;
                  $spreadsheet->setActiveSheetIndex(0)
                  ->setCellValueByColumnAndRow(1, $fila, $codigo_gestion)
                  // ->setCellValueByColumnAndRow(1, $fila, 'A'.$fila.':A'.$fila+$cantidad_temas)
                  ->setCellValueByColumnAndRow(2, $fila, $centro_costo)
                  ->setCellValueByColumnAndRow(3, $fila, $sala_nombre)
                  ->setCellValueByColumnAndRow(4, $fila, $fecha_registro)
                  ->setCellValueByColumnAndRow(5, $fila, $fecha_inspeccion)
                  ->setCellValueByColumnAndRow(6, $fila, $variable)
                  ->setCellValueByColumnAndRow(7, $fila, $nom_concepto)
                  ->setCellValueByColumnAndRow(8, $fila, $nom_tema)
                  ->setCellValueByColumnAndRow(9, $fila, $calificacion)
                  ->setCellValueByColumnAndRow(10, $fila, $hallazgo)
                  ->setCellValueByColumnAndRow(11, $fila, $acciones)
                  ->setCellValueByColumnAndRow(12, $fila, $fecha_control)
                  ->setCellValueByColumnAndRow(13, $fila, $observacion)
                  ->setCellValueByColumnAndRow(14, $fila, $cod_hermes)
                  ->setCellValueByColumnAndRow(15, $fila, $nom_estado);

                    $spreadsheet->getActiveSheet()->getStyle("A".$fila.":O".$fila)->applyFromArray($color_fila);


                } while ($resul_temas = $query_temas->fetch_object());

            } while ($resultado_informe = $query_informe->fetch_object());

            // Rename worksheet
            $spreadsheet->getActiveSheet()->setTitle('Accesos Evaluación');

            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $spreadsheet->setActiveSheetIndex(0);

            // Redirect output to a client’s web browser (Xlsx)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$fileName.'"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit;
  }
 ?>
