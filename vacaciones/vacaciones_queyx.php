<?php
error_reporting(0);

session_start();
include "../PAZYSALVO/conexion_ares.php";
$link=Conectarse();

$areas=$_POST['area'];
$i=$_REQUEST['rs'];
$nomaval= $_SESSION['AVALADOR'];
$hoy=date("Y-m-d");
$ayer = strtotime ( "-1 day" , strtotime ( $hoy ) ); 
$ayer = date ( 'Y-m-d' , $ayer );



//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");

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

  <table width="950" border="3" align="center">
    <tr>
      <td width="132" bgcolor="#CCCCCC">Identificacion</td>
      <td width="222"><label for="cedula"></label><?php echo $cedula; ?></td>
      <td width="119" colspan="-1" bgcolor="#CCCCCC">Nombre</td>
      <td><?php echo $row_n['NOMBRE']; ?>        <label for="motivo"></label></td>
      <td bgcolor="#CCCCCC">Motivo</td>
      <td><?php echo $motivo; ?></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC">Empresa</td>
      <td><?php echo $row_n['SOCIEDAD']; ?>&nbsp;</td>
      <td colspan="-1" bgcolor="#CCCCCC">Centro de Costo</td>
      <td width="198" colspan="-1"><?php echo $row_n['CC']; ?>&nbsp;</td>
      <td width="135" bgcolor="#CCCCCC">Cargo</td>
      <td width="100"><?php echo $cargo; ?></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC">Fecha Ingreso</td>
      <td><?php echo $fingreso ?></td>
      <td colspan="-1" bgcolor="#CCCCCC">Fecha Retiro</td>
      <td bgcolor="#FF9933"><?php echo $fretiro?>&nbsp;</td>
      <td bgcolor="#33FF00">FECHA LIMITE </td>
      <td bgcolor="#33FF00"><?php echo $flimite; ?></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC">OBSERVACIONES</td>
      <td colspan="3">
      <input name="obs" type="text" id="obs" size="90" /></td>
       <?php $difer = strtotime($hoy) - strtotime($flimite);
		if ($difer > 0)	
		{?>
        <script>
        	 document.getElementById('VB_pazysalvo').disabled=true;
		</script>
        <?php
        }?>
      <td bgcolor="#33FF00"><input type="button"  style="font-family: Arial; font-size: 10pt" name="VB_pazysalvo" id="VB_pazysalvo" value="DAR PAZ Y SALVO" onclick="guardar($('#area').val(), $('#obs').val(),
       '<?php echo $cedula; ?>'); return false;"/></td>
      <td bgcolor="#33FF00"><input type="button" name="siguiente" id="siguiente" value="SIGUIENTE"onclick="siguiente($('#area').val()); return false;" /></td>
    </tr>
    <td height="39" bgcolor="#CCCCCC">&nbsp;</td>
      <td colspan="3">
     <form action="../PAZYSALVO/guardar_archivo.php" method="post" enctype="multipart/form-data">
Seleccione el archivo:
  <input type="file" name="archivo" id="archivo" />
  <input type="submit" value="Guardar" />
  <br>
<br>
     </form></td>
      <td bgcolor="#33FF00">&nbsp;</td>
      <td colspan="2" bgcolor="#33FF00">&nbsp;</td>
</table>
<?php
	
  exit();
}while($i <= count($vector));
//$contador =  $_SESSION['contador'];


$link->close();
?>


          
   


