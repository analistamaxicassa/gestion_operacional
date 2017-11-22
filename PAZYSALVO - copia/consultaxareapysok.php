<link rel="stylesheet" type="text/css" href="../estilos.css"/>

<?php
include "conexion_ares.php";
error_reporting(0);

$link=Conectarse();
$hoy=date("Y-m-d");

//recojo variables
$areas=$_POST['area'];
$i=0;


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
			$sql="SELECT cedula, fretiro, flimite FROM personal_pazysalvo where $areas is null and `pego` is not null";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 
			}	
		else
			{				
			$sql="SELECT cedula, fretiro, flimite FROM personal_pazysalvo where $areas is null";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 
			}	

	
	//$sql="SELECT cedula, fretiro, flimite FROM personal_pazysalvo WHERE $areas is null";
	$qry_sql=$link->query($sql);
	$rs_qry=$qry_sql->fetch_object();  ///consultar 
	do{
	  $vector[]=$rs_qry->cedula;
	  $vector1[]=$rs_qry->fretiro;
	  $vector2[]=$rs_qry->flimite;
	}while($rs_qry=$qry_sql->fetch_object());
	
	$flimite = $vector2[0];
    $fretiro = $vector1[0];
    $cedula = $vector[0];
do{
	$query = "SELECT SO.NOMBRE_SOCIEDAD SOCIEDAD,  EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 					                   NOMBRE , CA.CARGO_NOMBRE,
        CC.CENCOS_NOMBRE CC,EM.EMP_FECHA_INI_CONTRATO
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
		
	
	?>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script>
    
		 function enviaradjunto()
        {	    alert ("hola ingrese")
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
        
        <table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>
         <td width="16%" height="46" class="encabezados" align="center"><img src="../gh/img/logo-gh.png" width="257" height="108"></td>
    <td width="100" align="center" class="encabezados">PROCESO DE GESTION HUMANA</td>
         <td width="25%" align="right"><img src="../gh/img/maxicassa.png" width="268" height="98" class="formulario"></td>
       </tr>
       </table>
  <br>
    <br>

  <table width="951" border="3" align="center">
    <tr class="encabezados">
      <td colspan="5" align="center">GESTION DE PAZ Y SALVO</td>
    </tr>
    <tr class="formulario">
      <td width="130"><span class="formulario">Identificacion</span></td>
      <td width="170"><span class="formulario"><?php echo $cedula; ?></span></td>
      <td width="158" colspan="-1"><span class="formulario">Nombre</span></td>
      <td colspan="2"><span class="formulario"><?php echo $row_n['NOMBRE']; ?></span></td>
    </tr>
    <tr>
      <td><span class="formulario">Empresa</span></td>
      <td><span class="formulario"><?php echo $row_n['SOCIEDAD']; ?>&nbsp;</span></td>
      <td colspan="-1"><span class="formulario">Centro de Costo</span></td>
      <td width="200" colspan="-1"><span class="formulario"><?php echo $row_n['CC']; ?>&nbsp;</span></td>
      <td width="133"><span class="formulario">Cargo</span></td>
      <td colspan="2"><span class="formulario"><?php echo $cargo; ?></span></td>
    </tr>
    <tr>
      <td><span class="formulario">Fecha Ingreso</span></td>
      <td><span class="formulario"><?php echo $fingreso ?></span></td>
      <td colspan="-1"><span class="formulario">Fecha Retiro</span></td>
      <td><span class="formulario"><?php echo $fretiro?>&nbsp;</span></td>
      <td><span class="formulario">FECHA LIMITE  </span></td>
       <td width="95"><span class="formulario"><?php echo $flimite ?></span></td>
    </tr>
    <tr>
      <td><span class="formulario">OBSERVACIONES</span></td>
      <td colspan="3">
        <span class="formulario">
        <input name="obs" type="text" id="obs" size="90" />
      </span></td>
      <?php $difer = strtotime($hoy) - strtotime($flimite);
		if ($difer > 0)	
		{?>
        <script>
        	 document.getElementById('VB_pazysalvo').disabled=true;
		</script>
        
        <?php
        }?>
      <td><span class="formulario">
      <input name="VB_pazysalvo" type="button" class="botones" id="VB_pazysalvo"  style="font-family: Arial; font-size: 10pt" onclick="guardar($('#area').val(), $('#obs').val(),'<?php echo $cedula; ?>'); return false;" value="DAR PAZ Y SALVO"/>
      </span></td>
      <td colspan="2"><span class="formulario">
      <input name="siguiente" type="button" class="botones" id="siguiente"onclick="siguiente($('#area').val()); return false;" value="SIGUIENTE" />
      </span></td>
    </tr>
    
</table>
<?php
  exit();
}while($i <= count($vector));


?>


          
   


