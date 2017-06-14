<?php
/**
 * Created by PhpStorm.
 * User: dlvivanco
 * Date: 07/04/2017
 * Time: 17:05
 */
require_once 'ServerW.php';

$cliente = new ServicioW();

$pvp = $cliente->getPVP("KSTMSDHC8GB");
print("El PVP es " . $pvp);

print "<br />";

$unidades = $cliente->getStock("KSTMSDHC8GB", 3);
print("Existen " . $unidades . " unidades");

print "<br />";

$familias = $cliente->getFamilias();
print_r($familias);

print "<br />";

$productos = $cliente->getProductosFamilia("ORDENA");
print_r($productos);

?>