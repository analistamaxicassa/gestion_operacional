<?php
require_once('Archivo.php');
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    // Allow certain file formats
	if($imageFileType != "csv" && $imageFileType != "txt") {
		echo "<script>alert('El archivo cargado tiene una extensión diferente a .csv o .txt, el archivo no pudo ser cargado.');</script>";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "El archivo no pudo ser cargado, inténtelo de nuevo o comuníquese con el administrador del sistema";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			//echo "El archivo ". basename( $_FILES["fileToUpload"]["name"]). " se ha cargado correctamente.";
			$file = new Archivo();
			$file->update($target_file);
		} else {
			echo "<script>alert('El archivo no pudo ser cargado. inténtelo de nuevo o comuníquese con el administrador del sistema');</script>";
		}
	}
}
?>
<?php

?>
<!DOCTYPE html>
<html>
<body>

<form action="intro_cargar_nom.php" method="post" enctype="multipart/form-data">
    <input type="submit" value="Regresar" name="submit">
</form>

</body>
</html>