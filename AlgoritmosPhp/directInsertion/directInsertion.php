<?php
if(isset($_GET["button"])){
    $insertion = new InsercionDirecta();
    $array = array(-66,8,28,48,44,-22,56,-38,41,-66,47,-92,-77,65,-28,-96,-37,54,-90,40,0,-15,-99,54,41,
        36,48,-66,-12,80,-54,82,85,-96,86,-67,-17,17,48,-86,-32,-24,11,-88,-27,72,-31,78,-8,-22,-72,-64,6,
        -46,62,7,-97,-19,81,-1,-84,18,89,-66,-58,-27,9,-69,91,-61,-36,-18,-76,2,-6,73,20,16,25,-10,-65,85,
        -32,-51,45,-19,-46,-96,-24,65,12,64,72,-30,25,60,-70,18,91,-55);

    echo ('El array a comprobar es de rango -100/100 y consta de 100 elementos generados de manera aleatoria  .<br/><br/>');
    echo ('El resultado es: ');
    $insertion->calculateDirectInsertion($array);



}

class InsercionDirecta{

    function calculateDirectInsertion($array){

        $i = 0;
        $j = 0;
        $auxiliar = 0;

        for ($i = 1; $i < count($array); $i++) {

            $auxiliar = $array[$i];

            for ($j = $i-1; $j >= 0 && $array[$j]>$auxiliar; $j--) {

                $array[$j + 1] = $array[$j];
                $array[$j] = $auxiliar;
            }

        }
        for ($i = 0; $i < count($array); $i++) {

            echo $array[$i].' ';
        }
    }
}