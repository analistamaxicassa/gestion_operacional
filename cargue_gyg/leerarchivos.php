<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
include_once "conexiones/conexion_cera.php";
//include_once "conexiones/conexion_max.php";
include_once "conexiones/conexion_pegomax.php";
include_once "conexiones/conexion_tucassa.php";

$empresa=$_POST['empresa'];
$tipo=$_POST['tipo'];

//valido que se va a insertar si el encabezado o el detalle
if($tipo=="ENC")
{
	  move_uploaded_file ($_FILES['archivo']['tmp_name'], "cargados/{$_FILES['archivo']['name']}");
		  if($_FILES['archivo'] ['error'] > 0)
		  {
				switch ($_FILES['archivo'] ['error'])
				{
					   case 1: echo '<center><br><br><br><br><br><hr><img src="img/alert.png"/><span style="font-family:Verdana, Geneva, sans-serif">Error: el tama&ntilde;o del archivo excede el valor permitido por el servidor<br>Comuniquese con el administrador del sistema.</span><hr><br><br><br><br><br></center>';
					   break;
					   case 2: echo '<center><br><br><br><br><br><hr><img src="img/alert.png"/><span style="font-family:Verdana, Geneva, sans-serif">Error: el archivo excede el tama&ntilde;o permitido de carga. <br>Comuniquese con el administrador del sistema.</span><hr><br><br><br><br><br></center>';
					   break;
					   case 3: echo '<center><br><br><br><br><br><hr><img src="img/alert.png"/><span style="font-family:Verdana, Geneva, sans-serif">Error: el archivo fue cargado parcialmente. <br>Comuniquese con el administrador del sistema.</span><hr><br><br><br><br><br></center>';
					   break;
					   case 4: echo '<center><br><br><br><br><br><hr><img src="img/alert.png"/><span style="font-family:Verdana, Geneva, sans-serif">Error: el archivo no fue cargado. Intente nuevamente o Comuniquese con el administrador del sistema.</span><hr><br><br><br><br><br></center>';
					   break;
				 }
		   }else{
			   echo '<center><br><br><hr><span style="font-family:Verdana, Geneva, sans-serif"><img src="img/add.png"/>Archivo cargado correctamente.</span><hr><br><br></center>';
		   }
		   
	  $archivo=file('cargados/'.$_FILES['archivo']['name']);

if($empresa=="CERA") //|| $empresa=="MAX")
{	  
		  switch ($empresa)
		  {
			  case "CERA":
			  	$conexion=$conn_cera;
				break;
			 /* case "MAX":
			  	$conexion=$conn_max;
				break;*/
		  }
			  
		  
		  foreach($archivo as $linea_num =>$linea)
		  {
			  $datos=explode("\t",$linea);
			  
			  $numero=trim($datos[0]);
			  //-----genero varible de sesion con el numero de documento para validar el detalle--------------
			  $_SESSION['numero']=$numero;
			  //----------------------------------------------------------------------------------------------
			  $mes=trim($datos[1]);
			  $anulado=trim($datos[2]);
			  $fecha=substr($datos[3],0,10);
			  $nit=trim($datos[4]);
			  $vencimiento=substr($datos[5],0,10);
			  $factura=trim($datos[6]);
			  $cuentacontable=trim($datos[7]);
			  $valor=trim($datos[8]);
			  $espera=trim($datos[9]);
			  $fechacreacion=substr($datos[10],0,10);
			  $claveusuario=trim($datos[11]);
			  $traslado_pyg=trim($datos[12]);
			  $num_doc_espera=trim($datos[13]);
			  $zona=trim($datos[14]);
			  $codigo_numeracion=trim($datos[15]);
			  $transmitido=trim($datos[16]);
			  $importacion=trim($datos[17]);
			  $concepto=trim($datos[18]);
			  $base_prorrateo=trim($datos[19]);
			  $id_moneda=trim($datos[20]);
			  $tasa=trim($datos[21]);
			  $codigo_plantilla=trim($datos[22]);
			  $idordenp=trim($datos[23]);
			  $codigo=trim($datos[24]);
			  $conceptocontable=trim($datos[25]);
			  $idimportacion=trim($datos[26]);
			  $facturaantes=trim($datos[27]);
			  $observaciones=trim($datos[28]);
			  
			  $insertar="INSERT INTO gastos1_2000 (numero,
						mes,
						anulado,
						fecha,
						nit,
						vencimiento,
						factura,
						cuentacontable,
						valor,
						espera,
						FECHACREACION,
						CLAVEUSUARIO,
						TRASLADO_PYG,
						NUM_DOC_ESPERA,
						ZONA,
						CODIGO_NUMERACION,
						TRANSMITIDO,
						importacion,
						concepto,
						Base_Prorrateo,
						Id_Moneda,
						Tasa,
						CODIGO_PLANTILLA,
						IDORDENP,
						CODIGO,
						CONCEPTOCONTABLE,
						IDIMPORTACION,
						FACTURAANTES,
						OBSERVACIONES)
						
					  VALUES 
					  
					  ('$numero',
					  '$mes',
					  $anulado,
					  $fecha,
					  '$nit',
					  $vencimiento,
					  '$factura',
					  '$cuentacontable',
					  $valor,
					  $espera,
					  $fechacreacion,
					  '$claveusuario',
					  $traslado_pyg,
					  '$num_doc_espera',
					  '$zona',
					  '$codigo_numeracion',
					  $transmitido,
					  '$importacion',
					  '$concepto',
					  $base_prorrateo,
					  '$id_moneda',
					  $tasa,
					  '$codigo_plantilla',
					  '$idordenp',
					  '$codigo',
					  '$conceptocontable',
					  '$idimportacion',
					  '$facturaantes',
					  '$observaciones'
			  )";
			  $msresults=odbc_exec($conexion,$insertar);
		  }
		  
		  echo "<center><br><br><br><span style='font-family:Verdana, Geneva, sans-serif; font-size:11px'><img src='img/add.png' width='10' height='10' /><b>Proceso culminado-><a href='intro_leer.php'>Volver</a></b></span></center>";	
} //fin if max cera

if($empresa=="TUC")
{
	foreach($archivo as $linea_num =>$linea)
	{
			  $datos=explode("\t",$linea);
			  
			  $numero=trim($datos[0]);
			  //-----genero varible de sesion con el numero de documento para validar el detalle--------------
			  $_SESSION['numero']=$numero;
			  //----------------------------------------------------------------------------------------------
			  $mes=trim($datos[1]);
			  $anulado=trim($datos[2]);
			  $fecha=substr($datos[3],0,10);
			  $nit=trim($datos[4]);
			  $vencimiento=substr($datos[5],0,10);
			  $factura=trim($datos[6]);
			  $cuentacontable=trim($datos[7]);
			  $valor=trim($datos[8]);
			  $espera=trim($datos[9]);
			  $fechacreacion=substr($datos[10],0,10);
			  $claveusuario=trim($datos[11]);
			  $traslado_pyg=trim($datos[12]);
			  $num_doc_espera=trim($datos[13]);
			  $zona=trim($datos[14]);
			  $codigo_numeracion=trim($datos[15]);
			  $transmitido=trim($datos[16]);
			  $importacion=trim($datos[17]);
			  $concepto=trim($datos[18]);
			  $base_prorrateo=trim($datos[19]);
			  $id_moneda=trim($datos[20]);
			  $tasa=trim($datos[21]);
			  $codigo_plantilla=trim($datos[22]);
			  $idordenp=trim($datos[23]);
			  $codigo=trim($datos[24]);
			  $conceptocontable=trim($datos[25]);
			  $idimportacion=trim($datos[26]);
			  $facturaantes=trim($datos[27]);
			  $observaciones=trim($datos[28]);
		  
			  $insertar="INSERT INTO gastos1_2000 (numero,
					   mes,
					   anulado,
					   fecha,
					   nit,
					   vencimiento,
					   factura,
					   cuentacontable,
					   valor,
					   espera,
					   FECHACREACION,
					   CLAVEUSUARIO,
					   TRASLADO_PYG,
					   NUM_DOC_ESPERA,
					   ZONA,
					   CODIGO_NUMERACION,
					   TRANSMITIDO,
					   concepto,
					   Base_Prorrateo,
					   Id_Moneda,
					   Tasa,
					   CODIGO,
					   CONCEPTOCONTABLE,
					   IDIMPORTACION,
					   FACTURAANTES,
					   OBSERVACIONES)
					   
					  VALUES 
					  
					  ('$numero',
					  '$mes',
					  $anulado,
					  $fecha,
					  '$nit',
					  $vencimiento,
					  '$factura',
					  '$cuentacontable',
					  $valor,
					  $espera,
					  $fechacreacion,
					  '$claveusuario',
					  $traslado_pyg,
					  '$num_doc_espera',
					  '$zona',
					  '$codigo_numeracion',
					  $transmitido,
					  '$concepto',
					  $base_prorrateo,
					  '$id_moneda',
					  $tasa,
					  '$codigo',
					  '$conceptocontable',
					  '$idimportacion',
					  '$facturaantes',
					  '$observaciones'
			  )";
			  $msresults_1=odbc_exec($conn_tc,$insertar);
     }
		  
		  echo "<center><br><br><br><span style='font-family:Verdana, Geneva, sans-serif; font-size:11px'><img src='img/add.png' width='10' height='10' /><b>Proceso culminado-><a href='intro_leer.php'>Volver</a></b></span></center>";
}//fin if tucassa
	  
if($empresa=="PEGO")
{    
		  foreach($archivo as $linea_num =>$linea)
		  {
			  $datos=explode("\t",$linea);
			  
			  $numero=trim($datos[0]);
			  //-----genero varible de sesion con el numero de documento para validar el detalle--------------
			  $_SESSION['numero']=$numero;
			  //----------------------------------------------------------------------------------------------
			  $mes=trim($datos[1]);
			  $anulado=trim($datos[2]);
			  $fecha=substr($datos[3],0,10);
			  $nit=trim($datos[4]);
			  $vencimiento=substr($datos[5],0,10);
			  $factura=trim($datos[6]);
			  $cuentacontable=trim($datos[7]);
			  $valor=trim($datos[8]);
			  $espera=trim($datos[9]);
			  $fechacreacion=substr($datos[10],0,10);
			  $claveusuario=trim($datos[11]);
			  $traslado_pyg=trim($datos[12]);
			  $num_doc_espera=trim($datos[13]);
			  $zona=trim($datos[14]);
			  $codigo_numeracion=trim($datos[15]);
			  $transmitido=trim($datos[16]);
			  $importacion=trim($datos[17]);
			  $concepto=trim($datos[18]);
			  $base_prorrateo=trim($datos[19]);
			  $id_moneda=trim($datos[20]);
			  $tasa=trim($datos[21]);
			  $codigo_plantilla=trim($datos[22]);
			  $idordenp=trim($datos[23]);
			  $codigo=trim($datos[24]);
			  $conceptocontable=trim($datos[25]);
			  $idimportacion=trim($datos[26]);
			  $facturaantes=trim($datos[27]);
			  $observaciones=trim($datos[28]);
		  
			  $insertar="INSERT INTO gastos1_2000 (numero,
					   mes,
					   anulado,
					   fecha,
					   nit,
					   vencimiento,
					   factura,
					   cuentacontable,
					   valor,
					   espera,
					   FECHACREACION,
					   CLAVEUSUARIO,
					   TRASLADO_PYG,
					   NUM_DOC_ESPERA,
					   ZONA,
					   CODIGO_NUMERACION,
					   TRANSMITIDO,
					   concepto,
					   Base_Prorrateo,
					   Id_Moneda,
					   Tasa,
					   CODIGO,
					   CONCEPTOCONTABLE,
					   IDIMPORTACION,
					   FACTURAANTES,
					   OBSERVACIONES)
					   
					  VALUES 
					  
					  ('$numero',
					  '$mes',
					  $anulado,
					  $fecha,
					  RTRIM('$nit'),
					  $vencimiento,
					  '$factura',
					  '$cuentacontable',
					  $valor,
					  $espera,
					  $fechacreacion,
					  '$claveusuario',
					  $traslado_pyg,
					  '$num_doc_espera',
					  '$zona',
					  '$codigo_numeracion',
					  $transmitido,
					  '$concepto',
					  $base_prorrateo,
					  '$id_moneda',
					  $tasa,
					  '$codigo',
					  '$conceptocontable',
					  '$idimportacion',
					  '$facturaantes',
					  '$observaciones'
			  )";
			  $stmt_insert = sqlsrv_query($conn_pego, $insertar) or die( print_r( sqlsrv_errors(), true));
		  }
		  
		 echo "<center><br><br><br><span style='font-family:Verdana, Geneva, sans-serif; font-size:11px'><img src='img/add.png' width='10' height='10' /><b>Proceso culminado-><a href='intro_leer.php'>Volver</a></b></span></center>";
 }  
}//fin tipo enc




if($tipo=="DET")
{
move_uploaded_file ($_FILES['archivo']['tmp_name'], "cargados/{$_FILES['archivo']['name']}");
    if($_FILES['archivo'] ['error'] > 0)
    {
    switch ($_FILES['archivo'] ['error'])
	    {
     case 1: echo '<center><br><br><br><br><br><hr><img src="img/alert.png"/><span style="font-family:Verdana, Geneva, sans-serif">Error: el tama&ntilde;o del archivo excede el valor permitido por el servidor<br>Comuniquese con el administrador del sistema.</span><hr><br><br><br><br><br></center>';
     break;
     case 2: echo '<center><br><br><br><br><br><hr><img src="img/alert.png"/><span style="font-family:Verdana, Geneva, sans-serif">Error: el archivo excede el tama&ntilde;o permitido de carga. <br>Comuniquese con el administrador del sistema.</span><hr><br><br><br><br><br></center>';
     break;
     case 3: echo '<center><br><br><br><br><br><hr><img src="img/alert.png"/><span style="font-family:Verdana, Geneva, sans-serif">Error: el archivo fue cargado parcialmente. <br>Comuniquese con el administrador del sistema.</span><hr><br><br><br><br><br></center>';
     break;
     case 4: echo '<center><br><br><br><br><br><hr><img src="img/alert.png"/><span style="font-family:Verdana, Geneva, sans-serif">Error: el archivo no fue cargado. Intente nuevamente o Comuniquese con el administrador del sistema.</span><hr><br><br><br><br><br></center>';
     break;
     }
     }
     else
     {
     echo '<center><br><br><hr><span style="font-family:Verdana, Geneva, sans-serif"><img src="img/add.png"/>Archivo cargado correctamente.</span><hr><br><br></center>';
     }
	 
$archivo=file('cargados/'.$_FILES['archivo']['name']);

if($empresa=="CERA" || $empresa=="MAX")
{
	switch ($empresa)
	{
	  case "CERA":
	  $conexion=$conn_cera;
	  break;
	  case "MAX":
	  $conexion=$conn_max;
	  break;	
	}
	
	foreach($archivo as $linea_num =>$linea)
	{  
	  $datos=explode("\t",$linea);
	  
	  $id=trim($datos[0]);
	  $numero=trim($datos[1]);
	  $anulado=trim($datos[2]);
	  $cuentacontable=trim($datos[3]);
	  $descripcion=trim($datos[4]);
	  $valor=trim($datos[5]);
	  $naturaleza=trim($datos[6]);
	  $ccostos=trim($datos[7]);
	  $nit=trim($datos[8]);
	  $conceptocontable=trim($datos[9]);
	  $valor_moneda=trim($datos[10]);
	  $codarancel=trim($datos[11]);
	  $numeropedido=trim($datos[12]);
	  $valorbasedoc=trim($datos[13]);
	  $idordenp=trim($datos[14]);
	  $base=trim($datos[15]);
	  $numerodocumento=trim($datos[16]);
	  $noprorratear=trim($datos[17]);
	  $concepto=trim($datos[18]);
	  $subcentrocosto=trim($datos[19]);
	  
	  $insertar="INSERT INTO gastos2_2000(id,
				numero,
				anulado,
				cuentacontable,
				descripcion,
				valor,
				naturaleza,
				ccostos,
				NIT,
				CONCEPTOCONTABLE,
				valor_Moneda,
				codarancel,
				NUMEROPEDIDO,
				VALORBASEDOC,
				IDORDENP,
				BASE,
				NUMERODOCUMENTO,
				NOPRORRATEAR,
				CONCEPTO,
				SUBCENTROCOSTO)
		
		VALUES
		
		('$id',
		'$numero',
		$anulado,
		'$cuentacontable',
		'$descripcion',
		$valor,
		$naturaleza,
		'$ccostos',
		'$nit',
		'$conceptocontable',
		$valor_moneda,
		'$codarancel',
		'$numeropedido',
		$valorbasedoc,
		'$idordenp',
		'$base',
		'$numerodocumento',
		$noprorratear,
		'$concepto',
		'$subcentrocosto')";
		
		$msresults_1=odbc_exec($conexion,$insertar);
	}
			echo "<center><br><br><br><span style='font-family:Verdana, Geneva, sans-serif; font-size:11px'><img src='img/add.png' width='10' height='10' /><b>Detalle del documento ingresado. Proceso culminado-><a href='intro_leer.php'>Volver</a></b></span></center>";	
}//fin detalle max, cera

if($empresa=="TUC")
{   
    foreach($archivo as $linea_num =>$linea)
    {
     $datos=explode("\t",$linea);
     
     $id=trim($datos[0]);
	  $numero=trim($datos[1]);
	  $anulado=trim($datos[2]);
	  $cuentacontable=trim($datos[3]);
	  $descripcion=trim($datos[4]);
	  $valor=trim($datos[5]);
	  $naturaleza=trim($datos[6]);
	  $ccostos=trim($datos[7]);
	  $nit=trim($datos[8]);
	  $conceptocontable=trim($datos[9]);
	  $valor_moneda=trim($datos[10]);
	  $codarancel=trim($datos[11]);
	  $numeropedido=trim($datos[12]);
	  $valorbasedoc=trim($datos[13]);
	  $idordenp=trim($datos[14]);
	  $base=trim($datos[15]);
	  $numerodocumento=trim($datos[16]);
	  $noprorratear=trim($datos[17]);
	  $concepto=trim($datos[18]);
	  $subcentrocosto=trim($datos[19]);
     
     $insertar="INSERT INTO gastos2_2000(id,
                numero,
                anulado,
                cuentacontable,
                descripcion,
                valor,
                naturaleza,
                NIT,
                CONCEPTOCONTABLE,
                valor_Moneda,
                codarancel,
                NUMEROPEDIDO,
                BASE,
                NUMERODOCUMENTO,
                CONCEPTO,
                SUBCENTROCOSTO)
        
        VALUES
        
        ('$id',
        '$numero',
        $anulado,
        '$cuentacontable',
        '$descripcion',
        $valor,
        $naturaleza,
        '$nit',
        '$conceptocontable',
        $valor_moneda,
        '$codarancel',
        '$numeropedido',
        '$base',
        '$numerodocumento',
        '$concepto',
        '$subcentrocosto')";
        
        $msresults_1=odbc_exec($conn_tc,$insertar);
	}
        echo "<center><br><br><br><span style='font-family:Verdana, Geneva, sans-serif; font-size:11px'><img src='img/add.png' width='24' height='24' /><b>Proceso culminado-><a href='intro_leer.php'>Volver</a></b></span></center>";
}//fin detalle tucassa

if($empresa=="PEGO")
{
foreach($archivo as $linea_num =>$linea)
    {
     $datos=explode("\t",$linea);
     
     $id=trim($datos[0]);
	  $numero=trim($datos[1]);
	  $anulado=trim($datos[2]);
	  $cuentacontable=trim($datos[3]);
	  $descripcion=trim($datos[4]);
	  $valor=trim($datos[5]);
	  $naturaleza=trim($datos[6]);
	  $ccostos=trim($datos[7]);
	  $nit=trim($datos[8]);
	  $conceptocontable=trim($datos[9]);
	  $valor_moneda=trim($datos[10]);
	  $codarancel=trim($datos[11]);
	  $numeropedido=trim($datos[12]);
	  $valorbasedoc=trim($datos[13]);
	  $idordenp=trim($datos[14]);
	  $base=trim($datos[15]);
	  $numerodocumento=trim($datos[16]);
	  $noprorratear=trim($datos[17]);
	  $concepto=trim($datos[18]);
	  $subcentrocosto=trim($datos[19]);
     
     $insertar="INSERT INTO gastos2_2000(id,
                numero,
                anulado,
                cuentacontable,
                descripcion,
                valor,
                naturaleza,
                NIT,
                CONCEPTOCONTABLE,
                valor_Moneda,
                codarancel,
                NUMEROPEDIDO,
                BASE,
                NUMERODOCUMENTO,
                CONCEPTO,
                SUBCENTROCOSTO)
        
        VALUES
        
        ('$id',
        '$numero',
        $anulado,
        '$cuentacontable',
        '$descripcion',
        $valor,
        $naturaleza,
        '$nit',
        '$conceptocontable',
        $valor_moneda,
        '$codarancel',
        '$numeropedido',
        '$base',
        '$numerodocumento',
        '$concepto',
        '$subcentrocosto')";
        
        $msresults_1=sqlsrv_query($conn_pego,$insertar);
		 }
		
        echo "<center><br><br><br><span style='font-family:Verdana, Geneva, sans-serif; font-size:11px'><img src='img/add.png' width='24' height='24' /><b>Proceso culminado-><a href='intro_leer.php'>Volver</a></b></span></center>";
   

}

}//fin if detalle 

?>
