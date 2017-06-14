<?php
require_once('DB.php');
require_once('Product.php');

class Server {

  /**
   * Obtiene el PVP de un producto a partir de su código
   * @param string $code
   * @return float 
   */
  public function getPVP($code) {
    $product = DB::getProduct($code);
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
   * Devuelve un array con los códigos de los productos de una familia
   * @param string $family
   * @return string[]
   */
  public function getProductsByFamily($family) {
    $products = DB::getProductByFamily($family);
    return $products;
  }

  /**
   * Devuelve el número de unidades que existen en una tienda de un producto
   * @param string $code
   * @param int $shop
   * @return int 
   */
  public function getStock($code, $shop) {
    $unities = DB::getStock($code, $shop);
    return $unities;
  }

}
?>
