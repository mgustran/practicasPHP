<?php

require_once 'ServerW.php';

$cliente = new ServerW();

$familias = $cliente->getFamilies();
print("FAMILIAS:  ");
var_dump($familias);
print "<br />";
print "<br />";

$productos = $cliente->getProductsByFamily("MP3");
print("PRODUCTOS POR FAMILIA 'MP3':  ");
var_dump($productos);
print "<br />";
print "<br />";

$pvp = $cliente->getPVP("KSTMSDHC8GB");
print("El PVP es ");
var_dump($pvp);
print "<br />";
print "<br />";

$unidades = $cliente->getStock("KSTMSDHC8GB", 3);
print("Para el producto KSTMSDHC8GB Existen ");
var_dump($unidades);
print("unidades")
?>
