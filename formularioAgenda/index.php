<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formulario - Agenda de contactos</title>
    <link rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<div class="contenedor">
    <div >
        <p><h2>Formulario de agenda</p><hr></h2></div>
    <div class="contenido">
        <?php
        $matriz_agenda = array();

        if (isset($_REQUEST['enviar'])) {

            foreach ($_REQUEST as $key => $value) {
                if (($key <> 'accion') && ($key <> 'nombre') && ($key <> 'telefono') && ($key <> 'enviar')) {
                    $matriz_agenda["$key"] = $value;
                }
            }
            if (!empty($_REQUEST['nombre'])) {
                if (false) {
                    echo "duplicado<br />";

                    if (empty($_REQUEST['telefono']) || $_REQUEST['telefono'] == '') {
                        echo "lo borro<br />";
                        unset($matriz_agenda[$_REQUEST['nombre']]);
                    } else
                        $matriz_agenda[$_REQUEST['nombre']] = $_REQUEST['telefono'];
                }
                else {

                    if (!empty($_REQUEST['telefono'])) {
                        $matriz_agenda[$_REQUEST['nombre']] = $_REQUEST['telefono'];
                    } else {
                        echo "Debes introducir un numero de teléfono<br />";
                    }
                }
            } else {
                if (empty($_REQUEST['nombre']))
                    echo "Debes introducir un nombre<br />";
            }
            echo '<div class="encuadre">';
            echo "<h3>Contactos de la agenda</h3>";
            echo "<table>";
            echo "<tr><th>Nombre</th><th>Teléfono</th></tr>";
            $cont = 0;
            foreach ($matriz_agenda as $nom => $num) {
                echo "<tr><td>$nom</td><td>$num </td></tr>";
                $cont++;
            }
            echo "</table>";
            echo "Hay un total de $cont contactos en la agenda";
            echo '</div>';
            echo '<br>';
            echo '<br>';
        }
        if (isset($_REQUEST['borrar'])) {
            if (isset($matriz_agenda)) {
                unset($matriz_agenda);
                $matriz_agenda = array();
            }
        }
        echo '<div class="encuadre">';
        echo '<form  action =./index.php method="post">';
        if (isset($matriz_agenda)) {
            foreach ($matriz_agenda as $nom => $num) {
                echo '<input type="hidden" name="' . $nom . '" value="' . $num . '">';
            }
        }
        echo '<label>Nombre: </label><input type="text" name="nombre"/><br />';
        echo '<label>Teléfono: </label><input type="text" name="telefono"/><br />';
        echo '<p><input type="submit" value ="Añadir Contacto" name="enviar">';
        echo '<input type="submit" value ="Vaciar agenda" name="borrar"><p/>';
        echo '</form>';
        echo '</div>';
        function comprobacion($matriz) {
            foreach ($matriz as $nom => $num) {
                if ($nom ==  $_REQUEST('nombre')) {
                    return true;
                }
                return false;
            }
        }
        var_dump($_REQUEST);
        var_dump($matriz_agenda);
        ?>
    </div>
</div>
</body>
</html>