<?php

//serverW.php es el fichero descrito anteriormente,
// donde se implementan los métodos que se se ofrecen
require_once 'ServerW.php';
require_once 'WSDLDocument.php'; //script que generará el fichero xml

$url = "http://localhost/practicasPHP/soapWS/conF/ServerW.php";
$uri = "http://localhost/practicasPHP/soapWS/conF/";

$accion = new WSDLDocument("ServerW", $url, $uri);

header('Content-Type: text/xml');
echo $accion->saveXML();
?>