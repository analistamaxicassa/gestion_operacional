<link rel="stylesheet" type="text/css" href="../estilos.css"/>
<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>
         <td width="16%" height="46" class="encabezados" align="center"><img src="../gh/img/logo-gh.png" width="257" height="108"></td>
    <td width="100" align="center" class="encabezados">SOLICITUDES DE GESTION HUMANA</td>
         <td width="25%" align="right"><img src="../gh/img/maxicassa.png" width="316" height="98" class="formulario"></td>
       </tr>
</table> 

<input  type="submit" name="inc_sin_legalizar" id="inc_sin_legalizar" value="Informes de Incapacidades" onclick="informeinc()" />
<?php
include "../PAZYSALVO/conexion_ares.php";

$link=Conectarse();


//recojo variables
//$areas=$_POST['area'];
$i=0;


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

				
$sql="SELECT id, `cedula`, `tipo_incapacidad`, `numero_incapacidad`, `finicial`, `ffinal` , `ndias`, `diagnostico`, `entidad` FROM `incapacidades` WHERE `queryx` = '0' and tipo_incapacidad <> ' ' ";
			$qry_sql=$link->query($sql);
			$rs_qry=$qry_sql->fetch_object();  ///consultar 
			

	if (empty($rs_qry)) {
    echo 'No existen mas registros';
	}
	else
	{
	//$sql="SELECT cedula, tipo_inapacidad, numero_incapacidad, finicial FROM personal_pazysalvo WHERE $areas is null";
	$qry_sql=$link->query($sql);
	$rs_qry=$qry_sql->fetch_object();  ///consultar 
	//echo $i;
	do{
	  $vector[]=$rs_qry->cedula;
	  $vector1[]=$rs_qry->tipo_incapacidad;
	  $vector2[]=$rs_qry->numero_incapacidad;
  	  $vector3[]=$rs_qry->finicial;
   	  $vector4[]=$rs_qry->ffinal;
   	  $vector5[]=$rs_qry->ndias;
   	  $vector6[]=$rs_qry->diagnostico;
   	  $vector7[]=$rs_qry->entidad;
	  $vector8[]=$rs_qry->id;
	  
	
	$entidad = $vector7[$i];	
	$diagnostico = $vector6[$i];	
	$ndias = $vector5[$i];	
	$ffinal = $vector4[$i];	
	$finicial = $vector3[$i];	
	$numero_incapacidad = $vector2[$i];
    $tipo_incapacidad = $vector1[$i];
    $cedula = $vector[$i];
	  $id = $vector8[$i];
	
	
//do{
	$query = "SELECT  EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 					                   NOMBRE FROM EMPLEADO EM WHERE EM.EMP_CODIGO = '$cedula'";
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row_n = $stmt->fetch();
		
		$row_n['NOMBRE'];
	
	?>
          
    
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script>

  function informeinc()
		{
			window.open("informeinc.php", "Buscar empleado", "width=800, 		height=500")
		}	
        
 			
		function guardarinc(id, cedula, tipo_incapacidad, numero_incapacidad, ndias, finicial, ffinal, diagnostico)
        {	
				//var respuesta=confirm("¿Esta seguro?");
     			//if(respuesta==true){
					//alert(id);
        		var parametros = {
				"id": id,
				"cedula": cedula,
				"tipo_incapacidad": tipo_incapacidad,
				"numero_incapacidad": numero_incapacidad,
				"ndias": ndias,
				"finicial": finicial,
				"ffinal": ffinal,
				"diagnostico": diagnostico,
				};
                $.ajax({
                data: parametros,
                url: 'insertar_queryx_incapacidad.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
						
					     document.getElementById('confirmarinc').style.display = 'none';
                        $("#validador").html(response);

                    }
					
        
        });}
		
		 //else
         //return 0;
       // }
		function eliminarinc(id)
        {	
			var respuesta=confirm("¿Esta seguro?");
     			if(respuesta==true){
					//alert(id);
        		var parametros = {
				"id": id,
				};
                $.ajax({
                data: parametros,
                url: 'eliminar_inc.php',
                type: 'post',
                    beforeSend: function () 
                    {
                        $("#validador").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
						
					     document.getElementById('eliminar').disabled=true;
                        $("#validador").html(response);

                    }
					
        
        });}
		else
         return 0;
        }

        </script>
        
<style type="text/css">
        .AA {
	text-align: center;
	font-weight: bold;
	font-size: 18px;
}


        </style>
<div id="validador"></div>
<br>
<table width="951" border="3" align="center" class="formulario">
  <tr>
      <td height="50" colspan="6"  align="left">&nbsp;</td>
      <td height="50" class="AA">&nbsp;</td>
    </tr>
    <tr class="encabezados">
      <td height="50" colspan="7" class="AA">CONFIRMACION DE INCAPACIDADES</td>
    </tr>
    <tr>
      <td width="130" bgcolor="#CCCCCC" class="header">Identificacion</td>
      <td width="170"><label for="cedula"></label><?php echo $cedula; ?></td>
      <td width="158" colspan="-1" bgcolor="#CCCCCC">Nombre</td>
      <td colspan="4"><?php echo $row_n['NOMBRE']; ?></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC">Tipo Incapacidad</td>
      <td>
      <input type="text" name="t_incap" id="t_incap" value="<?php echo $tipo_incapacidad; ?>" /></td>
      <td colspan="-1" bgcolor="#CCCCCC">No incapacidad</td>
      <td width="200" colspan="-1">
                    
          <input type="text" name="No_incap" id="No_incap" value="<?php echo $numero_incapacidad; ?>" />
     </td>
      <td width="133" bgcolor="#CCCCCC">No de Dias</td>
      <td colspan="2">
                 <input type="text" name="diaas_incap" id="diaas_incap" value="<?php echo $ndias; ?>" />
     </td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC">Fecha Inicial</td>
      <td>
      <input type="text" name="f_ini_incap" id="f_ini_incap"  value="<?php echo $finicial ?>"/></td>
      <td colspan="-1" bgcolor="#CCCCCC">Fecha Final</td>
      <td bgcolor="#FFFFFF">
       
      <input type="text" name="f_fin_incap" id="f_fin_incap" value="<?php echo $ffinal ?>" /></td>
      <td bgcolor="#CCCCCC">Entidad  </td>
       <td width="95" bgcolor="#FFFFFF">
         <label for="ent_incap"></label>
       <input name="ent_incap" type="text" id="ent_incap" value="<?php echo $entidad ?>" readonly="readonly" /></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC">Diagnostico</td>
      <td colspan="6">

      <input name="diag_incap" type="text" id="diag_incap" value="<?php echo $diagnostico ?>" size="60" /></td>
    </tr>
    <tr>
      <td height="39" colspan="5" bgcolor="#3B5998"><input type="submit" name="eliminar" id="eliminar" value="Eliminar" onclick="eliminarinc('<?php echo $id; ?>')" /></td>
     
      <td colspan="2" bgcolor="#999999" align="center"><input name="confirmarinc" type="button" class="botones" id="confirmarinc"  style="font-family: Arial; font-size: 10pt" onclick="guardarinc( '<?php echo $id; ?>', '<?php echo $cedula; ?>','<?php echo $tipo_incapacidad; ?>','<?php echo $numero_incapacidad; ?>','<?php echo $ndias; ?>','<?php echo $finicial; ?>','<?php echo $ffinal; ?>','<?php echo $diagnostico; ?>'); return false;" value="CONFIRMAR"/></td>
    </tr>
</table>

<?php
$i = $i+1;
}while($rs_qry=$qry_sql->fetch_object());

  //exit();
//}while($i <= count($vector));
}

?>


          
   


