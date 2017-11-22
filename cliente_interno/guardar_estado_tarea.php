  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

<?php

//error_reporting(0);

 $estado = $_REQUEST['estado'];
 $fnueva = $_REQUEST['fnueva'];


require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

 echo $sql="UPDATE `personal`.`concepto_sala` SET `CUMPLIDO` = '1' WHERE `concepto_sala`.`id` = $id;";

/* $sql="SELECT `fecha`,`concepto_esp`, `hallazgo`, `tarea`, `responsable`,`fecha_control` FROM `concepto_sala` WHERE cumplida = '0' and `cc` = '$sala'  and tarea <> ''";*/
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 
		
	if (empty($rs_qry)) {
    echo 'Esta sala no tiene tareas pendientes';
	exit();
	}
	else {
		?>	
	<?php	
		


	?>
    
<!DOCTYPE html>
 
<html lang="es">
 
<head>


<title>CLIENTE INTERNO</title>
<meta charset="utf-8" />

<link rel="stylesheet" type="text/css" href="../estilos.css">    
    
<script src="//code.jquery.com/jquery-1.10.2.js"></script>

</head>

<body>



    <header>
       <h4>

       <table width="70%" border="10" cellpadding="0" cellspacing="0">
       <tr style="background-color:transparent">
         <td width="26%" height="46"><img src="../gh/img/logo-gh.png" width="185" height="46"></td>
         <td width="50%" align="center" valign="middle"><div style="font-family:Verdana, Geneva, sans-serif; font-size:12px; width:600px; height:60px; text-align:center" class="intro_tk">
     <br>
     <b style="color:#333">CLIENTE INTERNO</b></div>
    </td>
         <td align="right">
         <img src="../gh/img/maxicassa.png" width="279" height="44">
         </td>
       </tr>
       </table>
	 </h4>
     </header>

 
<p><br> 
</p>
<p>&nbsp;</p>
<p><br>
  <br>
</p>
<table  align="center" width="85%" border="1">
    <tr class="encabezados">
      <th colspan="7" class="encabezados" scope="row">INFORME DE SEGUIMIENTO</th>
    </tr>
    <tr>
      <th colspan="7" scope="row">Sala: <?php echo $sala ?></th>
    </tr>
    <tr>
      <th scope="row">FECHA</th>
      <th scope="row">CONCEPTO</th>
      <th scope="row">HALLAZGO</th>
      <th scope="row">TAREA</th>
      <th scope="row">RESPONSABLE</th>
      <th scope="row">FECHA DE CONTROL</th>
      <th scope="row">NUEVO ESTADO</th>
    </tr>
    
  <?php
do{
?>
    <tr>
      <th><?php echo $rs_qry->fecha ?></th>
        
      <th><?php echo $rs_qry->concepto_esp  ?></th>
      <th><?php echo $rs_qry->hallazgo ?></th>
      <td><?php echo $rs_qry->tarea ?></td>
      <td><?php echo $rs_qry->responsable?></td>
      <td><?php echo $rs_qry->fecha_control ?></td>
      <td><label>
        <select name="nvoestado" id="nvoestado" onBlur="cambioestado(this.value)">
          <option value="1">CUMPLIDO</option>
          <option value="0">APLAZADO</option>
        </select>
      </label></td>
    </tr>
 

<?php
  }
while($rs_qry=$qry_sql->fetch_object());
  
?>
 </table>

<p>&nbsp;</p>
<br>
<br>
<br>
<?php	
  		} 
	?>

    <footer>
    
    </footer>
</body>
</html>
