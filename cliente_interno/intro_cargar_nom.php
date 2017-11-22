<?php

?>
<!DOCTYPE html>
<html lang="es">
	<title>Parametros</title>
	<meta charset="utf-8" />
	<head>
		<style>
			p { font-family:Verdana, Geneva, sans-serif; font-size:12px;}
		</style>
		<script src="../js/jquery-ui-1.10.2.custom/js/jquery-1.9.1.js"></script>
	</head>
	<body style="font-family: Verdana, Geneva, sans-serif; font-size: 12px;">
		<br><br>
		<table width="100%" height="174" border="0" align="center">
			<tr align="center">
				<td height="22"><b style="color: #903">CARGA DE INFORMACIÓN</b></td>
			</tr>
			<tr align="center">
				<td width="36%" height="22" bgcolor="#F7F7F7"><strong><span style="text-align:center">Cargue de archivo plano de .csv o .txt</span></strong></td>
			</tr>
			<tr align="center">
				<td height="26" align="center" bgcolor="#EDEFFE"><div id="frmcera" style="display:block" align="center">
					<form action="upload.php" method="post" enctype="multipart/form-data">
						<p>Recuerde que el archivo csv sera procesados el token <strong>','</strong><br>:
							<br><br>
							Seleccione archivo a cargar:
							<input type="file" name="fileToUpload" id="fileToUpload" accept=".csv,.txt">
							<br><br>
							<input type="submit" value="Procesar Archivo" name="submit">
						</p>
					</form>
				</div></td>
			</tr>
		</table>
		<br><br>
	</body>
</html>
