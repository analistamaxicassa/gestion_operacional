<style type="text/css">
.text {font-family:Verdana, Geneva, sans-serif;
	   font-size:11px;
}
</style>

<?php

//session_start();


//recojo variables
$cedula=$_POST['aval'];



//conexion
try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		
		 $query = "SELECT SO.NOMBRE_SOCIEDAD SOCIEDAD,  EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE , CA.CARGO_NOMBRE,  CC.CENCOS_NOMBRE CC 
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
		
	
	
	
$query1 = "SELECT TAUS_NOMBRE, TAUS_CODIGO FROM TRH_TIPO_AUSENTISMO TA where TA.TAUS_CODIGO in ('1','2','4','7','8','9','10','15','17')";
$stmt1 = $dbh->prepare($query1);
		$stmt1->execute();
		$row_n1 = $stmt1->fetch();
		
			
$query2 = "SELECT DIAU_CODIGO, DIAU_NOMBRE FROM TRH_DIAG_AUSEN ORDER BY DIAU_CODIGO";
$stmt2 = $dbh->prepare($query2);
		$stmt2->execute();
		$row_n2 = $stmt2->fetch();
//		$diagnostico = rtrim($row_n['DIAU_NOMBRE']);
		

//$result = $dbh->query($query1);
		
?>	



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
     $.datepicker.regional['es'] = {
     closeText: 'Cerrar',
     prevText: '<Ant',
     nextText: 'Sig>',
     currentText: 'Hoy',
     monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
     monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
     dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
     dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
     dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
     weekHeader: 'Sm',
     dateFormat: 'yy/mm/dd',
     firstDay: 1,
     isRTL: false,
     showMonthAfterYear: false,
     yearSuffix: ''
     };
     $.datepicker.setDefaults($.datepicker.regional['es']);
 
 	 $(function () {
     $("#f_inicial" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  yearRange: '-100:+0'
       });
    });
   
	 $(function () {
     $("#f_final" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  yearRange: '-100:+0'
       });
    });
	</script>
    

</head>
<body style="font-family:Verdana, Geneva, sans-serif; font-size:12px">

<br>
  <table width="884" border="1" align="center" style="border-collapse: collapse; font-size: 12px; text-align: center;">
    <tr>
      <td height="40" colspan="2" align="center"  valign="middle" bgcolor="#99FFFF" style="border-collapse: collapse; font-size: 18px;">INFORMES SELECCION<strong></strong></td>
    </tr>
    <tr>
      <td height="30" align="left" >TIPO DE INCAPACIDAD:
       <select name="codausentismo" id="codausentismo" >   
  		  <?php    
// 		   while ($row_n1 = $stmt1->fetch())  
			do  
		    {
    	    ?>
   
        <option value="<?php echo $row_n1['TAUS_CODIGO'];?>">
      	  <?php echo $row_n1['TAUS_NOMBRE']; ?>
        </option>
       
        <?php
   		 }   while ($row_n1 = $stmt1->fetch())
  		  ?>       
		</select></td>
      <td width="457" height="30" align="left">&nbsp;</td>
    </tr>
    <tr>
      <td height="30" align="left">FECHA INICIAL 
        <label for="f_inicial"></label>
      <input name="f_inicial" type="text"  class="text" id="f_inicial"  value="" required /> 
     
      </td>
      
           
      <td align="left">FECHA FINAL
        <input name="f_final" type="text"  class="text" id="f_final"  value="" required /></td>
    </tr>
    <tr>
      <td height="30" colspan="2" bgcolor="#CCCCCC"><input name="rotacion3" type="reset" id="rotacion3" value="INF ROTACION 3 MESES"/			>
          <input type="submit" name="rotacion6" id="rotacion6" value="INF ROTACION 6" /></td>
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
