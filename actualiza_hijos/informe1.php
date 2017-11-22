<?php

//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");


//conexion QUERYS
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

$cedulapost = '0';
$i = 1;

 $sql1="SELECT cod_empleado  FROM `hijos` order by cod_empleado";
		$qry_sql1=$link->query($sql1);
			$rs_qry1=$qry_sql1->fetch_object();  ///consultar 
			
		 $cedula=$rs_qry1->cod_empleado;
			
	
			
		
			
?>
   
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ares::Actualizacion de información</title>
<link rel="stylesheet" type="text/css" href="../estilos.css">
</head>
<body>

	 <form>
    
       <table width="90%" border="1">
         <tr class="encabezados">
           <th scope="col">Cedula </th>
           <th scope="col">Empleado</th>
           <th scope="col">C.C.</th>
           <th scope="col">Nombre hijo(a)</th>
           <th scope="col">Genero</th>
           <th scope="col">F. nacimeinto</th>
         </tr>

<?php
   do{
	   
	   $sql3="SELECT max(id_hijo) mid FROM `hijos` WHERE `cod_empleado` = '$rs_qry1->cod_empleado' ";
		$qry_sql3=$link->query($sql3);
			$rs_qry3=$qry_sql3->fetch_object();  ///consultar 
			
				
$query = "SELECT EMP.EMP_NOMBRE||' '||EMP.EMP_APELLIDO1||' '||EMP.EMP_APELLIDO2 NOMBRE, CC.CENCOS_NOMBRE CC
FROM EMPLEADO EMP, centro_costo cc
WHERE  EMP.EMP_CODIGO = '$rs_qry1->cod_empleado' and  CC.CENCOS_CODIGO = EMP.EMP_CC_CONTABLE" ;

		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch();	
		
		//$nombre=$row['NOMBRE'];

 $sql2="SELECT `id_hijo`, `nombre_hijo`, `apellido_hijo`, `genero`, `f_nacimiento`, `colegio`, `grado`, `jornada`, `aficiones`, `talento` FROM `hijos` WHERE `cod_empleado` = '$rs_qry1->cod_empleado' and id_hijo = $i";
		$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
			
			if (empty($rs_qry2)) {
   						 echo 'No existen registros';
						exit;
								}
		
		
		
		
		 
?>
			        
         <tr>
           <th scope="col"><?php echo  $rs_qry1->cod_empleado; ?></th>
           <th scope="col"><?php echo $row['NOMBRE']; ?></th>
           <th scope="col"><?php echo $nombre=$row['CC']; ?></th>
           <th scope="col"><?php echo $rs_qry2->nombre_hijo." ".$rs_qry2->apellido_hijo; ?></th>
           <th scope="col"><?php echo $rs_qry2->genero; ?></th>
           <th scope="col"><?php echo $rs_qry2->f_nacimiento; ?></th>
         </tr>
     
       <?php

		 
			  if ($i < $rs_qry3->mid)
		 	{ 
				  $i = $i+1;
				
			 } 
			 
			 
			else
			{$i=1;}
		 }
		 
		while($rs_qry1=$qry_sql1->fetch_object());	
		?>
      </table>
       
       <p>
         <input type="submit" name="salir" id="salir" value="SALIR" onclick="window.location.href='http://190.144.42.83/ares/index.php';" />
       </p>
	 </form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
