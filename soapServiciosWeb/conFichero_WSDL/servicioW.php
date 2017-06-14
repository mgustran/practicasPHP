<?php
/**
 * Created by PhpStorm.
 * User: dlvivanco
 * Date: 30/03/2017
 * Time: 18:12
 */
/** Al visualizar el archivo en un navegador, añadir ?WSDL, al final para visualizar el contenido XML */
require_once './ServerW.php';
$xml = 'http://localhost/PhpstormProjects/soapServiciosWeb/conFichero_WSDL/servicio.wsdl';
$server = new SoapServer($xml);
$server->setClass('ServicioW');
$server->handle();