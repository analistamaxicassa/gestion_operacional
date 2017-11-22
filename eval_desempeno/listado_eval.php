<?php

error_reporting(0);

//recojo variables
$arealis=$_POST['area'];
//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();
$hoy=date("Y-m-d");
$antes = date('Y-m-d', strtotime('-15 day')) ;

?>	

<link rel="stylesheet" type="text/css" href="../estilos.css"/>
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Evaluacion de desempeño</title>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script>
		 function guardar_conc(area, concepto, cedula, id)
        {	//alert(area); alert(concepto); alert(cedula); alert(id); 
				var parametros = {
				"area": area,
				"concepto": concepto,
				"cedula": cedula,
				"id": id,
				};
                $.ajax({
                data: parametros,
                url: 'guardar_concepto_eval.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta").html(response);
						
						
                    }
        
        });
        }
		
		
		
        </script>

</head>
<body>
<form method="post" >
<table width="982" border="0" align="left">
    <tr>
      <td class="encabezados" colspan="9" align="center" valign="middle"><strong>EVALUACION DE DESEMPEÑO</strong>
      </td>
    </tr> 
    <tr>
       <td width="407"> Nombre     </td>
      <td colspan="3">&nbsp;</td>
      <td width="186" bgcolor="#B6BCC3">&nbsp;</td>
    
      
    </tr>
    </table>

<?php
	//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
	//conexion sql	
	
		if (($arealis == "vb_gerencia"))
		{
			$sql="SELECT  id, `ced_evaluado`, `cc`, `cargo`, fecha_evaluacion FROM `eval_desempeno` where  `vb_gerencia` = '' and fecha_evaluacion > date_add(NOW(), INTERVAL -20 DAY)";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 
			
			}	
		if (($arealis == "concepto_gh"))
		{
			$sql="SELECT id, `ced_evaluado`, `cc`, `cargo`, fecha_evaluacion  FROM `eval_desempeno` WHERE `concepto_gh` = '' and fecha_evaluacion > date_add(NOW(), INTERVAL -20 DAY)";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 
			}	
		if (($arealis == "concepto_auditoria"))
			{				
			$sql="SELECT  id, `ced_evaluado`, `cc`, `cargo`, fecha_evaluacion  FROM `eval_desempeno` where  `concepto_auditoria` = '' and fecha_evaluacion > date_add(NOW(), INTERVAL -20 DAY)";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 
			}	
		if (($arealis == ""))
		{ echo "Seleccione su area";
			}	
	
	do{
		
	$id = $rs_qry->id;	
	$cedula = $rs_qry->ced_evaluado;
	$cc = $rs_qry->cc;
	$cargo = $rs_qry->cargo;
	$fecha_evaluacion = $rs_qry->fecha_evaluacion;
			
	
		 $query = "SELECT EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE FROM EMPLEADO EM WHERE EM.EMP_CODIGO = '$cedula'";
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row_n = $stmt->fetch();		
		$row_n['NOMBRE'];
	
		
	
?>
<br>
  <table width="982" border="3" align="left" style="font-size: 14px;"  >
    <tr>
      <td width="279"> <?php echo $row_n['NOMBRE']; ?> Evaluacion de: <?php echo $fecha_evaluacion; ?> </td>
      <td colspan="3"><?php echo $cc; ?>&nbsp;</td>
      <td width="182"><?php echo $cargo; ?></td>
      <td width="182">Concepto: 
        <label>
          <textarea name="concepto" id="concepto<?php echo $id; ?>" cols="45" rows="5"></textarea>
      </label></td>
      <td width="182"><input type="submit" name="guardar" id="guardar" value="Guardar" onClick="guardar_conc($('#area').val(),$('#concepto<?php echo $id; ?>').val(), <?php echo $cedula; ?>,  <?php echo $id; ?>)" /></td>
    
             
    </tr>
  </table>
  </p>
 <div id="respuestax"></div>
</form>


</body>
</html>
<?php
}
while($rs_qry=$qry_sql->fetch_object());	

?>	
