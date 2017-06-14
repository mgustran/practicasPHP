<?php

/**
 * Created by PhpStorm.
 * User: dlvivanco
 * Date: 30/03/2017
 * Time: 16:24
 */
require_once('DB.php');
require_once('Producto.php');

class ServicioW {
    /**
     * Obtiene el PVP de un producto a partir de su código
     * @param string $codigo
     * @return float
     */
    public function getPVP($codigo) {
        $producto = DB::obtieneProducto($codigo);
        $precio = $producto->getPVP();
        return $precio;
    }
    /**
     * Devuelve un array con los códigos de todas las familias
     * @return array
     */
    public function getFamilias() {
        $familias = DB::obtieneFamilias();
        return $familias;
    }
    /**
     * Devuelve un array con los códigos de los productos de una familia
     * @param string $familia
     * @return array
     */
    public function getProductosFamilia($familia) {
        $productos = DB::obtieneProductosFamilia($familia);
        return $productos;
    }
    /**
     * Devuelve el número de unidades que existen en una tienda de un producto
     * @param string $codigo
     * @param int $tienda
     * @return int
     */
    public function getStock($codigo, $tienda) {
        $unidades = DB::obtieneStock($codigo, $tienda);
        return $unidades;
    }
}

