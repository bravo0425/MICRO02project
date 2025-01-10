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


function cambiarPass($conn) {
    $idProfe = $_SESSION['idProfe'];

    // Consulta para obtener la contraseña del profesor
    $queryName = 'SELECT * FROM profesores WHERE id = ' . $idProfe;
    $r = mysqli_query($conn, $queryName);

    if ($fila = mysqli_fetch_assoc($r)) {
        $correctOldPass = trim($fila['pass']);
    } else {
        echo "<p>Error: No se encontró el usuario.</p>";
        return;
    }

    $oldpass = trim($_POST['oldpass']);
    $newpass = $_POST['newpass'];
    $newpass2 = $_POST['newpass2'];

    // Compara la contraseña ingresada con la de la base de datos
    if ($oldpass !== $correctOldPass) {
        echo "<p>No coinciden la contraseña antigua</p>";
    } elseif ($newpass !== $newpass2) {
        // Verifica si las nuevas contraseñas coinciden
        echo "<p>No coinciden las contraseñas</p>";
    } else {
        // Actualiza la contraseña en la base de datos
        $updateQuery = "UPDATE profesores SET pass = '$newpass' WHERE id = $idProfe";
        if (mysqli_query($conn, $updateQuery)) {
            echo "<p>Contraseña actualizada</p>";
        } else {
            echo "<p>Error al actualizar la contraseña</p>";
        }
    }
}


?>


