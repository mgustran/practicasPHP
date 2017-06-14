<?php

/**
 * Created by PhpStorm.
 * User: dlvivanco
 * Date: 30/03/2017
 * Time: 17:24
 */
require_once('Producto.php');

class DB {

    /**
     * Conexión a base de datos
     */
    protected static function conexion(){
        try{
            $conexion = new PDO('mysql:host=localhost; dbname=dwes', 'root', '');
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->exec("SET CHARACTER SET utf8");
        }catch (Exception $e){
            die("Error: " . $e->getMessage());
        }
        return $conexion;
    }

    protected static function ejecutaConsulta($sql) {
        $resultado = null;
        try {
            $dwes = self::conexion();
            if (isset($dwes)) {
                $resultado = $dwes->query($sql);
            }
        } catch (PDOException $ex) {
            echo $ex->getCode() . ": " . $ex->getMessage();
        }
        return $resultado;
    }


    public static function obtieneProducto($codigo) {
        $sql = "SELECT cod, nombre_corto, nombre, PVP, descripcion, familia";
        $sql .= " FROM producto WHERE cod='" . $codigo . "'";
        $resultado = self::ejecutaConsulta($sql);
        $producto = null;
        if (isset($resultado)) {
            $row = $resultado->fetch();
            $producto = new Producto($row);
        }
        return $producto;
    }

    public static function obtieneFamilias(){
        $sql = "SELECT cod FROM familia";
        $resultado = self::ejecutaConsulta($sql);
        $familias = array();
        if ($resultado){
            $row = $resultado->fetch();
            while ($row != null){
                $familias[] = $row['cod'];
                $row = $resultado->fetch();
            }
        }
        return $familias;
    }

    public static function obtieneProductosFamilia($familia){
        $sql = "SELECT cod FROM producto WHERE familia = '".$familia."'";
        $resultado = self::ejecutaConsulta($sql);
        $codigosProd = array();
        if ($resultado){
            $row = $resultado->fetch();
            while ($row != null) {
                $codigosProd[] = $row['cod'];
                $row = $resultado->fetch();
            }
            return $codigosProd;
        }
    }

    public static function obtieneStock($codigo, $tienda){
        $sql = "SELECT unidades FROM stock";
        $sql .= " WHERE producto = '".$codigo."' AND tienda = ".$tienda;
        $resultado = self::ejecutaConsulta($sql);
        $unidades = null;
        if ($resultado){
            $row = $resultado->fetch();
            $unidades = $row['unidades'];
        }
        return $unidades;
    }
}

