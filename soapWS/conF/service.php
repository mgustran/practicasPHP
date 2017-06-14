<?php
require_once './ServerW.php';

$xml = "http://localhost/practicasPHP/soapWS/conF/ServerW.wsdl";
$server = new SoapServer($xml);

$server->setClass('ServerW');
$server->handle();
?>
