<?php
require_once './Server.php';

$uri = "http://localhost/practicasPHP/soapServiciosWeb/sinOriginal/";
$server = new SoapServer(null, array('uri' => $uri));

$server->setClass('Server');
$server->handle();
?>
