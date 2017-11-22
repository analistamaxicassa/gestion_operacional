<?php

//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");

//recojo variables
$ubicacion=$_POST['ubicacion'];
$nhijos=$_POST['nhijos'];
$empresa=$_POST['empresa'];
$cedula=$_POST['cedula'];
$id_hijo=$_POST['id_hijo'];
$tdoc_identidad=$_POST['tdoc_identidad'];
$doc_identidad=$_POST['doc_identidad'];
$nombre_hijo=$_POST['nombre_hijo'];
$apellido_hijo=$_POST['apellido_hijo'];
$genero=$_POST['genero'];
$f_nacimiento=$_POST['f_nacimiento'];
$noestudia=$_POST['noestudia'];
$basica=$_POST['basica'];
$superior=$_POST['superior'];
$colegio=$_POST['colegio'];
$grado=$_POST['grado'];
$programa=$_POST['carrera'];
$jornada=$_POST['jornada'];
$aficiones=$_POST['aficiones'];
$talentos=$_POST['talentos'];
$trabaja=$_POST['trabaja'];
$hoy=date("y/m/d");



/*//conexion QUERYS
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}*/

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

if($noestudia <> "")
	{
	$educacion = $noestudia;
	}
if($basica <> "")
	{
	$educacion = $basica;
	}
if($superior <> "")
	{
	$educacion = $superior;
	}

$sql1="INSERT INTO `personal`.`hijos` (`id`,  `ubicacion`,  `nhijos`, `empresa`, `cod_empleado`, `id_hijo`,  `tipo_doc`,`doc_identidad`, `nombre_hijo`, `apellido_hijo`, `genero`, `f_nacimiento`, `educacion`, `colegio`, `grado`, `programa`, `jornada`, `aficiones`, `talento`, `trabaja`, `f_actualizacion`) VALUES (NULL,  '$ubicacion', '$nhijos', '$empresa', '$cedula', '$id_hijo', '$tdoc_identidad', '$doc_identidad', '$nombre_hijo', '$apellido_hijo', '$genero', '$f_nacimiento', '$educacion', '$colegio', '$grado', '$programa', '$jornada', '$aficiones', '$talentos', '$trabaja',  '$hoy')";
		$qry_sql1=$link->query($sql1);
		
		echo  "<font color='blue'; font-size:35px;>REGISTRO AGREGARDO<br></font>";
		
		
		
		$sql2="SELECT `id_hijo`, `nombre_hijo`,`apellido_hijo`, `genero`, `f_nacimiento`, `colegio`, `grado`, `jornada`, `aficiones`, `talento` FROM `hijos` WHERE `cod_empleado` = '$cedula' ";
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
<script>
 function guardarotrohijo(cedula)  
        {   
				
				var parametros = {
			    "aval": cedula,
			              	};
				$.ajax({
                data: parametros,
				url: 'http://190.144.42.83:9090/plantillas/actualiza_hijos/formato_actualiza.php',
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
				
		 $(function () {
     $("#f_nacimiento" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  yearRange: '-100:+0'
       });
    });
	


</script>
</head>
<body>

	 <form>
    
       <table width="90%" border="1">
         <tr>
           <th scope="col">Nro</th>
           <th scope="col">Nombre</th>
           <th scope="col">Genero</th>
           <th scope="col">Fecha Nacimiento</th>
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
         
         <input type="submit" name="otro_hijo" id="otro_hijo" value="Agregar mas hijos" 
         onclick="guardarotrohijo($('#cedula').val()); return false;" />
         
        
       </p>
       <p>&nbsp;</p>
       <p>
         <input type="submit" name="salir" id="salir" value="SALIR" onclick="window.location.href='http://190.144.42.83/ares/index.php';"/>
       </p>
	 </form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
