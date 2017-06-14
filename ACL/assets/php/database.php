<?php
session_start();
ob_start();

    class ConexionDB{

        public static function conexion(){

            try{
                $conexion = new PDO('mysql:host=localhost; dbname=acl', 'root', 'root');
                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $conexion->exec("SET CHARACTER SET utf8");


            }catch (Exception $e){
                die("Error: " . $e->getMessage());
            }
            return $conexion;
        }
    }
?>


