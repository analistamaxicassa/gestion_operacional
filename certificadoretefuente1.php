<?php

//funcion fechas
require_once("FuncionFechas.php");

//recojo variables
$certificado=$_POST['certificado'];
$cedula=$_POST['cedula'];
$hoy=date("d/m/y");
$fsolicitud = $hoy;


//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}

//conexion tabla de retencion
		require_once('conecrete.php');
		
		//objeto para manipulacion de datos
		$link = Conectarse();
		
		$query = "SELECT SO.NOMBRE_SOCIEDAD SOCIEDAD,  EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 					                   NOMBRE , EM.EMP_CODIGO, CA.CARGO_NOMBRE,
        CC.CENCOS_NOMBRE CC,EM.EMP_FECHA_INI_CONTRATO, EM.EMP_FECHA_RETIRO
        FROM EMPLEADO EM, CARGO CA,  sociedad SO, CENTRO_COSTO CC
        WHERE EM.EMP_CARGO = CA.CARGO_CODIGO  AND EM.EMP_CC_CONTABLE = CC.CENCOS_CODIGO
        AND EM.EMP_SOCIEDAD = SO.COD_SOCIEDAD
        AND EM.EMP_CODIGO = '$cedula'";
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row_n = $stmt->fetch();
		
		$row_n['NOMBRE'];
		$row_n ['SOCIEDAD'];
		$row_n['NOMBRE'];
		$row_n['EMP_CODIGO'];
		$cargo=utf8_encode($row_n['CARGO_NOMBRE']);
		$row_n ['CC'];
		$row_n['EMP_FECHA_INI_CONTRATO'];
		$fingreso=$row_n['EMP_FECHA_INI_CONTRATO'];
		$fretiro=$row_n['EMP_FECHA_RETIRO'];

 
?>	
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script>
        function crear(cedula, fsolicitud)
        {	
				var parametros = {
                "cedula": cedula,
                "fsolicitud": fsolicitud,
				};
                $.ajax({
                data: parametros,
                url: 'Z:\ingresar_pazysalvo.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#validador").html(response);
						document.getElementById('prn').style.display="block";
						
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




<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<body>
<form method="post" action="web_contacto.php">
<label></label>
  <table width="830" border="3" align="left">
    <tr>
      <td colspan="7" align="center" valign="middle" bgcolor="#99FFFF"><label><strong>PAZ Y SALVO</strong></label></td>
    </tr>
    <tr>
      <td width="97">Contratado</td>
      <td colspan="3"><?php echo $row_n['SOCIEDAD']; ?>&nbsp;</td>
      <td width="56">Motivo</td>
      <td width="441">&nbsp;</td>
      <td width="132" rowspan="2"><span style="margin-left:100px;width:210px;">
        <input name="Enviar" type="submit" value='SOLICITAR'  onclick="crear($('#cedula').val(),  $('#fsolicitud').val()); return false;"  />
      </span></td>
    </tr>
    <tr>
      <td>Identificacion</td>
      <td colspan="3"><label for="cedula"></label><?php echo $cedula; ?></td>
      <td>Nombre</td>
      <td><?php echo $row_n['NOMBRE']; ?></td>
    </tr>
    <tr>
      <td>Cargo</td>
      <td colspan="3"><?php echo $cargo; ?>&nbsp;</td>
      <td>Almacen</td>
      <td> <?php echo $row_n['CC']; ?>&nbsp;</td>
      <td rowspan="2"><input type="submit" name="CONSULTAR" id="CONSULTAR" value="CONSULTAR" /></td>
    </tr>
    <tr>
      <td rowspan="3">Proceso</td>
      <td colspan="3" rowspan="3">&nbsp;</td>
      <td>Fecha Ingreso</td>
      <td> <?php echo fechaletra($fingreso) ?>&nbsp;</td>
    </tr>
    <tr>
      <td>Fecha Retiro</td>
      <td> <?php echo fechaletra($fretiro) ?>&nbsp;</td>
      <td rowspan="2"><input type="submit" name="IMPRIMIR" id="IMPRIMIR" value="IMPRIMIR" /></td>
    </tr>
    <tr>
      <td>Fecha Solicitud </td>
      <td bgcolor="#FF9933"><?php echo fechaletra($fsolicitud) ?>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="7" align="center" bgcolor="#CCCCCC"><em><strong>1. CONCEPTO CONTABILIDAD</strong></em></td>
    </tr>
    <tr>
      <td colspan="3">F. Respuesta</td>
      <td width="127">&nbsp;</td>
      <td colspan="4"><input type="submit" name="Vo.Bo.1" id="Vo.Bo.1" value="Vo.Bo." /></td>
    </tr>
    <tr>
      <td>Observaciones: </td>
      <td colspan="6"><label for="obs1"></label>
      <input name="obs1" type="text" id="obs1" value="" size="130" /></td>
    </tr>
    <tr>
      <td colspan="7" align="center" bgcolor="#CCCCCC"><em><strong>2. CONCEPTO CARTERA</strong></em></td>
    </tr>
    <tr>
      <td colspan="3">F. Respuesta</td>
      <td>&nbsp;</td>
      <td colspan="3"><input type="submit" name="Vo.Bo.2" id="Vo.Bo.2" value="Vo.Bo." /></td>
    </tr>
    <tr>
      <td>Observaciones:</td>
      <td colspan="6"><label for="obs2"></label>
      <input name="obs2" type="text" id="obs2" size="130" /></td>
    </tr>
    <tr>
      <td colspan="7" align="center" bgcolor="#CCCCCC"><em><strong>3. CONCEPTO INFRAESTRUCTURA TECNOLOGIA Y SISTEMAS</strong></em></td>
      </tr>
    <tr>
      <td colspan="3">F. Respuesta</td>
      <td>&nbsp;</td>
      <td colspan="3"><input type="submit" name="Vo.Bo.3" id="Vo.Bo.3" value="Vo.Bo." /></td>
    </tr>
    <tr>
      <td colspan="3">Observaciones</td>
      <td colspan="4"><label for="obs3"></label>
      <input name="obs3" type="text" id="obs3" size="130" /></td>
    </tr>
    <tr>
      <td colspan="7" align="center" bgcolor="#CCCCCC"><em><strong>4. CONCEPTO INFRAESTRUCTURA Y SERVICIOS</strong></em></td>
    </tr>
    <tr>
      <td colspan="3">F. Respuesta</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="Vo.Bo.4" id="Vo.Bo.4" value="Vo.Bo." /></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">Observaciones </td>
      <td colspan="4"><label for="obs4"></label>
      <input name="obs4" type="text" id="obs4" size="130" /></td>
    </tr>
    <tr>
      <td colspan="7" align="center" bgcolor="#CCCCCC"><em><strong>5. CONCEPTO DE AUDITORIA</strong></em></td>
    </tr>
    <tr>
      <td colspan="3">F. Respuesta</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="Vo.Bo.5" id="Vo.Bo.5" value="Vo.Bo" /></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">Observaciones</td>
      <td colspan="4"><label for="obs5"></label>
      <input name="obs5" type="text" id="obs5" size="130" /></td>
    </tr>
    <tr>
      <td colspan="7" align="center" bgcolor="#CCCCCC"><em><strong>6. CONCEPTO GESTION HUMANA</strong></em></td>
    </tr>
    <tr>
      <td colspan="3">F. Respuesta</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="Vo.Bo.6" id="Vo.Bo.6" value="Vo.Bo." /></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">Observaciones</td>
      <td colspan="4"><label for="obs6"></label>
      <input name="obs6" type="text" id="obs6" size="130" /></td>
    </tr>
    <tr>
      <td colspan="7" align="center" bgcolor="#CCCCCC"><em><strong>7. CONCEPTO FONDO DE EMPLEADO</strong></em></td>
    </tr>
    <tr>
      <td colspan="3">F. Respuesta</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="Vo.Bo.7" id="Vo.Bo.7" value="Vo.Bo." /></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">Observaciones</td>
      <td colspan="4"><label for="obs7"></label>
      <input name="obs7" type="text" id="obs7" size="130" /></td>
    </tr>
    <tr>
      <td colspan="7" align="center" bgcolor="#CCCCCC"><em><strong>8. CONCEPTO NOMINA</strong></em></td>
    </tr>
    <tr>
      <td colspan="3">F. Respuesta</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="Vo.Bo.8" id="Vo.Bo.8" value="Vo.Bo." /></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">Observaciones</td>
      <td colspan="4"><label for="obs8"></label>
      <input name="obs8" type="text" id="obs8" size="130" /></td>
    </tr>
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
