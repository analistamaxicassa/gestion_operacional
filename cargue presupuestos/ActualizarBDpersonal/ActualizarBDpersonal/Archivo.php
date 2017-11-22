<?php
require_once("Conexion/ConectarPersonal.php");

class Archivo extends ConectarBDPersonal
{
    private $db;
    
    public function __construct() 
    {
        $this->db=parent::conectar();
        parent::setNames();   
    }
	
	public function update($target_file)
    {
        if (($fichero = fopen("$target_file", "r")) !== FALSE) 			
		{
			//Verificar si las columnas son numericas
			$esNum = true;
			while (($vdatos = fgetcsv($fichero, 0, ";")) !== FALSE AND $esNum) 
			{
				$puntuacion = array(",",".");
				$precios = str_replace($puntuacion, "", $vdatos[1]);
				//echo $precios;
				if((!is_numeric($vdatos[0])) OR (!is_numeric($precios)) )
				{
					echo "<script>alert('Algunos de los valores en el archivo no son numéricos por lo tanto el procesamiento del archivo no continuara.');</script>";
					$esNum = false;
				}
			}
			rewind($fichero);
			if($esNum)
			{
				while (($datos = fgetcsv($fichero, 0, ";")) !== FALSE) 
				{
					$puntuacion2 = array(",",".");
					$precios2 = str_replace($puntuacion2, "", $datos[1]);
					$sql="UPDATE `salas` SET `presupuesto`= '$precios2' WHERE cc = '$datos[0]'";
					$this->db->query($sql);
				}
			}
			fclose($fichero);
		}
			//copy("../cargas_maestra/sala-32.csv","../cargas_maestra/$sala".date("Ymdhis").".csv");
    }
	
}
?>