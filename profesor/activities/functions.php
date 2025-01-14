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

function mostrarImg($conn){
    $idProfe = $_SESSION['idProfe'];

    $queryName = 'SELECT img, tipus FROM profesores WHERE id = ' . $idProfe;
    
    $r = mysqli_query($conn, $queryName);

    if ($r && mysqli_num_rows($r) > 0) {
        $fila = mysqli_fetch_assoc($r);
        
        echo "<img src='data:" . $fila['tipus'] . ";base64," . base64_encode($fila['img']) . "' >";
    }
}

?>