<?php

//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");


//recojo variables
$cedula=$_POST['cedula'];


/*//conexion QUERYS
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}*/

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

		$sql2="SELECT `id_hijo`, `nombre_hijo`, `apellido_hijo`, `genero`, `f_nacimiento`, `educacion`, `colegio`, programa,  `grado`, `jornada`, `aficiones`, `talento` FROM `hijos` WHERE `cod_empleado` = '$cedula' ";
		$qry_sql2=$link->query($sql2);
			$rs_qry2=$qry_sql2->fetch_object();  ///consultar 
			
			if (empty($rs_qry2)) {
   						 echo 'No existen registros';
						exit;
								}
		
		
		
		
		 
?>
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ares::Actualizacion de información</title>
<link rel="stylesheet" type="text/css" href="../estilos.css">
<script>
function actualizar(cedula)
  {   
				var parametros = {
				"cedula": cedula,
				          	};
				$.ajax({
                data: parametros,
                url: 'http://190.144.42.83:9090/plantillas/actualiza_hijos/actualizar_datoshijos.php',
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


</head>
<body>


    
       <table width="98%" border="1">
         <tr class="encabezados">
           <th  scope="col">Nro</th>
           <th  scope="col">Nombre</th>
           <th  scope="col">Genero</th>
           <th scope="col">Fecha Nacimiento</th>
           <th  scope="col">Educación </th>
           <th  scope="col"><p>Programa </p>
           <p style="font-size:9px">(Solo aplica en Educación superior)</p></th>
           <th  scope="col">Institucion</th>
           <th scope="col">Grado</th>
           <th  scope="col">Jornada</th>
           <th  scope="col">Aficiones</th>
           <th  scope="col"><p>Talentos</p></th>
         </tr>
          <?php
     do{
     ?>
         <tr style="font-size:10px">
           <th scope="col"><?php echo $rs_qry2->id_hijo; ?>
            </th>
           <th scope="col"><?php echo $rs_qry2->nombre_hijo." ".$rs_qry2->apellido_hijo; ?></th>
           <th scope="col"><?php echo $rs_qry2->genero; ?></th>
           <th scope="col"><?php echo $rs_qry2->f_nacimiento; ?></th>
           <th scope="col"><?php echo $rs_qry2->educacion; ?></th>
           <th scope="col"><?php echo $rs_qry2->programa; ?></th>
           <th scope="col"><?php echo $rs_qry2->colegio; ?></th>
           <th scope="col"><?php echo $rs_qry2->grado; ?></th>
           <th scope="col"><?php echo $rs_qry2->jornada; ?>       </th>
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
         <input type="submit" name="salir" id="salir" value="SALIR" onclick="window.location.href='http://190.144.42.83/ares/index.php';" />
         <input type="submit" name="actualizar" id="actualizar" value="ACTUALIZAR DATOS" onclick="actualizar('<?php echo $cedula;?>')" />
       </p>

<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
