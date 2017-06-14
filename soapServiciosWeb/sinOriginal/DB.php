<?php

require_once('Product.php');

class DB {

  protected static function executeQuery($sql) {
    try {
      $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
      $dsn = "mysql:host=localhost;dbname=phpShop";
      $user = 'root';
      $passwd = '1996';
      $phpShop = new PDO($dsn, $user, $passwd, $opc);
      $result = null;
      if (isset($phpShop)) {
        $result = $phpShop->query($sql);
      }
      return $result;
    } catch (PDOException $ex) {
      echo $ex->getCode() . ": " . $ex->getMessage();
    }
  }
  

  public static function getProduct($codigo) {
    $sql = "SELECT cod, nombre_corto, nombre, PVP, descripcion, familia";
    $sql .= " FROM producto WHERE cod='" . $codigo . "'";
    $result = self::executeQuery($sql);
    $product = null;
    if (isset($result)) {
      $row = $result->fetch();
      $product = new Producto($row);
    }
    return $product;
  }

  public static function getProductFamilies(){
    $sql = "SELECT cod FROM familia";
    $result = self::executeQuery($sql);
    $families = array();
    if ($result){
      $row = $result->fetch();
      while ($row != null){
        $families[] = $row['cod'];
        $row = $result->fetch();
      }
    }
    return $families;
  }
  

  public static function getProductByFamily($familia){
    $sql = "SELECT cod FROM producto WHERE familia = '".$familia."'";
    $result = self::executeQuery($sql);
    $productCodes = array();
    if ($result){
      $row = $result->fetch();
      while ($row != null) {
        $productCodes[] = $row['cod'];
        $row = $result->fetch();
      }
      return $productCodes;
    }
  }

  public static function getStock($codigo, $tienda){
    $sql = "SELECT unidades FROM stock";
    $sql .= " WHERE producto = '".$codigo."' AND tienda = ".$tienda;
    $result = self::executeQuery($sql);
    $unities = null;
    if ($result){
      $row = $result->fetch();
      $unities = $row['unidades'];
    }
    return $unities;
  }
  
}
?>
