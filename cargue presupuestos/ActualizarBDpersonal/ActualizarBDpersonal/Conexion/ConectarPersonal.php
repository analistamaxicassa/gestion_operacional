<?php
abstract class ConectarBDPersonal
{
    private $mysqli;
    
    public function conectar()
    {
        $this->mysqli=new mysqli('10.1.0.22', 'IT008', 'KcZnMxCUXWmmpBLS');
        $this->mysqli->select_db('personal');
        return $this->mysqli;   
    }
    public function setNames()
    {
        return $this->mysqli->query("SET NAMES 'utf8'");
    }
    
}
?>