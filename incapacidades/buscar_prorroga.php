
<link rel="stylesheet" type="text/css" href="../estilos.css"/>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<?php
//recojo variables
$cedula=$_POST['cedula'];

$id= "NO";

//conexion Queryx
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}

 $queryx = "Select AUS_CONSECUTIVO, to_char(AUS_FECHA_FINAL + 1,'DD/MM/YYYY') AUS_FECHA_FINAL, TAUS_CODIGO, DIAG_CODIGO  from (select * from TRH_AUSENTISMO order by  AUS_CONSECUTIVO desc )
where  EMP_CODIGO = '$cedula' and rownum = 1";
		$stmt = $dbh->prepare($queryx);
		$stmt->execute();
		$row_n1 = $stmt->fetch();
		
		$AUS_CONSECUTIVO = $row_n1['AUS_CONSECUTIVO'];
		 $AUS_FECHA_FINAL = $row_n1['AUS_FECHA_FINAL'];
	    $TAUS_CODIGO = $row_n1['TAUS_CODIGO'] ;
		 $DIAG_CODIGO = $row_n1['DIAG_CODIGO'] ;
		
 $queryx1 = "Select TAUS_NOMBRE from TRH_TIPO_AUSENTISMO
where  TAUS_CODIGO = '$TAUS_CODIGO'";
		
		$stmt1 = $dbh->prepare($queryx1);
		$stmt1->execute();
		$row_n2 = $stmt1->fetch();
		
		$NOMBRE_TAUS = $row_n2['TAUS_NOMBRE'];
		
	 $queryx2 = "Select DIAU_NOMBRE from TRH_DIAG_AUSEN
where  DIAU_CODIGO = '$DIAG_CODIGO'";
		
		$stmt2 = $dbh->prepare($queryx2);
		$stmt2->execute();
		$row_n3 = $stmt2->fetch();
		
		$NOMBRE_DIAU = $row_n3['DIAU_NOMBRE'];
		
				
	$query12 = "SELECT DIAU_CODIGO, DIAU_NOMBRE FROM TRH_DIAG_AUSEN ORDER BY DIAU_CODIGO";
	$stmt12 = $dbh->prepare($query12);
		$stmt12->execute();
		$row_n12 = $stmt12->fetch();
		
		
		
	//	$dato = $AUS_CONSECUTIVO."-".$AUS_FECHA_FINAL."-".$NOMBRE_TAUS;		
		
		
		
		
	
?>	
<script>

	
	</script>
    


<form>
  <div id="prorroga" align="left">
  <p>&nbsp;</p>
  <table width="884" border="1" align="center" style="border-collapse: collapse; font-size: 12px; text-align: center;">
    <tr class="encabezados">
      <td width="213" height="40" align="center" style="border-collapse: collapse; font-size: 18px;"  valign="middle">&nbsp;</td>
      <td colspan="2" align="center" valign="middle"><strong>REPORTE DE INCAPACIDAD</strong></td>
    </tr>
    <tr>
      <td height="30" colspan="2" class="text">CEDULA:
        <label for="cedula"></label>
        <label for="cedula">
          <input name="cedula" type="text" class="textbox" id="cedula" style="background-color:#CCC" value="<?php echo $cedula; ?>" readonly="readonly" />
        </label></td>
      <td class="text">&nbsp;</td>
    </tr>
    <tr>
      <td height="18" colspan="3" bgcolor="#CCCCCC" class="text"><b>DETALLES DE LA INCAPACIDAD</b></td>
    </tr>
    <tr>
      <td height="18" colspan="3" class="encabezados">(La siguiente informacion la encuentra en el documento de incapacidad generado por su entidad de salud)
        <label for="motivo"></label></td>
    </tr>
    <tr>
      <td height="30" colspan="2" align="left" class="text" >TIPO DE INCAPACIDAD:
        
        <label for="tincapacidad"></label>
        <input name="tincapacidad" type="text" id="tincapacidad" style="background-color:#CCC" value="<?php echo $NOMBRE_TAUS; ?>" size="30" readonly="readonly" /></td>
      <td height="30" align="left" class="text"> INCAPACIDAD No
        <label for="numero_inc2"></label>
        <label for="prorroga"></label>
      <input   name="numero_inc" required="required" class="textbox" id="numero_inc" /></td>
    </tr>
    <tr>
      <td height="30" align="left" class="text">FECHA INICIAL
        <label for="f_inicial"></label>
        <span class="formulario">
          <input name="f_inicial" type="text" required="required"  class="textbox" id="f_inicial" style="background-color:#CCC" value="<?php echo $AUS_FECHA_FINAL ?>" readonly="readonly" />
               </td>
      <td width="165" height="30" align="left" class="text">DIAS DE INCAPACIDAD(números) 
      <input  name="ndias" type="text" class="textbox" id="ndias" size="5"
       onchange="sumaFecha( this.value, $('#f_inicial').val())" /></td>
      <td align="left" class="text">FECHA FINAL
<input name="f_final" type="text" disabled="disabled" style="background-color:#CCC"  class="textbox" id="f_final"  value="" readonly="readonly" 	
           /></td>
    </tr>
    <tr>
      <td height="30" colspan="3" align="left" class="text">CODIGO DE DIAGNOSTICO:
        <select name="motivo" id="motivo">
          <option value="<?php echo $DIAG_CODIGO ?>"><?php echo $DIAG_CODIGO." ".$NOMBRE_DIAU; ?></option>
          <?php    

			do  
		    {
    	    ?>
          <option value="<?php echo $row_n12['DIAU_CODIGO'];?>">
            <?php 
			//	$diagnostico = substr($row_n12 ['DIAU_NOMBRE'], 0, 60);
				// echo $row_n12['DIAU_CODIGO']."-".$diagnostico; 
				 echo $row_n12['DIAU_CODIGO']."-".substr($row_n12 ['DIAU_NOMBRE'], 0, 60); ?>
            </option>
          <?php
   		 }   while ($row_n12 = $stmt12->fetch())
  		  ?>
          </select>
        
        REF :
        <input name="referencia" type="text" id="referencia" style="background-color:#CCC" value="<?php echo $AUS_CONSECUTIVO; ?>" size="15" readonly="readonly" /></td>
    </tr>
    <tr>
      <td height="30" colspan="3"  class="text"><input name="entidad" type="text" id="entidad" style="visibility:hidden" size="10" />
        OBSERVACION:
        <input name="observacion" type="text" class="textbox" id="observacion" value="prorroga Incapacidad Queryx No.<?php echo $AUS_CONSECUTIVO ?>" size="100" readonly="readonly" />
        <label for="otro"></label>
        <input name="Enviarpro" type="submit" class="botones" id="Enviarpro" 
        onclick="crearinc('<?php echo $id; ?>',$('#cedula').val(),'<?php echo $TAUS_CODIGO; ?>',$('#numero_inc').val(),$('#f_inicial').val(),$('#f_final').val(),$('#ndias').val(),' ','<?php echo  $DIAG_CODIGO; ?>',$('#observacion').val(), $('#referencia').val() ); return false;"  value="GENERAR PRORROGA"/></td>    </tr>  </table>
       
  </div>
</form>
