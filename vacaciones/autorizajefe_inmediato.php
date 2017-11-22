<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<?php
require_once("../FuncionFechas.php");



//recojo variables
$jefe=$_POST['aval'];
//$cedula='8496805';
//$hoy=date("y/m/d");
$hoy=date("d/m/y");


require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}

	
		//conexion sql	
			$sql="SELECT  `ID`,`CEDULA`,`JEFE`,`PERIODO`,`DIAS`,`SALIDA`,`ENTRADA`,`REEMPLAZO`,`F_EMPALME`,`EMAIL_PERSONAL` FROM `VACACIONES`
WHERE JEFE = '$jefe' and aut_jefe is null limit 1";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 

			if (empty($rs_qry)) {
   						 echo 'No existen registros por autorizar';
							//$datelimite = 0;
							exit;
								}

		do{
	$id = 	$rs_qry->ID;
	$cedula = $rs_qry->CEDULA;
	$periodo  = $rs_qry->PERIODO;
	$dias = $rs_qry->DIAS;
	$salida = $rs_qry->SALIDA;
	$entrada = $rs_qry->ENTRADA;
	$reemplazo = $rs_qry->REEMPLAZO;
	$f_empalme = $rs_qry->F_EMPALME;
	$email_personal = $rs_qry->EMAIL_PERSONAL;
	
	
	
	
	
//	consulta en queryx

	 $query = "SELECT SO.NOMBRE_SOCIEDAD SOCIEDAD,  EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , CA.CARGO_NOMBRE,  CC.CENCOS_NOMBRE CC, CC.CENCOS_TIPO_CODIGO, LO.NOMBRE_LOCALIDAD, EM.EMP_CC_CONTABLE
        FROM EMPLEADO EM, CARGO CA,  sociedad SO, CENTRO_COSTO CC, LOCALIDAD LO
        WHERE EM.EMP_CARGO = CA.CARGO_CODIGO  AND EM.EMP_CC_CONTABLE = CC.CENCOS_CODIGO
        AND EM.EMP_SOCIEDAD = SO.COD_SOCIEDAD AND EM.EMP_LOCALIDAD = LO.COD_LOCALIDAD
        AND EM.EMP_CODIGO = '$cedula'";
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row_n = $stmt->fetch();
		
		$row_n['NOMBRE'];
		$row_n ['SOCIEDAD'];
		$row_n ['CC'];
		$cargo=utf8_encode($row_n['CARGO_NOMBRE']);
		$tipo = $row_n ['CENCOS_TIPO_CODIGO'];
				$row_n ['NOMBRE_LOCALIDAD'];
		$codcc = substr($row_n ['EMP_CC_CONTABLE'], 0, -7);	
		
		if($codcc =='10-099'||$codcc =='70-099'||$codcc == '20-099')
				 {
				echo "El empleado es administrativo<b>";	 
				 $correo2 = " ";
					}
			else
				{
					echo "El empleado es comercial.<b>";	  		
			$sql1="SELECT email emailpunto FROM email_permisos where cc = '$codcc'";
			$qry_sql1=$link->query($sql1);
			$rs_qry1=$qry_sql1->fetch_object();  ///consultar 
			$correo2 =$rs_qry1->emailpunto;
				}	
	
	
	 $codcc = trim(substr($row_n ['EMP_CC_CONTABLE'], 0, -7));

	if($codcc == '10-099'||$codcc =='70-099'||$codcc == '20-099')
			 { 
			}
		else {
				 $reemplazo = "";
				 $f_empalme = "";
			}	
	
		$queryjefe = " select EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBREJEFE
        FROM EMPLEADO EM
        WHERE EM.EMP_CODIGO = '$jefe'";
		$stmt1 = $dbh->prepare($queryjefe);
		$stmt1->execute();
		$row_n1 = $stmt1->fetch();
		$row_n1['NOMBREJEFE'];
		
		$proceso = explode("-", $row_n ['CC']);
		
	
?> 

<script>

  
 function autoriza(id, ema, jefe, correo2, reemplazajp, empalmejp)
        {	
				if (reemplazajp==""){ alert ("La casilla REEMPLAZA es obligatoria")
					document.getElementById('reemplazajp').focus();
					}
				if (empalmejp==""){ alert ("La casilla FECHA DE EMPALME es obligatoria")
					document.getElementById('empalmajp').focus();
					}
		
				alert('"APROBADAS"')
				var parametros = {
				"id": id,	
				"ema": ema,	
				"jefe": jefe,
				"correo2": correo2,
				"reemplazajp": reemplazajp,
				"empalmejp": empalmejp,	
				};									
                $.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/vacaciones/actualiza_aut_jefe_inmediato.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validadorfinal").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
						 document.getElementById('autorizabtn').disabled=true;
						 document.getElementById('rechazabtn').disabled=true;
                        $("#validadorfinal").html(response);
											
                    }
        
        });
        }
		
 function	guardajp()
 {
	 }
		  
 function rechaza(id, ema, obsrechazo, correo2)
        { alert ('"SE HA NEGADO LA SOLICITUD DE VACACIONES"');
		
		var parametros = {
				"id": id,	
				"ema": ema,	
				"obsrechazo": obsrechazo,
				"correo2": correo2,					
				};									
                $.ajax({
                data: parametros,
                url: 'negada_aut_jefe_inmediato.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validadorfinal").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
						 document.getElementById('autorizabtn').disabled=true;
						 document.getElementById('rechazabtn').disabled=true;
                        $("#validadorfinal").html(response);
											
                    }
        
        });
        }


  </script>
  <script type="text/javascript">
function imprSelec(validador){
	var ficha=document.getElementById(validador);
    var ventimp=window.open(' ','popimpr');
	ventimp.document.write(ficha.innerHTML);
	ventimp.document.close();
	ventimp.print();
	ventimp.close();
}
</script>



			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Autorizacion de Vacaciones</title>
</head>
<div id="validador"> 

<body style="font-family: Verdana, Geneva, sans-serif; font-weight: bold;">
<table width="100%" border="0" align="center">
  <tr>
    <td>
    <center style="font-size: 10px">
        <table width="100%" border="1">
        <tr>
          <th width="19%" rowspan="3" scope="row"><?php echo $row_n['SOCIEDAD']; ?>&nbsp;</th>
          <td width="62%" rowspan="3" align="center">SOLICITUD DE VACACIONES </td>
          <td width="19%">Codigo: FR-GH-15</td>
        </tr>
        <tr>
          <td>Version: 3</td>
        </tr>
        <tr>
          <td>Pag 1 de 1</td>
        </tr>
      </table>
    </center>
    <p><?php $localidad = utf8_encode(str_replace("?","&Ntilde",$row_n['NOMBRE_LOCALIDAD']));
	 echo $localidad;  echo","; echo fechaletra($hoy); ?> </p>
    <p>&nbsp;</p>
    <p>Señores:</p>
    <p>GESTION HUMANA</p>
    <p>Bogota D.C.</p>
    <p>&nbsp;</p>
    <p>Apreciados señores</p>
    <p>&nbsp;</p>
    <p style="text-align: justify">Por medio del presente solicito me sean autorizados <b> <?php echo $dias; ?></b> dias de vacaciones; correspondiente al periodo <b><?php echo substr("$periodo", 0, 19); ?></b>, para ser tomados desde el dia <b><?php echo $salida; ?></b> hasta el dia <b><?php echo $entrada; ?></b>  y en caso de no haber cumplido el tiempo necesario, autorizo que se me descuente de mi liquidacion final de prestaciones sociales, premios, bonificaciones, indemnizaciones y salarios el valor proporcional</p>
    <p>Agradezco la atencion prestada al presente </p>
    <p>&nbsp;</p>
     <table width="83%" border="0">
      <tr>
        <th width="35%" align="left" ><b><?php echo $row_n['NOMBRE']; ?></b>&nbsp;</th>
        <td width="65%" ><div id="validadorfinal"></div></td>
      </tr>
      </table>
     <span style="text-align: left" scope="row"></span>
    <table width="100%" border="1" style="border-collapse: collapse; font-weight: bold; font-size: 10px;" bordercolor="#000000" >
      <tr>
        <th width="50%" align="left" bgcolor="#CCCCCC" scope="row"><span style="text-align: left"></span>Cedula</th>
        <td width="50%" colspan="2" bgcolor="#CCCCCC">Proceso</td>
      </tr>
      <tr>
        <th height="34" align="left" scope="row"><?php echo $cedula; ?>&nbsp;</th>
        <td colspan="2"><?php echo $proceso[2]; ?>&nbsp;</td>
      </tr>
      <tr>
        <th align="left" bgcolor="#CCCCCC" scope="row">Cargo</th>
        <td colspan="2" bgcolor="#CCCCCC">Almacen</td>
      </tr>
      <tr>
        <th height="30" align="left" scope="row"><?php echo $row_n['CARGO_NOMBRE']; ?>&nbsp;</th>
        <td colspan="2"><?php echo $proceso[1]; ?>&nbsp;</td>
      </tr>
      <tr>
        <th align="left" bgcolor="#CCCCCC" scope="row">Quien reemplaza</th>
        <td colspan="2" bgcolor="#CCCCCC">Fecha de Empalme</td>
      </tr>
      <tr>
        <th height="35" align="left" scope="row">&nbsp;
          <label for="reemplazajp"></label>
          
          <input type="text"  style="background-color:#CCC" name="reemplazajp" id="reemplazajp" value="<?php echo $reemplazo; ?>" onChange="guardajp()" /></th>
        <td colspan="2">&nbsp;
          <label for="empalmejp"></label>
         
          <input type="text" style="background-color:#CCC" name="empalmejp" id="empalmejp" value=" <?php echo $f_empalme; ?>" /></td>
      </tr>
      <tr>
        <th align="left" bgcolor="#CCCCCC" scope="row">Nombre de Jefe inmediato</th>
        <td colspan="2" bgcolor="#CCCCCC">Autorizacion Jefe </td>
      </tr>
      <tr>
        <th height="38" align="left" scope="row"><?php echo $row_n1['NOMBREJEFE']; ?>&nbsp;</th>
        <td>
        <label for="autorizacion">
          <input name="boton" type="button" id="autorizabtn"  
          onclick= "autoriza('<?php echo $id;?>','<?php echo $email_personal;?>', '<?php echo $jefe;?>', '<?php echo $correo2;?>', $('#reemplazajp').val(), $('#empalmejp').val()); return false;" value="Autoriza"/>
        </label></td>
        <td>Observacion de rechazo:
<input name="obsrechazo" type="text" id="obsrechazo" size="30" />          <input name="rechazabtn" type="button" id="rechazabtn"  
          onclick= "rechaza('<?php echo $id;?>','<?php echo $email_personal;?>', $('#obsrechazo').val(), '<?php echo $correo2;?>'); return false;" value="Rechaza" /></td>
          
                    
          
      </tr>
     
    </table></td>
    
  </tr>
  <tr>
    <td></td>
  </tr>
</table>
 

</div>
   </p>
   <input type="button" name="imprimir" id="prn" value="imprimir" onClick="imprSelec('validador');" >
 </div> 

</body>
<?php
  }
while($rs_qry=$qry_sql->fetch_object());
  
?>
</html>
