
<?php


error_reporting(0);
//funcion fechas
require_once("../PAZYSALVO/FuncionFechas.php");

//recojo variables
$sala=$_POST['sala'];
$nombre=$_POST['nombre'];
$cedula=$_POST['cedula'];
$expedid=$_POST['expe'];
$genero=$_POST['genero'];
$fnacimiento=$_POST['fnacimiento'];
$ecivil=$_POST['ecivil'];
$hijos=$_POST['hijos'];
$direccion=$_POST['direccion'];
$ciudad=$_POST['ciudad'];
$telefono=$_POST['telefono'];
$celular=$_POST['celular'];
$email=$_POST['email'];
$emplabora=$_POST['emplabora'];
$hoy=date("y/m/d");


require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

 $sql1="INSERT INTO `personal`.`club_maestros` (`id`, `fechaInc`, `sala`, `cedula`,  `expedida`,  `nombre`, `genero`, `fnacimiento`, `estado_civil`, `hijos`, `direccion`, `ciudad`, `telefono`, `celular`, `email`, `emplabora`) VALUES (NULL, '$hoy', '$sala', '$cedula', '$expedid', '$nombre', '$genero', '$fnacimiento', '$ecivil', '$hijos', '$direccion', '$ciudad', '$telefono', '$celular', '$email', '$emplabora')";
		$qry_sql1=$link->query($sql1);
		
		
		
		//echo  "<font color='blue'; font-size:35px;>REGISTRO AGREGADO<br></font>";
		

		
$sql2="SELECT sala, cedula, expedida,UPPER(nombre) nombre, genero, fnacimiento, estado_civil, direccion, ciudad, telefono, celular, email, hijos, emplabora FROM `personal`.`club_maestros` WHERE `cedula` = '$cedula' ";
		$qry_sql2=$link->query($sql2);
			$rs_qry=$qry_sql2->fetch_object();  ///consultar 
				
				$maestro = $rs_qry->nombre;
		 
		 		
$sql3="SELECT nombre FROM `personal`.`salas` WHERE `cc` = $sala ";
		$qry_sql3=$link->query($sql3);
			$rs_qry3=$qry_sql3->fetch_object();  ///consultar 
				
				$nombresala = $rs_qry3->nombre;
		 
		 
?>
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>Afiliacion club de maestros ***EL ESPECIALISTA***</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="../estilos.css">
 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  
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
 <div id="validador" >
   <input type="submit" name="IMPRIMIR" id="IMPRIMIR" value="IMPRIMIR" onclick="imprSelec('validador');" />
 </div>
 
  <table width="80%" border="0" align="center"  style="border-collapse:collapse">
    <tr>
      <td colspan="2" align="left" valign="middle"><img src="..\club_maestros\img/LOGO ESPECIALISTA.jpg" width="155" height="87"  /></td>
      <td width="122" colspan="6" align="left" valign="middle"><img src="..\club_maestros\img/LOGOS INSTITUCIONALES-02.jpg" width="266" height="84"  /></td>
    </tr>
    <tr>
      <td colspan="8" align="left" valign="middle"><h2 class="encabezados">AFILIACION CLUB DE MAESTROS &quot;EL ESPECIALISTA&quot;</h2></td>
    </tr>
    <tr>
      <td align="left" valign="middle">SALA DE VENTAS</td>
      <td colspan="7" align="left" valign="middle"><label>
        <input type="text" name="sala" id="sala" value="<?php echo $nombresala; ?>"  readonly="readonly"/>
      </label></td>
    </tr>
    <tr>
      <td colspan="8" align="left" valign="middle">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="8" align="left" valign="middle"><em><strong>DATOS PERSONALES</strong></em></td>
    </tr>
    <tr>
      <td align="left" valign="middle">NOMBRES  APELLIDOS</td>
      <td colspan="7" align="left" valign="middle"><label>
        <input name="nombre" type="text" class="intro_tk" id="nombre" size="60" style="text-transform:uppercase;" value="<?php echo $rs_qry->nombre ?>" />
      </label></td>
    </tr>
    <tr>
      <td align="left" valign="middle">No  CEDULA</td>
      <td align="left" valign="middle"><input name="cedula" type="text" class="intro_tk" id="cedula" size="20" value="<?php   echo $rs_qry->cedula ?>"/></td>
      <td width="88"  align="justify" >expedida en</td>
      <td colspan="5"  align="justify" ><input name="erxpedido" type="text" class="intro_tk" id="erxpedido" size="20" style="text-transform:uppercase;" value="<?php   echo $rs_qry->expedida ?>" /></td>
    </tr>
    <tr>
      <td align="left" valign="middle">GENERO</td>
      <td width="140" align="left" valign="middle"><label>
        <input name="genero" type="text" class="intro_tk" id="genero" value="<?php echo $rs_qry->genero ?>" size="5" />
      </label></td>
      <td colspan="2"  align="justify" >Fecha de Nacimiento</td>
      <td colspan="4"  align="justify" ><input name="fnacimiento" type="text" class="intro_tk" id="fnacimiento" size="25" value="<?php echo $rs_qry->fnacimiento ?>" /></td>
    </tr>
    <tr>
      <td colspan="2" align="left" valign="middle">ESTADO CIVIL</td>
      <td colspan="2" align="left" valign="middle"><input name="ecivil" type="text" class="intro_tk" id="ecivil" size="25" value="<?php echo $rs_qry->estado_civil ?>" /></td>
      <td colspan="2" align="left" valign="middle">No de Hijos</td>
      <td colspan="2" align="left" valign="middle"><input name="hijos" type="text" class="intro_tk" id="hijos" size="5" value="<?php echo $rs_qry->hijos ?>" /></td>
    </tr>
    <tr>
      <td colspan="2" align="left" valign="middle">DIRECCION RESIDENCIA</td>
      <td colspan="2" align="left" valign="middle"><input name="direccion" type="text" class="intro_tk" id="direccion" size="30" value="<?php echo $rs_qry->direccion ?>" style="text-transform:uppercase;" /></td>
      <td colspan="2" align="left" valign="middle">CIUDAD</td>
      <td colspan="2" align="left" valign="middle"><input name="ciudad" type="text" class="intro_tk" id="ciudad" size="25" value="<?php echo $rs_qry->ciudad ?>" /></td>
    </tr>
    <tr>
      <td width="173" align="left" valign="middle">TELEFONO</td>
      <td colspan="2" align="left" valign="middle"><input name="telefono" type="text" class="intro_tk" id="telefono" size="15" value="<?php echo $rs_qry->telefono ?>" /></td>
      <td width="127"  align="justify" >CELULAR</td>
      <td colspan="2"  align="justify" ><input name="celular" type="text" class="intro_tk" id="celular" size="15" value="<?php   echo $rs_qry->celular ?>" /></td>
      <td width="67"  align="justify" >E-MAIL</td>
      <td width="143"  align="justify" ><input name="email" type="text" class="intro_tk" id="email" size="15" value="<?php   echo $rs_qry->email ?>" /></td>
    </tr>
    <tr>
      <td colspan="3" align="left" valign="middle">EMPRESA PARA LA QUE TRABAJA
</td>
      <td colspan="5" align="left" valign="middle"><input name="emplabora" type="text" class="intro_tk" id="emplabora" size="45" value="<?php echo $rs_qry->emplabora ?>" style="text-transform:uppercase;" /></td>
    </tr>
    <tr>
      <td height="19" colspan="8" align="left" valign="middle">&nbsp;</td>
    </tr>
</table>
  <table width="90%" border="1" align="center" style="font-size:12px">
    <tr>
      <td   align="justify" width="743" style="font-size:14px"><p> Yo <?php echo $rs_qry->nombre;?> identificado con cedula de ciudadania No <?php echo $rs_qry->cedula;?> expedida en <?php echo $rs_qry->expedida;?> actuando en nombre propio y conforme a la ley 1581 de 2012 y demas Decretos reglamentarios, autorizo a la EMPRESA para el tratamiento y manejo de mis datos personales el cual consiste en recolectar, almacenar, depurar, usar analizar, circular, actualizar, cruzar informacion propia, encuestas de satisfaccion, fidelizacion, estadisticos, y demas actividades de mercadeo y publicidad; análisis de información; inteligencia de mercado; envio de informacion acerca de nuestros productos, servicios, pronmociones, eventos, alianzas y ofertas entre otros; y mejoramiento de servicio asi como me comprometo con el club a:</p>
        <p>1. Dejar en alto el nombre de la compañia Ceramigres y del Club El Especialista.</p>
        <p>2. Informacion a la Dirección general del Club, por escrito, cualquier cambio de mi estado cvivil o cualquiera de los datos suministrados.</p>
        <p>3. A utilizar el carnet como documento personal e Intrasferible.</p>
        <p>Firma y Nro de Cedula del titular</p>
        <p>Recibido por el funcionario _________________  Fecha de radicado: _______________ Anexar cedula.</p>
      <p></p></td>
    </tr>
</table>
<p align="center">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</p>
<table width="95%" height="224" border="1" align="center">
    <tr>
      <td width="14%" rowspan="3"><img src="..\club_maestros\img/LOGO ESPECIALISTA.jpg" width="133" height="189" /></td>
      <td  align="center"><img src="..\club_maestros\img/LOGOS INSTITUCIONALES-02.jpg" width="258" height="59" /></td>
      <td width="59%" rowspan="2" style="font-size:14px"><p align="justify">El presente carnét es personal e intrasnferible, lo identifica como afiliado al club de constructores El Especialista.</p>
      <p>Su utilizaciòn es valida para acceder a los beneficios de descuentos, capacitaciones, servicios, promociones y premios, siempre y cuando su aplicacion sea vigente.</p>
      <p>Su utilizacion esta limitada a los fines propios del club de maestros y podrà ser retirado por su uso indebido.</p>
      <p>En caso de pèrdida o extravio favor devolverlo a la dirección Cra 69A No. 37B - 65 Sur. Bogota PBX (57-1) 744 44 20</p></td>
    </tr>
    <tr>
      <td height="63"><p align="center">CLUB DE MAESTROS</p>
      <p align="center">EL ESPECIALISTA</p></td>
    </tr>
    <tr align="center">
      <td >
        <input name="maestro" type="text" class="intro_tk" id="maestro" value="<?php echo $rs_qry->nombre;?>" size="35" />
        <br />
        C.C.
        <input name="idmaestro" type="text" class="intro_tk" id="idmaestro" value="<?php echo $rs_qry->cedula;?>" size="20" />
        <br />
      </td>
      <td align="right"><img src="..\club_maestros\img/LOGOS INSTITUCIONALES-02.jpg" width="179" height="66" /></td>
    </tr>
  </table>
</body>
</html>



