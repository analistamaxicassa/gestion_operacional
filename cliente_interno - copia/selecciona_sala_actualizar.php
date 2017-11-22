<?php
require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();


//conexion
try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit();
		}

		 $sqlr = "select * from cliente_interno_queryx";
			$qry_sqlr=$link->query($sqlr);
			$rs_qryr=$qry_sqlr->fetch_object();  ///consultar 
 
		if (isset($rs_qryr)) {
								//elimianr contenido anterior
							 $sqle = "delete from cliente_interno_queryx";
							$qry_sqle=$link->query($sqle);
							//	$rs_qrye=$qry_sqle->fetch_object();  ///consultar 
							  }

	
$query1 = "SELECT EM.EMP_CODIGO, EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE FROM EMPLEADO EM WHERE EM.EMP_MARCA_TARJETA = 'S' and EM.EMP_ESTADO <> 'R' order by EM.EMP_NOMBRE ";
$stmt1 = $dbh->prepare($query1);
		$stmt1->execute();
		$row_n1 = $stmt1->fetch();
		
	
		

//$result = $dbh->query($query1);
		


//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");
//$i= 0;

?>	
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link rel="stylesheet" type="text/css" href="../estilos.css"/>

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
                url: 'informe_cliente_interno.php',
                type: 'post',
                   beforeSend: function () 
                    {
                        $("#respuesta").html("Validando, espere por favor...");
                    },
        
                    success: function (response) 
                    {
                        $("#respuesta").html(response);
						
						
                    }
        
        });
        }
		
		
        </script>
        
</head>


<body style="font-family:Verdana, Geneva, sans-serif; font-size:16px" >

 <table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>
         <td width="16%" height="46" class="encabezados" align="center"><img src="../gh/img/logo-gh.png" width="260" height="92"></td>
    <td width="100" align="center" class="encabezados">PROCESO DE GESTION HUMANA</td>
         <td width="25%" align="right"><img src="../gh/img/maxicassa.png" width="268" height="98" class="formulario"></td>
       </tr>
       </table>

  <br>
    <br>
  <table width="830" border="1" align="center" class="formulario" style="border-collapse:collapse">
    <tr>
      <td colspan="6" align="center" valign="middle" class="encabezados">
        <label><strong>INFORME DE CLIENTE INTERNO</strong></label></td>
    </tr>
    <tr>
      <td width="121">SALA DE VENTAS</td>
      <td colspan="3">
        <select name="sala" id="sala">
              <option value="555">CERAAGUACHICA</option>
              <option value="521">CERAALCIBIA</option>
              <option value="641">CERAARMENIA</option>
              <option value="742">CERAATALAYA</option>
              <option value="701">CERABUCARAMANGA</option>
              <option value="501">CERABARRANQUILLA</option>
              <option value="402">CERABELLO</option>
              <option value="105">CERABOSA</option>
              <option value="201">CERACALI</option>
              <option value="741">CERACUCUTA</option>
              <option value="802">CERADUITAMA</option>
              <option value="523">CERA EL EDEN</option>
              <option value="151">CERAGIRARDOT</option>
              <option value="552">CERAGUATAPURI</option>
              <option value="822">CERAIBAGUE</option>
              <option value="821">CERAJARDIN</option>
              <option value="554">CERAKENNEDY</option>
              <option value="502">CERALA43</option>
              <option value="522">CERAMAGANGUE</option>
              <option value="671">CERAMANIZALEZ</option>
              <option value="441">CERAMONTERIA</option>
              <option value="152">CERAMOSQUERA</option>
              <option value="601">CERAPEREIRA</option>
              <option value="591">CERARIOHACHA</option>
              <option value="401">CERASAN BENITO</option>
              <option value="104">CERASANTA LUCIA</option>
              <option value="571">CERASANTA MARTA</option>
              <option value="541">CERASINCELEJO</option>
              <option value="803">CERASOGAMOSO</option>
              <option value="103">CERASUBA</option>
              <option value="801">CERATUNJA REAL</option>
              <option value="553">CERAVALLEDUPAR</option>
              <option value="102">CERAVENECIA</option>
              <option value="836">CERAVILLAVICENCIO</option>
              <option value="153">CERAZIPAQUIRA</option>
              <option value="128">MAXBOSA</option>
              <option value="221">MAXCALI</option>
              <option value="511">MAXCALLE 30</option>
              <option value="531">MAXCARTAGENA</option>
              <option value="533">MAXEL EDEN</option>
              <option value="127">MAXFONTIBON</option>
              <option value="721">MAXLA AURORA</option>
              <option value="532">MAXLA HEROICA</option>
              <option value="722">MAXLA ROSITA</option>
              <option value="456">MAXMONTERIA</option>
              <option value="864">MAXNEIVA</option>
              <option value="596">MAXRIOHACHA</option>
              <option value="546">MAXSINCELEJO</option>
              <option value="222">MAXTULUA</option>
              <option value="126">MAXVENECIA</option>
              <option value="723">MAXYARIGUIES</option>
              <option value="736">TU CASSA BUCARAMANGA</option>
              <option value="143">TU CASSA CARVAJAL</option>
              <option value="518">TU CASSA MALAMBO</option>
      </select></td>
      <td width="96"><input name="consultar" type="button" class="botones" id="consultar" onclick= "consultarci($('#sala').val());" value="CONSULTAR" /></td>
      <td width="384">
      <div id="validador"></div></td>
    </tr>
    <tr>
      <td colspan="6"><div id="respuesta"></div></td>
    </tr>
    <tr>
      <td colspan="6">&nbsp;</td>
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
