<?php
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

	session_start();
	//$usuingreso= $_SESSION['ced'];



//conexion
try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit();
		}

		/*	$sqle="TRUNCATE TABLE `cliente_interno_queryx`";
			$qry_sqle=$link->query($sqle);
			$rs_qrye=$qry_sqle->fetch_object();  ///consultar */


		 $sqlr = "select * from cliente_interno_queryx";
			$qry_sqlr=$link->query($sqlr);
			$rs_qryr=$qry_sqlr->fetch_object();  ///consultar 
 
		if (isset($rs_qryr)) {
								//elimianr contenido anterior
							 $sqle = "delete from cliente_interno_queryx";
							$qry_sqle=$link->query($sqle);
							//	$rs_qrye=$qry_sqle->fetch_object();  ///consultar 
							  }
							  
		   $sqls = "SELECT cc, nombre FROM `salas` WHERE `activo` = '1' order by nombre";
			$qry_sqls=$link->query($sqls);
			$rs_qrys=$qry_sqls->fetch_object();  ///consultar 
						
		

//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");
//$i= 0;

?>	
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CLIENTE INTERNO</title>
<link rel="stylesheet" type="text/css" href="../estilos1.css"/>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script>
		 function consultarci(sala)
        {	
				var parametros = {
				"sala": sala,
				};
                $.ajax({
                data: parametros,
                url: 'informe_sala.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta").html(response);
						 {
						//document.getElementById('consultar').hidden=true;
						//document.getElementById('sala').hidden=true;
							//document.getElementById('consultar').disabled=true;
						 // document.getElementById('sala').disabled=true;
                        $("#validador").html(response);

                    }
						
                    }
        
        });
        }
		
		
		 function buscaremp(empleado, empresa)
        {	
				var parametros = {
				"empleado": empleado,
				"empresa": empresa,
				};
                $.ajax({
                data: parametros,
                url: 'informe_busqueda.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta").html(response);
						 {
						//document.getElementById('consultar').hidden=true;
						//document.getElementById('sala').hidden=true;
							//document.getElementById('consultar').disabled=true;
						 // document.getElementById('sala').disabled=true;
                        $("#validador").html(response);

                    }
						
                    }
        
        });
        }
		
		
        </script>
        
  </header>

<body>


 
       <h4>
       <table width="70%" border="10" cellpadding="0" cellspacing="0" class="encabezados">
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


<br>
    <br>
  <table width="279" border="0" align="center" style="border-collapse:collapse">
    <tr>
      <td width="273" align="center"  style="font-size:x-large" >SALA DE VENTAS </td>
    </tr>
    <tr>
      <td align="center"  style="font-size:xx-large" ><select style="font-size:28px" name="sala"  id="sala">
        <?php    
			do  
		    {
    	    ?>
        <option value="<?php echo $rs_qrys->cc;?>"> <?php echo  $rs_qrys->nombre; ?></option>
        <?php
   		 }   while ($rs_qrys=$qry_sqls->fetch_object())
  		  ?>
      </select></td>
    </tr>
    <tr>
      <td align="center"  style="font-size:xx-large" ><input name="consultar" type="button" class="botones" id="consultar" onclick= "consultarci($('#sala').val());" value="CONSULTAR" /></td>
    </tr>    
</table>
  
<br>
    <br>
    
<br>
    <br>  
    
    <table width="335" height="120" align="center">
    <tr>
     
      <td colspan="2"  style="font-size:24px" bgcolor="#999999" border="2" align="center" ><em><strong>Busqueda por empleado</strong></em></td>
      </tr>
    <tr>
     
      <td style="font-size:18px" ><label for="buscaremp"></label>
        Empleado          </td>
      <td colspan="-1">
      <input  type="text" value="" name="buscaremp" id="buscaremp" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" "font-size:18px"></td>
    </tr>
    <tr>
      
      <td>Empresa 
        <label for="empresa"></label>
        <select name="empresa" id="empresa">
          <option value="10">Maxicassa</option>
          <option value="60">Pegomax</option>
          <option value="40">Tu Cassa</option>
          <option value="20">Innovapack</option>
      </select></td>
      <td colspan="-1"><input type="submit" name="buscar" id="buscar" value="Buscar Emp" onclick="buscaremp($('#buscaremp').val(),$('#empresa').val())" /></td>
    </tr>
        

  </table>
    <tr>
 <div id="respuesta"></div>
</tr>



  <label></label>
  <blockquote>
    <p><br/>
    </p>
    <p>&nbsp;</p>
  </blockquote>
  <label style="margin-left:100px;width:210px;"></label> 
<blockquote>
    <p>
      </form>
      
      
    </p>
</blockquote>
</body>
</html>