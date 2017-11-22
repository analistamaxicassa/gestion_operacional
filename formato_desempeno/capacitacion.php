
<?php

//error_reporting(0);

$cedula=$_REQUEST['cedula'];

require_once('../PAZYSALVO/conexion_ares.php'); 
$link=Conectarse();

	?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../estilos.css">
<title>Necesidad de capacitación</title>
</head>

<body>
<form action="guarda_capacitacion.php" method="post">
<table width="847" border="0">
  <tr>
    <td colspan="3" class="encabezados">TEMAS DE CAPACITACION</td>
  </tr>
  <tr>
    <td colspan="3"><label>
      <input type="text" name="cedula" id="cedula" value="<?php echo $cedula; ?>"  hidden="hidden"/>
    </label></td>
  </tr>
  <tr>
    <td colspan="3" class="subtitulos">SIESA</td>
  </tr>
  <tr>
    <td width="95"><input  name="checkbox[]"  type="checkbox" value="Modulo Financiero" id="checkbox" />
Modulo Financiero</td>
    <td width="311"><input  name="checkbox[]"  type="checkbox" value="Modulo Comercial" id="checkbox" />
      Modulo Comercial</td>
    <td width="168">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="subtitulos">PROCEDIMIENTOS</td>
  </tr>
  <tr>
    <td><input  name="checkbox[]"  type="checkbox" value="caja" id="checkbox" />
    Caja</td>
    <td><input  name="checkbox[]"  type="checkbox" value="Inventario" id="checkbox" />
      Inventario</td>
    <td><input  name="checkbox[]"  type="checkbox" value="Ciclicos" id="checkbox" />
    Ciclicos</td>
  </tr>
  <tr>
    <td><input  name="checkbox[]"  type="checkbox" value="Arqueos" id="checkbox" />
    Arqueos</td>
    <td><input  name="checkbox[]"  type="checkbox" value="Entrada de mercancia" id="checkbox" />
      Entrada de mercancia</td>
    <td><input  name="checkbox[]"  type="checkbox" value="Devoluciones" id="checkbox" />
    Devoluciones</td>
  </tr>
  <tr>
    <td><input  name="checkbox[]"  type="checkbox" value="Medios de pago" id="checkbox" />
    Medios de pago</td>
    <td><input  name="checkbox[]"  type="checkbox" value="Marcado de Productos" id="checkbox" />
      Marcado de Productos</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="subtitulos">VENTAS</td>
  </tr>
  <tr>
    <td><input  name="checkbox[]"  type="checkbox" value="modulo1" id="checkbox" />
Entendiendo el arte de vender acabados para el hogar</td>
    <td><input  name="checkbox[]"  type="checkbox" value="modulo2" id="checkbox" />
      Las competencias del asesor comercial exitoso</td>
    <td><input  name="checkbox[]"  type="checkbox" value="modulo3" id="checkbox" />
    Tipologia de clientes</td>
  </tr>
  <tr>
    <td><input  name="checkbox[]"  type="checkbox" value="modulo4" id="checkbox" />
Principios de comunicacion</td>
    <td><input  name="checkbox[]"  type="checkbox" value="modulo5" id="checkbox" />
      El proceso de venta exitoso</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="subtitulos">SEGURIDAD </td>
  </tr>
  <tr>
    <td><input  name="checkbox[]"  type="checkbox" value="SGSST" id="checkbox" />
    Sistema  de Gestion y seguridad en el trabajo</td>
    <td><input  name="checkbox[]"  type="checkbox" value="Proteccion personal" id="checkbox" />
      Proteccion Personal y Autocuidado</td>
    <td><input  name="checkbox[]"  type="checkbox" value="Planes de emergencia" id="checkbox" />
Planes de Energencia</td>
  </tr>
  <tr>
    <td colspan="3" class="subtitulos">OTROS</td>
  </tr>
  <tr>
    <td><input  name="checkbox[]"  type="checkbox" value="almacenamiento de producto" id="checkbox" />
    Almacenamiento de producto</td>
    <td><input  name="checkbox[]"  type="checkbox" value="Servicio al cliente" id="checkbox" />
      Servicio al cliente</td>
    <td><input  name="checkbox[]"  type="checkbox" value="Herramientas de Office" id="checkbox" />
    Herramientas de Office</td>
  </tr>
  <tr>
    <td><input  name="checkbox[]"  type="checkbox" value="Portafolio" id="checkbox" />
    Portafolio</td>
    <td><input  name="checkbox[]"  type="checkbox" value="Mapa de Georeferenciación" id="checkbox" />
      Mapa de Georeferenciación</td>
    <td><input  name="checkbox[]"  type="checkbox" value="Mediciòn de Tráfico" id="checkbox" />
    Mediciòn de Tráfico</td>
  </tr>
  <tr>
    <td colspan="3">Otros:
      <input name="capacitacion" type="text" id="capacitacion" size="100" /></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="button" id="button" value="GUARDAR" /></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<p>
  <input type="submit" style="background:#FFF" name="cerrar" id="cerrar"  onclick="window.close();"value="CERRAR" />
</p>
</body>
</html>