
<?php

//recojo variables
$cedula=$_POST['aval'];

try {
			$dbh = new PDO("oci:dbname=SRHQ7;host=localhost;port=1521","SRHADMIN","SRHADMIN");
		} catch (PDOException $e) {
			echo "Error: ". $e->getMessage();
			exit;
		}
		
		$query = "SELECT EM.EMP_NOMBRE||' '||EM.EMP_APELLIDO1||' '||EM.EMP_APELLIDO2 NOMBRE 
        FROM EMPLEADO EM
        WHERE  EM.EMP_CODIGO = '$cedula'";
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		$row_n = $stmt->fetch();
		
		if ($row_n['NOMBRE']!="")
		{
			session_start(); //Iniciamos o Continuamos la sesion
			$_SESSION['aval'] = $cedula; //Nickname Grabado
			
		}
		
?>
 
<html>
<head>
</head>
<body>
</body>
</html>