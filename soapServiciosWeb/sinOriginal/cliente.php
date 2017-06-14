<?php
$url = "http://localhost/practicasPHP/soapServiciosWeb/sinOriginal/servicio.php";
$uri = "http://localhost/practicasPHP/soapServiciosWeb/sinOriginal/";

$cliente = new SoapClient(null, array('location'=>$url,'uri'=>$uri));

?> PVP con codigo : PS3320GB (PS3...) <?php  var_dump($cliente->getPVP('PS3320GB')); ?>
<br>
<br>
    Familias (todas) : <?php var_dump($cliente->getFamilies()); ?>
<br>
<br>
    Productos de la familia 'MEMFLA' : <?php var_dump($cliente->getProductsByFamily('MEMFLA')); ?>
<br>
<br>
    Stock de Producto 'EEEPC1005PXD' con Tienda '1' :<?php var_dump($cliente->getStock('EEEPC1005PXD',1)); ?>