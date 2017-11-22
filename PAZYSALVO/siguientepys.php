 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
<link rel="stylesheet" type="text/css" href="../estilos.css"/>

<?php
error_reporting(0);

session_start();
$nomaval= $_SESSION['AVALADOR'];

include "conexion_ares.php";
$link=Conectarse();

$areas=$_POST['area'];
$i=$_REQUEST['rs'];
$nomaval= $_SESSION['AVALADOR'];
$hoy=date("Y-m-d");
$ayer = strtotime ( "-1 day" , strtotime ( $hoy ) ); 
$ayer = date ( 'Y-m-d' , $ayer );



//funcion fechas
require_once("FuncionFechas.php");

//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}

  
//conexion sql
	
	if (($areas == "vb_gcomercialpego") or($areas == "vb_produccion")
		or($areas == "vb_adminpego")or($areas == "vb_despachos"))
		{
		$sql="SELECT cedula, fretiro, flimite, motivo FROM personal_pazysalvo where $areas is null and `pego`= '1' and flimite > '$ayer'";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 
			}	
		else
			{
			$sql="SELECT cedula, fretiro, flimite, motivo FROM personal_pazysalvo where $areas is null and flimite > '$ayer'";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 
			}	

//$sql="SELECT cedula, fretiro, flimite, motivo FROM personal_pazysalvo WHERE $areas is null";
	$qry_sql=$link->query($sql);
	$rs_qry=$qry_sql->fetch_object();  ///consultar 
	do{
	  $vector[]=$rs_qry->cedula;
	  $vector1[]=$rs_qry->fretiro;
	  $vector2[]=$rs_qry->flimite;
  	  $vector3[]=$rs_qry->motivo;

	  
	}while($rs_qry=$qry_sql->fetch_object());

	$total = count($vector);


	if ($i == $total)
	{
		echo "NO EXISTEN MAS REGISTROS";
		 exit();
	}
    $motivo = $vector3[$i];	
    $flimite = $vector2[$i];
    $fretiro = $vector1[$i];
    $cedula = $vector[$i];

	
do{
	$query = "SELECT SO.NOMBRE_SOCIEDAD SOCIEDAD,  EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 					                   NOMBRE , CA.CARGO_NOMBRE,
        CC.CENCOS_NOMBRE CC,EM.EMP_FECHA_INI_CONTRATO, (SUBSTR(EM.EMP_CC_CONTABLE,4,3)) CODCC
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
		$fingreso=$row_n['EMP_FECHA_INI_CONTRATO'];
		$row_n ['CODCC'];
		
		
		
	?>
   
<script>
    
		 function enviaradjunto()
        {	   
                $.ajax({
                data: parametros,
                url: 'enviaradjunto.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#validador").html(response);
						
                    }
        
        });
        }
        </script>
             	<script>
	
	
					
function gsalae(cedula, sala)
{  

window.open("http://190.144.42.83:9090/plantillas/suministros/inventario_emp_pys.php?sala="+sala+"&&empleado="+cedula+"", "Inv Asociado", "width=800, height=500")
//	location.href="http://190.144.42.83:9090/plantillas/suministros/inventario_emp_pys.php?sala="+sala+"&&empleado="+cedula+""
	
	}
	
	function act_elemento(cedula, nomaval)
{
				
		window.open("http://190.144.42.83:9090/plantillas/suministros/cambio_responsable_pys.php?nomaval="+nomaval+"&&empleado="+cedula+"", "Cambio de respobsable", "width=800, height=500")
	
}		


	</script>

  <table class="tablas" width="951" border="4" align="center" >
  <tr>
      <td colspan="6" align="center" valign="middle" class="encabezados"><label><strong>PAZ Y SALVO</strong></label></td>
    </tr>
    <tr>
      <td  bgcolor="#CCCCCC" width="131" >Identificacion</td>
      <td width="160"><label for="cedula"></label><?php echo $cedula; ?></td>
      <td width="179" colspan="-1" bgcolor="#CCCCCC">Nombre</td>
      <td><?php echo $row_n['NOMBRE']; ?>        <label for="motivo"></label></td>
      <td bgcolor="#CCCCCC">Motivo</td>
      <td><?php echo $motivo; ?></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC">Empresa</td>
      <td><?php echo $row_n['SOCIEDAD']; ?>&nbsp;</td>
      <td colspan="-1" bgcolor="#CCCCCC">Centro de Costo</td>
      <td width="197" colspan="-1"><?php echo $row_n['CC']; ?>&nbsp;</td>
      <td width="134" bgcolor="#CCCCCC">Cargo</td>
      <td width="103"><?php echo $cargo; ?></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC">Fecha Ingreso</td>
      <td><?php echo $fingreso ?></td>
      <td colspan="-1" bgcolor="#CCCCCC">Fecha Retiro</td>
      <td class="encabezados"><?php echo $fretiro?>&nbsp;</td>
      <td class="encabezados">FECHA LIMITE </td>
      <td  class="encabezados"><?php echo $flimite; ?></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC">OBSERVACIONES</td>
      <td colspan="3">
      <input name="obs" type="text" class="textbox" id="obs" size="90" />
     </td>
       <?php $difer = strtotime($hoy) - strtotime($flimite);
		if ($difer > 0)	
		{?>
        <script>
        	 document.getElementById('VB_pazysalvo').disabled=true;
		</script>
        <?php
        }?>
      <td><input name="VB_pazysalvo" type="button" class="botones" id="VB_pazysalvo"  style="font-family: Arial; font-size: 10pt" onclick="guardar($('#area').val(), $('#obs').val(),
       '<?php echo $cedula; ?>'); return false;" value="DAR PAZ Y SALVO"/></td>
      <td><input name="siguiente" type="button" class="botones" id="siguiente"onclick="siguiente($('#area').val()); return false;" value="SIGUIENTE" /></td>
    </tr>
    <tr>
      <td height="39" colspan="4" bgcolor="#CCCCCC">
      <form action="guardar_archivo.php" method="post" enctype="multipart/form-data">
        Seleccione el archivo:
        <input name="archivo" type="file" id="archivo" />
        <input type="submit" class="botones" value="Guardar" />
        <br>
  <br>
      </form></td>
      <td height="39" bgcolor="#CCCCCC"><h6><img id="myImage" onclick="gsalae( <?php echo $cedula; ?>, <?php echo $row_n['CODCC']; ?> )" src="../PAZYSALVO/img/utiles.png"  width="99" height="49" alt="Herramientas Asignadas" /></h6>
      <h6>ELEMENTOS ASIGNADOS</h6></td>
      <td height="39" bgcolor="#CCCCCC"><p><img id="myImage2" onclick="act_elemento( '<?php echo $cedula; ?>', '<?php echo $nomaval; ?>')" src="../PAZYSALVO/img/actualizar.png"  width="99" height="49" alt="Herramientas Asignadas" /></p>
      <h6>REASIGNACION DE ELEMENTOS</h6></td>
      <td height="39" bgcolor="#CCCCCC">&nbsp;</td>
  </table>
<?php
	
  exit();
}while($i <= count($vector));
//$contador =  $_SESSION['contador'];


$link->close();
?>

<div>

</div>
          
   


