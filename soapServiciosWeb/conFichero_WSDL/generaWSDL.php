<?php
/**
 * Created by PhpStorm.
 * User: dlvivanco
 * Date: 07/04/2017
 * Time: 16:43
 */

require_once 'ServerW.php';
require_once 'WSDLDocument.php';
$url = "http://localhost/www/PhpstormProjects/soapServiciosWeb/conFichero_WSDL/ServerW.php";
$uri = "http://localhost/www/PhpstormProjects/soapServiciosWeb/conFichero_WSDL/";

$accion = new WSDLDocument("Servicio", $url, $uri);
header('Content-Type: text/xml');
echo $accion->saveXML();
?>