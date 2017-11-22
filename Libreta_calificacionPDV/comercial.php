<?php
	session_start();

	if(!isset($_SESSION['userID']))
	{
		?>
		<script>
		alert("Sesión inactiva");
		location.href="index.php";
		</script>
			<?php
	}
	else {
		//echo "string".session_id();
	}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>ARES::Maxicassa</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link href="https://fonts.googleapis.com/css?family=Merriweather:700i" rel="stylesheet">
		<link rel="stylesheet" href="../CSS/nav.css">
		<style media="screen">
			.navbar-default {
				background-color: #002F87;
				border-color: #002F87;
			}
		</style>
	</head>
<body>
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" id="p01" href="comercial.php">Maxicassa</a>
	    </div>
	    <div class="collapse navbar-collapse" id="myNavbar">
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="../logout.php?origen=1" id="a02"><span class="glyphicon glyphicon-log-out"></span> Cerrar Sesión</a></li>
	      </ul>
	    </div>
	  </div>
	</nav>
	<div id="page-wrapper">
		<div class="container-fluid">
			<div class="row">
				<iframe id="principal"  name="principal"  src="principal.php" style="margin-top:1px; overflow: hidden; width: 100%; position: relative;"  frameborder="0" height="1000"></iframe>
				<!-- /.col-lg-12 -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container-fluid -->
	</div>
	<!-- /#page-wrapper -->

</body>
</html>
