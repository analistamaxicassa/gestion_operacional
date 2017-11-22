
<?php 
error_reporting(0);

//$cedulaent = $_REQUEST['cedula'];
$cedulaent = '52522883';
$hoy = date('Y-m-d') ;


require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();



//session_start();  
//$cedulaent = $_SESSION['cedula'];


	//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}


	
// consulta en queryx anterior para corregir no sirve en cambio de año
$query = "SELECT EMP.EMP_CODIGO CEDULA ,EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE,EMP.EMP_FECHA_INGRESO INGRESO, CC.CENCOS_NOMBRE CCNOMBRE,
 EMP.EMP_CC_CONTABLE CODCC ,TO_NUMBER(to_date (SYSDATE) - to_date (EMP.EMP_FECHA_INGRESO)) AS DIAS,
  EMP.EMP_CARGO CARGO FROM EMPLEADO EMP, CENTRO_COSTO CC
  WHERE EMP.EMP_CC_CONTABLE = CC.CENCOS_CODIGO AND EMP.EMP_ESTADO <> 'R' and EMP.EMP_CC_CONTABLE like '70%' 
    order by dias" ;

		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch();	
	do  
		    {	
		 $cedulae=$row['CEDULA'];	
			$nombre=$row['NOMBRE'];
		
 $sql2="Select ced_evaluado from eval_desempeno where ced_evaluado = '$cedulae'	"; 
$qry_sql2=$link->query($sql2);
$rs= $qry_sql2->fetch_object();



if ($rs->ced_evaluado=='') {  
 	
	$sql3="INSERT INTO `personal`.`eval_desempeno` (`id`, `ced_evaluado`, `nombre`, `ced_evaluador`, `fecha_evaluacion` , `periodo`, `empresa`,  `item_aspecto`, `valor_aspecto`, `obs_aspecto`, `fortalezas`, `oportunidades`, `mejoras`, `obs_evaluador`, `procesos_disc`, `concepto_gh`, `concepto_auditoria`, `Contrataxempresa`, `vb_gerencia`) VALUES ('', '$cedulae',  '$nombre', '$cedulaent', '$hoy', '',  '', '', '', '', '', '', '', '', '', '', '', '', '');"; 
	
		$qry_sql3=$link->query($sql3);
			}
 else{}
 }
 

    while ($row = $stmt->fetch());
 

 $sql5="Select ced_evaluado, nombre from eval_desempeno "; 		
			$qry_sql5=$link->query($sql5);
			$rs5=$qry_sql5->fetch_object();

	$rs5->ced_evaluado;

?>



</table>


<!doctype html>
<html lang="en">
<head>
   


<style type='text/css'>
tr:nth-child(odd) {
    background-color:#f2f2f2;
}
tr:nth-child(even) {
	background-color: #fbfbfb;
	
	
}
</style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CLIENTE INTERNO</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="../estilos.css">
 
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

  <script>     
     function val_ced(cedula, cedulaent)
{ 
				var parametros = {
				"cedula": cedula,
				"cedulaent": cedulaent,
				};
				 $.ajax({
                data: parametros,
                url: 'muestra_datos.php?cedula='+cedula+', cedulaent='+cedulaent+'',
                type: 'post',
                   beforeSend: function () 
                   {
                        $("#entrevista").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#entrevista").html(response);
					//document.getElementById('tbl_ppal').style.display="none"	
                    }
					  });		

}
 
		
		
        </script>
        
         <script>     
     function val_ced_imp(cedula)
{ 
				var parametros = {
				"cedula": cedula,
				};
				 $.ajax({
                data: parametros,
                url: 'imprimir_entrevista.php?cedula='+cedula+'',
                type: 'post',
                   beforeSend: function () 
                   {
                        $("#entrevista").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#entrevista").html(response);
					//document.getElementById('tbl_ppal').style.display="none"	
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
</head>
<body>

<br> <br> <br> <br><br> <br> <br>


  
  <table width="830" border="0" align="center"  style="border-collapse:collapse">
    
    <tr>
      <td colspan="4" align="left" valign="middle"><strong>NOMBRE DEL EMPLEADO</strong></td>
      <td  colspan="6"  align="justify" >
     
        <select name="jefe" id="jefe" onchange="val_ced(this.value,  <?php echo $cedulaent; ?>)"> 
        <option value="">seleccione... </option>
              <?php    
// 		   while ($row_n1 = $stmt1->fetch())  
			do  
		    {
    	    ?>
          <option value="<?php echo $rs5->ced_evaluado;?>">
                <?php echo $rs5->nombre; ?>
              </option>
              
              <?php
   		 }   while ($rs5=$qry_sql5->fetch_object())
  		  ?>       
            </select></td>
    </tr>
 
</table>       

 <p>&nbsp;</p>
 <p>&nbsp;</p>
 <p>&nbsp;</p>
 <div id="entrevista" ></div>
 
  <table width="830" border="0" align="center"  style="border-collapse:collapse">
    
    <tr>
      <td colspan="4" align="left" valign="middle"><strong>Imprimir Evaluacion anteriores</strong></td>
      <td width="415"  colspan="6"  align="justify" >Cedula: 
       <input type="text" name="buscarcedula" id="buscarcedula">
      <input type="submit" name="consultar" id="consultar" onClick="val_ced_imp($('#buscarcedula').val())"   value="Consultar"></td>
    </tr>
 
</table> 
