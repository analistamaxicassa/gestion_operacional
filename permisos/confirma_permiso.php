
<link rel="stylesheet" type="text/css" href="../estilos.css"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
  <script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
  <script src="../SpryAssets/SpryValidationRadio.js" type="text/javascript"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  
<?php
//session_start();


//recojo variables
$cedula=$_POST['avaljefe'];
//$cedula = '80139134';


//funcion fechas
require_once('../PAZYSALVO/conexion_ares.php'); 
//require_once('conexion_ares.php'); 
$link=Conectarse();


	//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
	//conexion sql	
	
		$sql="SELECT * FROM permisos where autoriza = '$cedula' and `confirmado` is null limit 1";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 

			if (empty($rs_qry)) {
   						 echo 'No existen registros por autorizar';
							//$datelimite = 0;
							exit;
								}

		do{
	$id = $rs_qry->id;	
	$cedula = $rs_qry->cedula;
	$tausentismo  = $rs_qry->tausentismo;
	$f_permiso = $rs_qry->f_final;
	$f_solicitud = $rs_qry->f_liquidacion;
	$salida = $rs_qry->salida;
	$llegada = $rs_qry->llegada;
	$salida = $rs_qry->salida;
	$unidades = $rs_qry->unidades;
	$jefe = $rs_qry->autoriza;
	$observacion = $rs_qry->observacion;
	$correo = $rs_qry->correo;
	$correoemp = $rs_qry->correoemp;
	
	if ($tausentismo == '13')  { $motivo = 'SALUD';}
	if ($tausentismo == '7')  { $motivo = 'ENFERMEDAD GENERAL';}
	if ($tausentismo == '14')  { $motivo = 'ACOMPAÑAMIENTO FAMILIAR';}
	if ($tausentismo == '8')  { $motivo = 'ACCIDENTE DE TRABAJO';}
	if ($tausentismo == '12')  { $motivo = 'PERMISO NO REMUNERADO';}
	if ($tausentismo == '11')  { $motivo = 'DILIGENCIAS PERSONALES';}
	if ($tausentismo == '5')  { $motivo = 'CALAMIDAD DOMESTICA/DEBERES CIUDADANOS';}
	if ($tausentismo == '16')  { $motivo = 'DILIGENCIAS PERSONALES';}
	
		  if ($salida =="6")  { $salidafor ='6:00 AM';}
		  if ($salida =="6.5")  { $salidafor ='6:30 AM';}
		  if ($salida =="7")  { $salidafor ='7:00 AM';}
	 	  if ($salida =="7.5")  { $salidafor ='7:30 AM';}
          if ($salida =="8")  { $salidafor ='8:00 AM';}
          if ($salida =="8.5")  { $salidafor ='8:30 AM';}
          if ($salida =="9")  { $salidafor ='9:00 AM';}
          if ($salida =="9.5")  { $salidafor ='9:30 AM';}
          if ($salida =="10")  { $salidafor ='10:00 AM';}
          if ($salida =="10.5")  { $salidafor ='10:30 AM';}
          if ($salida =="11")  { $salidafor ='11:00 AM';}
          if ($salida =="11.5")  { $salidafor ='11:30 AM';}
          if ($salida =="12")  { $salidafor ='12:00 PM';}
          if ($salida =="12.5")  { $salidafor ='12:30 PM';}
          if ($salida =="13")  { $salidafor ='1:00 PM';}
          if ($salida =="13.5")  { $salidafor ='1:30 PM';}
          if ($salida =="14")  { $salidafor ='2:00 PM';}
          if ($salida =="14.5")  { $salidafor ='2:30 PM';}
          if ($salida =="15")  { $salidafor ='3:00 PM';}
          if ($salida =="15.5")  { $salidafor ='3:30 PM';}
          if ($salida =="16")  { $salidafor ='4:00 PM';}
          if ($salida =="16.5")  { $salidafor ='4:30 PM';}
          if ($salida =="17")  { $salidafor ='5:00 PM';}
          if ($salida =="17.5")  { $salidafor ='5:30 PM';}
          if ($salida =="18")  { $salidafor ='6:00 PM';}
		  
	      if ($llegada =="7")  { $llegadafor ='7:00 AM';}
		  if ($llegada =="7.5")  { $llegadafor ='7:30 AM';}
          if ($llegada =="8")  { $llegadafor ='8:00 AM';}
          if ($llegada =="8.5")  { $llegadafor ='8:30 AM';}
          if ($llegada =="9")  { $llegadafor ='9:00 AM';}
          if ($llegada =="9.5")  { $llegadafor ='9:30 AM';}
          if ($llegada =="10")  { $llegadafor ='10:00 AM';}
          if ($llegada =="10.5")  { $llegadafor ='10:30 AM';}
          if ($llegada =="11")  { $llegadafor ='11:00 AM';}
          if ($llegada =="11.5")  { $llegadafor ='11:30 AM';}
          if ($llegada =="12")  { $llegadafor ='12:00 PM';}
          if ($llegada =="12.5")  { $llegadafor ='12:30 PM';}
          if ($llegada =="13")  { $llegadafor ='1:00 PM';}
          if ($llegada =="13.5")  { $llegadafor ='1:30 PM';}
          if ($llegada =="14")  { $llegadafor ='2:00 PM';}
          if ($llegada =="14.5")  { $llegadafor ='2:30 PM';}
          if ($llegada =="15")  { $llegadafor ='3:00 PM';}
          if ($llegada =="15.5")  { $llegadafor ='3:30 PM';}
          if ($llegada =="16")  { $llegadafor ='4:00 PM';}
          if ($llegada =="16.5")  { $llegadafor ='4:30 PM';}
          if ($llegada =="17")  { $llegadafor ='5:00 PM';}
          if ($llegada =="17.5")  { $llegadafor ='5:30 PM';}
          if ($llegada =="18")  { $llegadafor ='6:00 PM';}

	
	 $query = "SELECT SO.NOMBRE_SOCIEDAD SOCIEDAD,  EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , CA.CARGO_NOMBRE,  CC.CENCOS_NOMBRE CC, CC.CENCOS_TIPO_CODIGO,
	 EM.EMP_CC_CONTABLE CODCC
        FROM EMPLEADO EM, CARGO CA,  sociedad SO, CENTRO_COSTO CC
        WHERE EM.EMP_CARGO = CA.CARGO_CODIGO  AND EM.EMP_CC_CONTABLE = CC.CENCOS_CODIGO
        AND EM.EMP_SOCIEDAD = SO.COD_SOCIEDAD
        AND EM.EMP_CODIGO = '$cedula'";
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row_n = $stmt->fetch();
		
		$row_n['NOMBRE'];
		$row_n ['SOCIEDAD'];
		$row_n ['CC'];
		$cargo=utf8_encode($row_n['CARGO_NOMBRE']);
		$tipo = $row_n ['CENCOS_TIPO_CODIGO'];
		$codcc = substr($row_n ['CODCC'], 0, -7);
?>			


<script>

  
 function confirmar (cedula, f_solicitud, jefe, observacion, f_permiso, motivo, unidades, correoemp, tipo, salidafor, codcc, id)
        {	alert ("Permiso concedido");	
				var parametros = {
				"cedula": cedula,
				"f_solicitud": f_solicitud,
				"jefe": jefe,
				"observacion": observacion,
				"f_permiso": f_permiso,
				"motivo": motivo,
				"unidades": unidades,	
				"correoemp": correoemp,
				"tipo": tipo,	
				"salidafor": salidafor,	
				"codcc": codcc,	
				"id": id,								
               	};
				
							
                $.ajax({
                data: parametros,
                url: 'insertar_queryx.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
						 document.getElementById('restablecer').style.display = 'none';
						 document.getElementById('denegar').style.display = 'none';;
                        $("#validador").html(response);
											
                    }
        
        });
        }
		
		  
 function denegar(cedula, correoemp, codcc)
        { alert ('"SE HA NEGADO EL PERMISO"');
		
		var parametros = {
				"cedula": cedula,
				"correoemp": correoemp,
				"codcc": codcc,	
				        	};
	             $.ajax({
                data: parametros,
                url: 'denegar.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {	 document.getElementById('restablecer').disabled=true;
						 document.getElementById('denegar').disabled=true;
                        $("#validador").html(response);
											
                    }
        
        });
 }


  </script>






<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
  <table width="884" border="1" align="center" style="border-collapse: collapse; font-size: 12px;">
    <tr class="encabezados">
      <td width="336" height="40" align="center" style="border-collapse: collapse; font-size: 18px;"  valign="middle"  class="encabezados" bgcolor="#99FFFF"><?php echo $row_n['SOCIEDAD']; ?>&nbsp;</td>
      <td colspan="2" align="center" valign="middle"  class="encabezados" bgcolor="#99FFFF"><strong>CONFIRMACION  DE PERMISO</strong></td>
    </tr>
    <tr>
      <td height="30" colspan="2" class="header">NOMBRE DEL TRABAJADOR: <?php echo $row_n['NOMBRE']; ?></td>
      <td width="457">CEDULA: 
        <label for="cedula"></label> <label for="cedula"></label>
        <input name="cedula" type="text" id="cedula" value="<?php echo $cedula; ?>" readonly /></td>
    </tr>
    <tr>
      <td height="30" colspan="2" class="header">CENTRO DE TRABAJO: <?php echo $row_n ['CC']; ?></td>
      <td>CARGO: <?php echo $cargo ; ?></td>
    </tr>
    <tr>
      <td height="30" colspan="2" class="header">FECHA DE SOLICITUD 
        <label for="f_solicitud"></label>
      <input name="f_solicitud" type="text" required  class="text" id="f_solicitud"  value="<?php echo $f_solicitud; ?>" readonly /> 
     
      </td>
      
           
      <td class="header">FECHA DE PERMISO
      <input name="f_permiso" type="text" required  class="text" id="f_permiso"  value="<?php echo $f_permiso; ?>" readonly /></td>
    </tr>
    <tr>
      <td height="30" colspan="2" class="header">HORA DE SALIDA
        <label for="salida"></label>
        <input name="salida" type="text" id="salida" value="<?php echo $salidafor; ?>" readonly /></td>
      <td><div id="validador">HORA DE LLEGADA 
          <label for="llegada"></label>
            <input name="llegada" type="text" id="llegada2"  value="<?php echo $llegadafor; ?>" readonly  />
      </div></td>
    </tr>
    <tr>
      <td height="30" colspan="3" class="header"><div id="respuesta">MOTIVO DE PERMISO :      
                <input name="motivo" type="text" id="motivo" value="<?php echo $motivo; ?>" size="50" readonly />
      </div></td>
    </tr>
    <tr>
      <td height="30" colspan="3" bgcolor="#CCCCCC" class="header">OBSERVACION:</td>
    </tr>
    <tr>
      <td height="30" colspan="3" class="header"><label for="observacion"></label>
      <input name="observacion" type="text" id="observacion" value="<?php echo $observacion; ?>" size="140" readonly /></td>
    </tr>

    <tr>
      <td colspan="2" class="header"><input name="restablecer" type="reset" class="botones" id="restablecer"
        onClick="confirmar ($('#cedula').val(),$('#f_solicitud').val(),('<?php echo $jefe;?>'),('<?php echo utf8_encode($observacion);?>'),$('#f_permiso').val(),('<?php echo $tausentismo;?>'),('<?php echo $unidades;?>'),('<?php echo $correoemp;?>'),('<?php echo $tipo;?>'),('<?php echo $salidafor;?>'),('<?php echo $codcc;?>'),('<?php echo $id;?>')); return false;" value="AUTORIZAR"/></td>
      <td class="header"><input name="denegar" type="submit" class="botones" id="denegar" onClick="denegar($('#cedula').val(),('<?php echo $correoemp;?>'),('<?php echo $codcc;?>')); return false;" value="NEGAR PERMISO"  /></td>


    </tr>
 <?php
}
while($rs_qry=$qry_sql->fetch_object());	

?> 
</table>


  <p>&nbsp;</p>
  <label ></label>	
  <p>&nbsp;</p>
  <label></label>
  <p>&nbsp;</p>
  <label></label>
  <p>&nbsp;</p>
  <label></label>
  <br/>
  <p>&nbsp;</p>
  <label style="margin-left:100px;width:210px;"></label> 
</form>
</body>
</html>
