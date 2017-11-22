<?php
 function Conectarse() { 
        if (!($link = new mysqli('localhost', 'root', 'KcZnMxCUXWmmpBLS'))) { 
            echo "Error conectando al servidor de base de datos."; 
            exit(); 
        }
        
        if (!($link->select_db('act_man'))) { 
            echo "Error seleccionando la base de datos."; 
            exit(); 
        }
        return $link; 
    }
?>