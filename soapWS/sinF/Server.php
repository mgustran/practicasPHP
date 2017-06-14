<?php
require_once('DB.php');
require_once('Product.php');

class Server {

  public function getPVP($code) {
    $product = DB::getProduct($code);
    $price = $product->getPVP();
    return $price;
  }

  public function getFamilies() {
    $families = DB::getProductFamilies();
    return $families;
  }

  public function getProductsByFamily($family) {
    $products = DB::getProductByFamily($family);
    return $products;
  }

  public function getStock($code, $shop) {
    $unities = DB::getStock($code, $shop);
    return $unities;
  }

}
?>
