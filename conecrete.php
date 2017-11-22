<?php
 function Conectarse() { 
        if (!($link = new mysqli('localhost', 'root', ''))) { 
            echo "Error conectando al servidor de base de datos."; 
            exit(); 
        }
        
        if (!($link->select_db('personal'))) { 
            echo "Error seleccionando la base de datos."; 
            exit(); 
        }
        return $link; 
    }
?>