<?php
  require_once("conexionesDB\conexion.php");
  class LogFile
  {
    private $db;

    public function __construct()
    {
      $this->db = Conectarse_libreta();
    }

    public function getIngreso($usuario_ID)
    {
      $sql="SELECT usuario_ID, date_IN, date_OUT FROM log_ingresos WHERE usuario_ID = $usuario_ID";
      $datos= $this->db->query($sql);
      $arreglo=array();
      while($reg=$datos->fetch_object())
      {
        $arreglo[]=$reg;
      }
      return $arreglo;
    }
    public function insertar( $ingreso_ID, $usuario_ID, $origen)
    {
        $sql="INSERT INTO log_ingresos( ingreso_ID, usuario_ID, origen) VALUES ('$ingreso_ID', '$usuario_ID', '$origen')";
        $this->db->query($sql);
    }
    public function actualizar($ingreso_ID, $date_OUT)
    {
      $sql="UPDATE log_ingresos SET date_OUT='$date_OUT' WHERE ingreso_ID='$ingreso_ID'";
      $this->db->query($sql);
    }
    public function eliminar($ingreso_ID)
    {
        echo $sql="DELETE FROM log_ingresos WHERE ingreso_ID ='$ingreso_ID'";
        $this->db->query($sql);
    }
  }
 ?>
