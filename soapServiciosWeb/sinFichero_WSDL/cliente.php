<?php
/**
 * Created by PhpStorm.
 * User: dlvivanco
 * Date: 30/03/2017
 * Time: 18:11
 */

$url = "http://localhost/PhpstormProjects/soapServiciosWeb/sinFichero_WSDL/servicio.php";
$uri = "http://localhost/www/PhpstormProjects/soapServiciosWeb/sinFichero_WSDL/";

$cliente = new SoapClient(null, array('location'=>$url,'uri'=>$uri));

echo "---- Precio ----";
print "<br />";
print_r($cliente->getPVP('3DSNG')) + '<br>';
print "<br />";

echo "---- Stock del producto OPTIOLS1100 ----";
print "<br />";
print_r($cliente->getStock('OPTIOLS1100',1)) + '<br>';
print "<br />";

echo "---- Familia de todos los productos ----";
print "<br />";
$familias_productos = $cliente->getFamilias();
foreach ($familias_productos as $producto) {
    echo $producto;
    print "<br />";
}
echo "---- Familia del producto ORDENA ----";
print "<br />";
$familia_producto = $cliente->getProductosFamilia('ORDENA');
foreach ($familia_producto as $familia) {
    echo $familia;
    print "<br />";
}




