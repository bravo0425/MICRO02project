<?php

function añadirItem($conn) {
    $IdActividad = $_POST['actividad'];
    $tituloItem = $_POST['titulo'];
    $valorItem = $_POST['valores'];

    if (!empty($IdActividad) && !empty($tituloItem) && !empty($valorItem)) {
        $insert = "INSERT INTO items (activity_id, titulo, valor) VALUES ('$IdActividad', '$tituloItem', '$valorItem')";

        mysqli_query($conn, $insert);
    }
}


?>