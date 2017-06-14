<?php
require_once './Server.php';

$uri = "http://localhost/practicasPHP/soapWS/sinF/";
$server = new SoapServer(null, array('uri' => $uri));

$server->setClass('Server');
$server->handle();
?>
