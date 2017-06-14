<?php
    $algorithm = null;
    if(isset($_GET['button'])){
        $algorithm = $_GET['selectAlgorithm'];
    }
    switch($algorithm){
        case 'Insercion Directa': include_once('directInsertion/directInsertion.html'); break;
        case 'Seleccion Directa': include_once('directSelection/directSelection.html'); break;
        case 'Intercambio': include_once('interchange/interchange.html'); break;
        case 'Burbuja': include_once('bubble/bubbleAlgorithm.html'); break;

        default:  break;
    }
?>








