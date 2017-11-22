<?php

//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");

//recojo variables
$id=$_POST['id'];
$educacion=$_POST['educacion'];
$programa=$_POST['programa'];
$colegio=$_POST['colegio'];
$grado=$_POST['grado'];
$jornada=$_POST['jornada'];
$aficiones=$_POST['aficiones'];
$talentos=$_POST['talentos'];


/*//conexion QUERYS
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}*/

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

$sql1="UPDATE `personal`.`hijos` SET `educacion` = '$educacion', `programa` = '$programa', `colegio` = '$colegio', `grado` = '$grado', `jornada` = '$jornada', `aficiones` = '$aficiones', `talento` = '$talentos' WHERE `hijos`.`id` = '$id'";
		$qry_sql1=$link->query($sql1);
		

		
		
		
		$sql2="SELECT `id_hijo`, `nombre_hijo`,`apellido_hijo`, `genero`, `f_nacimiento`, `educacion`, `programa`, `colegio`, `grado`, `jornada`, `aficiones`, `talento` FROM `hijos` WHERE `hijos`.`id` = '$id'";
		$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
				
				// $rs_qry->id_hijo;
		
		
		
		
		 
?>
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>Actualizacion Datos</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="../estilos.css">
 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


</head>
<body>

	 <form>
    
       <table width="90%" border="1">
         <tr>
           <th scope="col">Nro</th>
           <th scope="col">Nombre</th>
           <th scope="col">Genero</th>
           <th scope="col">Fecha Nacimiento</th>
           <th scope="col">Educacion</th>
           <th scope="col">Programa</th>
           <th scope="col">Colegio</th>
           <th scope="col">Grado</th>
           <th scope="col">Jornada</th>
           <th scope="col">Aficiones</th>
           <th scope="col"><p>Talentos</p></th>
         </tr>
          <?php
     do{
     ?>
         <tr>
           <th scope="col"><?php echo $rs_qry2->id_hijo; ?></th>
           <th scope="col"><?php echo $rs_qry2->nombre_hijo." ".$rs_qry2->apellido_hijo; ?></th>
           <th scope="col"><?php echo $rs_qry2->genero; ?></th>
           <th scope="col"><?php echo $rs_qry2->f_nacimiento; ?></th>
           <th scope="col"><?php echo $rs_qry2->educacion; ?></th>
           <th scope="col"><?php echo $rs_qry2->programa; ?></th>
           <th scope="col"><?php echo $rs_qry2->colegio; ?></th>
           <th scope="col"><?php echo $rs_qry2->grado; ?></th>
           <th scope="col"><?php echo $rs_qry2->jornada; ?></th>
           <th scope="col"><?php echo $rs_qry2->aficiones; ?></th>
           <th scope="col"><?php echo $rs_qry2->talento; ?></th>
         </tr>
     
       <?php
		}
		while($rs_qry2=$qry_sql2->fetch_object());	
		?>
      </table>
       <p>
        
         <label for="cedula"></label>
         <input type="text" name="cedula" id="cedula" style="display:none" value="<?php echo $cedula; ?>"  readonly="readonly" />
       </p>
       <p>
         <input type="submit" name="salir" id="salir" value="SALIR" onclick="window.location.href='http://190.144.42.83/ares/index.php';"/>
       </p>
	 </form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
