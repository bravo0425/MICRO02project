<?php
function mostrarUsername($conn) {
    $idProfe = $_SESSION['idProfe'];

    $queryName = 'SELECT username FROM profesores WHERE id = ' . $idProfe;
    
    $r = mysqli_query($conn, $queryName);

    while ($fila = mysqli_fetch_assoc($r)) {
        echo "<p>" . htmlspecialchars($fila['username']) . "</p>";
    }
}

function mostrarMail($conn) {
    $idProfe = $_SESSION['idProfe'];

    $queryName = 'SELECT email FROM profesores WHERE id = ' . $idProfe;
    
    $r = mysqli_query($conn, $queryName);

    while ($fila = mysqli_fetch_assoc($r)) {
        echo "<p>" . htmlspecialchars($fila['email']) . "</p>";
    }
}

function updateImg($conn) {
    $idProfe = $_SESSION['idProfe'];
    $file = $_FILES['updateImg'];
    $tipus = $_FILES['updateImg']['type'];

    $imgData = file_get_contents($file['tmp_name']);
    $imgData = mysqli_real_escape_string($conn, $imgData);

    $sql = "UPDATE profesores SET img = '$imgData', tipus = '$tipus' WHERE id = $idProfe";

    mysqli_query($conn, $sql);
}

function mostrarImg($conn){
    $idProfe = $_SESSION['idProfe'];

    $queryName = 'SELECT img, tipus FROM profesores WHERE id = ' . $idProfe;
    
    $r = mysqli_query($conn, $queryName);

    // Asegúrate de que haya resultados
    if ($r && mysqli_num_rows($r) > 0) {
        $fila = mysqli_fetch_assoc($r);
        
        // Mostrar la imagen a través de un archivo PHP
        echo "<img src='data:" . $fila['tipus'] . ";base64," . base64_encode($fila['img']) . "' >";
    }
}

?>
