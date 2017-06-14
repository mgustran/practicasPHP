<?php
/**
 * Created by PhpStorm.
 * User: dlvivanco
 * Date: 30/03/2017
 * Time: 18:12
 */
require_once 'Server.php';
$uri = "http://localhost/www/PhpstormProjects/soapServiciosWeb/sinFichero_WSDL/";
$server = new SoapServer(null, array('uri' => $uri));
$server->setClass('Server');
$server->handle();