<?php
require_once('DB.php');
require_once('Product.php');

class ServerW {

  /**
   * Obtiene el PVP de un producto a partir de su código
   * @param string $codigo
   * @return float 
   */
  public function getPVP($codigo) {
    $product = DB::getProduct($codigo);
    $price = $product->getPVP();
    return $price;
  }

  /**
   * Devuelve un array con los códigos de todas las familias
   * @return string[] 
   */
  public function getFamilies() {
    $families = DB::getProductFamilies();
    return $families;
  }

  /**
   * Devuelve un array de los productos de una familia
   * @param string $familia
   * @return string[]
   */
  public function getProductsByFamily($familia) {
    $products = DB::getProductByFamily($familia);
    return $products;
  }

  /**
   * Devuelve el stock asociado a una tienda, de un producto
   * @param string $codigo
   * @param int $tienda
   * @return int 
   */
  public function getStock($codigo, $tienda) {
    $unities = DB::getStock($codigo, $tienda);
    return $unities;
  }

}
?>
