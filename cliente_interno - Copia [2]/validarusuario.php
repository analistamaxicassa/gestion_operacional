<?php

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

ini_set('error_reporting',(E_ERROR | E_WARNING | E_PARSE));

$us=$_POST['usuario'];
$pa=($_POST['password']);

if($us=="")
{
	echo "<center><span style='font-family: Verdana; font-size: 12px; color: #900'><b><img src='images/alert.png' width='16' height='16' />&nbsp;&nbsp;&nbsp;&nbsp;El campo usuario es obligatorio</b></span></center>";
	?>
    <script>
	document.getElementById('usuario').value="";
	document.getElementById('usuario').focus();
	</script>
    <?php
	exit();
}

if($_POST['password']=="")
{
	echo "<center><span style='font-family: Verdana; font-size: 12px; color: #900'><b><img src='images/alert.png' width='16' height='16' />&nbsp;&nbsp;&nbsp;&nbsp;La contrase&ntilde;a es obligatoria</b></span></center>";
	?>
    <script>
	document.getElementById('password').value="";
	document.getElementById('password').focus();
	</script>
    <?php
	exit();
}


$consulta="SELECT cedula, password, perfil, estado FROM autentica_ci WHERE cedula='$us' AND password='$pa'";
$resultado = $link->query($consulta);
$datos=$resultado->fetch_object();


if($us==$datos->cedula && $pa==$datos->password && $datos->estado =='1')
{
	echo "<center><span style='font-family: Verdana; font-size: 12px;'>Datos v&aacute;lidos<br><br> Bienvenido </span></center>";
	
	session_start();
	$_SESSION['us']=$datos->perfil;
	$_SESSION['ced']=$datos->cedula;
	
	
	
	/*sapo($us,"Ingreso al sistema");*/
	?>
    <script language="JavaScript" type="text/javascript">
		var pagina="http://190.144.42.83:9090/plantillas/cliente_interno/selecciona_sala.php";
		function redireccionar() 
		{
			location.href=pagina
		} 
			setTimeout ("redireccionar()", 1000);
	</script>
    <?php
	$resultado->free();
	$link->close();
}else{
	?>

    <table width="326" border="0" align="center">
  		<tr>
    		<td width="63" align="center"><img src='file:///C|/xampp/htdocs/ares/images/alert.png'></td>
    		<td width="328"><span style='font-family: Verdana; font-size: 12px;'><b>Datos inv&aacute;lidos, Intente nuevamente</b></span></td>
  		</tr>
	</table>
    <script>
	document.getElementById('usuario').value='';
	document.getElementById('password').value='';
	document.getElementById('usuario').focus();
	</script>

    <?php
}
?>

