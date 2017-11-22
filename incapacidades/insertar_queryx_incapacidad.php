<?php

error_reporting(0);

require_once('../permisos/conexion_ares.php'); 
$link=Conectarse();

//recojo variables
$ID=$_POST['id'];
$EMP_CODIGO=$_POST['cedula'];
$TAUS_CODIGO=$_POST['tipo_incapacidad'];
$AUS_INCAPACIDAD=$_POST['numero_incapacidad']; 
$NDIAS=$_POST['ndias'];
$AUS_FECHA_INICIAL=$_POST['finicial'];
$AUS_FECHA_FINAL=$_POST['ffinal'];
$DIAG_CODIGO=$_POST['diagnostico']; 
$hoy=date("d/m/y");
$hoy2=date("d/m/Y",strtotime($hoy));
$AUS_FECHA_INICIAL2=date("m/d/Y",strtotime($AUS_FECHA_INICIAL));
$AUS_FECHA_FINAL2=date("m/d/Y",strtotime($AUS_FECHA_FINAL));

//conexion Queryx
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
	
	
	
	//SOLUCIONAR QUERYX************************************	
	 $queryx = "SELECT SRH_AUSENTISMO.NEXTVAL FROM DUAL";
	
	 $queryx = " Select AUS_CONSECUTIVO from (select * from TRH_AUSENTISMO order by  AUS_CONSECUTIVO desc )where rownum = 1";
		$stmt = $dbh->prepare($queryx);
		$stmt->execute();
		$row_n1 = $stmt->fetch();
		
		 $AUS_CONSECUTIVO = $row_n1['AUS_CONSECUTIVO']+1;
		 
		 
		 //VERIFICA QUE ESTA INCAPACIDAD NO EXISTA ENQUERYZ IGUAL NOMBRE IGUAL FECHA
		$queryv = "select aus_consecutivo from trh_ausentismo au where AU.EMP_CODIGO = '$EMP_CODIGO' and aus_fecha_inicial = '$AUS_FECHA_INICIAL'";
		$stmtv = $dbh->prepare($queryv);
		$stmtv->execute();
		$row_nv = $stmtv->fetch();
		
		$consecutivoq = $row_nv['EMP_TIPO_NOMINA']; 
		
		if(empty($consecutivoq))
		{
		//examina tipo de nomina segun queryx
		
		 $query1 = "SELECT EM.EMP_TIPO_NOMINA
        FROM EMPLEADO EM
        WHERE EM.EMP_CODIGO = '$EMP_CODIGO'";
		$stmt1 = $dbh->prepare($query1);
		$stmt1->execute();
		$row_n1 = $stmt1->fetch();
		
		$tipo_nomina = $row_n1['EMP_TIPO_NOMINA']; 
		
		//Inserta en queryx
		
	
	$sql="Insert into TRH_AUSENTISMO
   (AUS_CONSECUTIVO, EMP_CODIGO, EN1_CODIGO, TNOM_CODIGO, TAUS_CODIGO, 
    AUS_FECHA_INICIAL, AUS_FECHA_FINAL, AUS_UNIDADES, AUS_FECHA_LIQ, AUS_ESTADO, 
    AUS_CONSECUTIVO_REFER, AUS_DOCUMENTO, AUS_INCAPACIDAD, AUS_DOC_AUT_DESC_INCAP, AUS_OBSERVACION, 
    DIAG_CODIGO, CABUPZ_CODIGO, USERNAME, AUS_FECHA_SISTEMA, AUS_CONSEC_GENERO, 
    VERSION)
 Values
   ($AUS_CONSECUTIVO, '$EMP_CODIGO', 1, '$tipo_nomina','$TAUS_CODIGO', 
    TO_DATE('$AUS_FECHA_INICIAL', 'dd/mm/yyyy HH24:MI:SS'), TO_DATE('$AUS_FECHA_FINAL', 'dd/mm/yyyy HH24:MI:SS'), $NDIAS, TO_DATE('$AUS_FECHA_INICIAL', 'dd/mm/yyyy HH24:MI:SS'), 'ACT', 
    NULL, NULL, '$AUS_INCAPACIDAD', NULL, NULL,'$DIAG_CODIGO', NULL,'SRHCATERIN',TO_DATE('$hoy', 'dd/mm/yyyy HH24:MI:SS'), NULL, 
    0)";
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		
		$queryx1 = "SELECT SRH_AUSENTISMO.NEXTVAL FROM DUAL";
		$stmta = $dbh->prepare($queryx1);
		$stmta->execute();
		
	
 $queryx = "SELECT SRH_AUSENTISMO.NEXTVAL FROM DUAL";

//conexion sql	para eliminar el registro
	
	
			$sql="UPDATE `incapacidades` SET queryx = '1' WHERE `id` = '$ID'";
			$qry_sql=$link->query($sql);
	
	
	  $query2 = "SELECT AUS_INCAPACIDAD
        FROM TRH_AUSENTISMO
        WHERE AUS_INCAPACIDAD = '$AUS_INCAPACIDAD'";
		$stmt2 = $dbh->prepare($query2);
		$stmt2->execute();
		$row_n2 = $stmt2->fetch();
		
		$incluido = $row_n2['AUS_INCAPACIDAD']; 
		
	if (isset($incluido))
	
		 	echo "SE INGRESO EL REGISTRO A QUERYX CORRECTAMENTE";
	else echo "POR FAVOR VERIFIQUE EL REGISTRO EN QUERYX, AL PARECER SE GENERO UN ERROR Y NO FUE INCORPORADO";
		}
		
		else{
			echo "*** Esta incapacidad ya fue incorporada, verifique ***";
			exit();
			}

?>	
