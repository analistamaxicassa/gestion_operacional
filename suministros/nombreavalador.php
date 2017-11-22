<?php

session_start();


//recojo variables
$avaladorXX=$_POST['aval'];

if (empty($avaladorXX)) {
    echo 'Debe ingresar su clave de ingreso';
}
 else {


		
		//conexion
		try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}

		$queryx = "SELECT  EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 					                   	AVALADOR FROM EMPLEADO EM WHERE EM.EMP_CODIGO = '$avaladorXX'";
		$stmt = $dbh->prepare($queryx);
		$stmt->execute();
		$row_n = $stmt->fetch();
		$nomaval1 = $row_n['AVALADOR'];
		$_SESSION['AVALADOR']=$nomaval1;
	
		if (empty($nomaval1)) {
    	echo 'No digito correctamente su Clave, vuelva al menu de Autorizar';
		exit;
		}
		 else {
	 	}
?>

<link rel="stylesheet" type="text/css" href="../estilos.css"/>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Entrevista de retiro</title>
</head>
<body style="font-family:Verdana, Geneva, sans-serif; font-size:14px;">
<form method="post" action="../suministros/elementos_sala.php?cedula=<?php echo $avaladorXX?>">

  <table width="656" border="1" align="center" cellpadding="4" cellspacing="0"   style="border-collapse:collapse; border:solid 1px;">
    <tr>
      <td align="center" valign="middle" class="encabezados"><strong>CONTROL DE ACCESO</strong></td>
    </tr>
    <tr valign="middle">
      <td align="center"><p><span style="font-size: 18px">Bienvenido</span></p>
        <p> <?php echo $nomaval1  ?> &nbsp;</p>
        <p>
          <input type="submit" name="ingresar" id="ingresar" value="INGRESAR"  style="height:40px; font-size:19px; " />
      </p></td>
    </tr>
  </table>
</form>
<?php
}	
?>

</body>
</html>
